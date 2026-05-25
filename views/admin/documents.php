<style>
    .sys-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 900px) { .sys-stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 500px) { 
        .sys-stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; } 
        .sys-stat-card { padding: 12px 10px; gap: 8px; }
        .sys-stat-icon { width: 36px; height: 36px; border-radius: 10px; }
        .sys-stat-icon svg { width: 18px; height: 18px; }
        .sys-stat-num { font-size: 1.3rem; }
        .sys-stat-label { font-size: 0.65rem; }
    }

    .sys-stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .sys-stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); transform: translateY(-1px); }
    .sys-stat-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .sys-stat-icon svg { width: 22px; height: 22px; }
    .sys-stat-info { flex: 1; min-width: 0; }
    .sys-stat-num {
        font-size: 1.6rem;
        font-weight: 800;
        line-height: 1;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .sys-stat-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 4px;
    }

    .sys-panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    .sys-toolbar {
        padding: 14px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
        background: #f8fafc;
    }

    .sys-search-wrap {
        flex: 1;
        min-width: 200px;
        position: relative;
    }
    .sys-search-wrap svg {
        position: absolute;
        left: 12px; top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        width: 16px; height: 16px;
        pointer-events: none;
    }
    .sys-search-wrap input {
        width: 100%;
        padding: 9px 14px 9px 38px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.875rem;
        font-family: inherit;
        color: #1e293b;
        outline: none;
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .sys-search-wrap input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }

    .sys-filter-chips {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .sys-chip {
        padding: 8px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        background: #fff;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .sys-chip:hover { background: #f1f5f9; border-color: #cbd5e1; }
    .sys-chip.active { background: #1e293b; color: #fff; border-color: #1e293b; }

    .sys-count-badge {
        font-size: 0.8rem;
        color: #475569;
        font-weight: 600;
        background: #e2e8f0;
        padding: 4px 10px;
        border-radius: 20px;
        margin-left: auto;
        white-space: nowrap;
    }

    .sys-table-wrap { overflow-x: auto; }
    .sys-table { width: 100%; border-collapse: collapse; min-width: 800px; }
    .sys-table th {
        text-align: left;
        padding: 12px 20px;
        background: #f8fafc;
        color: #64748b;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
    }
    .sys-table td {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        font-size: 0.875rem;
        vertical-align: middle;
    }
    .sys-table tbody tr:last-child td { border-bottom: none; }
    .sys-table tbody tr:hover { background: #fafafa; }

    .sys-status-badge {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }
    .status-pending { background: #fef3c7; color: #b45309; }
    .status-approved { background: #dcfce7; color: #166534; }
    .status-rejected { background: #fee2e2; color: #991b1b; }

    .sys-actions { display: flex; gap: 6px; }
    .sys-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px;
        border-radius: 8px;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.2s;
    }
    .sys-btn svg { width: 16px; height: 16px; }
    .sys-btn-view { background: #eff6ff; color: #3b82f6; }
    .sys-btn-view:hover { background: #dbeafe; transform: scale(1.05); }
    .sys-btn-approve { background: #f0fdf4; color: #22c55e; }
    .sys-btn-approve:hover { background: #dcfce7; transform: scale(1.05); }
    .sys-btn-reject { background: #fef2f2; color: #ef4444; }
    .sys-btn-reject:hover { background: #fee2e2; transform: scale(1.05); }

    .sys-mobile-cards { display: none; padding: 12px; }
    .sys-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 10px;
        transition: box-shadow 0.2s;
    }
    .sys-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
    .sys-card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px; gap: 8px; }
    .sys-card-title { font-weight: 700; font-size: 0.95rem; color: #0f172a; line-height: 1.2; }
    .sys-card-sub { font-size: 0.8rem; color: #64748b; margin-top: 2px; }
    .sys-card-row { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; flex-wrap: wrap; }
    .sys-card-footer { 
        display: flex; justify-content: space-between; align-items: center; 
        margin-top: 12px; padding-top: 12px; border-top: 1px solid #f1f5f9; 
    }

    @media (max-width: 800px) {
        .sys-table-wrap { display: none !important; }
        .sys-mobile-cards { display: block !important; }
        .sys-toolbar { padding: 10px 12px; flex-direction: column; align-items: stretch; }
        .sys-count-badge { align-self: flex-start; margin-left: 0; }
        .sys-filter-chips { overflow-x: auto; padding-bottom: 4px; flex-wrap: nowrap; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
        .sys-filter-chips::-webkit-scrollbar { display: none; }
        .sys-chip { white-space: nowrap; }
    }

    .sys-empty { padding: 60px 20px; text-align: center; }
    .sys-empty svg { width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 12px; display: inline-block; }
    .sys-empty p { color: #64748b; font-size: 0.9rem; font-weight: 500; margin: 0; }

    @keyframes fadeRow { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
    .sys-anim-in { animation: fadeRow 0.3s ease; }
</style>

<div class="sys-stats-grid">
    <div class="sys-stat-card">
        <div class="sys-stat-icon" style="background:#f1f5f9; color:#475569;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div class="sys-stat-info">
            <div class="sys-stat-num" id="stat-total">—</div>
            <div class="sys-stat-label"><?= __('admin_docs_stat_total') ?></div>
        </div>
    </div>
    <div class="sys-stat-card">
        <div class="sys-stat-icon" style="background:#fffbeb; color:#d97706;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="sys-stat-info">
            <div class="sys-stat-num" id="stat-pending">—</div>
            <div class="sys-stat-label"><?= __('admin_docs_stat_pending') ?></div>
        </div>
    </div>
    <div class="sys-stat-card">
        <div class="sys-stat-icon" style="background:#f0fdf4; color:#16a34a;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="sys-stat-info">
            <div class="sys-stat-num" id="stat-approved">—</div>
            <div class="sys-stat-label"><?= __('admin_docs_stat_approved') ?></div>
        </div>
    </div>
    <div class="sys-stat-card">
        <div class="sys-stat-icon" style="background:#fef2f2; color:#dc2626;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="sys-stat-info">
            <div class="sys-stat-num" id="stat-rejected">—</div>
            <div class="sys-stat-label"><?= __('admin_docs_stat_rejected') ?></div>
        </div>
    </div>
</div>

<div class="sys-panel">
    <div class="sys-toolbar">
        <div class="sys-search-wrap">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="sys-search" placeholder="<?= __('admin_docs_search_ph') ?>" oninput="filterTable()">
        </div>
        
        <div class="sys-filter-chips">
            <button class="sys-chip active" data-filter="all" onclick="setFilter(this, 'all')"><?= __('admin_docs_filter_all') ?></button>
            <button class="sys-chip" data-filter="pending" onclick="setFilter(this, 'pending')">
                <span style="width:8px;height:8px;border-radius:50%;background:#f59e0b;"></span> <?= __('admin_docs_filter_pending') ?>
            </button>
            <button class="sys-chip" data-filter="approved" onclick="setFilter(this, 'approved')">
                <span style="width:8px;height:8px;border-radius:50%;background:#10b981;"></span> <?= __('admin_docs_filter_approved') ?>
            </button>
            <button class="sys-chip" data-filter="rejected" onclick="setFilter(this, 'rejected')">
                <span style="width:8px;height:8px;border-radius:50%;background:#ef4444;"></span> <?= __('admin_docs_filter_rejected') ?>
            </button>
        </div>

        <div class="sys-count-badge" id="sys-count-badge">0 / 0</div>
    </div>

    <div class="sys-table-wrap">
        <table class="sys-table">
            <thead>
                <tr>
                    <th><?= __('admin_docs_th_student') ?></th>
                    <th><?= __('admin_docs_th_type') ?></th>
                    <th><?= __('admin_docs_th_filename') ?></th>
                    <th><?= __('admin_docs_th_date') ?></th>
                    <th><?= __('admin_docs_th_status') ?></th>
                    <th style="text-align: right;">Действия</th>
                </tr>
            </thead>
            <tbody id="sys-tbody">
                <tr><td colspan="6">
                    <div class="sys-empty">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <p><?= __('admin_docs_loading') ?></p>
                    </div>
                </td></tr>
            </tbody>
        </table>
    </div>

    <div class="sys-mobile-cards" id="sys-mobile-cards"></div>
</div>

<script>
let allDocs = [];
let currentFilter = 'all';

const typeNames = {
    'passport': '<?= __('admin_docs_type_passport') ?>', 
    'transcript': '<?= __('admin_docs_type_transcript') ?>', 
    'certificate': '<?= __('admin_docs_type_certificate') ?>'
};

function fmtDate(str) {
    if (!str) return '—';
    const d = new Date(str);
    return d.toLocaleDateString('ru-RU', { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit' });
}

function escHtml(str) {
    return String(str||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function setFilter(btn, status) {
    document.querySelectorAll('.sys-chip').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    currentFilter = status;
    filterTable();
}

function filterTable() {
    const q = document.getElementById('sys-search').value.toLowerCase();

    const filtered = allDocs.filter(d => {
        const matchQ = !q || [d.full_name, d.email, d.original_name].some(f => (f||'').toLowerCase().includes(q));
        const matchStatus = currentFilter === 'all' || d.status === currentFilter;
        return matchQ && matchStatus;
    });

    renderData(filtered);
    document.getElementById('sys-count-badge').textContent = `${filtered.length} / ${allDocs.length}`;
}

function renderData(list) {
    const tbody = document.getElementById('sys-tbody');
    const mCards = document.getElementById('sys-mobile-cards');

    if (!list.length) {
        const emptyHtml = `<div class="sys-empty">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <p><?= __('admin_docs_empty_title') ?></p>
        </div>`;
        tbody.innerHTML = `<tr><td colspan="6">${emptyHtml}</td></tr>`;
        mCards.innerHTML = emptyHtml;
        return;
    }

    tbody.innerHTML = list.map(d => {
        const docName = typeNames[d.type] || d.type;
        const dateStr = fmtDate(d.created_at);
        
        let actions = `<div class="sys-actions" style="justify-content: flex-end;">
            <a href="${window.BASE_URL}/api/documents/view?id=${d.id}" target="_blank" class="sys-btn sys-btn-view" title="<?= __('admin_docs_btn_view') ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </a>`;
            
        if (d.status === 'pending') {
            actions += `
                <button onclick="updateStatus(${d.id}, 'approved')" class="sys-btn sys-btn-approve" title="<?= __('admin_docs_btn_approve') ?>">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </button>
                <button onclick="updateStatus(${d.id}, 'rejected')" class="sys-btn sys-btn-reject" title="<?= __('admin_docs_btn_reject') ?>">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>`;
        }
        actions += `</div>`;

        return `<tr class="sys-anim-in">
            <td>
                <div style="font-weight:600; color:#1e293b; font-size:0.9rem;">${escHtml(d.full_name)}</div>
                <div style="font-size:0.75rem; color:#64748b; margin-top:2px;">${escHtml(d.email)}</div>
            </td>
            <td><span style="font-weight:600; color:#475569; font-size:0.85rem;">${docName}</span></td>
            <td>
                <div style="max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:#3b82f6; font-size:0.85rem; background:#eff6ff; padding:4px 8px; border-radius:6px; display:inline-block;" title="${escHtml(d.original_name)}">
                    📄 ${escHtml(d.original_name)}
                </div>
            </td>
            <td style="color:#64748b; font-size:0.8rem;">${dateStr}</td>
            <td><span class="sys-status-badge status-${d.status}">${d.status}</span></td>
            <td>${actions}</td>
        </tr>`;
    }).join('');

    mCards.innerHTML = list.map(d => {
        const docName = typeNames[d.type] || d.type;
        const dateStr = fmtDate(d.created_at);
        
        let actions = `
            <a href="${window.BASE_URL}/api/documents/view?id=${d.id}" target="_blank" class="sys-btn sys-btn-view" style="flex:1; gap:6px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span style="font-size:0.8rem; font-weight:600;"><?= __('admin_docs_btn_watch') ?></span>
            </a>`;
            
        if (d.status === 'pending') {
            actions += `
                <button onclick="updateStatus(${d.id}, 'approved')" class="sys-btn sys-btn-approve" style="flex:1;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </button>
                <button onclick="updateStatus(${d.id}, 'rejected')" class="sys-btn sys-btn-reject" style="flex:1;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>`;
        }
        
        return `<div class="sys-card sys-anim-in">
            <div class="sys-card-top">
                <div>
                    <div class="sys-card-title">${escHtml(d.full_name)}</div>
                    <div class="sys-card-sub">${escHtml(d.email)}</div>
                </div>
                <span class="sys-status-badge status-${d.status}">${d.status}</span>
            </div>
            
            <div style="background:#f8fafc; border:1px solid #f1f5f9; border-radius:8px; padding:10px; margin-bottom:12px;">
                <div style="font-weight:600; color:#475569; font-size:0.85rem; margin-bottom:4px;">${docName}</div>
                <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:#3b82f6; font-size:0.8rem;" title="${escHtml(d.original_name)}">
                    📄 ${escHtml(d.original_name)}
                </div>
            </div>
            
            <div style="font-size:0.75rem; color:#94a3b8; margin-bottom:12px;"><?= __('admin_docs_lbl_loaded') ?>${dateStr}</div>
            
            <div style="display:flex; gap:8px;">
                ${actions}
            </div>
        </div>`;
    }).join('');
}

function updateStats() {
    const total = allDocs.length;
    const pending = allDocs.filter(d => d.status === 'pending').length;
    const approved = allDocs.filter(d => d.status === 'approved').length;
    const rejected = allDocs.filter(d => d.status === 'rejected').length;

    document.getElementById('stat-total').textContent = total;
    document.getElementById('stat-pending').textContent = pending;
    document.getElementById('stat-approved').textContent = approved;
    document.getElementById('stat-rejected').textContent = rejected;
}

async function updateStatus(id, status) {
    let reason = null;
    if (status === 'rejected') {
        reason = prompt('<?= __('admin_docs_prompt_reject') ?>');
        if (reason === null) return;
    } else {
         if(!confirm('<?= __('admin_docs_confirm_approve') ?>')) return;
    }

    console.log(`[Documents] updateStatus() initiated for ID: ${id}, status: ${status}, reason: ${reason}`);
    try {
        const url = `${window.BASE_URL}/api/admin/doc-status`;
        console.log(`[Documents] Fetching POST to: ${url}`);
        const res = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id, status, reason })
        });
        console.log(`[Documents] Update status response code: ${res.status}`);

        const text = await res.text();
        console.log(`[Documents] Raw response text:`, text);

        let data = JSON.parse(text);
        if(data.success) {
            console.log('[Documents] Status update succeeded');
            const doc = allDocs.find(d => d.id == id);
            if(doc) doc.status = status;
            updateStats();
            filterTable();
        } else {
            console.error('[Documents] Status update failed on server:', data.error);
            alert('<?= __('admin_docs_err_update') ?>' + (data.error || '<?= __('admin_docs_err_unknown') ?>'));
        }
    } catch (e) {
        console.error('[Documents] updateStatus() exception caught:', e);
        alert('<?= __('admin_docs_err_net_update') ?>');
    }
}

async function loadDocs() {
    console.log('[Documents] loadDocs() initiated');
    console.log('[Documents] window.BASE_URL value:', window.BASE_URL);
    try {
        const url = `${window.BASE_URL}/api/admin/documents`;
        console.log(`[Documents] Fetching GET from: ${url}`);
        const res = await fetch(url);
        console.log(`[Documents] Fetch response status: ${res.status}`);

        const text = await res.text();
        console.log(`[Documents] Raw Response Text (first 200 chars):`, text.substring(0, 200));

        let data;
        try {
            data = JSON.parse(text);
        } catch (parseError) {
            console.error('[Documents] Failed to parse JSON response. Raw output was likely HTML. Error:', parseError);
            throw parseError;
        }

        console.log('[Documents] Loaded documents payload:', data);
        allDocs = data.documents || [];
        updateStats();
        filterTable();
        console.log('[Documents] Rendering/filtering completed successfully');
    } catch (err) {
        console.error('[Documents] loadDocs() fatal exception caught:', err);
        const errHtml = `<div class="sys-empty" style="color:#ef4444;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <p><?= __('admin_docs_err_load_title') ?></p>
        </div>`;
        document.getElementById('sys-tbody').innerHTML = `<tr><td colspan="6">${errHtml}</td></tr>`;
        document.getElementById('sys-mobile-cards').innerHTML = errHtml;
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadDocs);
} else {
    loadDocs();
}
</script>
