<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asistente de documentación personal · RAG</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>📚 Asistente de documentación personal</h1>
        <p class="subtitle">Sube documentos y pregunta en lenguaje natural · RAG con IA local</p>
        <p class="stack">Stack: PHP (front) + Python FastAPI (backend) + ChromaDB + Ollama</p>
    </header>

    <main>
        <!-- Columna izquierda: gestión de documentos -->
        <aside class="docs-panel">
            <h2>📄 Documentos cargados</h2>
            <div id="docs-list" class="docs-list">
                <p class="empty">Sin documentos</p>
            </div>

            <h3>Subir documento</h3>
            <form id="upload-form">
                <input type="file" id="file-input" accept=".txt,.md" required>
                <button type="submit">⬆️ Subir e indexar</button>
            </form>
            <div id="upload-status" class="status"></div>

            <button id="clear-btn" class="danger">🗑️ Borrar todos</button>
        </aside>

        <!-- Columna derecha: pregunta y respuesta -->
        <section class="chat-panel">
            <h2>❓ Haz una pregunta sobre tus documentos</h2>
            <form id="query-form">
                <textarea id="query-input" rows="3" placeholder="Ej: ¿Quién fundó la empresa? ¿Cuál es la facturación?"></textarea>
                <button type="submit">🔍 Preguntar</button>
            </form>

            <div id="answer-section" class="answer-section" style="display:none;">
                <h3>Respuesta</h3>
                <div id="answer" class="answer-box"></div>
                <details class="fuentes-details">
                    <summary>📎 Ver fuentes utilizadas</summary>
                    <div id="fuentes"></div>
                </details>
            </div>
        </section>
    </main>

    <script src="js/app.js"></script>
</body>
</html>