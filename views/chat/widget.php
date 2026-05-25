
<style>
    #chat-widget {
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 380px;
        height: 600px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(0, 0, 0, 0.04);
        display: flex;
        flex-direction: column;
        z-index: 9999;
        transform: translateY(20px) scale(0.95);
        opacity: 0;
        pointer-events: none;
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        overflow: hidden;
        font-family: 'Outfit', sans-serif;
    }

    #chat-widget.open {
        transform: translateY(0) scale(1);
        opacity: 1;
        pointer-events: all;
        bottom: 100px;
    }

    #chat-toggle-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #2563EB 0%, #7C3AED 100%);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 8px 30px rgba(37, 99, 235, 0.4);
        z-index: 10000;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-radius 0.3s ease;
        border: none;
    }

    #chat-toggle-btn:hover {
        transform: scale(1.08);
        box-shadow: 0 12px 40px rgba(37, 99, 235, 0.5);
        border-radius: 22px;
    }

    #chat-toggle-btn:active {
        transform: scale(0.95);
    }

    #chat-toggle-btn svg {
        width: 28px;
        height: 28px;
        fill: white;
    }

    #chat-toggle-btn::after {
        content: '';
        position: absolute;
        top: -3px; left: -3px; right: -3px; bottom: -3px;
        border-radius: 20px;
        background: linear-gradient(135deg, #2563EB, #7C3AED);
        opacity: 0;
        z-index: -1;
        animation: btnGlow 3s infinite;
    }

    @keyframes btnGlow {
        0%, 100% { opacity: 0; transform: scale(1); }
        50% { opacity: 0.3; transform: scale(1.15); }
    }

    #chat-toggle-btn .chat-dot {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 14px;
        height: 14px;
        background: #EF4444;
        border-radius: 50%;
        border: 2.5px solid white;
        animation: dotPulse 2s infinite;
    }

    @keyframes dotPulse {
        0%, 80%, 100% { transform: scale(1); }
        40% { transform: scale(1.2); }
    }

    .chat-header {
        background: linear-gradient(135deg, #1E40AF 0%, #7C3AED 100%);
        padding: 16px 18px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
    }

    .chat-header-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chat-avatar {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
        backdrop-filter: blur(10px);
    }

    .chat-header-text h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: -0.01em;
    }

    .chat-header-text span {
        font-size: 0.72rem;
        opacity: 0.8;
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 2px;
    }

    .chat-header-text span::before {
        content: '';
        width: 7px;
        height: 7px;
        background: #34D399;
        border-radius: 50%;
        box-shadow: 0 0 8px #34D399;
    }

    .chat-header-actions {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .chat-header-actions button {
        background: rgba(255,255,255,0.15);
        border: none;
        color: white;
        width: 34px;
        height: 34px;
        border-radius: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }

    .chat-header-actions button:hover {
        background: rgba(255,255,255,0.25);
    }

    .chat-messages {
        flex: 1;
        padding: 16px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 10px;
        background: #F8FAFC;
    }

    .message {
        max-width: 82%;
        padding: 11px 15px;
        border-radius: 16px;
        font-size: 0.9rem;
        line-height: 1.55;
        position: relative;
        animation: messageSlide 0.3s ease-out;
        word-wrap: break-word;
    }

    @keyframes messageSlide {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .message.bot {
        align-self: flex-start;
        background: white;
        color: #1E293B;
        border-bottom-left-radius: 4px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border: 1px solid #E2E8F0;
    }

    .message.user {
        align-self: flex-end;
        background: linear-gradient(135deg, #2563EB, #1D4ED8);
        color: white;
        border-bottom-right-radius: 4px;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    }

    .message ul {
        margin: 6px 0;
        padding-left: 16px;
    }

    .message li {
        margin-bottom: 3px;
    }

    .message p {
        margin: 0 0 6px 0;
    }
    .message p:last-child {
        margin-bottom: 0;
    }
    .message ul, .message ol {
        margin: 4px 0 8px 18px;
        padding-left: 0;
    }
    .message strong, .message b {
        font-weight: 700;
    }
    .message a {
        text-decoration: underline;
    }
    .message.user a {
        color: #E2E8F0;
    }
    .message.bot a {
        color: #2563EB;
    }
    .message code {
        background: rgba(0,0,0,0.06);
        padding: 2px 4px;
        border-radius: 4px;
        font-family: monospace;
        font-size: 0.85em;
    }
    .message pre {
        background: #F1F5F9;
        padding: 8px;
        border-radius: 6px;
        overflow-x: auto;
        font-size: 0.85em;
    }

    .typing-indicator {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 14px 18px !important;
    }

    .typing-indicator span {
        width: 7px;
        height: 7px;
        background: #94A3B8;
        border-radius: 50%;
        animation: typingBounce 1.4s infinite ease-in-out;
    }

    .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes typingBounce {
        0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
        40% { transform: scale(1); opacity: 1; }
    }

    .chat-input-area {
        padding: 14px 16px;
        background: white;
        border-top: 1px solid #E2E8F0;
        display: flex;
        gap: 8px;
        align-items: center;
    }

    #chat-input {
        flex: 1;
        padding: 11px 16px;
        border: 1.5px solid #E2E8F0;
        border-radius: 14px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #F8FAFC;
        font-size: 0.9rem;
        font-family: 'Outfit', sans-serif;
    }

    #chat-input:focus {
        border-color: #2563EB;
        background: white;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    #chat-send {
        background: linear-gradient(135deg, #2563EB, #1D4ED8);
        color: white;
        border: none;
        width: 42px;
        height: 42px;
        border-radius: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s, box-shadow 0.2s;
        flex-shrink: 0;
    }

    #chat-send:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
    }

    #chat-send:active {
        transform: scale(0.95);
    }

    #chat-send svg {
        width: 18px;
        height: 18px;
        fill: white;
        margin-left: 1px;
    }

    .chat-messages::-webkit-scrollbar { width: 5px; }
    .chat-messages::-webkit-scrollbar-track { background: transparent; }
    .chat-messages::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }

    @media (max-width: 480px) {
        #chat-widget {
            width: calc(100vw - 20px);
            height: calc(100vh - 120px);
            right: 10px;
            bottom: 80px !important;
            border-radius: 16px;
        }
        #chat-widget.open {
            bottom: 80px;
        }
        #chat-toggle-btn {
            bottom: 16px;
            right: 16px;
            width: 54px;
            height: 54px;
            border-radius: 16px;
        }
    }
