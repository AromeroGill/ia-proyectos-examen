const estiloBtns = document.querySelectorAll('.estilo-btn');
const correoInput = document.getElementById('correo-input');
const corregirBtn = document.getElementById('corregir-btn');
const resultadoSection = document.getElementById('resultado-section');
const resultadoDiv = document.getElementById('resultado');
const copiarBtn = document.getElementById('copiar-btn');
const metaSpan = document.getElementById('meta');

let estiloSeleccionado = null;

function actualizarBoton() {
    corregirBtn.disabled = !(estiloSeleccionado && correoInput.value.trim());
}

estiloBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        estiloBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        estiloSeleccionado = btn.dataset.estilo;
        actualizarBoton();
    });
});

correoInput.addEventListener('input', actualizarBoton);

corregirBtn.addEventListener('click', async () => {
    const correo = correoInput.value.trim();
    if (!correo || !estiloSeleccionado) return;

    resultadoSection.style.display = 'block';
    resultadoDiv.classList.add('loading');
    resultadoDiv.textContent = 'Corrigiendo correo... (puede tardar 10-20 segundos)';
    metaSpan.textContent = '';
    corregirBtn.disabled = true;

    try {
        const res = await fetch('api/corregir.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ correo, estilo: estiloSeleccionado })
        });
        const data = await res.json();
        resultadoDiv.classList.remove('loading');

        if (data.ok) {
            resultadoDiv.textContent = data.corregido;
            metaSpan.textContent = `✓ Estilo: ${data.estilo} · Ejemplos de entrenamiento usados: ${data.ejemplos_usados}`;
        } else {
            resultadoDiv.textContent = '⚠️ Error: ' + data.error;
        }
    } catch (err) {
        resultadoDiv.classList.remove('loading');
        resultadoDiv.textContent = '⚠️ Error de red: ' + err.message;
    } finally {
        corregirBtn.disabled = false;
    }
});

copiarBtn.addEventListener('click', () => {
    const texto = resultadoDiv.textContent;
    navigator.clipboard.writeText(texto).then(() => {
        copiarBtn.textContent = '✅ ¡Copiado!';
        setTimeout(() => { copiarBtn.textContent = '📋 Copiar al portapapeles'; }, 1500);
    });
});