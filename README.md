# Proyectos IA

Tres proyectos que cubren los 7 ejercicios del módulo de Inteligencia Artificial, agrupados de forma temática.

## Resumen

| Proyecto | Ejercicios cubiertos | Stack |
|----------|---------------------|-------|
| **A — Asistente web** | 1 (Ollama), 2 (MicroChatGPT PHP), 3 (Q&A) | PHP + Ollama |
| **B — Corrector de correos** | 4 (Corrector con IA), 5 (Entrenamiento con JSON) | PHP + Ollama + JSON few-shot |
| **C — Asistente RAG** | 6 (RAG con BD vectorial), 7 (Stack PHP+Python) | PHP + Python FastAPI + ChromaDB + Ollama |

## Requisitos

- **XAMPP** (Apache corriendo en puerto 80)
- **Python 3.12 o superior** (con `pip` accesible desde la terminal)
- **Ollama** corriendo en `http://localhost:11434`
- Modelos descargados:
  - `llama3.1:8b` (para chat y generación)
  - `nomic-embed-text` (solo para Proyecto C, embeddings)

## Instalación rápida en un PC nuevo

```bash
# 1. Clonar el repo dentro de htdocs de XAMPP
cd C:\xampp\htdocs
git clone https://github.com/AromeroGill/ia-proyectos-examen.git ia-proyectos

# 2. Descargar modelos de Ollama
ollama pull llama3.1:8b
ollama pull nomic-embed-text

# 3. (Solo Proyecto C) Configurar entorno Python
cd ia-proyectos/proyecto-c-rag/backend
python -m venv venv
source venv/Scripts/activate     # Git Bash en Windows
pip install -r requirements.txt
```

## Cómo arrancar cada proyecto

Ver el `README.md` dentro de cada subcarpeta.

## URLs locales

- Proyecto A: http://localhost/ia-proyectos/proyecto-a-chat/
- Proyecto B: http://localhost/ia-proyectos/proyecto-b-corrector/
- Proyecto C: http://localhost/ia-proyectos/proyecto-c-rag/ (requiere backend Python arrancado)

## Autor

Proyecto académico desarrollado bajo la tutoría de **José Vicente Carratalá (Jocarsa)**.
