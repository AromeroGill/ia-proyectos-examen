// Cambio de pestañas
document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.mode').forEach(m => m.classList.remove('active'));
        tab.classList.add('active');
        document.getElementById('mode-' + tab.dataset.mode).classList.add('active');
    });
});

// ====== MODO CHAT ======
let chatHistory = [];
const chatForm = document.getElementById('chat-form');
const chatInput = document.getElementById('chat-input');
const chatMessages = document.getElementById('chat-messages');
const chatClear = document.getElementById('chat-clear');

function addMessage(role, content, isLoading = false) {
    const div = document.createElement('div');
    div.className = 'msg ' + role + (isLoading ? ' loading' : '');
    div.textContent = content;
    chatMessages.appendChild(div);
    chatMessages.scrollTop = chatMessages.scrollHeight;
    return div;
}

chatForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const message = chatInput.value.trim();
    if (!message) return;

    addMessage('user', message);
    chatInput.value = '';
    const loadingDiv = addMessage('assistant', 'Pensando...', true);

    try {
        const res = await fetch('api/chat.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message, history: chatHistory })
        });
        const data = await res.json();
        loadingDiv.remove();

        if (data.ok) {
            addMessage('assistant', data.reply);
            chatHistory.push({ role: 'user', content: message });
            chatHistory.push({ role: 'assistant', content: data.reply });
        } else {
            addMessage('assistant', '⚠️ Error: ' + data.error);
        }
    } catch (err) {
        loadingDiv.remove();
        addMessage('assistant', '⚠️ Error de red: ' + err.message);
    }
});

chatClear.addEventListener('click', () => {
    chatHistory = [];
    chatMessages.innerHTML = '';
});

// ====== MODO Q&A ======
const qaForm = document.getElementById('qa-form');
const qaInput = document.getElementById('qa-input');
const qaAnswer = document.getElementById('qa-answer');

qaForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const question = qaInput.value.trim();
    if (!question) return;

    qaAnswer.textContent = 'Pensando...';
    qaAnswer.style.opacity = '0.6';

    try {
        const res = await fetch('api/qa.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ question })
        });
        const data = await res.json();
        qaAnswer.style.opacity = '1';
        qaAnswer.textContent = data.ok ? data.reply : '⚠️ Error: ' + data.error;
    } catch (err) {
        qaAnswer.style.opacity = '1';
        qaAnswer.textContent = '⚠️ Error de red: ' + err.message;
    }
});