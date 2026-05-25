# Proyecto C — Asistente RAG con stack PHP+Python

Sistema RAG (Retrieval Augmented Generation) que permite subir documentos de texto y hacer preguntas en lenguaje natural sobre ellos. Las respuestas se generan citando los documentos fuente.

## Arquitectura
cat > proyecto-c-rag/README.md << 'EOF'
# Proyecto C — Asistente RAG con stack PHP+Python

Sistema RAG (Retrieval Augmented Generation) que permite subir documentos de texto y hacer preguntas en lenguaje natural sobre ellos. Las respuestas se generan citando los documentos fuente.

## Arquitectura
PHP actúa como **proxy** entre el navegador y el backend Python. Python gestiona la base de datos vectorial y la comunicación con Ollama.

## Ejercicios del temario que cubre

- **Ejercicio 6** — RAG con base de datos vectorial (ChromaDB).
- **Ejercicio 7** — Stack PHP+Python, comunicación entre lenguajes.

## Requisitos adicionales

- Python 3.12+ con entorno virtual y dependencias en `backend/requirements.txt`.
- Modelo de embeddings: `ollama pull nomic-embed-text`

## Cómo arrancar

### 1. Backend Python

```bash
cd backend
python -m venv venv
source venv/Scripts/activate   # Git Bash en Windows
pip install -r requirements.txt
uvicorn main:app --reload --port 8000
```

Verifica con: http://localhost:8000/ → debe devolver `{"status":"ok",...}`

### 2. Frontend PHP

1. Arranca Apache en XAMPP.
2. Abre: http://localhost/ia-proyectos/proyecto-c-rag/

## Endpoints del backend

- `GET /` — Health check
- `POST /ingest` — Subir un documento (.txt o .md)
- `POST /query` — Preguntar sobre los documentos
- `GET /documents` — Listar documentos indexados
- `DELETE /documents` — Borrar todos los documentos

## Persistencia

La base de datos vectorial se guarda en `chroma_db/` (excluido del repo). Al volver a arrancar el backend, los documentos previamente cargados siguen disponibles. Si quieres empezar limpio, borra esa carpeta.
