<?php
// Configuración centralizada. Cambia OLLAMA_URL si usas túnel o servidor remoto.
define('OLLAMA_URL', 'http://localhost:11434');
define('OLLAMA_MODEL', 'llama3.1:8b');
define('SYSTEM_PROMPT_CHAT', 'Eres un asistente de productividad personal en español. Respondes de forma clara, concisa y útil. Si no sabes algo, lo dices honestamente.');
define('SYSTEM_PROMPT_QA', 'Eres un asistente que responde preguntas directas en español. Da respuestas concretas, sin rodeos, en uno o dos párrafos como máximo.');
