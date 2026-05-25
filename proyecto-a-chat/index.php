<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asistente de Productividad Personal</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>🤖 Asistente de Productividad</h1>
        <p class="subtitle">IA local con <?= OLLAMA_MODEL ?> · Tu privacidad, tu máquina</p>
    </header>

    <nav class="tabs">
        <button class="tab active" data-mode="chat">💬 Chat conversacional</button>
        <button class="tab" data-mode="qa">❓ Pregunta y respuesta</button>
    </nav>

    <main>
        <!-- MODO CHAT -->
        <section id="mode-chat" class="mode active">
            <div id="chat-messages" class="messages"></div>
            <form id="chat-form" class="input-area">
                <textarea id="chat-input" placeholder="Escribe tu mensaje..." rows="2"></textarea>
                <button type="submit">Enviar</button>
                <button type="button" id="chat-clear">🗑️</button>
            </form>
        </section>

        <!-- MODO Q&A -->
        <section id="mode-qa" class="mode">
            <form id="qa-form" class="input-area">
                <textarea id="qa-input" placeholder="Haz una pregunta directa..." rows="3"></textarea>
                <button type="submit">Preguntar</button>
            </form>
            <div id="qa-answer" class="answer-box"></div>
        </section>
    </main>

    <script src="js/app.js"></script>
</body>
</html>
