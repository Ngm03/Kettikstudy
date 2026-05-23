<style>
    :root {
        --card-radius: 14px;
        --card-border: #e2e8f0;
        --card-shadow: 0 1px 3px rgba(0,0,0,0.05);
        --card-hover-shadow: 0 6px 20px rgba(0,0,0,0.09);
        --muted: #64748b;
        --text: #1e293b;
    }

    .an-page { display: flex; flex-direction: column; gap: 20px; }

    .an-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }
    .an-topbar-title h2 { font-size: 1.1rem; font-weight: 700; color: var(--text); }
    .an-topbar-title p  { font-size: 0.78rem; color: var(--muted); margin-top: 2px; }
    .an-refresh-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px;
        background: #fff;
        border: 1px solid var(--card-border);
        border-radius: 10px;
        font-size: 0.82rem; font-weight: 600;
        color: var(--text);
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all 0.2s;
        box-shadow: var(--card-shadow);
    }
    .an-refresh-btn:hover { border-color: #ef4444; color: #ef4444; background: #fff8f8; }
    .an-refresh-btn svg { width: 15px; height: 15px; }
    .an-refresh-btn.spinning svg { animation: spin 0.8s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    .an-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
    }
    @media (max-width: 900px) { .an-stats { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 500px) { 
        .an-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; }
        .an-stat { padding: 12px 10px; gap: 8px; }
        .an-stat-icon { width: 36px; height: 36px; border-radius: 10px; }
        .an-stat-icon svg { width: 18px; height: 18px; }
        .an-stat-num { font-size: 1.3rem; }
        .an-stat-label { font-size: 0.65rem; }
        .an-stat-sub { font-size: 0.65rem; }
    }

    .an-stat {
        background: #fff;
        border: 1px solid var(--card-border);
        border-radius: var(--card-radius);
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        box-shadow: var(--card-shadow);
        transition: box-shadow 0.2s, transform 0.2s;
        cursor: default;
    }
    .an-stat:hover { box-shadow: var(--card-hover-shadow); transform: translateY(-2px); }
    .an-stat-head { display: flex; justify-content: space-between; align-items: flex-start; }
    .an-stat-icon {
        width: 40px; height: 40px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .an-stat-icon svg { width: 18px; height: 18px; }
    .an-stat-badge {
        font-size: 0.68rem; font-weight: 700;
        padding: 3px 7px; border-radius: 6px;
        white-space: nowrap;
    }
    .an-stat-num {
        font-size: 1.8rem; font-weight: 800; line-height: 1;
        color: var(--text);
        font-variant-numeric: tabular-nums;
    }
    .an-stat-label { font-size: 0.72rem; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; }
    .an-stat-sub { font-size: 0.75rem; color: var(--muted); display: flex; align-items: center; gap: 4px; }
    .an-stat-sub span { background: #f1f5f9; padding: 2px 6px; border-radius: 5px; font-weight: 600; font-size: 0.7rem; }

    .icon-blue   { background: #eff6ff; color: #3b82f6; }
    .icon-green  { background: #f0fdf4; color: #22c55e; }
    .icon-amber  { background: #fffbeb; color: #f59e0b; }
    .icon-violet { background: #f5f3ff; color: #8b5cf6; }
    .icon-red    { background: #fef2f2; color: #ef4444; }

    .an-charts {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }
    @media (max-width: 800px) { .an-charts { grid-template-columns: 1fr; } }

    .an-chart-card {
        background: #fff;
        border: 1px solid var(--card-border);
        border-radius: var(--card-radius);
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: box-shadow 0.2s;
    }
    .an-chart-card:hover { box-shadow: var(--card-hover-shadow); }
    .an-chart-header {
        padding: 16px 20px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 4px;
    }
    .an-chart-header h3 { font-size: 0.9rem; font-weight: 700; color: var(--text); }
    .an-chart-header span { font-size: 0.72rem; color: var(--muted); }
    .an-chart-body { padding: 12px 20px 20px; position: relative; height: 280px; }

    .an-table-card {
        background: #fff;
        border: 1px solid var(--card-border);
        border-radius: var(--card-radius);
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    .an-table-header {
        padding: 14px 20px;
        border-bottom: 1px solid var(--card-border);
        background: #f8fafc;
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
        flex-wrap: wrap;
    }
    .an-table-header h3 { font-size: 0.9rem; font-weight: 700; color: var(--text); }
    .live-pill {
        display: inline-flex; align-items: center; gap: 5px;
        background: #f0fdf4; color: #16a34a;
        border: 1px solid #bbf7d0;
        border-radius: 20px;
        padding: 3px 10px;
        font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .live-dot { width: 6px; height: 6px; background: #22c55e; border-radius: 50%; animation: blink 1.5s ease-in-out infinite; }
    @keyframes blink { 0%,100% { opacity:1; } 50% { opacity:0.3; } }

    .an-table { width: 100%; border-collapse: collapse; }
    .an-table th {
        text-align: left; padding: 10px 20px;
        font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
        color: var(--muted); background: #f8fafc; border-bottom: 1px solid var(--card-border);
    }
    .an-table td { padding: 12px 20px; border-bottom: 1px solid #f1f5f9; font-size: 0.845rem; color: var(--text); }
    .an-table tbody tr:last-child td { border-bottom: none; }
    .an-table tbody tr:hover { background: #fafafa; }

    .device-badge {
        display: inline-flex; align-items: center; gap: 4px;
        background: #f1f5f9; padding: 3px 8px; border-radius: 6px;
        font-size: 0.75rem; font-weight: 600; color: #475569;
    }
    .source-badge {
        display: inline-flex; align-items: center;
        background: #eff6ff; padding: 3px 8px; border-radius: 6px;
        font-size: 0.75rem; font-weight: 600; color: #2563eb;
    }

    .an-mobile-activity { display: none; padding: 12px; }
    .activity-card {
        background: #f8fafc; border: 1px solid var(--card-border); border-radius: 10px;
        padding: 12px 14px; margin-bottom: 8px;
        display: flex; flex-direction: column; gap: 6px;
    }
    .activity-card-top { display: flex; justify-content: space-between; align-items: center; }
    .activity-card-ip { font-weight: 700; font-size: 0.875rem; color: var(--text); }
    .activity-card-time { font-size: 0.72rem; color: var(--muted); }
    .activity-card-row { display: flex; gap: 6px; flex-wrap: wrap; align-items: center; }

    @media (max-width: 600px) {
        .an-table-wrapper { display: none; }
        .an-mobile-activity { display: block; }
        .an-topbar { flex-direction: column; align-items: flex-start; }
    }
    @media (min-width: 601px) { .an-mobile-activity { display: none; } }
</style>

<div class="an-page">

    <div class="an-topbar">
        <div class="an-topbar-title">
            <h2><?= __('analytics_title') ?></h2>
            <p><?= __('analytics_subtitle') ?></p>
        </div>
        <button onclick="refreshAnalytics(this)" class="an-refresh-btn">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            <?= __('analytics_btn_refresh') ?>
        </button>
    </div>

    <div class="an-stats">
        <div class="an-stat">
            <div class="an-stat-head">
                <div class="an-stat-icon icon-blue">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <span class="an-stat-badge" style="background:#eff6ff;color:#3b82f6;"><?= __('analytics_stat_visitors_today') ?></span>
            </div>
            <div>
                <div class="an-stat-num" id="visitors-count">—</div>
                <div class="an-stat-label"><?= __('analytics_stat_visitors_lbl') ?></div>
            </div>
            <div class="an-stat-sub"><?= __('analytics_stat_visitors_sub') ?><span id="visitors-yesterday">—</span></div>
        </div>

        <div class="an-stat">
            <div class="an-stat-head">
                <div class="an-stat-icon icon-green">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span class="an-stat-badge" style="background:#f0fdf4;color:#16a34a;"><?= __('analytics_stat_leads_total') ?></span>
            </div>
            <div>
                <div class="an-stat-num" id="leads-count">—</div>
                <div class="an-stat-label"><?= __('analytics_stat_leads_lbl') ?></div>
            </div>
            <div class="an-stat-sub"><?= __('analytics_stat_visitors_sub') ?><span id="leads-yesterday">—</span></div>
        </div>

        <div class="an-stat">
            <div class="an-stat-head">
                <div class="an-stat-icon icon-amber">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/></svg>
                </div>
                <span class="an-stat-badge" style="background:#fffbeb;color:#d97706;">Hot</span>
            </div>
            <div>
                <div class="an-stat-num" id="qualified-count">—</div>
                <div class="an-stat-label"><?= __('analytics_stat_hot_lbl') ?></div>
            </div>
            <div class="an-stat-sub"><?= __('analytics_stat_visitors_sub') ?><span id="qualified-yesterday">—</span></div>
        </div>

        <div class="an-stat">
            <div class="an-stat-head">
                <div class="an-stat-icon icon-violet">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <span class="an-stat-badge" style="background:#f5f3ff;color:#7c3aed;">CR</span>
            </div>
            <div>
                <div class="an-stat-num" id="conversion-rate">—</div>
                <div class="an-stat-label"><?= __('analytics_stat_cr_lbl') ?></div>
            </div>
            <div class="an-stat-sub"><?= __('analytics_stat_cr_sub') ?></div>
        </div>
    </div>

    <div class="an-charts">
        <div class="an-chart-card">
            <div class="an-chart-header">
                <h3><?= __('analytics_chart_traffic') ?></h3>
                <span><?= __('analytics_chart_traffic_sub') ?></span>
            </div>
            <div class="an-chart-body">
                <canvas id="trafficChart" style="max-height:100%;"></canvas>
            </div>
        </div>
        <div class="an-chart-card">
            <div class="an-chart-header">
                <h3><?= __('analytics_chart_directions') ?></h3>
                <span><?= __('analytics_chart_directions_sub') ?></span>
            </div>
            <div class="an-chart-body">
                <canvas id="directionsChart" style="max-height:100%;"></canvas>
            </div>
        </div>
    </div>

    <div class="an-table-card">
        <div class="an-table-header">
            <h3><?= __('analytics_table_title') ?></h3>
            <div class="live-pill"><span class="live-dot"></span> LIVE</div>
        </div>

        <div class="an-table-wrapper" style="overflow-x:auto;">
            <table class="an-table">
                <thead>
                    <tr>
                        <th><?= __('analytics_table_col_ip') ?></th>
                        <th><?= __('analytics_table_col_source') ?></th>
                        <th><?= __('analytics_table_col_device') ?></th>
                        <th style="text-align:center">Просмотры</th>
                        <th style="text-align:right">Время</th>
                    </tr>
                </thead>
                <tbody id="visitorsTableBody">
                    <tr><td colspan="5" style="text-align:center;padding:40px;color:#94a3b8;font-size:0.875rem;"><?= __('analytics_table_loading') ?></td></tr>
                </tbody>
            </table>
        </div>

        <div class="an-mobile-activity" id="visitorsCards"></div>
    </div>

</div>

<script>
function refreshAnalytics(btn) {
    btn.classList.add('spinning');
    loadAnalytics().finally(() => btn.classList.remove('spinning'));
}
</script>
