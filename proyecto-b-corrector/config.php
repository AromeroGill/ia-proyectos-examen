<?php
define('OLLAMA_URL', 'http://localhost:11434');
define('OLLAMA_MODEL', 'llama3.1:8b');
define('TRAINING_FILE', __DIR__ . '/entrenamiento.json');

// Definición de estilos disponibles
$ESTILOS = [
    'corporativo' => [
        'nombre' => 'Corporativo formal',
        'descripcion' => 'Para clientes, proveedores y superiores. Tono profesional, formal y respetuoso.',
        'icono' => '🏢'
    ],
    'tecnico' => [
        'nombre' => 'Técnico claro',
        'descripcion' => 'Para devs e IT. Directo, preciso, con estructura clara para tickets o bugs.',
        'icono' => '💻'
    ],
    'comercial' => [
        'nombre' => 'Comercial persuasivo',
        'descripcion' => 'Para ventas, captación y propuestas. Tono cercano pero persuasivo.',
        'icono' => '📈'
    ],
    'academico' => [
        'nombre' => 'Académico',
        'descripcion' => 'Para profesores, tutores y entornos universitarios. Formal, respetuoso y estructurado.',
        'icono' => '🎓'
    ],
    'informal' => [
        'nombre' => 'Informal cercano',
        'descripcion' => 'Entre compañeros de equipo. Tono natural, cercano pero profesional.',
        'icono' => '☕'
    ]
];