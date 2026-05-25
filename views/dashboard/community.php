<style>
.mobile-back-btn {
    display: none;
}

body, html {
    overflow: hidden;
}

.main-content {
    padding: 0 !important;
    height: 100vh;
    display: flex;
    flex-direction: column;
}

.messenger-layout {
    display: flex;
    flex: 1;
    height: calc(100vh - 70px);
    background: #ffffff;
    overflow: hidden;
    width: 100%;
}

.messenger-sidebar {
    width: 350px;
    border-right: 1px solid #e2e8f0;
    background: #ffffff;
    display: flex;
    flex-direction: column;
    z-index: 5;
}

.sidebar-header {
    padding: 20px 24px 15px;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(226, 232, 240, 0.5);
}

.sidebar-header-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
}

.sidebar-header h2 {
    margin: 0;
    font-size: 1.6rem;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.5px;
}

.new-chat-btn {
    background: #eff6ff;
    color: #3b82f6;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}

.new-chat-btn:hover {
    background: #dbeafe;
    transform: scale(1.05);
}

.search-bar {
    background: #f1f5f9;
    border-radius: 12px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    border: 1px solid transparent;
    transition: all 0.3s ease;
}

.search-bar:focus-within {
    border-color: #3b82f6;
    background: #ffffff;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.08);
}

.search-input {
    border: none;
    background: transparent;
    width: 100%;
    outline: none;
    font-size: 0.95rem;
    color: #334155;
}

.search-input::placeholder {
    color: #94a3b8;
}

.rooms-list {
    flex: 1;
    overflow-y: auto;
    padding: 8px 12px;
}

.rooms-list::-webkit-scrollbar {
    width: 5px;
}

.rooms-list::-webkit-scrollbar-thumb {
    background-color: #cbd5e1;
    border-radius: 10px;
}

.room-item {
    display: flex;
    align-items: center;
    padding: 14px 16px;
    border-radius: 14px;
    margin-bottom: 4px;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.room-item:hover {
    background: #f8fafc;
}

.room-item.active {
    background: #0052FF;
    box-shadow: 0 4px 15px rgba(0, 82, 255, 0.25);
}

.room-item.active .room-name, 
.room-item.active .room-preview,
.room-item.active .room-time {
    color: #ffffff !important;
}

.room-item.active .room-preview {
    opacity: 0.9;
}

.room-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    height: 60%;
    width: 4px;
    background: #ffffff;
    border-radius: 0 4px 4px 0;
}

.room-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    font-weight: 700;
    color: white;
    margin-right: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    flex-shrink: 0;
    border: 2px solid white;
}

.room-item.active .room-avatar {
    border-color: rgba(255,255,255,0.3);
}

.avatar-general { background: linear-gradient(135deg, #001a70, #0052FF); }
.avatar-city { background: linear-gradient(135deg, #065f46, #10b981); }

.room-info {
    flex: 1;
    min-width: 0;
}

.room-top {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 6px;
}

.room-name {
    font-weight: 700;
    color: #1e293b;
    font-size: 1.05rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: color 0.1s;
}

.room-time {
    font-size: 0.75rem;
    color: #94a3b8;
    font-weight: 500;
    transition: color 0.1s;
}

.room-preview {
    font-size: 0.9rem;
    color: #64748b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: color 0.1s;
}

.messenger-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #F8FAFC;
    position: relative;
}

.chat-header {
    background: #ffffff !important;
    padding: 12px 24px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    z-index: 10;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    flex-shrink: 0;
}

.header-left {
    display: flex;
    align-items: center;
}

.header-info {
    margin-left: 14px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.header-name {
    margin: 0;
    font-size: 1.15rem;
    color: #0f172a;
    font-weight: 700;
    line-height: 1.2;
}

.header-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin-top: 2px;
}

.msg-bubble img {
    max-width: 100%;
    border-radius: 8px;
    margin-top: 5px;
}

.emoji-picker {
    display: none;
    position: absolute;
    bottom: 60px;
    right: 20px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    padding: 10px;
    width: 250px;
    z-index: 50;
    grid-template-columns: repeat(5, 1fr);
    gap: 8px;
    max-height: 200px;
    overflow-y: auto;
}

.emoji-item {
    font-size: 24px;
    text-align: center;
    cursor: pointer;
    padding: 5px;
    border-radius: 8px;
    transition: background 0.2s;
    user-select: none;
}

.emoji-item:hover {
    background: #f1f5f9;
}

.msg-actions {
    position: absolute;
    top: 4px;
    right: 4px;
    opacity: 0;
    transition: opacity 0.2s;
    z-index: 10;
}

.message:hover .msg-actions {
    opacity: 1;
}

.msg-actions-btn {
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #64748b;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.msg-actions-btn:hover {
    background: #ffffff;
    color: #0f172a;
}

.msg-actions-dropdown {
    display: none;
    position: absolute;
    right: 0;
    top: 28px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    min-width: 120px;
    overflow: hidden;
    z-index: 20;
}

.msg-action-item {
    padding: 8px 12px;
    font-size: 13px;
    color: #334155;
    cursor: pointer;
    transition: background 0.2s;
}

.msg-action-item:hover {
    background: #f1f5f9;
}

.msg-action-item.text-red-500 {
    color: #ef4444;
}

.unread-badge {
    background: #ef4444;
    color: white;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 700;
    min-width: 18px;
    height: 18px;
    padding: 0 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: auto;
    flex-shrink: 0;
}

.msg-reactions {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin-top: 6px;
}

.reaction-chip {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #f1f5f9;
    border: 1.5px solid #e2e8f0;
    border-radius: 999px;
    padding: 3px 10px 3px 7px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.18s ease;
    user-select: none;
    font-weight: 500;
    color: #334155;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}

.reaction-chip span.emoji { font-size: 15px; }
.reaction-chip span.count { font-size: 12px; font-weight: 700; color: #475569; }

.reaction-chip:hover {
    background: #e2e8f0;
    transform: scale(1.07);
    border-color: #cbd5e1;
}

.reaction-chip.mine {
    background: #eff6ff;
    border-color: #93c5fd;
    color: #1d4ed8;
    box-shadow: 0 0 0 2px rgba(59,130,246,0.15);
}

.reaction-chip.mine span.count { color: #1d4ed8; }

.reaction-chip.mine:hover {
    background: #dbeafe;
}

.msg-sent .reaction-chip {
    background: rgba(255,255,255,0.15);
    border-color: rgba(255,255,255,0.3);
    color: white;
}

.msg-sent .reaction-chip span.count { color: rgba(255,255,255,0.9); }

.msg-sent .reaction-chip.mine {
    background: rgba(255,255,255,0.3);
    border-color: rgba(255,255,255,0.6);
    box-shadow: 0 0 0 2px rgba(255,255,255,0.2);
}

.msg-sent .reaction-chip:hover {
    background: rgba(255,255,255,0.25);
}

.quick-react-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    right: -30px;
    background: white;
    border: 1.5px solid #e2e8f0;
    border-radius: 50%;
    width: 26px;
    height: 26px;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.2s, transform 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    z-index: 5;
    color: #64748b;
    line-height: 1;
}

.msg-sent .quick-react-btn {
    right: auto;
    left: -30px;
}

.message:hover .quick-react-btn {
    opacity: 1;
    transform: translateY(-50%) scale(1.1);
}

.quick-react-picker {
    display: none;
    position: absolute;
    bottom: 100%;
    right: -10px;
    margin-bottom: 6px;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 6px 8px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    flex-direction: row;
    gap: 2px;
    z-index: 200;
    white-space: nowrap;
    animation: fadeInUp 0.15s ease;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(4px); }
    to   { opacity: 1; transform: translateY(0); }
}

.msg-sent .quick-react-picker { right: auto; left: -10px; }

.quick-react-emoji {
    font-size: 22px;
    cursor: pointer;
    padding: 4px;
    border-radius: 8px;
    transition: background 0.15s, transform 0.15s;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.quick-react-emoji:hover { background: #f1f5f9; transform: scale(1.25); }

.msg-reply-quote {
    background: rgba(0, 82, 255, 0.06);
    border-left: 3px solid #0052FF;
    border-radius: 6px;
    padding: 6px 10px;
    margin-bottom: 8px;
    overflow: hidden;
    max-width: 100%;
    cursor: pointer;
}

.reply-quote-author {
    font-size: 11px;
    font-weight: 700;
    color: #0052FF;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.reply-quote-text {
    font-size: 12px;
    color: #475569;
    line-height: 1.4;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.msg-sent .msg-reply-quote {
    background: rgba(0,0,0,0.15);
    border-left-color: rgba(255,255,255,0.5);
}

.msg-sent .reply-quote-author {
    color: rgba(255,255,255,0.9);
}

.msg-sent .reply-quote-text {
    color: rgba(255,255,255,0.72);
}

#reply-bar {
    display: none;
    align-items: center;
    gap: 12px;
    padding: 10px 16px;
    background: linear-gradient(90deg, #eff6ff, #f0f4ff);
    border-top: 2px solid #0052FF;
    font-size: 13px;
    color: #334155;
}

#reply-bar svg {
    flex-shrink: 0;
    opacity: 0.7;
}

#reply-bar .reply-preview {
    flex: 1;
    overflow: hidden;
}

#reply-bar .reply-name {
    font-weight: 700;
    color: #0052FF;
    margin-bottom: 2px;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

#reply-bar .reply-text-content {
    font-size: 13px;
    color: #475569;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

#reply-bar button {
    background: none;
    border: none;
    cursor: pointer;
    color: #94a3b8;
    font-size: 18px;
    padding: 4px;
    flex-shrink: 0;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s, color 0.15s;
}

#reply-bar button:hover {
    background: rgba(239,68,68,0.1);
    color: #ef4444;
}

#chat-search-bar {
    display: none;
    padding: 12px 20px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    gap: 10px;
    align-items: center;
}

#chat-search-bar input {
    flex: 1;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s;
}

#chat-search-bar input:focus {
    border-color: #0052FF;
}

