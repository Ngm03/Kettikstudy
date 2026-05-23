<style>
    .ap-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 900px) { .ap-stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 500px) { 
        .ap-stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; }
        .ap-stat-card { padding: 12px 10px; gap: 8px; }
        .ap-stat-icon { width: 36px; height: 36px; border-radius: 10px; }
        .ap-stat-icon svg { width: 18px; height: 18px; }
        .ap-stat-icon span { font-size: 0.9rem !important; }
        .ap-stat-num { font-size: 1.3rem; }
        .ap-stat-label { font-size: 0.65rem; } 
    }

    .ap-stat-card {
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
    .ap-stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); transform: translateY(-1px); }
    .ap-stat-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .ap-stat-icon svg { width: 22px; height: 22px; }
    .ap-stat-info { flex: 1; min-width: 0; }
    .ap-stat-num {
        font-size: 1.6rem;
        font-weight: 800;
        line-height: 1;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .ap-stat-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 4px;
    }

    .ap-panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    .ap-toolbar {
        padding: 14px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
        background: #f8fafc;
    }

    .ap-search-wrap {
        flex: 1;
        min-width: 200px;
        position: relative;
    }
    .ap-search-wrap svg {
        position: absolute;
        left: 12px; top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        width: 16px; height: 16px;
        pointer-events: none;
    }
    .ap-search-wrap input {
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
    .ap-search-wrap input:focus { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }

    .ap-select {
        padding: 9px 32px 9px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.85rem;
        font-family: inherit;
        color: #1e293b;
        outline: none;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") no-repeat right 12px center;
        appearance: none;
        cursor: pointer;
        transition: border-color 0.2s;
        min-width: 140px;
    }
    .ap-select:focus { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }

    .ap-count-badge {
        font-size: 0.8rem;
        color: #475569;
        font-weight: 600;
        background: #e2e8f0;
        padding: 4px 10px;
        border-radius: 20px;
        margin-left: auto;
        white-space: nowrap;
    }

    .ap-table-wrap { overflow-x: auto; }
    .ap-table { width: 100%; border-collapse: collapse; min-width: 900px; }
    .ap-table th {
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
    .ap-table td {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        font-size: 0.875rem;
        vertical-align: middle;
    }
    .ap-table tbody tr:last-child td { border-bottom: none; }
    .ap-table tbody tr:hover { background: #fafafa; }

    .ap-cat-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.2px;
        white-space: nowrap;
    }
    .cat-food        { background: #fef9c3; color: #713f12; }
    .cat-transport   { background: #dbeafe; color: #1e40af; }
    .cat-housing     { background: #dcfce7; color: #14532d; }
    .cat-services    { background: #f3e8ff; color: #581c87; }
    .cat-entertainment { background: #fce7f3; color: #831843; }
    .cat-other       { background: #f1f5f9; color: #475569; }

    .ap-del-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px;
        border-radius: 8px;
        background: #fef2f2;
        color: #ef4444;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.2s;
    }
    .ap-del-btn:hover { background: #fee2e2; border-color: #fca5a5; transform: scale(1.05); }
    .ap-del-btn svg { width: 16px; height: 16px; }

    .ap-mobile-cards { display: none; padding: 12px; }
    .ap-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 10px;
        transition: box-shadow 0.2s;
    }
    .ap-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
    .ap-card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; gap: 8px; }
    .ap-card-title { font-weight: 700; font-size: 0.95rem; color: #0f172a; margin-bottom: 4px; line-height: 1.3; }
    .ap-card-price { font-size: 1.1rem; font-weight: 800; color: #0f172a; white-space: nowrap; }
    .ap-card-row { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; flex-wrap: wrap; }
    .ap-card-text { font-size: 0.8rem; color: #475569; }
    .ap-card-sub { font-size: 0.75rem; color: #94a3b8; }
    .ap-card-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 12px; padding-top: 12px; border-top: 1px solid #f1f5f9; }



    @media (max-width: 800px) {
        .ap-table-wrap { display: none !important; }
        .ap-mobile-cards { display: block !important; }
        .ap-toolbar { padding: 10px 12px; flex-direction: column; align-items: stretch; }
        .ap-count-badge { align-self: flex-start; margin-left: 0; }
    }
    .ap-empty { padding: 60px 20px; text-align: center; }
    .ap-empty svg { width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 12px; display: inline-block; }
    .ap-empty p { color: #64748b; font-size: 0.9rem; font-weight: 500; margin: 0; }

    @keyframes fadeRow { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
    .ap-anim-in { animation: fadeRow 0.3s ease; }
</style>

<div style="background:rgba(59,130,246,0.1); border:1px solid rgba(59,130,246,0.2); border-radius:12px; padding:12px 16px; margin-bottom:24px; display:flex; gap:12px; align-items:center;">
    <div style="width:32px; height:32px; background:#eff6ff; color:#3b82f6; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </div>
    <div>
        <div style="font-weight:700; color:#1e3a8a; font-size:0.85rem;"><?= __('prices_admin_title') ?></div>
        <div style="color:#3b82f6; font-size:0.75rem; font-weight:500; margin-top:2px;"><?= __('prices_admin_desc') ?></div>
    </div>
</div>

<div class="ap-stats-grid">
    <div class="ap-stat-card">
        <div class="ap-stat-icon" style="background:#eff6ff; color:#3b82f6;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
        </div>
        <div class="ap-stat-info">
            <div class="ap-stat-num" id="stat-total">—</div>
            <div class="ap-stat-label"><?= __('prices_total_records') ?></div>
        </div>
    </div>
    <div class="ap-stat-card">
        <div class="ap-stat-icon" style="background:#fef2f2; color:#ef4444;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div class="ap-stat-info">
            <div class="ap-stat-num" id="stat-cities">—</div>
            <div class="ap-stat-label"><?= __('prices_unique_cities') ?></div>
        </div>
    </div>
    <div class="ap-stat-card">
        <div class="ap-stat-icon" style="background:#f0fdf4; color:#22c55e;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
        <div class="ap-stat-info">
            <div class="ap-stat-num" id="stat-authors">—</div>
            <div class="ap-stat-label"><?= __('prices_author_students') ?></div>
        </div>
    </div>
    <div class="ap-stat-card">
        <div class="ap-stat-icon" style="background:#fffbeb; color:#f59e0b;">
            <span style="font-weight:800; font-size:1.1rem;">PLN</span>
        </div>
        <div class="ap-stat-info">
            <div class="ap-stat-num" id="stat-avg">—</div>
            <div class="ap-stat-label"><?= __('prices_avg_price') ?></div>
        </div>
    </div>
</div>

<div class="ap-panel">
    <div class="ap-toolbar">
        <div class="ap-search-wrap">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="ap-search" placeholder="<?= __('prices_search_ph') ?>" oninput="filterTable()">
        </div>
        <select class="ap-select" id="ap-cat-filter" onchange="filterTable()">
            <option value=""><?= __('prices_filter_all_cat') ?></option>
            <option value="food"><?= __('prices_filter_food') ?></option>
            <option value="transport"><?= __('prices_filter_transport') ?></option>
            <option value="housing"><?= __('prices_filter_housing') ?></option>
            <option value="services"><?= __('prices_filter_services') ?></option>
            <option value="entertainment"><?= __('prices_filter_entertainment') ?></option>
            <option value="other"><?= __('prices_filter_other') ?></option>
        </select>
        <select class="ap-select" id="ap-city-filter" onchange="filterTable()">
            <option value=""><?= __('prices_filter_all_cities') ?></option>
        </select>
        <div class="ap-count-badge" id="ap-count-badge">0 из 0</div>
    </div>

    <div class="ap-table-wrap">
        <table class="ap-table">
            <thead>
                <tr>
                    <th style="width: 40px;">#</th>
                    <th><?= __('prices_th_item') ?></th>
                    <th><?= __('prices_th_category') ?></th>
                    <th><?= __('prices_th_price') ?></th>
                    <th><?= __('prices_th_city') ?></th>
                    <th><?= __('prices_th_author') ?></th>
                    <th><?= __('prices_th_comment') ?></th>
                    <th><?= __('prices_th_date') ?></th>
                    <th style="text-align: right; width: 60px;"></th>
                </tr>
            </thead>
            <tbody id="ap-tbody">
                <tr><td colspan="9">
                    <div class="ap-empty">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <p><?= __('prices_loading') ?></p>
                    </div>
                </td></tr>
            </tbody>
        </table>
    </div>

    <div class="ap-mobile-cards" id="ap-mobile-cards"></div>
</div>

<script>
let allPrices = [];

const catLabels = {
    food:          ['<?= __('prices_lbl_food') ?>',    'cat-food'],
    transport:     ['<?= __('prices_lbl_transport') ?>',  'cat-transport'],
    housing:       ['<?= __('prices_lbl_housing') ?>',      'cat-housing'],
    services:      ['<?= __('prices_lbl_services') ?>',     'cat-services'],
    entertainment: ['<?= __('prices_lbl_en') ?>',      'cat-entertainment'],
    other:         ['<?= __('prices_lbl_other') ?>',     'cat-other'],
};

function fmtDate(str) {
    if (!str) return '—';
    const d = new Date(str);
    return d.toLocaleDateString('ru-RU', { day:'2-digit', month:'short', year:'numeric' });
}

function filterTable() {
    const q     = document.getElementById('ap-search').value.toLowerCase();
    const cat   = document.getElementById('ap-cat-filter').value;
    const city  = document.getElementById('ap-city-filter').value;

    const filtered = allPrices.filter(r => {
        const matchQ    = !q   || [r.item_name, r.author, r.city_name, r.comment].some(f => (f||'').toLowerCase().includes(q));
        const matchCat  = !cat  || r.category === cat;
        const matchCity = !city || r.city_name === city;
        return matchQ && matchCat && matchCity;
    });

    renderData(filtered);
    document.getElementById('ap-count-badge').textContent = `${filtered.length} из ${allPrices.length}`;
}

function renderData(list) {
    const tbody = document.getElementById('ap-tbody');
    const mCards = document.getElementById('ap-mobile-cards');

    if (!list.length) {
        const emptyHtml = `<div class="ap-empty">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <p><?= __('prices_not_found') ?></p>
        </div>`;
        tbody.innerHTML = `<tr><td colspan="9">${emptyHtml}</td></tr>`;
        mCards.innerHTML = emptyHtml;
        return;
    }

    tbody.innerHTML = list.map((r, i) => {
        const [label, cls] = catLabels[r.category] || ['📌 Прочее', 'cat-other'];
        const price = parseFloat(r.price).toFixed(2);
        
        return `<tr class="ap-anim-in">
            <td style="color:#94a3b8; font-size:0.8rem; font-weight:600;">${i + 1}</td>
            <td><span style="font-weight:700; color:#0f172a;">${escHtml(r.item_name)}</span></td>
            <td><span class="ap-cat-badge ${cls}">${label}</span></td>
            <td>
                <span style="font-weight:800; color:#0f172a;">${price}</span>
                <span style="font-size:0.75rem; color:#64748b; font-weight:600;">PLN</span>
            </td>
            <td><span style="display:inline-flex; align-items:center; gap:6px; background:#f1f5f9; padding:3px 8px; border-radius:6px; font-size:0.8rem; font-weight:600; color:#475569;">
                <img src="https://flagcdn.com/16x12/pl.png" width="16" height="12" style="border-radius:2px;">
                ${escHtml(r.city_name || '—')}
            </span></td>
            <td style="font-weight:600; color:#334155;">${escHtml(r.author || '—')}</td>
            <td style="color:#64748b; max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="${escHtml(r.comment||'')}">${escHtml(r.comment || '—')}</td>
            <td style="color:#94a3b8; font-size:0.8rem; white-space:nowrap;">${fmtDate(r.created_at)}</td>
            <td style="text-align: right;">
                <button class="ap-del-btn" onclick="confirmDelete(${r.id}, '${escHtml(r.item_name)}')">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </td>
        </tr>`;
    }).join('');

    mCards.innerHTML = list.map((r) => {
        const [label, cls] = catLabels[r.category] || ['📌 Прочее', 'cat-other'];
        const price = parseFloat(r.price).toFixed(2);
        
        return `<div class="ap-card ap-anim-in">
            <div class="ap-card-top">
                <div class="ap-card-title">${escHtml(r.item_name)}</div>
                <div class="ap-card-price">${price} <span style="font-size:0.75rem; color:#64748b;">PLN</span></div>
            </div>
            
            <div class="ap-card-row">
                <span class="ap-cat-badge ${cls}" style="font-size:0.65rem;">${label}</span>
                <span style="display:inline-flex; align-items:center; gap:4px; background:#f1f5f9; padding:2px 6px; border-radius:4px; font-size:0.75rem; font-weight:600; color:#475569;">
                    <img src="https://flagcdn.com/16x12/pl.png" width="14" height="10" style="border-radius:2px;">
                    ${escHtml(r.city_name || '—')}
                </span>
            </div>
            
            ${r.comment ? `<div class="ap-card-text" style="margin-top:8px;"><strong><?= __('prices_lbl_comment') ?></strong> ${escHtml(r.comment)}</div>` : ''}
            
            <div class="ap-card-footer">
                <div style="display:flex; flex-direction:column; gap:2px;">
                    <span class="ap-card-sub">👤 ${escHtml(r.author || '—')}</span>
                    <span class="ap-card-sub">📅 ${fmtDate(r.created_at)}</span>
                </div>
                <button class="ap-del-btn" onclick="confirmDelete(${r.id}, '${escHtml(r.item_name)}')">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        </div>`;
    }).join('');
}

function escHtml(str) {
    return String(str||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function confirmDelete(id, name) {
    if (!confirm(`Удалить запись «${name}»? Это действие необратимо.`)) return;

    fetch(`${window.BASE_URL}/api/community/prices/delete`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            allPrices = allPrices.filter(p => p.id !== id);
            filterTable();
            updateStats();
        } else {
            alert('<?= __('prices_err_unknown') ?>' + (data.error || 'Неизвестная'));
        }
    })
    .catch(() => alert('<?= __('prices_err_net') ?>'));
}

function updateStats() {
    document.getElementById('stat-total').textContent   = allPrices.length;
    const cities  = new Set(allPrices.map(r => r.city_name).filter(Boolean));
    const authors = new Set(allPrices.map(r => r.author).filter(Boolean));
    const avg     = allPrices.length ? (allPrices.reduce((s, r) => s + parseFloat(r.price||0), 0) / allPrices.length).toFixed(2) : '0.00';
    
    document.getElementById('stat-cities').textContent  = cities.size;
    document.getElementById('stat-authors').textContent = authors.size;
    document.getElementById('stat-avg').textContent     = avg;

    const sel = document.getElementById('ap-city-filter');
    const cur = sel.value;
    sel.innerHTML = '<option value=""><?= __('prices_filter_all_cities') ?></option>';
    [...cities].sort().forEach(c => {
        const o = document.createElement('option');
        o.value = c; o.textContent = c;
        if (c === cur) o.selected = true;
        sel.appendChild(o);
    });
}

function loadPrices() {
    fetch(`${window.BASE_URL}/api/community/prices`)
        .then(r => r.json())
        .then(data => {
            allPrices = data.prices || [];
            updateStats();
            filterTable();
            document.getElementById('ap-count-badge').textContent = `${allPrices.length} из ${allPrices.length}`;
        })
        .catch(err => {
            const errHtml = `<div class="ap-empty" style="color:#ef4444;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <p><?= __('prices_err_load') ?></p>
            </div>`;
            document.getElementById('ap-tbody').innerHTML = `<tr><td colspan="9">${errHtml}</td></tr>`;
            document.getElementById('ap-mobile-cards').innerHTML = errHtml;
        });
}

document.addEventListener('DOMContentLoaded', loadPrices);
</script>
