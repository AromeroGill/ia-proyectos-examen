# Checklist día del examen

## Antes de entrar al aula

- [ ] Llevar pendrive con los modelos de Ollama por si el wifi falla:
      copiar `C:\Users\<usuario>\.ollama\models` al USB
- [ ] URL del repo: https://github.com/AromeroGill/ia-proyectos-examen
- [ ] Tener cuenta de GitHub accesible (login)
- [ ] Tener Lavender y Google Drive accesibles desde el navegador

## En el PC del aula (no hay Git Bash)

### 1. Pedir permiso al profesor para instalar Ollama y Python

### 2. Instalar

- [ ] Ollama: https://ollama.com/download/windows
- [ ] Python 3.12: Microsoft Store → "Python 3.12"
- [ ] Verificar en una terminal nueva: `python --version`, `pip --version`, `ollama --version`

### 3. Recuperar los modelos de Ollama

Opción A (con USB, más rápido):
- Copiar `models/` del USB a `C:\Users\<usuario>\.ollama\models`

Opción B (con red, más lento):
- `ollama pull llama3.1:8b`
- `ollama pull nomic-embed-text`

### 4. Clonar el repo con VS Code

1. Abrir VS Code
2. Ctrl+Shift+P → "Git: Clone"
3. Pegar URL: https://github.com/AromeroGill/ia-proyectos-examen.git
4. Elegir carpeta destino: `C:\xampp\htdocs\`
5. Aceptar abrir la carpeta clonada
6. Login con GitHub si lo pide

IMPORTANTE: la carpeta debe quedar en `C:\xampp\htdocs\ia-proyectos-examen` o `C:\xampp\htdocs\ia-proyectos`. Las URLs locales dependen de ese nombre.

### 5. Arrancar Apache de XAMPP

- [ ] Abrir XAMPP Control Panel → Start Apache

### 6. Probar Proyecto A

- [ ] http://localhost/ia-proyectos-examen/proyecto-a-chat/
- [ ] (ajustar URL si la carpeta tiene otro nombre)
- [ ] Modo Chat → preguntar → debe responder
- [ ] Modo Q&A → preguntar → debe responder

### 7. Probar Proyecto B

- [ ] http://localhost/ia-proyectos-examen/proyecto-b-corrector/
- [ ] Elegir estilo → pegar correo → corregir → debe responder

### 8. Preparar Proyecto C (terminal integrada de VS Code)

Abrir terminal en VS Code: Ctrl + ñ

```powershell
cd C:\xampp\htdocs\ia-proyectos-examen\proyecto-c-rag\backend
python -m venv venv
venv\Scripts\Activate.ps1
pip install -r requirements.txt
uvicorn main:app --reload --port 8000
```

NOTA: si PowerShell se queja con "execution policy", ejecutar primero:
```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
```
(responder "S" si pregunta).

- [ ] Esperar a "Application startup complete"
- [ ] Verificar: http://localhost:8000/ → debe devolver JSON ok
- [ ] http://localhost/ia-proyectos-examen/proyecto-c-rag/
- [ ] Subir documento → hacer pregunta → debe responder

## Durante el examen

- [ ] Grabar vídeo de 1-3 min por cada uno de los 7 ejercicios
- [ ] Picar el texto LinkedIn de cada ejercicio en Google Drive
- [ ] Compartir en Lavender al finalizar

## Estructura del texto LinkedIn (por ejercicio)

1. **Introducción** — qué es y por qué importa
2. **Cómo se usa por parte del público general** — caso de uso real
3. **Aspectos técnicos** — stack, decisiones técnicas, retos
4. **Conclusión** — aprendizajes y aplicabilidad
