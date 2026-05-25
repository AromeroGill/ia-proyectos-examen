"""
FastAPI backend para el proyecto RAG.
Expone endpoints para subir documentos, consultar y listar.
"""
from fastapi import FastAPI, UploadFile, File, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
import rag

app = FastAPI(title="RAG Backend", version="1.0")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"]
)


class QueryRequest(BaseModel):
    query: str


@app.get("/")
def root():
    return {"status": "ok", "service": "RAG Backend", "version": "1.0"}


@app.post("/ingest")
async def ingest(file: UploadFile = File(...)):
    if not file.filename.lower().endswith(('.txt', '.md')):
        raise HTTPException(400, "Solo se admiten archivos .txt o .md")

    content_bytes = await file.read()
    try:
        content = content_bytes.decode('utf-8')
    except UnicodeDecodeError:
        content = content_bytes.decode('latin-1')

    result = rag.ingest_document(file.filename, content)
    return result


@app.post("/query")
def query(req: QueryRequest):
    if not req.query.strip():
        raise HTTPException(400, "Pregunta vacía")
    return rag.answer_with_rag(req.query)


@app.get("/documents")
def documents():
    return {"documentos": rag.list_documents()}


@app.delete("/documents")
def delete_all():
    return rag.clear_all()
