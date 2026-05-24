<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

:root {
    --blue: #0052FF;
    --blue-dark: #0040cc;
    --blue-light: #e8f0ff;
    --amber: #f59e0b;
    --amber-light: #fffbeb;
    --green: #10b981;
    --red: #ef4444;
    --bg: #f1f5f9;
    --surface: #fff;
    --surface2: #f8fafc;
    --border: #e2e8f0;
    --text: #0f172a;
    --muted: #64748b;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --shadow-md: 0 4px 20px rgba(0,0,0,0.06), 0 1px 4px rgba(0,0,0,0.04);
    --shadow-lg: 0 10px 40px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
    --radius: 18px;
    --radius-sm: 10px;
}

* { box-sizing: border-box; }

body {
    background: var(--bg);
    color: var(--text);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    -webkit-font-smoothing: antialiased;
}

.prices-header {
    background: linear-gradient(135deg, #0052FF 0%, #0ea5e9 50%, #7c3aed 100%);
    border-radius: var(--radius);
    padding: 32px 36px;
    margin-bottom: 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,82,255,0.3);
}

.prices-header::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}

.prices-title h1 {
    font-size: 2.1rem;
    font-weight: 900;
    margin: 0 0 6px;
    color: #fff;
    letter-spacing: -0.8px;
    text-shadow: 0 2px 8px rgba(0,0,0,0.12);
}

.prices-title p {
    margin: 0;
    color: rgba(255,255,255,0.8);
    font-size: 1rem;
    font-weight: 500;
}

.btn-primary {
    background: rgba(255,255,255,0.18);
    color: #fff;
    border: 1.5px solid rgba(255,255,255,0.35);
    padding: 11px 22px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s;
    backdrop-filter: blur(8px);
    white-space: nowrap;
}

