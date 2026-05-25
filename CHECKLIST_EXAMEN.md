# Checklist día del examen

## Antes de entrar al aula

- [ ] Llevar pendrive con los modelos de Ollama por si el wifi falla:
      copiar `C:\Users\<usuario>\.ollama\models` al USB
- [ ] Tener clara la URL del repo: https://github.com/AromeroGill/ia-proyectos-examen
- [ ] Tener Lavender y Google Drive accesibles desde el navegador

## En el PC del aula

### 1. Pedir permiso al profesor para instalar Ollama y Python

### 2. Instalar (mientras descargan otras cosas en paralelo)

- [ ] Ollama: https://ollama.com/download/windows
- [ ] Python 3.12: Microsoft Store → "Python 3.12"
- [ ] Verificar: `python --version`, `pip --version`, `ollama --version`

### 3. Recuperar los modelos de Ollama

Opción A (con USB, más rápido):
- Copiar `models/` del USB a `C:\Users\<usuario>\.ollama\models`

Opción B (con red):
- `ollama pull llama3.1:8b`
- `ollama pull nomic-embed-text`

### 4. Clonar el repo

```bash
cd /c/xampp/htdocs
git clone https://github.com/AromeroGill/ia-proyectos-examen.git ia-proyectos
```

### 5. Arrancar XAMPP

- [ ] Abrir XAMPP Control Panel → Start Apache

### 6. Probar Proyecto A

- [ ] http://localhost/ia-proyectos/proyecto-a-chat/
- [ ] Modo Chat → preguntar algo → debe responder
- [ ] Modo Q&A → preguntar algo → debe responder

### 7. Probar Proyecto B

- [ ] http://localhost/ia-proyectos/proyecto-b-corrector/
- [ ] Elegir un estilo (ej. Corporativo)
- [ ] Pegar correo de prueba → corregir → debe responder

### 8. Preparar Proyecto C

```bash
cd /c/xampp/htdocs/ia-proyectos/proyecto-c-rag/backend
python -m venv venv
source venv/Scripts/activate
pip install -r requirements.txt
uvicorn main:app --reload --port 8000
```

- [ ] Esperar a "Application startup complete"
- [ ] Verificar: http://localhost:8000/ → JSON ok
- [ ] http://localhost/ia-proyectos/proyecto-c-rag/
- [ ] Subir un documento, hacer una pregunta → debe responder

## Durante el examen

- [ ] Grabar vídeo de 1-3 min por cada uno de los 7 ejercicios
- [ ] Picar el texto LinkedIn de cada ejercicio en Google Drive
- [ ] Compartir en Lavender al finalizar

## Estructura del texto LinkedIn (por ejercicio)

1. **Introducción** — qué es y por qué importa
2. **Cómo se usa por parte del público general** — caso de uso real
3. **Aspectos técnicos** — stack, decisiones técnicas, retos
4. **Conclusión** — aprendizajes y aplicabilidad
