"""
Lógica RAG: ingesta, almacenamiento vectorial y búsqueda.
"""
import os
import requests
import chromadb
from chromadb.config import Settings

OLLAMA_URL = os.getenv("OLLAMA_URL", "http://localhost:11434")
EMBED_MODEL = "nomic-embed-text"
CHAT_MODEL = "llama3.1:8b"

CHROMA_DIR = os.path.join(os.path.dirname(__file__), "..", "chroma_db")
chroma_client = chromadb.PersistentClient(
    path=CHROMA_DIR,
    settings=Settings(anonymized_telemetry=False)
)

COLLECTION_NAME = "documentos_usuario"


def get_collection():
    return chroma_client.get_or_create_collection(name=COLLECTION_NAME)


def get_embedding(text: str) -> list:
    response = requests.post(
        f"{OLLAMA_URL}/api/embeddings",
        json={"model": EMBED_MODEL, "prompt": text},
        timeout=60
    )
    response.raise_for_status()
    return response.json()["embedding"]


def chunk_text(text: str, chunk_size: int = 500, overlap: int = 50) -> list:
    chunks = []
    start = 0
    while start < len(text):
        end = start + chunk_size
        chunks.append(text[start:end])
        start += chunk_size - overlap
    return [c.strip() for c in chunks if c.strip()]


def ingest_document(filename: str, content: str) -> dict:
    collection = get_collection()
    chunks = chunk_text(content)

    if not chunks:
        return {"ok": False, "error": "Documento vacio"}

    try:
        collection.delete(where={"filename": filename})
    except Exception:
        pass

    ids = [f"{filename}_chunk_{i}" for i in range(len(chunks))]
    embeddings = [get_embedding(chunk) for chunk in chunks]
    metadatas = [{"filename": filename, "chunk_index": i} for i in range(len(chunks))]

    collection.add(
        ids=ids,
        embeddings=embeddings,
        documents=chunks,
        metadatas=metadatas
    )

    return {"ok": True, "filename": filename, "fragmentos": len(chunks)}


def search_relevant(query: str, top_k: int = 4) -> list:
    collection = get_collection()
    if collection.count() == 0:
        return []

    query_embedding = get_embedding(query)
    results = collection.query(
        query_embeddings=[query_embedding],
        n_results=min(top_k, collection.count())
    )

    fragments = []
    for i, doc in enumerate(results["documents"][0]):
        fragments.append({
            "texto": doc,
            "filename": results["metadatas"][0][i]["filename"],
            "distancia": float(results["distances"][0][i])
        })
    return fragments


def answer_with_rag(query: str) -> dict:
    fragments = search_relevant(query)

    if not fragments:
        return {
            "respuesta": "No hay documentos cargados. Sube primero algun documento para poder hacer preguntas sobre el.",
            "fuentes": []
        }

    contexto = "\n\n---\n\n".join([
        f"[Fragmento de {f['filename']}]\n{f['texto']}"
        for f in fragments
    ])

    system_prompt = (
        "Eres un asistente que responde preguntas en espanol basandote UNICAMENTE en los fragmentos "
        "de documentos que se te proporcionan como contexto. Si la respuesta no esta en el contexto, "
        "dilo claramente. No inventes informacion. Se claro y conciso, y cita el nombre del documento "
        "del que sacas la informacion cuando sea posible."
    )

    user_prompt = (
        f"CONTEXTO:\n{contexto}\n\n"
        f"PREGUNTA: {query}\n\n"
        f"Responde basandote unicamente en el contexto anterior."
    )

    response = requests.post(
        f"{OLLAMA_URL}/api/chat",
        json={
            "model": CHAT_MODEL,
            "messages": [
                {"role": "system", "content": system_prompt},
                {"role": "user", "content": user_prompt}
            ],
            "stream": False,
            "options": {"temperature": 0.2}
        },
        timeout=180
    )
    response.raise_for_status()
    respuesta = response.json()["message"]["content"]

    return {
        "respuesta": respuesta,
        "fuentes": [
            {"filename": f["filename"], "fragmento": f["texto"][:200] + "..."}
            for f in fragments
        ]
    }


def list_documents() -> list:
    collection = get_collection()
    if collection.count() == 0:
        return []

    all_data = collection.get()
    filenames = {}
    for meta in all_data["metadatas"]:
        fn = meta["filename"]
        filenames[fn] = filenames.get(fn, 0) + 1

    return [{"filename": fn, "fragmentos": count} for fn, count in filenames.items()]


def clear_all() -> dict:
    try:
        chroma_client.delete_collection(name=COLLECTION_NAME)
    except Exception:
        pass
    return {"ok": True}
