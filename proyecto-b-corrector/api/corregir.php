<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../ollama.php';

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $correo = trim($input['correo'] ?? '');
    $estilo = $input['estilo'] ?? '';

    if (empty($correo)) {
        throw new Exception('Debes pegar el correo a corregir');
    }
    if (empty($estilo)) {
        throw new Exception('Debes elegir un estilo');
    }

    // Cargar JSON de entrenamiento
    if (!file_exists(TRAINING_FILE)) {
        throw new Exception('No se encuentra el archivo de entrenamiento');
    }
    $entrenamiento = json_decode(file_get_contents(TRAINING_FILE), true);

    if (!isset($entrenamiento[$estilo])) {
        throw new Exception("Estilo no válido: $estilo");
    }

    // Obtener metadata del estilo (descripción)
    $estilosMeta = [
        'corporativo' => 'corporativo formal, para clientes, proveedores y superiores. Tono profesional, formal y respetuoso.',
        'tecnico' => 'técnico claro, para devs e IT. Directo, preciso, con estructura clara para tickets o bugs.',
        'comercial' => 'comercial persuasivo, para ventas, captación y propuestas. Tono cercano pero persuasivo.',
        'academico' => 'académico, para profesores y entornos universitarios. Formal, respetuoso y estructurado.',
        'informal' => 'informal cercano, entre compañeros. Tono natural, cercano pero profesional.'
    ];
    $descripcionEstilo = $estilosMeta[$estilo];

    // Construir el system prompt
    $systemPrompt = "Eres un experto corrector de correos electrónicos profesionales en español. "
                  . "Tu tarea es reescribir correos en estilo $descripcionEstilo "
                  . "Mantienes la intención original del mensaje pero corriges la redacción, gramática, ortografía y formato. "
                  . "Devuelves ÚNICAMENTE el correo corregido, sin explicaciones ni comentarios previos. "
                  . "No añadas texto del tipo 'Aquí tienes el correo:' ni nada similar. Directamente el correo.";

    // Montar mensajes con few-shot learning desde el JSON
    $messages = [['role' => 'system', 'content' => $systemPrompt]];

    foreach ($entrenamiento[$estilo] as $ejemplo) {
        $messages[] = ['role' => 'user', 'content' => $ejemplo['entrada']];
        $messages[] = ['role' => 'assistant', 'content' => $ejemplo['salida']];
    }

    // Añadir el correo real a corregir
    $messages[] = ['role' => 'user', 'content' => $correo];

    $corregido = ollamaChat($messages);

    echo json_encode([
        'ok' => true,
        'corregido' => $corregido,
        'estilo' => $estilo,
        'ejemplos_usados' => count($entrenamiento[$estilo])
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}