.btn-primary:hover {
    background: rgba(255,255,255,0.28);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-outline {
    background: transparent;
    color: var(--muted);
    border: 1.5px solid var(--border);
    padding: 11px 22px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-outline:hover { background: var(--surface2); color: var(--text); }

.clean-card {
    background: var(--surface);
    border-radius: var(--radius);
    padding: 28px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border);
    margin-bottom: 24px;
    transition: box-shadow 0.2s;
}

.clean-card:hover { box-shadow: var(--shadow-lg); }

.clean-card h3 {
    margin: 0 0 5px;
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.3px;
}

.clean-card p.card-desc {
    color: var(--muted);
    margin: 0 0 20px;
    font-size: 0.88rem;
}

.search-container { display: flex; gap: 10px; margin-bottom: 20px; }

.search-input-wrapper { flex: 1; position: relative; display: flex; align-items: center; }

.search-icon { position: absolute; left: 16px; color: #94a3b8; }

.giant-search-input {
    width: 100%;
    padding: 15px 15px 15px 48px;
    font-size: 0.98rem;
    border: 2px solid var(--border);
    border-radius: 12px;
    background: var(--surface2);
    color: var(--text);
    transition: all 0.25s;
    outline: none;
    font-family: inherit;
    font-weight: 500;
}
.giant-search-input::placeholder { color: #adb5bd; }
.giant-search-input:focus {
    background: #fff;
    border-color: var(--blue);
    box-shadow: 0 0 0 4px rgba(0,82,255,0.1);
}

.search-btn { padding: 0 24px; font-size: 0.95rem; border-radius: 12px; }

.market-results {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 14px;
}

.market-product-card {
    border: 1.5px solid var(--border);
    border-radius: 14px;
    padding: 16px;
    background: #fff;
    transition: all 0.22s;
    cursor: default;
}
.market-product-card:hover {
    box-shadow: 0 8px 28px rgba(0,82,255,0.1);
    transform: translateY(-3px);
    border-color: rgba(0,82,255,0.25);
}

.clean-table-container { overflow-x: auto; border-radius: 12px; }

.clean-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.clean-table th {
    text-align: left;
    padding: 11px 16px;
    color: var(--muted);
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    border-bottom: 2px solid var(--border);
    background: var(--surface2);
}
.clean-table th:first-child { border-radius: 10px 0 0 0; }
.clean-table th:last-child  { border-radius: 0 10px 0 0; }

.clean-table td {
    padding: 14px 16px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    font-size: 0.92rem;
}
.clean-table tbody tr:hover { background: rgba(0,82,255,0.02); }
.clean-table tbody tr:last-child td { border-bottom: none; }

.item-name { font-weight: 700; color: var(--text); font-size: 0.95rem; }
.item-date { color: #94a3b8; font-size: 0.8rem; margin-top: 2px; }

.item-price {
    font-weight: 800;
    font-size: 1.05rem;
    background: linear-gradient(135deg, var(--blue), #7c3aed);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.category-badge {
    background: var(--blue-light);
    color: var(--blue);
    font-size: 0.75rem;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 700;
    letter-spacing: 0.2px;
}

.form-input-clean {
    width: 100%;
    padding: 12px 14px;
    border: 2px solid var(--border);
    border-radius: 10px;
    font-family: inherit;
    font-size: 0.93rem;
    transition: all 0.2s;
    outline: none;
    background: var(--surface2);
}
.form-input-clean:focus {
    border-color: var(--blue);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(0,82,255,0.1);
}

.quick-btn-kzt {
    background: var(--amber-light);
    border: 1.5px solid #fde68a;
    border-radius: 20px;
    padding: 5px 14px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    color: #92400e;
    transition: all 0.15s;
    font-family: inherit;
}
.quick-btn-kzt:hover { background: #fef3c7; border-color: var(--amber); transform: scale(1.04); }

.quick-btn-pln {
    background: var(--blue-light);
    border: 1.5px solid #bfdbfe;
    border-radius: 20px;
    padding: 5px 14px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    color: #1e40af;
    transition: all 0.15s;
    font-family: inherit;
}
.quick-btn-pln:hover { background: #dbeafe; border-color: #93c5fd; transform: scale(1.04); }

select {
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 32px !important;
}

@keyframes spin { to { transform: rotate(360deg); } }

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}

.category-row-animated { animation: fadeUp 0.35s ease both; }

@media (max-width: 768px) {
    .prices-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 14px;
        padding: 22px 18px;
    }

    .prices-title h1 { font-size: 1.5rem; }

    .prices-header .btn-primary {
        width: 100%;
        justify-content: center;
    }

    .clean-card { padding: 18px 16px; }

    .search-container { flex-direction: column; }
    .search-btn { padding: 14px; width: 100%; }

    .city-selectors-row {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 12px !important;
    }

    .city-arrow-divider { display: none !important; }

    .calc-grid {
        grid-template-columns: 1fr !important;
    }

    .calc-swap-col {
        padding-top: 0 !important;
        justify-content: center;
    }

    .calc-swap-col button {
        transform: rotate(90deg);
    }

    .category-cols-grid {
        grid-template-columns: 1fr !important;
        gap: 8px !important;
    }

    .clean-table-container {
        overflow-x: unset;
    }

    .clean-table thead {
        display: none;
    }

    .clean-table tbody tr {
        display: block;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        margin-bottom: 10px;
        padding: 14px 16px;
        position: relative;
    }

    .clean-table td {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 6px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.88rem;
    }

    .clean-table td:last-child {
        border-bottom: none;
    }

    .clean-table td::before {
        content: attr(data-label);
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.4px;
        flex-shrink: 0;
        margin-right: 8px;
        padding-top: 2px;
        min-width: 90px;
    }

    .market-results {
        grid-template-columns: 1fr;
    }

    #price-modal {
        padding: 0 !important;
        align-items: flex-end !important;
    }

    #price-modal > div {
        border-radius: 20px 20px 0 0 !important;
        max-width: 100% !important;
        padding: 24px 20px !important;
        max-height: 90vh;
        overflow-y: auto;
    }

    #price-modal .form-grid-2col {
        grid-template-columns: 1fr !important;
    }

    #exchange-bar {
        flex-direction: column !important;
        gap: 8px !important;
    }
}

@media (max-width: 480px) {
    .prices-title h1 { font-size: 1.3rem; }
    .clean-card { padding: 14px 12px; }
    .quick-btn-kzt, .quick-btn-pln { font-size: 11px; padding: 5px 10px; }
}
</style>

<div class="prices-header">
    <div class="prices-title">
        <h1><?= __('prices_comparison') ?></h1>
        <p><?= __('prices_subtitle') ?></p>
    </div>
    <button onclick="openPriceModal()" class="btn-primary" style="display:none; align-items:center; gap:8px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        <?= __('add_data') ?>
    </button>
</div>

<div class="clean-card" style="background: linear-gradient(135deg, #f8faff 0%, #fff 100%);">
    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px;">
        <div>
            <h3 style="margin:0 0 4px;">&#127988; Казахстан vs &#127477;&#127473; Польша</h3>
            <p class="card-desc" style="margin:0;"><?= __('real_data_teleport') ?></p>
        </div>
        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;" class="city-selectors-row">
            <div style="display:flex; flex-direction:column; gap:4px;">
                <label style="font-size:11px; font-weight:600; color:#64748b; text-transform:uppercase;"><?= __('city_kz') ?></label>
                <select id="kz-city" onchange="loadComparison()" style="padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:14px; background:white; cursor:pointer;">
                    <option value="almaty"><?= __('city_almaty') ?></option>
                    <option value="astana"><?= __('city_astana') ?></option>
                </select>
            </div>
            <div style="font-size:22px; padding-top:18px; color:#94a3b8;" class="city-arrow-divider">&#10132;</div>
            <div style="display:flex; flex-direction:column; gap:4px;">
                <label style="font-size:11px; font-weight:600; color:#64748b; text-transform:uppercase;"><?= __('city_pl') ?></label>
                <select id="pl-city" onchange="loadComparison()" style="padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:14px; background:white; cursor:pointer;">
                    <option value="warsaw"><?= __('city_warsaw') ?></option>
                    <option value="krakow"><?= __('city_krakow') ?></option>
                    <option value="wroclaw"><?= __('city_wroclaw') ?></option>
                    <option value="poznan"><?= __('city_poznan') ?></option>
                    <option value="gdansk"><?= __('city_gdansk') ?></option>
                    <option value="lodz"><?= __('city_lodz') ?></option>
                </select>
            </div>
        </div>
    </div>

    <div id="comparison-loading" style="text-align:center; padding:40px; color:#94a3b8;">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="animation:spin 1.2s linear infinite; display:inline-block;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
        <div style="margin-top:10px; font-size:14px;"><?= __('loading_data') ?></div>
    </div>

    <div id="comparison-content" style="display:none;">
        <div id="exchange-bar" style="display:flex; align-items:center; gap:16px; background:#f0f4ff; border-radius:12px; padding:12px 16px; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
            <div style="font-size:13px; color:#334155;">
                <strong><?= __('exchange_rate') ?></strong> <span id="exchange-rate-text">...</span>
            </div>
            <div style="font-size:13px; color:#334155;">
                <strong id="avg-savings-label"><?= __('average') ?></strong> <span id="avg-savings-value" style="color:#0052FF; font-weight:700;"></span>
            </div>
        </div>

        <div id="category-rows" style="display:flex; flex-direction:column; gap:12px;"></div>

        <div style="margin-top:16px; font-size:11px; color:#94a3b8; text-align:right;">
            <?= __('source_numbeo') ?>
        </div>
    </div>

    <div id="comparison-error" style="display:none; text-align:center; padding:30px; color:#ef4444; font-size:14px;">
        <?= __('load_error_custom') ?>
    </div>
</div>

<div class="clean-card">
    <h3 style="display:flex; align-items:center; gap:8px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16"><path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>
        <?= __('search_products_pl') ?>
        <span style="font-size:0.7rem; background:rgba(0,82,255,0.1); color:var(--primary-blue); padding:3px 8px; border-radius:12px; line-height:1;">Open Food Facts</span>
    </h3>
    <p class="card-desc"><?= __('open_food_facts') ?></p>

    <div class="search-container">
        <div class="search-input-wrapper">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <input type="text" id="market-search" class="giant-search-input" placeholder="<?= __('search_placeholder') ?>" onkeyup="if(event.key === 'Enter') searchMarket()">
        </div>
        <button class="btn-primary search-btn" onclick="searchMarket()"><?= __('search_btn') ?></button>
    </div>

    <div id="market-results" class="market-results">
    </div>
</div>

<div class="clean-card" style="background:linear-gradient(135deg,#f0f4ff,#fff);">
    <h3 style="margin:0 0 4px; display:flex; align-items:center; gap:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0052FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        <?= __('currency_calculator') ?>
        <span id="calc-rate-badge" style="font-size:0.72rem; background:rgba(0,82,255,0.1); color:#0052FF; padding:3px 10px; border-radius:12px; font-weight:600;"><?= __('loading_rate') ?></span>
    </h3>
    <p class="card-desc"><?= __('actual_rate_desc') ?></p>

    <div style="display:grid; grid-template-columns:1fr auto 1fr; align-items:center; gap:12px;" class="calc-grid">
        <div>
            <label style="display:block; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px; display:flex; align-items:center; gap:6px;"><img src="https://flagcdn.com/20x15/kz.png" width="20" height="15" style="border-radius:2px;"> <?= __('tenge') ?></label>
            <div style="position:relative;">
                <input type="number" id="calc-kzt" placeholder="0" min="0" oninput="convertKztToPln()"
                    style="width:100%; padding:14px 54px 14px 16px; font-size:1.2rem; font-weight:700; border:2px solid #e2e8f0; border-radius:12px; outline:none; transition:border-color 0.2s; background:#f8fafc; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#f59e0b'; this.style.background='white';"
                    onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                <span style="position:absolute; right:14px; top:50%; transform:translateY(-50%); font-weight:700; color:#f59e0b; font-size:13px; pointer-events:none;">KZT</span>
            </div>
        </div>
        <div style="padding-top:22px; display:flex; align-items:center;" class="calc-swap-col">
            <button onclick="swapCurrencies()" title="Поменять"
                style="background:#0052FF; color:white; border:none; border-radius:50%; width:40px; height:40px; font-size:18px; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(0,82,255,0.25); transition:transform 0.25s, background 0.2s;"
                onmouseover="this.style.transform='rotate(180deg)'; this.style.background='#0043cc';"
                onmouseout="this.style.transform='rotate(0deg)'; this.style.background='#0052FF';">&#8646;</button>
        </div>
        <div>
            <label style="display:block; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px; display:flex; align-items:center; gap:6px;"><img src="https://flagcdn.com/20x15/pl.png" width="20" height="15" style="border-radius:2px;"> <?= __('zloty') ?></label>
            <div style="position:relative;">
                <input type="number" id="calc-pln" placeholder="0" min="0" oninput="convertPlnToKzt()"
                    style="width:100%; padding:14px 54px 14px 16px; font-size:1.2rem; font-weight:700; border:2px solid #e2e8f0; border-radius:12px; outline:none; transition:border-color 0.2s; background:#f8fafc; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#0052FF'; this.style.background='white';"
                    onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                <span style="position:absolute; right:14px; top:50%; transform:translateY(-50%); font-weight:700; color:#0052FF; font-size:13px; pointer-events:none;">PLN</span>
            </div>
        </div>
    </div>

    <div style="margin-top:14px; display:flex; flex-wrap:wrap; gap:8px; align-items:center;">
        <span style="font-size:12px; color:#64748b; font-weight:500;"><?= __('quick_kzt') ?></span>
        <button onclick="setKzt(10000)"  class="quick-btn-kzt">10 000 KZT</button>
        <button onclick="setKzt(50000)"  class="quick-btn-kzt">50 000 KZT</button>
        <button onclick="setKzt(100000)" class="quick-btn-kzt">100 000 KZT</button>
        <button onclick="setPln(100)"    class="quick-btn-pln">100 PLN</button>
        <button onclick="setPln(500)"    class="quick-btn-pln">500 PLN</button>
        <button onclick="setPln(2000)"   class="quick-btn-pln">2 000 PLN</button>
    </div>
</div>

<div class="clean-card">
    <h3><?= __('student_reports') ?></h3>
    <p class="card-desc"><?= __('reports_desc') ?></p>
    
    <div class="clean-table-container">
        <table class="clean-table">
            <thead>
                <tr>
                    <th><?= __('item_name') ?></th>
                    <th><?= __('category') ?></th>
                    <th><?= __('cost_pln') ?></th>
                    <th><?= __('note') ?></th>
                    <th><?= __('author_report') ?></th>
                </tr>
            </thead>
            <tbody id="prices-table-body">
                <tr><td colspan="5" style="text-align:center; padding:3rem; color:var(--text-muted); font-size:0.95rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="animation: spin 2s linear infinite; opacity: 0.5; margin-bottom:10px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    <br><?= __('syncing_data') ?>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

<div id="price-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); z-index:1000; align-items:center; justify-content:center; padding: 20px;">
    <div style="background:white; padding:32px; border-radius:20px; width:100%; max-width:480px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
        <h3 style="margin:0 0 24px 0; font-size:1.4rem; color:var(--text-main);"><?= __('add_record') ?></h3>
        <form id="price-form" onsubmit="submitPrice(event)">
            <div style="margin-bottom:16px;">
                <label style="display:block; margin-bottom:8px; font-size:0.9rem; font-weight:600; color:var(--text-main);"><?= __('item_name_label') ?></label>
                <input type="text" name="item_name" class="form-input-clean" placeholder="<?= __('item_name_placeholder') ?>" required>
            </div>
            
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:16px;" class="form-grid-2col">
                <div>
                    <label style="display:block; margin-bottom:8px; font-size:0.9rem; font-weight:600; color:var(--text-main);"><?= __('amount_pln') ?></label>
                    <input type="number" name="price" step="0.01" class="form-input-clean" placeholder="0.00" required>
                </div>
                <div>
                    <label style="display:block; margin-bottom:8px; font-size:0.9rem; font-weight:600; color:var(--text-main);"><?= __('group') ?></label>
                    <select name="category" class="form-input-clean">
                        <option value="food"><?= __('cat_food') ?></option>
                        <option value="transport"><?= __('cat_transport') ?></option>
                        <option value="housing"><?= __('cat_housing') ?></option>
                        <option value="services"><?= __('cat_services') ?></option>
                        <option value="entertainment"><?= __('cat_entertainment') ?></option>
                        <option value="other"><?= __('cat_other') ?></option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block; margin-bottom:8px; font-size:0.9rem; font-weight:600; color:var(--text-main);"><?= __('note') ?></label>
                <textarea name="comment" class="form-input-clean" rows="2" placeholder="<?= __('note_placeholder') ?>"></textarea>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px;">
                <button type="button" onclick="closePriceModal()" class="btn-outline"><?= __('cancel') ?></button>
                <button type="submit" class="btn-primary"><?= __('save_data_btn') ?></button>
            </div>
        </form>
    </div>
</div>

<script>
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    let exchangeRateKztPln = 0.0088; // fallback until API resolves

    function convertKztToPln() {
        const kzt = parseFloat(document.getElementById('calc-kzt').value);
        if (isNaN(kzt) || kzt < 0) { document.getElementById('calc-pln').value = ''; return; }
        const pln = kzt * exchangeRateKztPln;
        document.getElementById('calc-pln').value = pln.toFixed(2);
    }

    function convertPlnToKzt() {
        const pln = parseFloat(document.getElementById('calc-pln').value);
        if (isNaN(pln) || pln < 0) { document.getElementById('calc-kzt').value = ''; return; }
        const kzt = pln / exchangeRateKztPln;
        document.getElementById('calc-kzt').value = Math.round(kzt);
    }

    function swapCurrencies() {
        const kzt = document.getElementById('calc-kzt').value;
        const pln = document.getElementById('calc-pln').value;
        document.getElementById('calc-kzt').value = pln ? parseFloat(pln).toFixed(0) : '';
        document.getElementById('calc-pln').value = kzt ? parseFloat(kzt).toFixed(2) : '';
        if (document.getElementById('calc-kzt').value) convertKztToPln();
    }

    function setKzt(amount) {
        document.getElementById('calc-kzt').value = amount;
        convertKztToPln();
    }

    function setPln(amount) {
        document.getElementById('calc-pln').value = amount;
        convertPlnToKzt();
    }

    function updateCalcBadge(rate) {
        exchangeRateKztPln = rate;
        const kztPer1Pln = (1 / rate).toFixed(0);
        const badge = document.getElementById('calc-rate-badge');
        if (badge) {
            badge.textContent = `1 PLN = ${kztPer1Pln} KZT`;
            badge.style.background = 'rgba(22,163,74,0.1)';
            badge.style.color = '#16a34a';
        }
        if (document.getElementById('calc-kzt').value) convertKztToPln();
        else if (document.getElementById('calc-pln').value) convertPlnToKzt();
    }

    const FLAG_KZ = '<img src="https://flagcdn.com/20x15/kz.png" width="20" height="15" style="border-radius:2px; vertical-align:middle;">';
    const FLAG_PL = '<img src="https://flagcdn.com/20x15/pl.png" width="20" height="15" style="border-radius:2px; vertical-align:middle;">';

    const ICO = {
        home:    '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0052FF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
        bag:     '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0052FF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>',
        bus:     '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0052FF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="22" height="16" rx="2"/><path d="M1 8h22"/><path d="M12 3v5"/><circle cx="6.5" cy="19" r="1.5"/><circle cx="17.5" cy="19" r="1.5"/></svg>',
        fork:    '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0052FF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/></svg>',
        bolt:    '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0052FF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
        wifi:    '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0052FF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>',
        phone:   '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0052FF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>',
    };

    const costData = {
        almaty: {
            name: 'Алматы', flag: FLAG_KZ, currency: 'KZT',
            rows: [
                { label: '<?= __('month_rent_center') ?>',    icon: ICO.home,  value: 180000 },
                { label: '<?= __('month_rent_outside') ?>', icon: ICO.home,  value: 110000 },
                { label: '<?= __('groceries_month') ?>',          icon: ICO.bag,   value: 80000  },
                { label: '<?= __('transport_pass') ?>',          icon: ICO.bus,   value: 9000   },
                { label: '<?= __('cafe_meal') ?>',        icon: ICO.fork,  value: 2500   },
                { label: '<?= __('utilities') ?>',        icon: ICO.bolt,  value: 25000  },
                { label: '<?= __('internet') ?>',        icon: ICO.wifi,  value: 5000   },
                { label: '<?= __('mobile_plan') ?>',            icon: ICO.phone, value: 3000   },
            ]
        },
        astana: {
            name: 'Астана', flag: FLAG_KZ, currency: 'KZT',
            rows: [
                { label: '<?= __('month_rent_center') ?>',    icon: ICO.home,  value: 200000 },
                { label: '<?= __('month_rent_outside') ?>', icon: ICO.home,  value: 130000 },
                { label: '<?= __('groceries_month') ?>',          icon: ICO.bag,   value: 85000  },
                { label: '<?= __('transport_pass') ?>',          icon: ICO.bus,   value: 8000   },
                { label: '<?= __('cafe_meal') ?>',        icon: ICO.fork,  value: 2800   },
                { label: '<?= __('utilities') ?>',        icon: ICO.bolt,  value: 30000  },
                { label: '<?= __('internet') ?>',        icon: ICO.wifi,  value: 5500   },
                { label: '<?= __('mobile_plan') ?>',            icon: ICO.phone, value: 3000   },
            ]
        },
        warsaw: {
            name: 'Варшава', flag: FLAG_PL, currency: 'PLN',
            rows: [
                { label: '<?= __('month_rent_center') ?>',    icon: ICO.home,  value: 3200  },
                { label: '<?= __('month_rent_outside') ?>', icon: ICO.home,  value: 2300  },
                { label: '<?= __('groceries_month') ?>',          icon: ICO.bag,   value: 900   },
                { label: '<?= __('transport_pass') ?>',          icon: ICO.bus,   value: 110   },
                { label: '<?= __('cafe_meal') ?>',        icon: ICO.fork,  value: 35    },
                { label: '<?= __('utilities') ?>',        icon: ICO.bolt,  value: 450   },
                { label: '<?= __('internet') ?>',        icon: ICO.wifi,  value: 55    },
                { label: '<?= __('mobile_plan') ?>',            icon: ICO.phone, value: 30    },
            ]
        },
        krakow: {
            name: 'Краков', flag: FLAG_PL, currency: 'PLN',
            rows: [
                { label: '<?= __('month_rent_center') ?>',    icon: ICO.home,  value: 2600  },
                { label: '<?= __('month_rent_outside') ?>', icon: ICO.home,  value: 1900  },
                { label: '<?= __('groceries_month') ?>',          icon: ICO.bag,   value: 850   },
                { label: '<?= __('transport_pass') ?>',          icon: ICO.bus,   value: 113   },
                { label: '<?= __('cafe_meal') ?>',        icon: ICO.fork,  value: 30    },
                { label: '<?= __('utilities') ?>',        icon: ICO.bolt,  value: 400   },
                { label: '<?= __('internet') ?>',        icon: ICO.wifi,  value: 50    },
                { label: '<?= __('mobile_plan') ?>',            icon: ICO.phone, value: 28    },
            ]
        },
        wroclaw: {
            name: 'Вроцлав', flag: FLAG_PL, currency: 'PLN',
            rows: [
                { label: '<?= __('month_rent_center') ?>',    icon: ICO.home,  value: 2700  },
                { label: '<?= __('month_rent_outside') ?>', icon: ICO.home,  value: 1950  },
                { label: '<?= __('groceries_month') ?>',          icon: ICO.bag,   value: 820   },
                { label: '<?= __('transport_pass') ?>',          icon: ICO.bus,   value: 110   },
                { label: '<?= __('cafe_meal') ?>',        icon: ICO.fork,  value: 30    },
                { label: '<?= __('utilities') ?>',        icon: ICO.bolt,  value: 380   },
                { label: '<?= __('internet') ?>',        icon: ICO.wifi,  value: 50    },
                { label: '<?= __('mobile_plan') ?>',            icon: ICO.phone, value: 28    },
            ]
        },
        poznan: {
            name: 'Познань', flag: FLAG_PL, currency: 'PLN',
            rows: [
                { label: '<?= __('month_rent_center') ?>',    icon: ICO.home,  value: 2400  },
                { label: '<?= __('month_rent_outside') ?>', icon: ICO.home,  value: 1750  },
                { label: '<?= __('groceries_month') ?>',          icon: ICO.bag,   value: 800   },
                { label: '<?= __('transport_pass') ?>',          icon: ICO.bus,   value: 110   },
                { label: '<?= __('cafe_meal') ?>',        icon: ICO.fork,  value: 28    },
                { label: '<?= __('utilities') ?>',        icon: ICO.bolt,  value: 360   },
                { label: '<?= __('internet') ?>',        icon: ICO.wifi,  value: 48    },
                { label: '<?= __('mobile_plan') ?>',            icon: ICO.phone, value: 28    },
            ]
        },
        gdansk: {
            name: 'Гданьск', flag: FLAG_PL, currency: 'PLN',
            rows: [
                { label: '<?= __('month_rent_center') ?>',    icon: ICO.home,  value: 2800  },
                { label: '<?= __('month_rent_outside') ?>', icon: ICO.home,  value: 2000  },
                { label: '<?= __('groceries_month') ?>',          icon: ICO.bag,   value: 850   },
                { label: '<?= __('transport_pass') ?>',          icon: ICO.bus,   value: 110   },
                { label: '<?= __('cafe_meal') ?>',        icon: ICO.fork,  value: 32    },
                { label: '<?= __('utilities') ?>',        icon: ICO.bolt,  value: 400   },
                { label: '<?= __('internet') ?>',        icon: ICO.wifi,  value: 50    },
                { label: '<?= __('mobile_plan') ?>',            icon: ICO.phone, value: 28    },
            ]
        },
        lodz: {
            name: 'Лодзь', flag: FLAG_PL, currency: 'PLN',
            rows: [
                { label: '<?= __('month_rent_center') ?>',    icon: ICO.home,  value: 2000  },
                { label: '<?= __('month_rent_outside') ?>', icon: ICO.home,  value: 1400  },
                { label: '<?= __('groceries_month') ?>',          icon: ICO.bag,   value: 750   },
                { label: '<?= __('transport_pass') ?>',          icon: ICO.bus,   value: 90    },
                { label: '<?= __('cafe_meal') ?>',        icon: ICO.fork,  value: 26    },
                { label: '<?= __('utilities') ?>',        icon: ICO.bolt,  value: 340   },
                { label: '<?= __('internet') ?>',        icon: ICO.wifi,  value: 45    },
                { label: '<?= __('mobile_plan') ?>',            icon: ICO.phone, value: 25    },
            ]
        }
    };

    async function fetchExchangeRate() {
        const apis = [
            'https://api.exchangerate.host/convert?from=KZT&to=PLN&amount=1',
            'https://open.er-api.com/v6/latest/KZT'
        ];
        try {
            const res = await fetch(apis[0]);
            const data = await res.json();
            if (data.result && data.result > 0) return data.result;
            const res2 = await fetch(apis[1]);
            const data2 = await res2.json();
            if (data2.rates && data2.rates.PLN) return data2.rates.PLN;
        } catch(e) {}
        return 0.0088; // fallback ~2024
    }

    async function loadComparison() {
        const kzCity = document.getElementById('kz-city').value;
        const plCity = document.getElementById('pl-city').value;

        document.getElementById('comparison-loading').style.display = 'block';
        document.getElementById('comparison-content').style.display = 'none';
        document.getElementById('comparison-error').style.display = 'none';

        try {
            const rate = await fetchExchangeRate();

            const kztPerPln = (1 / rate).toFixed(0);
            document.getElementById('exchange-rate-text').textContent = `1 PLN = ${kztPerPln} KZT`;
            updateCalcBadge(rate);

            const kz = costData[kzCity];
            const pl = costData[plCity];
            const rowsEl = document.getElementById('category-rows');
            rowsEl.innerHTML = '';

            let totalKzt = 0, totalPlnInKzt = 0;

            kz.rows.forEach((kzRow, i) => {
                const plRow = pl.rows[i];
                if (!plRow) return;

                const kzVal  = kzRow.value;                   // KZT
                const plVal  = plRow.value;                   // PLN
                const plInKzt = Math.round(plVal / rate);     // PLN → KZT

                totalKzt      += kzVal;
                totalPlnInKzt += plInKzt;

                const cheaperInPL = plInKzt < kzVal;
                const diffKzt = Math.abs(kzVal - plInKzt);
                const diffPct = Math.round((diffKzt / kzVal) * 100);

                const kzPct = Math.min(100, (kzVal / Math.max(kzVal, plInKzt)) * 100);
                const plPct = Math.min(100, (plInKzt / Math.max(kzVal, plInKzt)) * 100);

                const row = document.createElement('div');
                row.className = 'category-row-animated';
                row.style.cssText = `background:#f8fafc; border-radius:14px; padding:16px 18px; border:1px solid #e2e8f0; animation-delay:${i * 60}ms;`;
                row.innerHTML = `
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; flex-wrap:wrap; gap:6px;">
                        <span style="font-weight:600; font-size:14px; display:flex; align-items:center; gap:6px;">
                            <span>${kzRow.icon}</span> ${kzRow.label}
                        </span>
                        <span style="font-size:12px; font-weight:700; color:${cheaperInPL ? '#16a34a' : '#dc2626'};
                            background:${cheaperInPL ? 'rgba(22,163,74,0.1)' : 'rgba(220,38,38,0.1)'}; padding:3px 10px; border-radius:20px;">
                            <?= __('in_poland') ?> ${cheaperInPL ? '<?= __('cheaper') ?>' : '<?= __('more_expensive') ?>'} ` + '<?= __('by_percent') ?>'.replace('%s', diffPct) + `
                        </span>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" class="category-cols-grid">
                        <div>
                            <div style="display:flex; justify-content:space-between; margin-bottom:5px;">
                                <span style="font-size:12px; color:#64748b;">${kz.flag} ${kz.name}</span>
                                <span style="font-size:13px; font-weight:800; color:#f59e0b;">${kzVal.toLocaleString()} KZT</span>
                            </div>
                            <div style="height:7px; background:#e2e8f0; border-radius:4px; overflow:hidden;">
                                <div style="height:100%; width:${kzPct}%; background:linear-gradient(90deg,#fbbf24,#f59e0b); border-radius:4px;"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display:flex; justify-content:space-between; margin-bottom:5px;">
                                <span style="font-size:12px; color:#64748b;">${pl.flag} ${pl.name}</span>
                                <span style="font-size:13px; font-weight:800; color:#0052FF;">${plVal.toLocaleString()} PLN</span>
                            </div>
                            <div style="height:7px; background:#e2e8f0; border-radius:4px; overflow:hidden;">
                                <div style="height:100%; width:${plPct}%; background:linear-gradient(90deg,#60a5fa,#0052FF); border-radius:4px;"></div>
                            </div>
                            <div style="font-size:11px; color:#94a3b8; margin-top:3px; text-align:right;">&asymp; ${plInKzt.toLocaleString()} KZT</div>
                        </div>
                    </div>
                `;
                rowsEl.appendChild(row);
            });

            const totalPln = pl.rows.reduce((s, r) => s + r.value, 0);
            const totalDiffPct = Math.round(((totalPlnInKzt - totalKzt) / totalKzt) * 100);
            const summarySign = totalDiffPct >= 0 ? '+' : '';
            document.getElementById('avg-savings-value').textContent =
                `<?= __('poland_total') ?> ${totalDiffPct >= 0 ? '<?= __('more_expensive') ?>' : '<?= __('cheaper') ?>'} ` + '<?= __('by_percent') ?>'.replace('%s', Math.abs(totalDiffPct)) + ` (${totalPln.toLocaleString()} PLN / ${totalKzt.toLocaleString()} KZT)`;

            document.getElementById('comparison-loading').style.display = 'none';
            document.getElementById('comparison-content').style.display = 'block';

        } catch (err) {
            console.error(err);
            document.getElementById('comparison-loading').style.display = 'none';
            document.getElementById('comparison-error').style.display = 'block';
        }
    }

    function searchMarket() {
        const query = document.getElementById('market-search').value.trim();
        if (query.length < 2) {
            alert('Введите минимум 2 символа');
            return;
        }

        const container = document.getElementById('market-results');
        container.innerHTML = `<div style="grid-column:1/-1; text-align:center; color:var(--text-muted); padding:2rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="animation:spin 1.5s linear infinite; opacity:0.5;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            <br><span style="margin-top:8px; display:inline-block;"><?= __('searching_off') ?></span>
        </div>`;

        const url = `https://world.openfoodfacts.org/cgi/search.pl?search_terms=${encodeURIComponent(query)}&search_simple=1&action=process&json=1&countries_tags=en:poland&page_size=12&fields=product_name,brands,image_front_small_url,quantity,categories_tags,nutriscore_grade`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                container.innerHTML = '';
                const products = (data.products || []).filter(p => p.product_name);

                if (products.length === 0) {
                    container.innerHTML = `<div style="grid-column:1/-1; text-align:center; color:var(--text-muted); padding:2rem; border:1px dashed var(--card-border); border-radius:12px; background:white;">
                        <?= __('not_found_off') ?>
                    </div>`;
                    return;
                }

                products.forEach(p => {
                    const name = p.product_name || '<?= __('unnamed_product') ?>';
                    const brand = p.brands ? `<span style="color:#64748b; font-size:12px;">${p.brands.split(',')[0]}</span>` : '';
                    const qty = p.quantity ? `<span style="color:#94a3b8; font-size:12px;">${p.quantity}</span>` : '';
                    const img = p.image_front_small_url
                        ? `<img src="${p.image_front_small_url}" style="width:60px; height:60px; object-fit:contain; border-radius:8px; background:#f8fafc; flex-shrink:0;" onerror="this.style.display='none'">`
                        : `<div style="width:60px; height:60px; background:#f1f5f9; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:24px; flex-shrink:0;">&#127859;</div>`;
                    const nutri = p.nutriscore_grade ? `<span style="background:${{'a':'#16a34a','b':'#65a30d','c':'#ca8a04','d':'#ea580c','e':'#dc2626'}[p.nutriscore_grade]||'#94a3b8'}; color:white; font-size:10px; font-weight:800; padding:2px 6px; border-radius:4px; text-transform:uppercase;">Nutri-Score ${p.nutriscore_grade.toUpperCase()}</span>` : '';

                    const card = document.createElement('div');
                    card.className = 'market-product-card';
                    card.style.cssText = 'display:flex; gap:12px; align-items:flex-start;';
                    card.innerHTML = `
                        ${img}
                        <div style="flex:1; min-width:0;">
                            <div style="font-weight:700; font-size:14px; color:var(--text-main); margin-bottom:3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${name}</div>
                            <div style="display:flex; gap:6px; align-items:center; flex-wrap:wrap; margin-bottom:6px;">${brand} ${qty}</div>
                            ${nutri}
                        </div>
                    `;
                    container.appendChild(card);
                });
            })
            .catch(err => {
                console.error(err);
                container.innerHTML = `<div style="grid-column:1/-1; color:#ef4444; padding:2rem; text-align:center; border:1px solid #fecaca; background:#fef2f2; border-radius:12px;">
                    <?= __('load_error_retry') ?>
                </div>`;
            });
    }

    function loadPrices() {
        const tbody = document.getElementById('prices-table-body');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding:3rem; color:var(--text-muted); font-size:0.95rem;">Раздел "Сообщество" временно на обслуживании. Добавление пользовательских отчетов недоступно.</td></tr>';
        }
    }

    const modal = document.getElementById('price-modal');
    function openPriceModal() { modal.style.display = 'flex'; }
    function closePriceModal() { modal.style.display = 'none'; }

    modal.addEventListener('click', function(e) {
        if(e.target === modal) closePriceModal();
    });

    function submitPrice(e) {
        e.preventDefault();
        alert('Раздел временно на обслуживании');
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadPrices();
        loadComparison();
    });
</script>
