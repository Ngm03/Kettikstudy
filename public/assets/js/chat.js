document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('chat-toggle-btn');
    const closeBtn = document.getElementById('chat-close');
    const widget = document.getElementById('chat-widget');
    const messagesContainer = document.getElementById('chat-messages');

    let sendBtn = document.getElementById('chat-send');
    let input = document.getElementById('chat-input');
    const inputArea = document.querySelector('.chat-input-area');

    function toggleChat() {
        widget.classList.toggle('open');
        if (widget.classList.contains('open')) {
            checkAuth();
            if (input) input.focus();
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    toggleBtn.addEventListener('click', toggleChat);
    closeBtn.addEventListener('click', toggleChat);

    document.getElementById('chat-clear').addEventListener('click', (e) => {
        e.stopPropagation();
        if (!confirm('Очистить историю чата?')) return;
        localStorage.removeItem('chat_history');
        messagesContainer.innerHTML = '';
        appendMessage('История очищена. Начните новый диалог!', 'bot');
    });

    let isAuthenticated = false;

    async function checkAuth() {
        try {
            const res = await fetch(`${window.BASE_URL}/api/auth/me`);
            if (res.ok) {
                if (!isAuthenticated) {
                    isAuthenticated = true;
                }
            } else {
                isAuthenticated = false;
            }
        } catch (e) {
            isAuthenticated = false;
        }
        restoreInputArea();
    }

    checkAuth();

    function showLoginPrompt() {
        inputArea.innerHTML = `
            <div class="auth-buttons" style="width: 100%; display: flex; gap: 10px; padding: 4px 0;">
                <a href="${window.BASE_URL}/login" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 11px; background: #2563EB; color: white; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 0.9rem; font-family: 'Outfit', sans-serif; transition: background 0.2s;">
                    Войти
                </a>
                <a href="${window.BASE_URL}/register" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 11px; background: #F1F5F9; color: #475569; border: 1px solid #E2E8F0; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 0.9rem; font-family: 'Outfit', sans-serif; transition: background 0.2s;">
                    Регистрация
                </a>
            </div>
        `;

        const lastMsg = messagesContainer.lastElementChild;
        if (!lastMsg || !lastMsg.innerHTML.includes('пожалуйста, авторизуйтесь')) {
            const authMessage = document.createElement('div');
            authMessage.classList.add('message', 'bot');
            authMessage.innerHTML = 'Чтобы начать общение и получить персональный подбор ВУЗов, пожалуйста, авторизуйтесь.';
            messagesContainer.appendChild(authMessage);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        input = null;
        sendBtn = null;
    }

    function restoreInputArea() {
        if (inputArea.querySelector('input')) return;

        inputArea.innerHTML = `
            <input type="text" id="chat-input" placeholder="Напишите сообщение..." autocomplete="off">
            <button id="chat-send">
                <svg viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path></svg>
            </button>
        `;

        input = document.getElementById('chat-input');
        sendBtn = document.getElementById('chat-send');

        sendBtn.addEventListener('click', sendMessage);
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });
    }

    async function sendMessage() {
        if (!input) return;

        const text = input.value.trim();
        if (!text) return;

        appendMessage(text, 'user');
        saveToHistory('user', text);
        input.value = '';

        const typing = document.createElement('div');
        typing.classList.add('message', 'bot', 'typing-indicator');
        typing.innerHTML = '<span></span><span></span><span></span>';
        messagesContainer.appendChild(typing);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        try {
            const htmlLang = document.documentElement.lang || 'ru';
            const langCookieMatch = document.cookie.match(/(?:^|; )lang=([^;]*)/);
            const userLang = langCookieMatch ? langCookieMatch[1] : htmlLang;

            const response = await fetch(`${window.BASE_URL}/api/chat/send?lang=${userLang}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    message: text,
                    history: getChatHistory(),
                    session_id: getSessionId()
                })
            });

            typing.remove();

            const data = await response.json();

            if (response.ok) {
                if (data.response) {
                    appendMessage(data.response, 'bot');
                    saveToHistory('bot', data.response);
                }
                if (data.manager_button) {
                    const btn = document.createElement('div');
                    btn.style.cssText = 'animation: messageSlide 0.3s ease-out; margin-top: -5px;';
                    btn.innerHTML = `
                        <a href="${data.manager_button.whatsapp_url}" target="_blank" 
                           style="display:flex; align-items:center; gap:10px; background:linear-gradient(135deg, #25D366, #128C7E); 
                                  color:white; padding:14px 20px; border-radius:16px; text-decoration:none; 
                                  font-weight:600; font-size:0.95rem; box-shadow:0 4px 15px rgba(37,211,102,0.3);
                                  transition: all 0.3s; max-width:85%;">
                            <svg width="24" height="24" fill="white" viewBox="0 0 16 16"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg>
                            <div>
                                <div>Связаться с ${data.manager_button.manager_name}</div>
                                <div style="font-size:0.75rem; opacity:0.85; font-weight:400;">Нажмите для перехода в WhatsApp</div>
                            </div>
                        </a>
                    `;
                    messagesContainer.appendChild(btn);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            } else {
                if (response.status === 401) {
                    showLoginPrompt();
                    isAuthenticated = false;
                } else {
                    appendMessage('Ошибка сервера. Попробуйте позже.', 'bot');
                }
            }

        } catch (error) {
            typing.remove();
            console.error('Chat Error:', error);
            appendMessage('Ошибка соединения. Проверьте интернет.', 'bot');
        }
    }

    if (sendBtn) sendBtn.addEventListener('click', sendMessage);
    if (input) input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });

    function saveToHistory(sender, text) {
        let history = getChatHistory();
        history.push({ sender, text });
        if (history.length > 100) history = history.slice(-100);
        localStorage.setItem('chat_history', JSON.stringify(history));
    }

    function getSessionId() {
        let sessionId = localStorage.getItem('chat_session_id');
        if (!sessionId) {
            sessionId = 'sess_' + Math.random().toString(36).substr(2, 9);
            localStorage.setItem('chat_session_id', sessionId);
        }
        return sessionId;
    }

    function getChatHistory() {
        return JSON.parse(localStorage.getItem('chat_history') || '[]');
    }

    const history = getChatHistory();
    if (history.length > 0) {
        messagesContainer.innerHTML = '';
        history.forEach(msg => appendMessage(msg.text, msg.sender));
    }

    function appendMessage(text, sender) {
        const div = document.createElement('div');
        div.classList.add('message', sender);

        let html = text;

        if (typeof marked !== 'undefined') {
            try {
                marked.use({
                    breaks: true,
                    gfm: true
                });
                html = marked.parse(text);
            } catch (e) {
                console.error('Markdown parse error:', e);
                html = text.replace(/\n/g, '<br>');
            }
        } else {
            html = text.replace(/\n/g, '<br>');
        }

        div.innerHTML = html;
        messagesContainer.appendChild(div);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});