</style>

<?php
if (!isset($settings)) {
    $settings = (new \App\Models\Setting())->getAll();
}
$botName = $settings['ai_bot_name'] ?? 'Абай';
$companyNameWidget = $settings['company_name'] ?? 'Kettik Study';
?>
<div id="chat-toggle-btn">
    <svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4V4c0-1.1-.9-2-2-2zm-3 12H7c-.55 0-1-.45-1-1s.45-1 1-1h10c.55 0 1 .45 1 1s-.45 1-1 1zm0-3H7c-.55 0-1-.45-1-1s.45-1 1-1h10c.55 0 1 .45 1 1s-.45 1-1 1zm0-3H7c-.55 0-1-.45-1-1s.45-1 1-1h10c.55 0 1 .45 1 1s-.45 1-1 1z"/></svg>
    <div class="chat-dot"></div>
</div>

<div id="chat-widget">
    <div class="chat-header">
        <div class="chat-header-info">
            <div class="chat-avatar">
                <svg width="22" height="22" fill="white" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
            </div>
            <div class="chat-header-text">
                <h3>Ассистент <?= htmlspecialchars($botName) ?></h3>
                <span>Онлайн — <?= htmlspecialchars($companyNameWidget) ?></span>
            </div>
        </div>
        <div class="chat-header-actions">
            <button id="chat-clear" title="Очистить историю">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
            <button id="chat-close" title="Закрыть">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
    <div id="chat-messages" class="chat-messages">
        <div class="message bot">
            Сәлем! Я <?= htmlspecialchars($botName) ?>, твой AI-гид по поступлению. Подберу ВУЗ, расскажу про визу или про жизнь в Польше. О чем хочешь узнать?
        </div>
        <div class="flex flex-col gap-2 mt-2 px-2" id="chat-quick-actions">
            <button onclick="sendQuickAction('🎓 Оценить мои шансы на поступление')" class="text-left px-4 py-2 bg-white border border-blue-200 text-blue-700 text-sm rounded-xl hover:bg-blue-50 transition shadow-sm font-medium">🎓 Оценить мои шансы на поступление</button>
            <button onclick="sendQuickAction('📄 Список документов для визы')" class="text-left px-4 py-2 bg-white border border-blue-200 text-blue-700 text-sm rounded-xl hover:bg-blue-50 transition shadow-sm font-medium">📄 Список документов для визы</button>
            <button onclick="sendQuickAction('💰 Узнать стоимость обучения')" class="text-left px-4 py-2 bg-white border border-blue-200 text-blue-700 text-sm rounded-xl hover:bg-blue-50 transition shadow-sm font-medium">💰 Узнать стоимость обучения</button>
        </div>
    </div>
    <div class="chat-input-area">
        <input type="text" id="chat-input" placeholder="Напишите сообщение..." autocomplete="off">
        <button id="chat-send">
            <svg viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path></svg>
        </button>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
function sendQuickAction(text) {
    const input = document.getElementById('chat-input');
    const sendBtn = document.getElementById('chat-send');
    if (input && sendBtn) {
        input.value = text;
        sendBtn.click();
        const actions = document.getElementById('chat-quick-actions');
        if (actions) actions.style.display = 'none';
    }
}
</script>