.search-result-item {
    padding: 10px 16px;
    border-bottom: 1px solid #f1f5f9;
    cursor: pointer;
    transition: background 0.15s;
}

.search-result-item:hover { background: #f8fafc; }

.search-result-author {
    font-weight: 600;
    font-size: 12px;
    color: #0052FF;
    margin-bottom: 2px;
}

.search-result-text {
    font-size: 13px;
    color: #334155;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

#search-results-panel {
    position: absolute;
    top: 60px;
    left: 0;
    right: 0;
    background: white;
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    border-radius: 0 0 12px 12px;
    max-height: 300px;
    overflow-y: auto;
    z-index: 30;
    display: none;
}

.online-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #22c55e;
    border: 2px solid white;
    position: absolute;
    bottom: 0;
    right: 0;
}

.room-avatar {
    position: relative;
}

.messages-area {
    flex: 1;
    padding: 30px 5% 20px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.messages-area::-webkit-scrollbar {
    width: 6px;
}

.messages-area::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.15);
    border-radius: 10px;
}

.message {
    max-width: 65%;
    display: flex;
    flex-direction: column;
    position: relative;
    animation: slideUpMessage 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes slideUpMessage {
    from { opacity: 0; transform: translateY(20px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.msg-received {
    align-self: flex-start;
}

.msg-sent {
    align-self: flex-end;
}

.msg-bubble {
    padding: 10px 16px;
    border-radius: 18px;
    font-size: 1rem;
    line-height: 1.45;
    position: relative;
    word-wrap: break-word;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
}


.msg-received .msg-bubble {
    background: #ffffff;
    color: #1e293b;
    border-bottom-left-radius: 4px;
    margin-left: 10px;
}

.msg-received .msg-bubble::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: -10px;
    width: 14px;
    height: 14px;
    background: radial-gradient(circle at top left, transparent 14px, #ffffff 15px);
    z-index: 10;
}

.msg-sent .msg-bubble {
    background: #0052FF;
    color: #ffffff;
    border-bottom-right-radius: 4px;
    margin-right: 10px;
}

.msg-sent .msg-bubble::before {
    content: '';
    position: absolute;
    bottom: 0;
    right: -10px;
    width: 14px;
    height: 14px;
    background: radial-gradient(circle at top right, transparent 14px, #0052FF 15px);
    z-index: 10;
}

.msg-author {
    font-size: 0.8rem;
    font-weight: 700;
    color: #0052FF;
    margin-bottom: 5px;
    padding-left: 2px;
}

.msg-sent .msg-author {
    display: none;
}

.msg-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 6px;
    margin-top: 4px;
}

.msg-time {
    font-size: 0.7rem;
    margin-top: 5px;
    font-weight: 500;
}

.msg-received .msg-time {
    color: #94a3b8;
    text-align: right;
}

.msg-sent .msg-time {
    color: rgba(255, 255, 255, 0.8);
}

.msg-status-icon {
    margin-top: 4px;
}

.msg-system {
    align-self: center;
    max-width: 85%;
    margin: 8px 0;
}

.msg-system .msg-bubble {
    background: rgba(148, 163, 184, 0.15);
    color: #475569;
    font-size: 0.85rem;
    padding: 8px 16px;
    border-radius: 20px;
    text-align: center;
    box-shadow: none;
    border: 1px solid rgba(148, 163, 184, 0.3);
}

.msg-broadcast {
    align-self: flex-start;
    width: 100%;
    max-width: 95%;
    margin-bottom: 12px;
}

.msg-broadcast .msg-bubble {
    background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
    border-left: 4px solid #ef4444;
    color: #1e293b;
    padding: 16px 20px;
    border-radius: 0 16px 16px 16px;
    box-shadow: 0 4px 10px -1px rgba(239, 68, 68, 0.1), 0 2px 5px -1px rgba(0, 0, 0, 0.05);
    font-size: 1.05rem;
    line-height: 1.5;
}

.msg-broadcast .msg-author {
    color: #ef4444;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    font-weight: 700;
}

.msg-broadcast .msg-time {
    color: #94a3b8;
    text-align: right;
    margin-top: 8px;
    border-top: 1px solid rgba(0,0,0,0.05);
    padding-top: 6px;
    font-size: 0.7rem;
    font-weight: 500;
}

.msg-system .msg-bubble::before {
    display: none;
}

.msg-system .msg-author, .msg-system .msg-footer {
    display: none;
}

.input-area {
    padding: 16px 5%;
    background: transparent;
    position: relative;
}

.input-area::before {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 100%;
    background: linear-gradient(to top, rgba(248, 250, 252, 1) 40%, rgba(248, 250, 252, 0));
    z-index: 0;
}

.input-wrapper {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: flex-end;
    background: #ffffff;
    border-radius: 28px;
    padding: 10px 12px;
    gap: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
    border: 1px solid rgba(226, 232, 240, 0.8);
}

.attach-btn, .emoji-btn {
    color: #94a3b8;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 10px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    flex-shrink: 0;
}

.attach-btn:hover, .emoji-btn:hover {
    color: #3b82f6;
    background: #f1f5f9;
}

.msg-input {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    font-family: inherit;
    font-size: 1.05rem;
    resize: none;
    min-height: 24px;
    max-height: 150px;
    line-height: 24px;
    padding: 8px 0;
    color: #0f172a;
    overflow-y: auto;
}

.msg-input::placeholder {
    color: #94a3b8;
}

.send-btn {
    background: #0052FF;
    color: white;
    border: none;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    flex-shrink: 0;
}

.send-btn:hover {
    background: #003cc2;
    transform: scale(1.08);
    box-shadow: 0 4px 12px rgba(0, 82, 255, 0.3);
}

.send-btn:active {
    transform: scale(0.95);
}

.send-btn:disabled {
    background: #cbd5e1;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    background: #f8fafc;
}

.empty-state-card {
    background: transparent;
    text-align: center;
    max-width: 320px;
}

.empty-state-icon {
    width: 100px;
    height: 100px;
    background: white;
    color: #0052FF;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    box-shadow: 0 10px 30px rgba(0, 82, 255, 0.15);
}

.empty-state h3 {
    color: #0f172a;
    margin: 0 0 12px 0;
    font-size: 1.4rem;
    font-weight: 800;
}

.empty-state p {
    margin: 0;
    font-size: 1rem;
    color: #64748b;
    line-height: 1.5;
}

@media (max-width: 768px) {
    .main-content {
        padding: 0 !important;
        margin-left: 0 !important;
        max-width: 100% !important;
    }

    .content-wrapper {
        padding: 0 !important;
        margin: 0 !important;
    }

    .messenger-layout {
        flex-direction: column;
        height: 100svh;
        height: 100vh;
        width: 100%;
        overflow: hidden;
    }

    .messenger-sidebar {
        width: 100%;
        height: 100%;
        flex: 1;
        border-right: none;
        display: flex;
        flex-direction: column;
    }

    .messenger-sidebar.mobile-hidden {
        display: none;
    }

    .sidebar-header {
        padding: 16px 18px 12px;
    }

    .sidebar-header-top {
        margin-bottom: 14px;
    }

    .sidebar-header h2 {
        font-size: 1.4rem;
    }

    .rooms-list {
        flex-direction: column;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 8px 12px;
        flex: 1;
    }

    .room-item {
        flex-direction: row;
        padding: 14px 16px;
        min-width: unset;
        text-align: left;
        background: #ffffff;
        border: none;
        box-shadow: none;
    }

    .room-item.active::before {
        display: none;
    }

    .room-avatar {
        margin: 0 14px 0 0;
        width: 50px;
        height: 50px;
    }

    .room-info {
        display: flex !important;
        flex-direction: column;
    }

    .messenger-main {
        width: 100%;
        height: 100%;
        flex: 1;
        display: none;
    }

    .messenger-main.mobile-visible {
        display: flex;
        flex-direction: column;
    }

    .mobile-back-btn {
        display: flex !important;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: none;
        cursor: pointer;
        color: #0052FF;
        padding: 6px;
        border-radius: 8px;
        margin-right: 4px;
        transition: background 0.2s;
        flex-shrink: 0;
    }

    .mobile-back-btn:active {
        background: #eff6ff;
    }

    .chat-header {
        padding: 10px 14px;
    }

    .header-name {
        font-size: 1rem;
    }

    .header-subtitle {
        font-size: 0.78rem;
    }

    .message {
        max-width: 88%;
    }

    .messages-area {
        padding: 16px 12px 12px;
        gap: 12px;
    }

    .input-area {
        padding: 10px 12px;
        padding-bottom: max(10px, env(safe-area-inset-bottom));
    }

    .input-wrapper {
        padding: 6px 10px;
        gap: 8px;
        border-radius: 22px;
    }

    .attach-btn, .emoji-btn {
        padding: 7px;
    }

    .msg-input {
        font-size: 1rem;
    }

    .send-btn {
        width: 40px;
        height: 40px;
    }

    .emoji-picker {
        right: 10px;
        bottom: 70px;
        width: 220px;
    }

    .quick-react-btn {
        display: none;
    }

    .msg-actions {
        opacity: 1;
    }
}

@media (max-width: 360px) {
    .room-avatar {
        width: 42px;
        height: 42px;
        font-size: 1rem;
    }

    .sidebar-header h2 {
        font-size: 1.2rem;
    }
}
</style>
<?php if (!isset($isAdminView)) $isAdminView = strpos($_SERVER['REQUEST_URI'], '/admin') !== false; ?>
<div class="messenger-layout">
    <div class="messenger-sidebar">
        <div class="sidebar-header">
            <div class="sidebar-header-top">
                <h2><?= __('messages') ?></h2>
                <div style="display:flex; gap:10px;">
                    <a href="#" onclick="openManagerWhatsApp(event)" class="new-chat-btn" style="background:#25D366; color:white; width:36px; height:36px; box-shadow: 0 4px 10px rgba(37,211,102,0.3);" title="<?= __('contact_manager') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg>
                    </a>
                </div>
            </div>
            <div class="search-bar">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#94a3b8" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>
                <input type="text" class="search-input" placeholder="<?= __('search_wip') ?>">
            </div>
        </div>
        <div class="rooms-list" id="rooms-list">
            <div style="padding:40px 20px; text-align:center; color:#94a3b8;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="animation: spin 2s linear infinite; opacity: 0.5;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                <p style="margin-top:15px; font-weight:500;"><?= __('connecting') ?></p>
            </div>
        </div>
    </div>

    <div class="messenger-main" id="chat-mainArea" style="display:none;">
        <div class="chat-header">
            <button class="mobile-back-btn" id="mobile-back-btn" onclick="closeMobileChat()" title="<?= __('back') ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
            </button>
            <div class="header-left">
                <div class="room-avatar" id="current-room-icon">#</div>
                <div class="header-info">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <h3 class="header-name" id="current-room-name"><?= __('chat') ?></h3>
                        <?php if ($isAdminView): ?>
                        <button onclick="openEditRoomModal()" title="<?= __('edit_chat') ?>" style="background:none; border:none; cursor:pointer; color:#94a3b8; padding:4px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg>
                        </button>
                        <?php endif; ?>
                    </div>
                    <div class="header-subtitle"><?= __('student_community') ?></div>
                </div>
            </div>
            <button onclick="toggleSearch()" title="Поиск" style="background:transparent; border:none; cursor:pointer; color:#64748b; padding:6px; border-radius:8px; transition:background 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='transparent'">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>
            </button>
        </div>

        <div id="chat-search-bar" style="display:none; padding:12px 20px; background:#f8fafc; border-bottom:1px solid #e2e8f0; gap:10px; align-items:center;">
            <input id="search-query" type="text" placeholder="<?= __('search_in_chat') ?>" onkeyup="if(event.key==='Enter') doSearch(); if(event.key==='Escape') toggleSearch();" style="flex:1; border:1px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:14px; outline:none;">
            <button onclick="doSearch()" style="background:#0052FF; color:white; border:none; border-radius:8px; padding:8px 14px; cursor:pointer; font-size:13px;"><?= __('find_btn') ?></button>
            <button onclick="toggleSearch()" style="background:transparent; border:none; cursor:pointer; color:#94a3b8;">&#10005;</button>
        </div>
        <div id="search-results-panel" style="display:none;"></div>

        <div class="messages-area" id="chat-messages">
        </div>

        <div class="input-area">
            <div id="reply-bar">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0052FF" viewBox="0 0 16 16" style="flex-shrink:0"><path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933z"/></svg>
                <div class="reply-preview">
                    <div class="reply-name" id="reply-author-name"></div>
                    <div class="reply-text-content" id="reply-text-preview"></div>
                </div>
                <button onclick="cancelReply()">&#10005;</button>
            </div>
            <div id="attachment-preview" style="display: none; padding: 8px 16px; background: #f8fafc; border-top: 1px solid #e2e8f0; align-items: center; justify-content: space-between; border-radius: 12px 12px 0 0; font-size: 13px; color: #475569;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z"/></svg>
                    <span id="attachment-name" style="font-weight:500; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width: 200px;">filename.pdf</span>
                </div>
                <button onclick="clearAttachment()" style="background:none; border:none; cursor:pointer; color:#ef4444; padding:4px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
                </button>
            </div>
            <div class="input-wrapper">
                <input type="file" id="chat-attachment-input" style="display:none;" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar" onchange="handleAttachment(this)">
                <input type="hidden" id="edit-message-id" value="">
                <button class="attach-btn" title="<?= __('attach_file') ?>" id="attach-btn" onclick="document.getElementById('chat-attachment-input').click()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16"><path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z"/></svg>
                </button>
                <textarea id="chat-input" class="msg-input" placeholder="<?= __('enter_message') ?>" rows="1" onkeydown="if(event.key === 'Enter' && !event.shiftKey) { event.preventDefault(); sendMessage(); }"></textarea>
                <button class="emoji-btn" title="<?= __('cancel_edit_title') ?>" id="cancel-edit-btn" style="display:none; color:#ef4444;" onclick="cancelEdit()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16"><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
                </button>
                <button class="emoji-btn" title="<?= __('emoji_title') ?>" id="emoji-btn" onclick="toggleEmojiPicker()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/></svg>
                </button>
                <div id="emoji-picker" class="emoji-picker">
                    <div class="emoji-item" data-insert-emoji="1">😀</div>
                    <div class="emoji-item" data-insert-emoji="1">😂</div>
                    <div class="emoji-item" data-insert-emoji="1">🥰</div>
                    <div class="emoji-item" data-insert-emoji="1">😎</div>
                    <div class="emoji-item" data-insert-emoji="1">🤔</div>
                    <div class="emoji-item" data-insert-emoji="1">👍</div>
                    <div class="emoji-item" data-insert-emoji="1">👎</div>
                    <div class="emoji-item" data-insert-emoji="1">🙏</div>
                    <div class="emoji-item" data-insert-emoji="1">🔥</div>
                    <div class="emoji-item" data-insert-emoji="1">🎉</div>
                    <div class="emoji-item" data-insert-emoji="1">✨</div>
                    <div class="emoji-item" data-insert-emoji="1">💯</div>
                    <div class="emoji-item" data-insert-emoji="1">❤️</div>
                    <div class="emoji-item" data-insert-emoji="1">💔</div>
                    <div class="emoji-item" data-insert-emoji="1">✅</div>
                    <div class="emoji-item" data-insert-emoji="1">❌</div>
                    <div class="emoji-item" data-insert-emoji="1">💡</div>
                    <div class="emoji-item" data-insert-emoji="1">🚀</div>
                    <div class="emoji-item" data-insert-emoji="1">👀</div>
                    <div class="emoji-item" data-insert-emoji="1">🙌</div>
                </div>
                <button class="send-btn" id="send-btn" onclick="sendMessage()">
                    <svg id="send-btn-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-left: -2px;"><path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z"/></svg>
                </button>
            </div>
        </div>
    </div>
    
    <div class="messenger-main empty-state" id="chat-emptyState">
        <div class="empty-state-card">
            <div class="empty-state-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" /></svg>
            </div>
            <h3><?= __('no_open_chats') ?></h3>
            <p><?= __('select_chat_to_start') ?></p>
        </div>
    </div>
</div>

<?php if ($isAdminView): ?>
<div id="editRoomModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl relative" style="animation: slideUpMessage 0.3s ease-out">
        <button onclick="document.getElementById('editRoomModal').style.display='none'" class="absolute -top-12 right-0 text-white hover:text-gray-200">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <h3 class="text-xl font-bold text-gray-900 mb-6"><?= __('edit_chat') ?></h3>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?= __('chat_name_label') ?></label>
                <input type="text" id="editRoomName" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#0052FF] focus:ring-2 focus:ring-[#0052FF]/20" placeholder="<?= __('chat_name_label') ?>">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?= __('avatar_url_label') ?></label>
                <input type="text" id="editRoomAvatarUrl" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#0052FF] focus:ring-2 focus:ring-[#0052FF]/20" placeholder="https://example.com/logo.png">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?= __('or_upload_file') ?></label>
                <input type="file" id="editRoomAvatarFile" accept="image/*" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#0052FF] focus:ring-2 focus:ring-[#0052FF]/20">
                <p class="text-xs text-gray-500 mt-1"><?= __('leave_empty_for_gradient') ?></p>
            </div>
        </div>

        <button onclick="saveRoomSettings()" class="w-full mt-8 bg-[#0052FF] hover:bg-blue-700 text-white font-medium py-3 rounded-xl transition-all shadow-md">
            <?= __('save_changes_btn') ?>
        </button>
    </div>
</div>
<?php endif; ?>

<script>
    let currentRoomId = null;
    let lastMessageId = 0;
    let pollInterval = null;
    let eventSource = null;
    let knownMessageIds = new Set();
    
    let studentName = '';
    let managerPhone = '';

    fetch('<?= BASE_URL ?>/api/profile/details')
        .then(r => r.json())
        .then(data => {
            if(data.user) studentName = data.user.full_name;
            if(data.details && data.details.manager_phone) {
                managerPhone = data.details.manager_phone;
            }
        });

    function openManagerWhatsApp(e) {
        if(e) e.preventDefault();
        const phone = managerPhone.replace(/\D/g, '') || '77777777777';
        const text = `<?= __('whatsapp_hello') ?>`.replace('{name}', studentName);
        window.open(`https://wa.me/${phone}?text=${encodeURIComponent(text)}`, '_blank');
    }

    function loadRooms() {
        fetch('<?= BASE_URL ?>/api/chat/rooms')
            .then(res => {
                if(res.status === 403) {
                    alert('<?= __('access_denied_enrolled_only') ?>');
                    window.location.href = '<?= BASE_URL ?>/dashboard';
                    throw new Error('Forbidden');
                }
                return res.text();
            })
            .then(text => {
                let data;
                try { data = JSON.parse(text); } catch(e) { console.error('Parse Error', text); return; }
                if(!data || !data.rooms) return;
                
                const container = document.getElementById('rooms-list');
                container.innerHTML = '';

                data.rooms.forEach(room => {
                    const isGeneral = room.type === 'general';
                    const icon = isGeneral ? 'K' : room.name.replace('Чат ', '').charAt(0);
                    const cssClass = isGeneral ? 'avatar-general' : 'avatar-city';
                    const bgStyle = room.avatar ? `background-image: url('${room.avatar}'); background-size: cover; background-position: center; color: transparent;` : '';
                    
                    const div = document.createElement('div');
                    div.className = `room-item`;
                    div.id = `room-tab-${room.id}`;
                    div.onclick = () => selectRoom(room, cssClass, icon);
                    
                    div.innerHTML = `
                        <div class="room-avatar ${cssClass}" style="${bgStyle}">${room.avatar ? '' : icon}</div>
                        <div class="room-info">
                            <div class="room-top">
                                <span class="room-name">${room.name}</span>
                                <span class="room-time"><?= __('now') ?></span>
                            </div>
                            <div class="room-preview"><?= __('click_to_open') ?></div>
                        </div>
                    `;
                    container.appendChild(div);
                });

                const urlParams = new URLSearchParams(window.location.search);
                const targetRoomId = urlParams.get('room_id');
                if (targetRoomId) {
                    const targetRoom = data.rooms.find(r => r.id == targetRoomId);
                    if (targetRoom) {
                        const isGen = targetRoom.type === 'general';
                        const icn = isGen ? 'K' : targetRoom.name.replace('Чат ', '').charAt(0);
                        const clss = isGen ? 'avatar-general' : 'avatar-city';
                        selectRoom(targetRoom, clss, icn);
                        
                        window.history.replaceState({}, document.title, window.location.pathname);
                    }
                }
            })
            .catch(err => console.error(err));
    }

    function isMobile() {
        return window.innerWidth <= 768;
    }

    function openMobileChat() {
        if (!isMobile()) return;
        const sidebar = document.querySelector('.messenger-sidebar');
        const messengerMain = document.querySelector('.messenger-main');
        const backBtn = document.getElementById('mobile-back-btn');
        sidebar.classList.add('mobile-hidden');
        if (messengerMain) messengerMain.classList.add('mobile-visible');
        if (backBtn) backBtn.style.display = 'flex';
    }

    function closeMobileChat() {
        const sidebar = document.querySelector('.messenger-sidebar');
        const messengerMain = document.querySelector('.messenger-main');
        const backBtn = document.getElementById('mobile-back-btn');
        sidebar.classList.remove('mobile-hidden');
        if (messengerMain) messengerMain.classList.remove('mobile-visible');
        if (backBtn) backBtn.style.display = 'none';
    }

    window.addEventListener('resize', () => {
        if (!isMobile()) {
            const sidebar = document.querySelector('.messenger-sidebar');
            const messengerMain = document.querySelector('.messenger-main');
            const backBtn = document.getElementById('mobile-back-btn');
            sidebar.classList.remove('mobile-hidden');
            if (messengerMain) messengerMain.classList.remove('mobile-visible');
            if (backBtn) backBtn.style.display = 'none';
        }
    });

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function selectRoom(room, cssClass, iconLetter) {
        currentRoomId = room.id;
        lastMessageId = 0;
        knownMessageIds.clear();
        
        document.querySelectorAll('.room-item').forEach(el => el.classList.remove('active'));
        document.getElementById(`room-tab-${room.id}`).classList.add('active');
        
        document.getElementById('chat-emptyState').style.display = 'none';
        document.getElementById('chat-mainArea').style.display = 'flex';
        
        document.getElementById('current-room-name').textContent = room.name;
        
        if (document.getElementById('editRoomName')) {
            document.getElementById('editRoomName').value = room.name;
            if (document.getElementById('editRoomAvatarUrl')) {
                document.getElementById('editRoomAvatarUrl').value = room.avatar && room.avatar.startsWith('http') ? room.avatar : (room.avatar || '');
            }
            if (document.getElementById('editRoomAvatarFile')) {
                document.getElementById('editRoomAvatarFile').value = '';
            }
        }

        const iconEl = document.getElementById('current-room-icon');
        iconEl.className = `room-avatar ${cssClass}`;
        
        if (room.avatar) {
            iconEl.style.backgroundImage = `url('${room.avatar}')`;
            iconEl.style.backgroundSize = 'cover';
            iconEl.style.backgroundPosition = 'center';
            iconEl.textContent = '';
        } else {
            iconEl.style.backgroundImage = '';
            iconEl.textContent = iconLetter;
        } 

        document.getElementById('chat-messages').innerHTML = '<div style="text-align:center; padding:30px; font-weight:500; color:#94a3b8;"><?= __('loading_messages') ?></div>';
        
        if(pollInterval) clearInterval(pollInterval);
        if(eventSource) { eventSource.close(); eventSource = null; }

        eventSource = new EventSource(`<?= BASE_URL ?>/api/chat/stream?room_id=${currentRoomId}&after_id=${lastMessageId}`);
        eventSource.onmessage = function(e) {
            try {
                const data = JSON.parse(e.data);
                if(data.messages && data.messages.length > 0) {
                    renderMessages(data.messages);
                }
            } catch(err) {
                console.error('SSE Error:', err);
            }
        };

        openMobileChat();
    }


    function loadMessages() {
        if(!currentRoomId) return;

        fetch(`<?= BASE_URL ?>/api/chat/messages?room_id=${currentRoomId}&after_id=${lastMessageId}`)
            .then(res => res.json())
            .then(data => {
                if(!data || !data.messages) return;
                renderMessages(data.messages);
            })
            .catch(err => console.error(err));
    }

    function renderMessages(messages) {
        const container = document.getElementById('chat-messages');
        if(lastMessageId === 0) container.innerHTML = '';

        let hasNewMsg = false;
        messages.forEach(msg => {
            if (knownMessageIds.has(msg.id)) return;
            knownMessageIds.add(msg.id);
            
            const div = document.createElement('div');
                    
                    let isSystemMsg = false;
                    let displayMsg = msg.message;
                    
                    if (msg.role === 'admin' && msg.message.startsWith('/sys ')) {
                        isSystemMsg = true;
                        displayMsg = msg.message.substring(5);
                    }
                    
                    if (isSystemMsg) {
                        div.className = 'message msg-system';
                        const formattedMsg = escapeHtml(displayMsg).replace(/\n/g, '<br>');
                        div.innerHTML = `<div class="msg-bubble">&#128276; ${formattedMsg}</div>`;
                    } else {
                        const isBroadcast = msg.role === 'admin' && displayMsg.includes('📢');
                        div.className = `message ${isBroadcast ? 'msg-broadcast' : (msg.is_mine ? 'msg-sent' : 'msg-received')}`;

                        const userRole = <?= json_encode($user['role'] ?? 'student') ?>;
                        const isSystemRole = msg.role === 'admin' || msg.role === 'manager';
                        const adminBadge = (isSystemRole && !msg.is_mine) ? `<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="${isBroadcast ? '#ef4444' : '#0052FF'}" viewBox="0 0 16 16" title="Verified Staff"><path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/></svg>` : '';
                        const authorHtml = msg.is_mine ? '' : `<div class="msg-author" style="display:flex; align-items:center; gap:4px;">${isBroadcast ? '<?= __('admin_kettik_study') ?>' : escapeHtml(msg.author_name)}${adminBadge}</div>`;
                        
                        let finalMsg = displayMsg ? displayMsg : '';
                        finalMsg = finalMsg.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

                        const formattedMsg = escapeHtml(finalMsg).replace(/\n/g, '<br>');
                        
                        let actionMenuHtml = '';
                        const msgTimeTimestamp = new Date(msg.created_at).getTime();
                        const now = new Date().getTime();
                        const minutesPassed = (now - msgTimeTimestamp) / 60000;
                        const canEdit = msg.is_mine && minutesPassed <= 15;
                        const isAdminOrManager = userRole === 'admin' || userRole === 'manager';
                        const canDelete = isAdminOrManager || (msg.is_mine && minutesPassed <= 15);

                        const safeAuthor = escapeHtml(msg.author_name || '<?= __('you') ?>');
                        const safePreview = escapeHtml(displayMsg.substring(0, 80));

                        actionMenuHtml = `
                                <div class="msg-actions">
                                    <button class="msg-actions-btn" onclick="toggleMsgActions(${msg.id})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/></svg>
                                    </button>
                                    <div class="msg-actions-dropdown" id="msg-actions-${msg.id}">
                                        <div class="msg-action-item" data-action="reply" data-msg-id="${msg.id}" data-author="${safeAuthor}" data-preview="${safePreview}"><?= __('reply_action') ?></div>
                                        ${canEdit ? `<div class="msg-action-item" data-action="edit" data-msg-id="${msg.id}" data-text="${escapeHtml(displayMsg.substring(0,500))}"><?= __('edit_action') ?></div>` : ''}
                                        ${canDelete ? `<div class="msg-action-item text-red-500" onclick="deleteMessage(${msg.id})"><?= __('delete_action') ?></div>` : ''}
                                    </div>
                                </div>
                            `;

                        let attachmentHtml = '';
                        if (msg.attachment_url) {
                            const isImage = msg.attachment_url.match(/\.(jpeg|jpg|gif|png|webp)$/i) != null;
                            const safeUrl = escapeHtml(msg.attachment_url);
                            if (isImage) {
                                attachmentHtml = `<div style="margin-bottom:8px; border-radius:8px; overflow:hidden;"><a href="${safeUrl}" target="_blank"><img src="${safeUrl}" style="max-width:100%; max-height:250px; display:block; border-radius:8px; object-fit:cover;"></a></div>`;
                            } else {
                                const filename = escapeHtml(msg.attachment_url.split('/').pop() || 'file');
                                attachmentHtml = `<div style="margin-bottom:8px;"><a href="${safeUrl}" target="_blank" style="display:inline-flex; align-items:center; gap:8px; background:rgba(0,0,0,0.05); padding:8px 12px; border-radius:8px; text-decoration:none; color:inherit; font-size:14px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z"/></svg> <span style="font-weight:500;">${filename}</span></a></div>`;
                            }
                        }

                        const checkmark = msg.is_mine ? `
                            <svg class="msg-status-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="rgba(255,255,255,0.8)" viewBox="0 0 16 16">
                                <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z"/>
                            </svg>` : '';

                        const editedLabel = msg.is_edited ? '<span style="font-size:10px; opacity:0.7; margin-right:4px;"><?= __('edited_label') ?></span>' : '';

                        let reactionsHtml = '';
                        if (msg.reactions && msg.reactions.length > 0) {
                            reactionsHtml = '<div class="msg-reactions">';
                            msg.reactions.forEach(r => {
                                const mineClass = r.mine ? ' mine' : '';
                                reactionsHtml += `<span class="reaction-chip${mineClass}" data-action="quick-react" data-msg-id="${msg.id}" data-emoji="${r.emoji}"><span class="emoji">${r.emoji}</span><span class="count">${r.count}</span></span>`;
                            });
                            reactionsHtml += '</div>';
                        }

                        let replyHtml = '';
                        if (msg.reply_to_text) {
                            const rAuthor = escapeHtml(msg.reply_to_author || msg.author_name || '');
                            const rText = escapeHtml(msg.reply_to_text.substring(0, 100));
                            replyHtml = `<div class="msg-reply-quote"><div class="reply-quote-author">${rAuthor}</div><div class="reply-quote-text">${rText}</div></div>`;
                        }

                        const _emojiEl = document.createElement('span');
                        const quickEmojis = ['&#128077;','&#10084;&#65039;','&#128514;','&#128293;','&#128558;'].map(function(h){_emojiEl.innerHTML=h;return _emojiEl.textContent;});
                        const quickReactHtml = `
                            <button class="quick-react-btn" data-action="toggle-picker" data-msg-id="${msg.id}" title="\uD83D\uDE00+">+</button>
                            <div class="quick-react-picker" id="qrp-${msg.id}">
                                ${quickEmojis.map(e => `<span class="quick-react-emoji" data-action="quick-react" data-msg-id="${msg.id}" data-emoji="${e}">${e}</span>`).join('')}
                            </div>
                        `;

                        div.innerHTML = `
                            ${authorHtml}
                            <div class="msg-bubble" style="position:relative;">
                                ${actionMenuHtml}
                                ${quickReactHtml}
                                ${replyHtml}
                                ${attachmentHtml}
                                ${formattedMsg}
                                <div class="msg-footer">
                                    ${editedLabel}
                                    <span class="msg-time">${msg.time}</span>
                                    ${checkmark}
                                </div>
                            </div>
                            ${reactionsHtml}
                        `;
                    }
                    container.appendChild(div);
                    lastMessageId = msg.id;
                    hasNewMsg = true;
                });

                if(hasNewMsg) scrollToBottom();
    }

    function handleAttachment(input) {
        if (input.files && input.files[0]) {
            document.getElementById('attachment-preview').style.display = 'flex';
            document.getElementById('attachment-name').textContent = input.files[0].name;
            document.querySelector('.input-wrapper').style.borderRadius = '0 0 24px 24px';
            document.querySelector('.input-wrapper').style.borderTop = 'none';
        } else {
            clearAttachment();
        }
    }

    function clearAttachment() {
        document.getElementById('chat-attachment-input').value = '';
        document.getElementById('attachment-preview').style.display = 'none';
        document.getElementById('attachment-name').textContent = '';
        document.querySelector('.input-wrapper').style.borderRadius = '';
        document.querySelector('.input-wrapper').style.borderTop = '';
    }

    function sendMessage() {
        if(!currentRoomId) return;
        
        const input = document.getElementById('chat-input');
        const fileInput = document.getElementById('chat-attachment-input');
        const btn = document.getElementById('send-btn');
        const text = input.value.trim();
        const file = fileInput.files && fileInput.files.length > 0 ? fileInput.files[0] : null;
        const editId = document.getElementById('edit-message-id').value;

        if(!text && !file) return;

        input.disabled = true;
        btn.disabled = true;

        if (editId) {
            fetch('<?= BASE_URL ?>/api/chat/messages/edit', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message_id: editId, message: text })
            })
            .then(res => res.json())
            .then(res => {
                if(res.success) {
                    cancelEdit(); // Reset UI
                    lastMessageId = 0; // Force full reload to show edits properly
                    knownMessageIds.clear();
                    loadMessages();
                } else {
                    alert(res.error || '<?= __('edit_error') ?>');
                }
            })
            .finally(() => {
                input.disabled = false;
                btn.disabled = false;
                input.focus();
            });
        } else {
            const replyId = window._replyToId || null;
            const replyText = window._replyToText || null;

            const formData = new FormData();
            formData.append('room_id', currentRoomId);
            formData.append('message', text);
            if (file) formData.append('attachment', file);
            if (replyId) formData.append('reply_to_id', replyId);
            if (replyText) formData.append('reply_to_text', replyText);

            fetch('<?= BASE_URL ?>/api/chat/messages', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if(res.success) {
                    input.value = '';
                    input.style.height = '24px';
                    clearAttachment();
                    cancelReply();
                    loadMessages();
                } else {
                    alert(res.error || '<?= __('send_error') ?>');
                }
            })
            .finally(() => {
                input.disabled = false;
                btn.disabled = false;
                input.focus();
            });
        }
    }

    window.toggleMsgActions = function(id) {
        document.querySelectorAll('.msg-actions-dropdown').forEach(el => {
            if (el.id !== `msg-actions-${id}`) el.style.display = 'none';
        });
        const dropdown = document.getElementById(`msg-actions-${id}`);
        if(dropdown) {
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }
    };

    document.addEventListener('click', function(e) {
        const item = e.target.closest('[data-action]');
        if (!item) return;
        const action = item.dataset.action;
        const msgId = parseInt(item.dataset.msgId);

        if (action === 'reply') {
            const author = item.dataset.author || 'Вы';
            const preview = item.dataset.preview || '';
            window.startReply(msgId, author, preview);
            document.querySelectorAll('.msg-actions-dropdown').forEach(el => el.style.display = 'none');

        } else if (action === 'edit') {
            const text = item.dataset.text || '';
            window.startEditMessage(msgId, text);
            document.querySelectorAll('.msg-actions-dropdown').forEach(el => el.style.display = 'none');

        } else if (action === 'toggle-picker') {
            e.stopPropagation();
            const picker = document.getElementById(`qrp-${msgId}`);
            document.querySelectorAll('.quick-react-picker').forEach(p => {
                if (p !== picker) p.style.display = 'none';
            });
            if (picker) picker.style.display = picker.style.display === 'flex' ? 'none' : 'flex';

        } else if (action === 'quick-react') {
            e.stopPropagation();
            const emoji = item.dataset.emoji;
            window.toggleReaction(msgId, emoji);
            const picker = document.getElementById(`qrp-${msgId}`);
            if (picker) picker.style.display = 'none';
        }
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.quick-react-picker') && !e.target.closest('[data-action="toggle-picker"]')) {
            document.querySelectorAll('.quick-react-picker').forEach(p => p.style.display = 'none');
        }
        if (!e.target.closest('.msg-actions-dropdown') && !e.target.closest('.msg-actions-btn')) {
            document.querySelectorAll('.msg-actions-dropdown').forEach(el => el.style.display = 'none');
        }
        if (!e.target.closest('#emoji-picker') && !e.target.closest('.emoji-btn')) {
            const ep = document.getElementById('emoji-picker');
            if (ep) ep.style.display = 'none';
        }
    });

    document.addEventListener('click', function(e) {
        const el = e.target.closest('[data-insert-emoji]');
        if (el) {
            e.stopPropagation();
            insertEmoji(el.textContent.trim());
        }
    });

    function toggleEmojiPicker() {
        const picker = document.getElementById('emoji-picker');
        picker.style.display = picker.style.display === 'grid' ? 'none' : 'grid';
    }

    function insertEmoji(emoji) {
        const input = document.getElementById('chat-input');
        const start = input.selectionStart;
        const end = input.selectionEnd;
        const text = input.value;
        input.value = text.substring(0, start) + emoji + text.substring(end);
        input.selectionStart = input.selectionEnd = start + emoji.length;
        input.focus();
        toggleEmojiPicker();
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.msg-actions')) {
            document.querySelectorAll('.msg-actions-dropdown').forEach(el => el.style.display = 'none');
        }
        if (!e.target.closest('#emoji-picker') && !e.target.closest('#emoji-btn')) {
            document.getElementById('emoji-picker').style.display = 'none';
        }
    });

    window.deleteMessage = function(id) {
        if(!confirm('<?= __('delete_msg_confirm') ?>')) return;
        fetch('<?= BASE_URL ?>/api/chat/messages/delete', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ message_id: id })
        })
        .then(res => res.json())
        .then(res => {
            if(res.success) {
                lastMessageId = 0; // Force reload to apply deletion
                knownMessageIds.clear();
                loadMessages();
            } else {
                alert(res.error || '<?= __('delete_error') ?>');
            }
        });
    }

    window.startEditMessage = function(id, text) {
        document.getElementById('edit-message-id').value = id;
        const input = document.getElementById('chat-input');
        input.value = text;
        input.focus();
        
        document.getElementById('attach-btn').style.display = 'none';
        document.getElementById('emoji-btn').style.display = 'none';
        document.getElementById('cancel-edit-btn').style.display = 'block';
        document.getElementById('send-btn-icon').innerHTML = '<path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>';
        clearAttachment();
    }

    window.cancelEdit = function() {
        document.getElementById('edit-message-id').value = '';
        const input = document.getElementById('chat-input');
        input.value = '';
        
        document.getElementById('attach-btn').style.display = 'block';
        document.getElementById('emoji-btn').style.display = 'block';
        document.getElementById('cancel-edit-btn').style.display = 'none';
        document.getElementById('send-btn-icon').innerHTML = '<path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z"/>';
    }

    document.getElementById('chat-input').addEventListener('input', function() {
        this.style.height = '24px';
        this.style.height = (this.scrollHeight) + 'px';
        if(this.value === '') this.style.height = '24px';
    });

    function scrollToBottom() {
        const container = document.getElementById('chat-messages');
        container.scrollTop = container.scrollHeight;
    }

    document.addEventListener('DOMContentLoaded', loadRooms);

    function openEditRoomModal() {
        document.getElementById('editRoomModal').style.display = 'flex';
    }

    function saveRoomSettings() {
        if (!currentRoomId) return;
        const name = document.getElementById('editRoomName').value.trim();
        const avatarUrl = document.getElementById('editRoomAvatarUrl') ? document.getElementById('editRoomAvatarUrl').value.trim() : '';
        const avatarFileInput = document.getElementById('editRoomAvatarFile');
        const avatarFile = avatarFileInput && avatarFileInput.files.length > 0 ? avatarFileInput.files[0] : null;
        
        if (!name) {
            alert('<?= __('name_required') ?>');
            return;
        }

        const formData = new FormData();
        formData.append('id', currentRoomId);
        formData.append('name', name);
        formData.append('avatar_url', avatarUrl);
        if (avatarFile) {
            formData.append('avatar', avatarFile);
        }

        fetch('<?= BASE_URL ?>/api/admin/chat-rooms', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                document.getElementById('editRoomModal').style.display = 'none';
                loadRooms(); // Refresh to show new avatar/name
            } else {
                alert(res.error || '<?= __('save_error') ?>');
            }
        })
        .catch(err => console.error(err));
    }

    function loadUnreadBadges() {
        fetch('<?= BASE_URL ?>/api/chat/unread')
            .then(r => r.json())
            .then(data => {
                document.querySelectorAll('.unread-badge').forEach(el => el.remove());
                const counts = data.unread || {};
                Object.entries(counts).forEach(([roomId, count]) => {
                    if (!count) return;
                    const roomEl = document.querySelector(`.room-item[data-room-id="${roomId}"]`);
                    if (roomEl) {
                        const badge = document.createElement('span');
                        badge.className = 'unread-badge';
                        badge.textContent = count > 99 ? '99+' : count;
                        roomEl.appendChild(badge);
                    }
                });
            }).catch(() => {});
    }

    setInterval(loadUnreadBadges, 10000);
    document.addEventListener('DOMContentLoaded', () => setTimeout(loadUnreadBadges, 1500));

    window.toggleReaction = function(messageId, emoji) {
        fetch('<?= BASE_URL ?>/api/chat/messages/react', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ message_id: messageId, emoji: emoji })
        })
        .then(r => r.json())
        .then(() => {
            lastMessageId = 0;
            knownMessageIds.clear();
            loadMessages();
        })
        .catch(err => console.error(err));
    };

    window.toggleQuickPicker = function(btn, msgId, event) {
        event.stopPropagation();
        const picker = btn.nextElementSibling;
        document.querySelectorAll('.quick-react-picker').forEach(p => {
            if (p !== picker) p.style.display = 'none';
        });
        picker.style.display = picker.style.display === 'flex' ? 'none' : 'flex';
    };

    window._replyToId = null;
    window._replyToText = null;

    window.startReply = function(msgId, authorName, msgText) {
        window._replyToId = msgId;
        window._replyToText = msgText;
        document.getElementById('reply-author-name').textContent = authorName;
        document.getElementById('reply-text-preview').textContent = msgText;
        const replyBar = document.getElementById('reply-bar');
        replyBar.style.display = 'flex';
        document.getElementById('chat-input').focus();
    };

    function cancelReply() {
        window._replyToId = null;
        window._replyToText = null;
        document.getElementById('reply-bar').style.display = 'none';
        document.getElementById('reply-author-name').textContent = '';
        document.getElementById('reply-text-preview').textContent = '';
    }

    function toggleSearch() {
        const bar = document.getElementById('chat-search-bar');
        const panel = document.getElementById('search-results-panel');
        const isVisible = bar.style.display === 'flex';
        bar.style.display = isVisible ? 'none' : 'flex';
        if (isVisible) {
            panel.style.display = 'none';
            panel.innerHTML = '';
        } else {
            document.getElementById('search-query').focus();
        }
    }

    function doSearch() {
        const q = document.getElementById('search-query').value.trim();
        if (!q || !currentRoomId) return;
        const panel = document.getElementById('search-results-panel');
        panel.innerHTML = '<div style="padding:16px; color:#94a3b8; text-align:center;"><?= __('searching') ?></div>';
        panel.style.display = 'block';
        fetch(`<?= BASE_URL ?>/api/chat/messages/search?q=${encodeURIComponent(q)}&room_id=${currentRoomId}`)
            .then(r => r.json())
            .then(data => {
                if (!data.results || data.results.length === 0) {
                    panel.innerHTML = '<div style="padding:16px; color:#94a3b8; text-align:center;"><?= __('nothing_found') ?></div>';
                    return;
                }
                panel.innerHTML = '';
                data.results.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'search-result-item';
                    const safeMessage = escapeHtml(item.message);
                    const highlighted = safeMessage.replace(new RegExp(escapeHtml(q), 'gi'), m => `<mark style="background:#fef08a">${m}</mark>`);
                    div.innerHTML = `<div class="search-result-author">${escapeHtml(item.author_name)} · ${escapeHtml(item.time)}</div><div class="search-result-text">${highlighted}</div>`;
                    panel.appendChild(div);
                });
            })
            .catch(() => { panel.innerHTML = '<div style="padding:16px; color:#ef4444;"><?= __('search_error') ?></div>'; });
    }

    function sendPing() {
        if (!currentRoomId) return;
        fetch('<?= BASE_URL ?>/api/chat/ping', { method: 'POST' }).catch(() => {});
    }
    setInterval(sendPing, 30000);
    document.addEventListener('DOMContentLoaded', sendPing);

</script>
