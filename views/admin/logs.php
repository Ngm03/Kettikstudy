<div class="ad-logs-wrapper">
    <div class="ad-header">
        <div class="ad-header-left">
            <h1 class="ad-page-title">Системные Логи Сервера</h1>
            <p class="ad-page-subtitle">В режиме реального времени отслеживаются ошибки PHP, предупреждения и критические сбои платформы.</p>
        </div>
        <div class="ad-header-right">
            <button class="ad-btn ad-btn-outline" onclick="loadLogs()" style="margin-right: 8px;">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px; height:16px; display:inline-block; vertical-align:middle;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <?= __('refresh_btn') ?>
            </button>
            <button class="ad-btn ad-btn-danger" onclick="clearLogs()">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px; height:16px; display:inline-block; vertical-align:middle;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Очистить логи
            </button>
        </div>
    </div>

    <!-- Статистика по логам -->
    <div class="log-stats-grid">
        <div class="log-stat-card border-left-blue">
            <div class="stat-icon-wrapper text-blue bg-blue-light">ℹ️</div>
            <div class="stat-info">
                <span class="stat-title">Лог-файл</span>
                <span class="stat-val font-mono" style="font-size: 0.85rem;">logs/app.log</span>
            </div>
        </div>
        <div class="log-stat-card border-left-red">
            <div class="stat-icon-wrapper text-red bg-red-light">🚨</div>
            <div class="stat-info">
                <span class="stat-title">Ошибки (Errors)</span>
                <span id="error-count" class="stat-val text-red">0</span>
            </div>
        </div>
        <div class="log-stat-card border-left-yellow">
            <div class="stat-icon-wrapper text-yellow bg-yellow-light">⚠️</div>
            <div class="stat-info">
                <span class="stat-title">Предупреждения</span>
                <span id="warning-count" class="stat-val text-yellow">0</span>
            </div>
        </div>
        <div class="log-stat-card border-left-gray">
            <div class="stat-icon-wrapper text-gray bg-gray-light">📋</div>
            <div class="stat-info">
                <span class="stat-title">Всего записей</span>
                <span id="total-count" class="stat-val">0</span>
            </div>
        </div>
    </div>

    <div class="ad-table-container">
        <table class="ad-table" id="desktopTable">
            <thead>
                <tr>
                    <th style="width: 140px;">Уровень</th>
                    <th style="width: 200px;">Время (Timestamp)</th>
                    <th>Сообщение об ошибке (Log Message)</th>
                </tr>
            </thead>
            <tbody id="logs-list">
                <tr><td colspan="3" style="text-align: center; padding: 3rem; color: #64748b;"><?= __('loading_history') ?></td></tr>
            </tbody>
        </table>
    </div>

    <div class="ad-mobile-cards" id="mobileCards">
    </div>

    <div id="toast" class="ad-toast">
        <svg class="ad-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span id="toastText">Логи успешно очищены!</span>
    </div>
</div>

<style>
.ad-logs-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    color: #1e293b;
}

.ad-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}
.ad-page-title {
    font-size: 1.875rem;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.025em;
    margin: 0 0 0.5rem 0;
}
.ad-page-subtitle {
    color: #64748b;
    font-size: 0.95rem;
    margin: 0;
}
.ad-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    font-size: 0.875rem;
    font-weight: 600;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    outline: none;
}
.ad-btn-outline {
    background: #fff;
    color: #475569;
    border: 1.5px solid #cbd5e1;
}
.ad-btn-outline:hover {
    background: #f8fafc;
    border-color: #94a3b8;
}
.ad-btn-danger {
    background: #dc2626;
    color: white;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
}
.ad-btn-danger:hover {
    background: #b91c1c;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(220, 38, 38, 0.3);
}

