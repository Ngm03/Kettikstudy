<div class="ad-logs-wrapper">
    <div class="ad-header">
        <div class="ad-header-left">
            <h1 class="ad-page-title"><?= __('action_log_title') ?></h1>
            <p class="ad-page-subtitle"><?= __('action_log_subtitle') ?></p>
        </div>
        <div class="ad-header-right">
            <button class="ad-btn ad-btn-primary" onclick="loadLogs()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                    <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                </svg>
                <?= __('refresh_btn') ?>
            </button>
        </div>
    </div>

    <div class="ad-table-container">
        <table class="ad-table" id="desktopTable">
            <thead>
                <tr>
                    <th><?= __('admin_col') ?></th>
                    <th><?= __('action_col') ?></th>
                    <th><?= __('details_col') ?></th>
                    <th><?= __('ip_col') ?></th>
                    <th style="text-align: right;"><?= __('date_col') ?></th>
                </tr>
            </thead>
            <tbody id="logs-list">
                <tr><td colspan="5" style="text-align: center; padding: 3rem; color: #64748b;"><?= __('loading_history') ?></td></tr>
            </tbody>
        </table>
    </div>

    <div class="ad-mobile-cards" id="mobileCards">
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
    margin-bottom: 2rem;
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
}
.ad-btn-primary {
    background: #0052FF;
    color: white;
    box-shadow: 0 4px 12px rgba(0, 82, 255, 0.25);
}
.ad-btn-primary:hover {
    background: #0044d6;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(0, 82, 255, 0.35);
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
    vertical-align: middle;
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

.ad-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}
.ad-badge-blue {
    background: #eff6ff;
    color: #2563eb;
}

.user-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}
.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
    color: #475569;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.85rem;
}
.user-name {
    font-weight: 600;
    color: #1e293b;
}

.details-cell {
    max-width: 300px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #64748b;
    font-size: 0.85rem;
}

.meta-cell {
    color: #64748b;
    font-size: 0.85rem;
    font-family: monospace;
}

.ad-mobile-cards {
    display: none;
}
.ad-card {
    background: white;
    border-radius: 16px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    border: 1px solid rgba(226, 232, 240, 0.8);
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}
.ad-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

@media (max-width: 768px) {
    .ad-header { flex-direction: column; align-items: flex-start; }
    .ad-header-right { width: 100%; }
    .ad-btn { width: 100%; justify-content: center; }
    
    .ad-table-container { display: none; }
    .ad-mobile-cards { display: block; }
}
</style>

<script>
function formatDate(dateString) {
    const options = { 
        year: 'numeric', month: 'short', day: 'numeric', 
        hour: '2-digit', minute: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('ru-RU', options);
}

function loadLogs() {
    const tableBody = document.getElementById('logs-list');
    const mobileCards = document.getElementById('mobileCards');

    tableBody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 3rem; color: #64748b;"><svg class="animate-spin inline mr-2 text-gray-400" width="20" height="20" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg><?= __('updating_list') ?></td></tr>`;
    mobileCards.innerHTML = `<div style="text-align: center; padding: 2rem; color: #64748b;"><?= __('updating_list') ?></div>`;

    fetch('<?= BASE_URL ?>/api/admin/logs')
        .then(res => res.json())
        .then(data => {
            if (!data.logs || data.logs.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 3rem; color: #64748b;"><?= __('history_empty') ?></td></tr>`;
                mobileCards.innerHTML = `<div style="text-align: center; padding: 3rem; color: #64748b;"><?= __('history_empty') ?></div>`;
                return;
            }
            
            let tableHtml = '';
            let cardsHtml = '';

            data.logs.forEach(log => {
                const nameFallback = log.admin_name || '<?= __('system_user') ?>';
                const initial = nameFallback.charAt(0).toUpperCase();

                const formattedDate = formatDate(log.created_at);
                const details = log.details || '-';
                const ip = log.ip_address || '-';
                
                const actionBadge = `
                    <span class="ad-badge ad-badge-blue">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 4px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        ${log.action}
                    </span>
                `;

                tableHtml += `
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">${initial}</div>
                                <div class="user-name">${nameFallback}</div>
                            </div>
                        </td>
                        <td>${actionBadge}</td>
                        <td class="details-cell" title="${details}">${details}</td>
                        <td class="meta-cell">${ip}</td>
                        <td class="meta-cell" style="text-align: right;">${formattedDate}</td>
                    </tr>
                `;

                cardsHtml += `
                    <div class="ad-card">
                        <div class="ad-card-header">
                            <div class="user-cell">
                                <div class="user-avatar">${initial}</div>
                                <div class="user-name">${nameFallback}</div>
                            </div>
                            <div class="meta-cell" style="font-size: 0.75rem;">${formattedDate}</div>
                        </div>
                        <div>
                            ${actionBadge}
                        </div>
                        <div style="font-size: 0.85rem; color: #334155; line-height: 1.4; background: #f8fafc; padding: 0.5rem; border-radius: 8px; border: 1px solid #e2e8f0;">
                            ${details}
                        </div>
                        <div class="meta-cell" style="display: flex; align-items: center; gap: 0.25rem;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                            ${ip}
                        </div>
                    </div>
                `;
            });

            tableBody.innerHTML = tableHtml;
            mobileCards.innerHTML = cardsHtml;
        })
        .catch(e => {
            console.error(e);
            tableBody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 3rem; color: #ef4444;"><?= __('load_error') ?></td></tr>`;
            mobileCards.innerHTML = `<div style="text-align: center; padding: 3rem; color: #ef4444;"><?= __('load_error') ?></div>`;
        });
}

document.addEventListener('DOMContentLoaded', loadLogs);

setInterval(loadLogs, 30000);
</script>
