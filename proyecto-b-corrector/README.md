# Proyecto B — Corrector de correos multi-estilo

Web que corrige correos electrónicos adaptándolos a uno de 5 estilos profesionales:
- Corporativo formal
- Técnico claro
- Comercial persuasivo
- Académico
- Informal cercano

El modelo se "entrena" mediante **few-shot learning**: el archivo `entrenamiento.json` contiene ejemplos de pares (entrada descuidada, salida corregida) para cada estilo, que se inyectan en el prompt para guiar al modelo.

## Ejercicios del temario que cubre

- **Ejercicio 4** — Corrector de correos con IA.
- **Ejercicio 5** — Entrenamiento de IA con JSON de preguntas y respuestas.

## Cómo arrancar

1. Asegúrate de que Ollama está corriendo y de tener `llama3.1:8b` descargado.
2. Arranca Apache en XAMPP.
3. Abre: http://localhost/ia-proyectos/proyecto-b-corrector/

## Modificar los ejemplos de entrenamiento

Editar `entrenamiento.json` para añadir, quitar o modificar ejemplos por estilo.
