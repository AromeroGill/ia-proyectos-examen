<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'query':
            $input = json_decode(file_get_contents('php://input'), true);
            $query = $input['query'] ?? '';
            if (empty($query)) throw new Exception('Pregunta vacía');

            $result = callBackend('POST', '/query', ['query' => $query]);
            echo $result;
            break;

        case 'upload':
            if (!isset($_FILES['file'])) throw new Exception('No se ha subido ningún archivo');
            $file = $_FILES['file'];
            if ($file['error'] !== UPLOAD_ERR_OK) throw new Exception('Error al subir el archivo');

            $result = uploadToBackend($file['tmp_name'], $file['name']);
            echo $result;
            break;

        case 'list':
            $result = callBackend('GET', '/documents');
            echo $result;
            break;

        case 'clear':
            $result = callBackend('DELETE', '/documents');
            echo $result;
            break;

        default:
            throw new Exception('Acción no válida');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}


/**
 * Llama al backend Python con un método HTTP y un body opcional.
 */
function callBackend(string $method, string $endpoint, array $body = null): string {
    $url = BACKEND_URL . $endpoint;
    $ch = curl_init($url);

    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_TIMEOUT => 180,
    ];

    if ($body !== null) {
        $options[CURLOPT_POSTFIELDS] = json_encode($body);
        $options[CURLOPT_HTTPHEADER] = ['Content-Type: application/json'];
    }

    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        throw new Exception("No se pudo conectar con el backend Python: $error");
    }
    if ($httpCode >= 400) {
        throw new Exception("Backend devolvió HTTP $httpCode: $response");
    }
    return $response;
}

/**
 * Sube un archivo al backend usando multipart/form-data.
 */
function uploadToBackend(string $filePath, string $filename): string {
    $url = BACKEND_URL . '/ingest';
    $cFile = new CURLFile($filePath, 'text/plain', $filename);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => ['file' => $cFile],
        CURLOPT_TIMEOUT => 180,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        throw new Exception("Error subiendo archivo al backend: $error");
    }
    if ($httpCode >= 400) {
        throw new Exception("Backend devolvió HTTP $httpCode: $response");
    }
    return $response;
}