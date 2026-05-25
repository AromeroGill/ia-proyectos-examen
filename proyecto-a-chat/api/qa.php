<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../ollama.php';

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $question = $input['question'] ?? '';

    if (empty($question)) {
        throw new Exception('Pregunta vacía');
    }

    // Q&A sin memoria: solo system + pregunta actual
    $messages = [
        ['role' => 'system', 'content' => SYSTEM_PROMPT_QA],
        ['role' => 'user', 'content' => $question]
    ];

    $reply = ollamaChat($messages);
    echo json_encode(['ok' => true, 'reply' => $reply]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}