<style>
    .an-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .an-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px;
    }
    .an-subtitle {
        font-size: 0.85rem;
        color: #64748b;
        margin: 0;
    }
    
    .an-badges {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .an-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        background: #fff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }
    .an-badge-total { color: #3b82f6; border-color: #bfdbfe; background: #eff6ff; }
    .an-badge-hot { color: #dc2626; border-color: #fca5a5; background: #fef2f2; }

    .an-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 24px;
        align-items: start;
    }

    .an-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        overflow: hidden;
    }
    .an-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 12px;
        background: #fafafa;
    }
    .an-card-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }
    .an-card-icon.blue { background: #eff6ff; color: #3b82f6; }
    .an-card-icon.purple { background: #f5f3ff; color: #8b5cf6; }
    .an-card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    .an-card-body {
        padding: 24px;
    }

    .an-form-group { margin-bottom: 20px; }
    .an-form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
    }
    .an-form-input, .an-form-textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 0.95rem;
        font-family: inherit;
        color: #1e293b;
        transition: all 0.2s;
        outline: none;
        background: #fff;
        box-sizing: border-box;
    }
    .an-form-textarea { resize: vertical; min-height: 120px; }
    .an-form-input:focus, .an-form-textarea:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139,92,246,0.15);
    }

    .an-chips {
        display: flex; gap: 8px; flex-wrap: wrap;
    }
    .an-chip {
        padding: 8px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.2s;
        user-select: none;
    }
    .an-chip:hover { background: #f1f5f9; border-color: #cbd5e1; }
    .an-chip.active { background: #8b5cf6; color: #fff; border-color: #8b5cf6; box-shadow: 0 2px 8px rgba(139,92,246,0.2); }

    .an-btn-submit {
        width: 100%;
        background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        color: #fff;
        border: none;
        padding: 14px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(139,92,246,0.25);
    }
    .an-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(139,92,246,0.35);
    }
    .an-btn-submit:active { transform: translateY(0); }
    .an-btn-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none; box-shadow: none; }

    .an-history-wrap { overflow-x: auto; }
    .an-history-table { width: 100%; border-collapse: collapse; min-width: 400px; }
    .an-history-table th {
        text-align: left;
        padding: 12px 16px;
        color: #64748b;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }
    .an-history-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        font-size: 0.85rem;
        vertical-align: top;
    }
    .an-history-table tr:hover { background: #fafafa; }
    .an-history-table tr:last-child td { border-bottom: none; }

    .an-h-title { font-weight: 700; color: #0f172a; margin-bottom: 4px; }
    .an-h-body { font-size: 0.75rem; color: #64748b; line-height: 1.4; }
    
    .an-h-count {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        background: #f1f5f9;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #475569;
    }
    .an-h-date { font-size: 0.75rem; color: #94a3b8; font-weight: 500; white-space: nowrap; }

    .an-empty { padding: 40px 20px; text-align: center; }
    .an-empty-icon {
        width: 48px; height: 48px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #94a3b8;
        margin: 0 auto 12px;
    }
    .an-empty-icon svg { width: 24px; height: 24px; }
    .an-empty p { color: #64748b; font-size: 0.9rem; margin: 0; font-weight: 500; }

    @media (max-width: 900px) {
        .an-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 600px) {
        .an-header { flex-direction: column; gap: 12px; }
        .an-card-header { padding: 14px 16px; }
        .an-card-body { padding: 16px; }
        .an-history-table td, .an-history-table th { padding: 12px 10px; }
    }
</style>

<div class="an-header">
    <div>
        <h1 class="an-title"><?= __('notif_title') ?></h1>
        <p class="an-subtitle"><?= __('notif_subtitle') ?></p>
    </div>
    <div class="an-badges">
        <div class="an-badge an-badge-total" id="stat-total" title="<?= __('notif_total_db') ?>">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span>...</span>
        </div>
        <div class="an-badge an-badge-hot" id="stat-hot" title="<?= __('notif_hot_leads') ?>">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            <span>...</span>
        </div>
    </div>
</div>

<div class="an-grid">
    <div class="an-card">
        <div class="an-card-header">
            <div class="an-card-icon purple">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </div>
            <h3 class="an-card-title"><?= __('notif_new_broadcast') ?></h3>
        </div>
        <div class="an-card-body">
            <form id="broadcast-form" onsubmit="event.preventDefault(); sendBroadcast();">
                <div class="an-form-group">
                    <label class="an-form-label"><?= __('notif_form_title_label') ?></label>
                    <input type="text" name="title" class="an-form-input" placeholder="<?= __('notif_form_title_ph') ?>" required>
                </div>
                
                <div class="an-form-group">
                    <label class="an-form-label"><?= __('notif_form_body_label') ?></label>
                    <textarea name="body" class="an-form-textarea" placeholder="<?= __('notif_form_body_ph') ?>" required></textarea>
                </div>
                
                <div class="an-form-group" style="margin-bottom: 24px;">
                    <label class="an-form-label"><?= __('notif_form_group_label') ?></label>
                    <div class="an-chips">
                        <div class="an-chip active" data-filter="all" onclick="selectFilter(this)"><?= __('notif_group_all') ?></div>
                        <div class="an-chip" data-filter="new" onclick="selectFilter(this)"><?= __('notif_group_new') ?></div>
                        <div class="an-chip" data-filter="hot" onclick="selectFilter(this)"><?= __('notif_group_hot') ?></div>
                        <div class="an-chip" data-filter="cold" onclick="selectFilter(this)"><?= __('notif_group_cold') ?></div>
                        <div class="an-chip" data-filter="converted" onclick="selectFilter(this)"><?= __('notif_group_converted') ?></div>
                    </div>
                    <input type="hidden" name="filter" id="filter-value" value="all">
                </div>
                
                <button type="submit" id="send-btn" class="an-btn-submit">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    <span><?= __('notif_btn_send') ?></span>
                </button>
            </form>
        </div>
    </div>

    <div class="an-card">
        <div class="an-card-header">
            <div class="an-card-icon blue">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="an-card-title"><?= __('notif_hist_title') ?></h3>
        </div>
        <div class="an-history-wrap">
            <table class="an-history-table">
                <thead>
                    <tr>
                        <th><?= __('notif_hist_col_msg') ?></th>
                        <th><?= __('notif_hist_col_reach') ?></th>
                        <th style="text-align: right;">Дата</th>
                    </tr>
                </thead>
                <tbody id="history-body">
                    <tr><td colspan="3">
                        <div class="an-empty">
                            <div class="an-empty-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </div>
                            <p><?= __('notif_hist_loading') ?></p>
                        </div>
                    </td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    let selectedFilter = 'all';

    function selectFilter(el) {
        document.querySelectorAll('.an-chip').forEach(c => c.classList.remove('active'));
        el.classList.add('active');
        selectedFilter = el.dataset.filter;
        document.getElementById('filter-value').value = selectedFilter;
    }

    function escHtml(str) {
        return String(str||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function sendBroadcast() {
        const form = document.getElementById('broadcast-form');
        const title = form.elements['title'].value.trim();
        const body = form.elements['body'].value.trim();
        const btn = document.getElementById('send-btn');

        if (!title || !body) return alert('<?= __('notif_err_empty_form') ?>');

        if (!confirm(`Вы уверены, что хотите запустить рассылку группе "${selectedFilter.toUpperCase()}"?\nЭто действие нельзя отменить.`)) {
            return;
        }

        const originalBtnHtml = btn.innerHTML;
        btn.innerHTML = `<svg style="animation: spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.25"></circle><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> <span><?= __('notif_sending') ?></span>`;
        btn.disabled = true;

        fetch(`${window.BASE_URL}/api/admin/broadcast`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ title, body, filter: selectedFilter })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(`<?= __('notif_success_send') ?>`.replace('%s', data.count));
                form.reset();
                selectFilter(document.querySelector('.an-chip[data-filter="all"]'));
                loadHistory();
            } else {
                alert('<?= __('notif_err_prefix') ?>' + (data.error || '<?= __('notif_err_unknown') ?>'));
            }
        })
        .catch(() => alert('<?= __('notif_err_net') ?>'))
        .finally(() => {
            btn.innerHTML = originalBtnHtml;
            btn.disabled = false;
        });
    }

    function loadHistory() {
        fetch(`${window.BASE_URL}/api/admin/broadcast-history`)
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById('history-body');
                
                if (!data.history || data.history.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="3">
                        <div class="an-empty">
                            <div class="an-empty-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                            </div>
                            <p><?= __('notif_hist_empty') ?></p>
                        </div>
                    </td></tr>`;
                    return;
                }
                
                tbody.innerHTML = data.history.map(h => {
                    const shortBody = (h.body || '').length > 60 ? (h.body.substring(0, 60) + '...') : h.body;
                    const dateStr = new Date(h.created_at).toLocaleDateString('ru-RU', {day:'2-digit', month:'short', hour:'2-digit', minute:'2-digit'});
                    
                    return `
                        <tr>
                            <td style="max-width: 250px;">
                                <div class="an-h-title">${escHtml(h.title)}</div>
                                <div class="an-h-body" title="${escHtml(h.body)}">${escHtml(shortBody)}</div>
                            </td>
                            <td>
                                <div class="an-h-count">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    ${h.recipient_count}
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <div class="an-h-date">${dateStr}</div>
                            </td>
                        </tr>
                    `;
                }).join('');
            })
            .catch(() => {
                document.getElementById('history-body').innerHTML = `<tr><td colspan="3">
                    <div class="an-empty" style="color:#ef4444;"><?= __('notif_hist_err_load') ?></div>
                </td></tr>`;
            });
    }

    function loadStats() {
        fetch(`${window.BASE_URL}/api/admin/students`)
            .then(res => res.json())
            .then(data => {
                if (data.students) {
                    document.querySelector('#stat-total span').textContent = '<?= __('notif_stat_total') ?>' + data.students.length;
                    const hot = data.students.filter(s => s.lead_status === 'hot').length;
                    document.querySelector('#stat-hot span').textContent = '<?= __('notif_stat_hot') ?>' + hot;
                }
            })
            .catch(()=>console.error('Failed to load stats for notifications'));
    }

    if(!document.getElementById('an-spinner-style')){
        const style = document.createElement('style');
        style.id = 'an-spinner-style';
        style.innerHTML = `@keyframes spin { to { transform: rotate(360deg); } }`;
        document.head.appendChild(style);
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadHistory();
        loadStats();
    });
</script>
