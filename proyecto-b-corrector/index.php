<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Corrector de correos con IA</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>✉️ Corrector de correos con IA</h1>
        <p class="subtitle">Adapta tus correos a cualquier contexto profesional · IA local</p>
    </header>

    <main>
        <section class="step">
            <h2>1. Elige el estilo</h2>
            <div class="estilos">
                <?php foreach ($ESTILOS as $key => $estilo): ?>
                    <button class="estilo-btn" data-estilo="<?= $key ?>">
                        <span class="icono"><?= $estilo['icono'] ?></span>
                        <span class="nombre"><?= $estilo['nombre'] ?></span>
                        <span class="descripcion"><?= $estilo['descripcion'] ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="step">
            <h2>2. Pega tu correo original</h2>
            <textarea id="correo-input" rows="8" placeholder="Pega aquí el correo que quieres corregir..."></textarea>
            <button id="corregir-btn" disabled>✨ Corregir correo</button>
        </section>

        <section class="step" id="resultado-section" style="display:none;">
            <h2>3. Resultado</h2>
            <div id="resultado" class="resultado-box"></div>
            <div class="resultado-actions">
                <button id="copiar-btn">📋 Copiar al portapapeles</button>
                <span id="meta" class="meta"></span>
            </div>
        </section>
    </main>

    <script src="js/app.js"></script>
</body>
</html>