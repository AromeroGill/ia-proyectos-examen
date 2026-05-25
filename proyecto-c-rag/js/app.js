const uploadForm = document.getElementById('upload-form');
const fileInput = document.getElementById('file-input');
const uploadStatus = document.getElementById('upload-status');
const docsList = document.getElementById('docs-list');
const clearBtn = document.getElementById('clear-btn');
const queryForm = document.getElementById('query-form');
const queryInput = document.getElementById('query-input');
const answerSection = document.getElementById('answer-section');
const answerDiv = document.getElementById('answer');
const fuentesDiv = document.getElementById('fuentes');

// ===== Listar documentos =====
async function loadDocs() {
    try {
        const res = await fetch('api/proxy.php?action=list');
        const data = await res.json();
        const docs = data.documentos || [];

        if (docs.length === 0) {
            docsList.innerHTML = '<p class="empty">Sin documentos</p>';
        } else {
            docsList.innerHTML = docs.map(d => `
                <div class="doc-item">
                    <div class="doc-name">📄 ${d.filename}</div>
                    <div class="doc-meta">${d.fragmentos} fragmentos indexados</div>
                </div>
            `).join('');
        }
    } catch (err) {
        docsList.innerHTML = '<p class="empty">Error cargando documentos</p>';
    }
}

// ===== Subir documento =====
uploadForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const file = fileInput.files[0];
    if (!file) return;

    uploadStatus.className = 'status loading';
    uploadStatus.textContent = `Procesando "${file.name}"... (puede tardar 10-30s)`;

    const fd = new FormData();
    fd.append('file', file);

    try {
        const res = await fetch('api/proxy.php?action=upload', {
            method: 'POST',
            body: fd
        });
        const data = await res.json();

        if (data.ok) {
            uploadStatus.className = 'status success';
            uploadStatus.textContent = `✓ ${data.filename} indexado (${data.fragmentos} fragmentos)`;
            fileInput.value = '';
            await loadDocs();
        } else {
            uploadStatus.className = 'status error';
            uploadStatus.textContent = '⚠️ ' + (data.error || 'Error desconocido');
        }
    } catch (err) {
        uploadStatus.className = 'status error';
        uploadStatus.textContent = '⚠️ Error de red: ' + err.message;
    }
});

// ===== Hacer pregunta =====
queryForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const query = queryInput.value.trim();
    if (!query) return;

    answerSection.style.display = 'block';
    answerDiv.textContent = 'Pensando... (puede tardar 15-40s)';
    answerDiv.style.opacity = '0.6';
    fuentesDiv.innerHTML = '';

    try {
        const res = await fetch('api/proxy.php?action=query', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ query })
        });
        const data = await res.json();
        answerDiv.style.opacity = '1';

        if (data.respuesta) {
            answerDiv.textContent = data.respuesta;
            fuentesDiv.innerHTML = (data.fuentes || []).map(f => `
                <div class="fuente-item">
                    <div class="fuente-file">📄 ${f.filename}</div>
                    <div class="fuente-text">${f.fragmento}</div>
                </div>
            `).join('') || '<p style="opacity:0.6;">Sin fuentes</p>';
        } else if (data.error) {
            answerDiv.textContent = '⚠️ ' + data.error;
        } else {
            answerDiv.textContent = '⚠️ Respuesta vacía';
        }
    } catch (err) {
        answerDiv.style.opacity = '1';
        answerDiv.textContent = '⚠️ Error: ' + err.message;
    }
});

// ===== Borrar todos =====
clearBtn.addEventListener('click', async () => {
    if (!confirm('¿Borrar todos los documentos indexados?')) return;
    try {
        await fetch('api/proxy.php?action=clear');
        await loadDocs();
        answerSection.style.display = 'none';
    } catch (err) {
        alert('Error: ' + err.message);
    }
});

// ===== Carga inicial =====
loadDocs();