/* Виджеты статистики логов */
.log-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}
.log-stat-card {
    background: white;
    border-radius: 14px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -2px rgba(0,0,0,0.02);
    border: 1px solid rgba(226, 232, 240, 0.8);
    transition: all 0.2s;
}
.log-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
}
.border-left-blue { border-left: 4px solid #0052FF; }
.border-left-red { border-left: 4px solid #ef4444; }
.border-left-yellow { border-left: 4px solid #f59e0b; }
.border-left-gray { border-left: 4px solid #64748b; }

.stat-icon-wrapper {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}
.bg-blue-light { background: #eff6ff; }
.bg-red-light { background: #fef2f2; }
.bg-yellow-light { background: #fffbeb; }
.bg-gray-light { background: #f8fafc; }

.text-blue { color: #2563eb; }
.text-red { color: #dc2626; }
.text-yellow { color: #d97706; }
.text-gray { color: #475569; }

.stat-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.stat-title {
    font-size: 0.75rem;
    color: #64748b;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 0.5px;
}
.stat-val {
    font-size: 1.25rem;
    font-weight: 800;
    color: #1e293b;
}

.ad-table-container {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.025);
    border: 1px solid rgba(226, 232, 240, 0.8);
    overflow: hidden;
    margin-bottom: 2rem;
}
.ad-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}
.ad-table th {
    background: #f8fafc;
    padding: 1rem 1.25rem;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
    font-weight: 600;
    border-bottom: 1px solid #e2e8f0;
}
.ad-table td {
    padding: 1rem 1.25rem;
    vertical-align: top;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.9rem;
}
.ad-table tbody tr {
    transition: background 0.15s;
}
.ad-table tbody tr:hover {
    background: #f8fafc;
}
.ad-table tbody tr:last-child td {
    border-bottom: none;
}

/* Colored Rows & Tints */
.row-error {
    background: #fff8f8;
}
.row-error:hover {
    background: #fef1f1 !important;
}
.row-warning {
    background: #fffff6;
}
.row-warning:hover {
    background: #fffdf0 !important;
}

.ad-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 1.5px solid transparent;
}
.ad-badge-red {
    background: #fef2f2;
    color: #991b1b;
    border-color: #fee2e2;
}
.ad-badge-yellow {
    background: #fffbeb;
    color: #92400e;
    border-color: #fef3c7;
}
.ad-badge-blue {
    background: #eff6ff;
    color: #1e40af;
    border-color: #dbeafe;
}

.timestamp-cell {
    color: #64748b;
    font-size: 0.85rem;
    font-weight: 500;
    white-space: nowrap;
}

.message-cell {
    font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
    font-size: 0.82rem;
    color: #1e293b;
    word-break: break-all;
    line-height: 1.5;
}
.text-red-msg {
    color: #b91c1c;
    font-weight: 600;
}

.ad-mobile-cards {
    display: none;
}
.ad-card {
    background: white;
    border-radius: 16px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.03);
    border: 1px solid rgba(226, 232, 240, 0.8);
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}
.card-error {
    border-left: 4px solid #ef4444;
    background: #fff8f8;
}
.card-warning {
    border-left: 4px solid #f59e0b;
    background: #fffff6;
}
.card-info {
    border-left: 4px solid #0052FF;
}

.ad-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.ad-toast {
    position: fixed;
    bottom: 1.5rem;
    right: 1.5rem;
    background: #10b981;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    transform: translateY(150%);
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 50;
    font-weight: 600;
}
.ad-toast.show {
    transform: translateY(0);
    opacity: 1;
}
.ad-toast .ad-icon {
    width: 20px;
    height: 20px;
}

@media (max-width: 768px) {
    .ad-header { flex-direction: column; align-items: flex-start; }
    .ad-header-right { width: 100%; display: flex; gap: 8px; }
    .ad-btn { flex: 1; justify-content: center; }
    
    .ad-table-container { display: none; }
    .ad-mobile-cards { display: block; }
}
</style>

<script>
function loadLogs() {
    const tableBody = document.getElementById('logs-list');
    const mobileCards = document.getElementById('mobileCards');

    tableBody.innerHTML = `<tr><td colspan="3" style="text-align: center; padding: 3rem; color: #64748b;"><svg class="animate-spin inline mr-2 text-gray-400" width="20" height="20" fill="none" viewBox="0 0 24 24" style="animation: spin 1.2s linear infinite; display: inline-block; vertical-align: middle; margin-right: 8px;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" style="opacity: 0.25;"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" style="opacity: 0.75;"></path></svg><?= __('updating_list') ?></td></tr>`;
    mobileCards.innerHTML = `<div style="text-align: center; padding: 2rem; color: #64748b;"><?= __('updating_list') ?></div>`;

    fetch(`${window.BASE_URL}/api/admin/logs`)
        .then(res => res.json())
        .then(data => {
            if (!data.logs || data.logs.length === 0) {
                const emptyMsg = `<tr><td colspan="3" style="text-align: center; padding: 3rem; color: #64748b;">Лог-файл пуст. Ошибок не обнаружено.</td></tr>`;
                tableBody.innerHTML = emptyMsg;
                mobileCards.innerHTML = `<div style="text-align: center; padding: 3rem; color: #64748b;">Лог-файл пуст. Ошибок не обнаружено.</div>`;
                
                document.getElementById('error-count').textContent = '0';
                document.getElementById('warning-count').textContent = '0';
                document.getElementById('total-count').textContent = '0';
                return;
            }
            
            let tableHtml = '';
            let cardsHtml = '';
            let errs = 0, warns = 0;

            data.logs.forEach(log => {
                let badgeClass = 'ad-badge-blue';
                let badgeLabel = 'INFO';
                let rowClass = '';
                let cardClass = 'card-info';
                let msgClass = '';

                if (log.level === 'error') {
                    badgeClass = 'ad-badge-red';
                    badgeLabel = 'ERROR';
                    rowClass = 'row-error';
                    cardClass = 'card-error';
                    msgClass = 'text-red-msg';
                    errs++;
                } else if (log.level === 'warning') {
                    badgeClass = 'ad-badge-yellow';
                    badgeLabel = 'WARN';
                    rowClass = 'row-warning';
                    cardClass = 'card-warning';
                    warns++;
                }

                const actionBadge = `<span class="ad-badge ${badgeClass}">${badgeLabel}</span>`;

                tableHtml += `
                    <tr class="${rowClass}">
                        <td style="padding: 12px 16px; vertical-align: middle;">${actionBadge}</td>
                        <td class="timestamp-cell" style="padding: 12px 16px; vertical-align: middle;">${log.timestamp}</td>
                        <td class="message-cell ${msgClass}" style="padding: 12px 16px;">${escapeHtml(log.message)}</td>
                    </tr>
                `;

                cardsHtml += `
                    <div class="ad-card ${cardClass}">
                        <div class="ad-card-header">
                            <div>${actionBadge}</div>
                            <div class="timestamp-cell" style="font-size: 0.75rem;">${log.timestamp}</div>
                        </div>
                        <div class="message-cell ${msgClass}" style="font-size: 0.8rem; line-height: 1.4; background: rgba(0,0,0,0.02); padding: 0.6rem; border-radius: 8px; border: 1px solid rgba(0,0,0,0.05);">
                            ${escapeHtml(log.message)}
                        </div>
                    </div>
                `;
            });

            tableBody.innerHTML = tableHtml;
            mobileCards.innerHTML = cardsHtml;

            document.getElementById('error-count').textContent = errs;
            document.getElementById('warning-count').textContent = warns;
            document.getElementById('total-count').textContent = data.logs.length;
        })
        .catch(e => {
            console.error(e);
            tableBody.innerHTML = `<tr><td colspan="3" style="text-align: center; padding: 3rem; color: #ef4444;"><?= __('load_error') ?></td></tr>`;
            mobileCards.innerHTML = `<div style="text-align: center; padding: 3rem; color: #ef4444;"><?= __('load_error') ?></div>`;
        });
}

function clearLogs() {
    if (!confirm('Вы действительно хотите полностью очистить лог-файл сервера? Это действие сотрет всю историю ошибок.')) {
        return;
    }

    const toast = document.getElementById('toast');
    
    fetch(`${window.BASE_URL}/api/admin/logs/clear`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
            loadLogs();
        } else {
            alert('Не удалось очистить логи: ' + (data.error || 'ошибка сервера'));
        }
    })
    .catch(() => alert('Ошибка соединения при очистке логов'));
}

function escapeHtml(text) {
    if (!text) return '';
    return text
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadLogs);
} else {
    loadLogs();
}
</script>
