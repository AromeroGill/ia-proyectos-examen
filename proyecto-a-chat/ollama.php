<?php
require_once __DIR__ . '/config.php';

/**
 * Llama al endpoint /api/chat de Ollama con un array de mensajes.
 * @param array $messages Array de mensajes con formato [['role' => 'user|assistant|system', 'content' => '...']]
 * @return string Respuesta del modelo
 */
function ollamaChat(array $messages): string {
    $url = OLLAMA_URL . '/api/chat';
    $payload = [
        'model' => OLLAMA_MODEL,
        'messages' => $messages,
        'stream' => false
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_TIMEOUT => 120
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        throw new Exception("Error de conexión con Ollama: $error");
    }
    if ($httpCode !== 200) {
        throw new Exception("Ollama devolvió código HTTP $httpCode: $response");
    }

    $data = json_decode($response, true);
    return $data['message']['content'] ?? '(sin respuesta)';
}
