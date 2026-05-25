<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../ollama.php';

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $history = $input['history'] ?? [];
    $userMessage = $input['message'] ?? '';

    if (empty($userMessage)) {
        throw new Exception('Mensaje vacío');
    }

    // Construir el array de mensajes con system + historial + nuevo mensaje
    $messages = [['role' => 'system', 'content' => SYSTEM_PROMPT_CHAT]];
    foreach ($history as $msg) {
        $messages[] = ['role' => $msg['role'], 'content' => $msg['content']];
    }
    $messages[] = ['role' => 'user', 'content' => $userMessage];

    $reply = ollamaChat($messages);
    echo json_encode(['ok' => true, 'reply' => $reply]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}