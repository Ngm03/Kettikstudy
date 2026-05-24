<style>
    :root {
        --card-radius: 16px;
        --card-border: #f1f5f9;
        --card-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -2px rgba(0,0,0,0.05);
        --card-hover-shadow: 0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -4px rgba(0,0,0,0.08);
        --muted: #64748b;
        --text: #0f172a;
    }

    .an-page { display: flex; flex-direction: column; gap: 24px; }

    .an-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }
    .an-topbar-title h2 { font-size: 1.5rem; font-weight: 800; color: var(--text); letter-spacing: -0.025em; }
    .an-topbar-title p  { font-size: 0.875rem; color: var(--muted); margin-top: 4px; }
    .an-refresh-btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 20px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 0.875rem; font-weight: 600;
        color: var(--text);
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all 0.2s;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .an-refresh-btn:hover { border-color: #ef4444; color: #ef4444; background: #fff8f8; transform: translateY(-1px); }
    .an-refresh-btn svg { width: 16px; height: 16px; }
    .an-refresh-btn.spinning svg { animation: spin 0.8s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    .an-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    @media (max-width: 1024px) { .an-stats { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px) { 
        .an-stats { grid-template-columns: 1fr; gap: 12px; }
    }

    .an-stat {
        background: #fff;
        border: 1px solid var(--card-border);
        border-radius: var(--card-radius);
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        box-shadow: var(--card-shadow);
        transition: box-shadow 0.25s, transform 0.25s;
        cursor: default;
    }
    .an-stat:hover { box-shadow: var(--card-hover-shadow); transform: translateY(-2px); }
    .an-stat-head { display: flex; justify-content: space-between; align-items: flex-start; }
    .an-stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .an-stat-icon svg { width: 22px; height: 22px; }
    .an-stat-badge {
        font-size: 0.75rem; font-weight: 700;
        padding: 4px 10px; border-radius: 8px;
        white-space: nowrap;
    }
    .an-stat-num {
        font-size: 2.25rem; font-weight: 800; line-height: 1;
        color: var(--text);
        font-variant-numeric: tabular-nums;
        letter-spacing: -0.03em;
    }
    .an-stat-label { font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; }
    .an-stat-sub { font-size: 0.8rem; color: var(--muted); display: flex; align-items: center; gap: 6px; }

    .icon-blue   { background: #eff6ff; color: #2563eb; }
    .icon-green  { background: #f0fdf4; color: #16a34a; }
    .icon-amber  { background: #fffbeb; color: #d97706; }
    .icon-violet { background: #f5f3ff; color: #7c3aed; }

    .an-charts {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    @media (max-width: 900px) { .an-charts { grid-template-columns: 1fr; } }

    .an-chart-card {
        background: #fff;
        border: 1px solid var(--card-border);
        border-radius: var(--card-radius);
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: box-shadow 0.25s;
    }
    .an-chart-card:hover { box-shadow: var(--card-hover-shadow); }
    .an-chart-header {
        padding: 20px 24px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .an-chart-header h3 { font-size: 1.1rem; font-weight: 800; color: var(--text); letter-spacing: -0.02em; }
    .an-chart-header span { font-size: 0.78rem; color: var(--muted); }
    .an-chart-body { padding: 16px 24px 24px; position: relative; height: 320px; }

    .an-table-card {
        background: #fff;
        border: 1px solid var(--card-border);
        border-radius: var(--card-radius);
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-top: 10px;
    }
    .an-table-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        background: #fafafa;
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
        flex-wrap: wrap;
    }
    .an-table-header h3 { font-size: 1.1rem; font-weight: 800; color: var(--text); letter-spacing: -0.02em; }
    .live-pill {
        display: inline-flex; align-items: center; gap: 6px;
        background: #ecfdf5; color: #059669;
        border: 1px solid #a7f3d0;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
    }
    .live-dot { width: 8px; height: 8px; background: #10b981; border-radius: 50%; animation: blink 1.5s ease-in-out infinite; }
    @keyframes blink { 0%,100% { opacity:1; } 50% { opacity:0.3; } }

    .an-table { width: 100%; border-collapse: collapse; }
    .an-table th {
        text-align: left; padding: 12px 24px;
        font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
        color: var(--muted); background: #fafafa; border-bottom: 1px solid #f1f5f9;
    }
    .an-table td { padding: 16px 24px; border-bottom: 1px solid #f1f5f9; font-size: 0.875rem; color: var(--text); }
    .an-table tbody tr:last-child td { border-bottom: none; }
    .an-table tbody tr:hover { background: #f8fafc; }

    .sbadge {
        display: inline-flex; align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .an-mobile-activity { display: none; padding: 16px; }
    .activity-card {
        background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
        padding: 16px; margin-bottom: 12px;
        display: flex; flex-direction: column; gap: 8px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .activity-card-top { display: flex; justify-content: space-between; align-items: center; }
    .activity-card-name { font-weight: 700; font-size: 0.95rem; color: var(--text); }
    .activity-card-time { font-size: 0.75rem; color: var(--muted); }
    .activity-card-row { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }

    @media (max-width: 640px) {
        .an-table-wrapper { display: none; }
        .an-mobile-activity { display: block; }
        .an-topbar { flex-direction: column; align-items: flex-start; }
    }
</style>

<!-- Глобальный объект для передачи локализованных строк в Chart.js -->
<script>
window.I18N_ANALYTICS = {
    status_new: '<?= __('status_new') ?>',
    status_hot: '<?= __('status_hot') ?>',
    status_urgent: '<?= __('status_urgent') ?>',
    status_processing: '<?= __('status_processing') ?>',
    status_qualified: '<?= __('status_qualified') ?>',
    status_documents: '<?= __('status_documents') ?>',
    status_visa: '<?= __('status_visa') ?>',
    status_enrolled: '<?= __('status_enrolled') ?>',
    status_lost: '<?= __('status_lost') ?>',
    students: '<?= __('an_badge_students') ?>',
    unassigned: '<?= __('unassigned') ?>',
    no_email: '<?= __('no_email') ?>',
    no_phone: '<?= __('no_phone') ?>',
    no_students: '<?= __('no_students') ?>',
    vs_prev_30_days: '<?= __('vs_prev_30_days') ?>',
    no_changes: '<?= __('no_changes') ?>',
    loading: '<?= __('loading') ?>'
};
</script>

<div class="an-page">

    <div class="an-topbar">
        <div class="an-topbar-title">
            <h2><?= __('an_title') ?></h2>
            <p><?= __('an_subtitle') ?></p>
        </div>
        <button onclick="refreshAnalytics(this)" class="an-refresh-btn">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            <?= __('refresh_btn') ?>
        </button>
    </div>

    <div class="an-stats">
        <!-- 1. Всего студентов -->
        <div class="an-stat">
            <div class="an-stat-head">
                <div class="an-stat-icon icon-blue">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <span class="an-stat-badge" style="background:#eff6ff;color:#2563eb;"><?= __('an_badge_students') ?></span>
            </div>
            <div>
                <div class="an-stat-num" id="visitors-count">—</div>
                <div class="an-stat-label"><?= __('an_total_students') ?></div>
            </div>
            <div class="an-stat-sub" id="visitors-diff">
                <span class="diff-badge" style="background:#f1f5f9; color:#64748b; font-weight: 600; font-size: 0.75rem;"><?= __('an_active_base') ?></span>
            </div>
        </div>

        <!-- 2. Активные лиды -->
        <div class="an-stat">
            <div class="an-stat-head">
                <div class="an-stat-icon icon-green">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span class="an-stat-badge" style="background:#f0fdf4;color:#16a34a;"><?= __('an_badge_30_days') ?></span>
            </div>
            <div>
                <div class="an-stat-num" id="leads-count">—</div>
                <div class="an-stat-label"><?= __('an_new_leads') ?></div>
            </div>
            <div class="an-stat-sub" id="leads-diff">
                <span class="diff-badge" style="background:#f1f5f9; color:#64748b; font-weight: 600; font-size: 0.75rem;"><?= __('an_funnel_loading') ?></span>
            </div>
        </div>

        <!-- 3. Горячие лиды -->
        <div class="an-stat">
            <div class="an-stat-head">
                <div class="an-stat-icon icon-amber">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
                </div>
                <span class="an-stat-badge" style="background:#fffbeb;color:#d97706;">Hot</span>
            </div>
            <div>
                <div class="an-stat-num" id="qualified-count">—</div>
                <div class="an-stat-label"><?= __('an_hot_leads') ?></div>
            </div>
            <div class="an-stat-sub" id="qualified-diff">
                <span class="diff-badge" style="background:#fffbeb; color:#d97706; font-weight: 600; font-size: 0.75rem;"><?= __('an_interest_70') ?></span>
            </div>
        </div>

        <!-- 4. Conversion Rate -->
        <div class="an-stat">
            <div class="an-stat-head">
                <div class="an-stat-icon icon-violet">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <span class="an-stat-badge" style="background:#f5f3ff;color:#7c3aed;">CR</span>
            </div>
            <div>
                <div class="an-stat-num" id="conversion-rate">—</div>
                <div class="an-stat-label"><?= __('an_conversion_to_enrollment') ?></div>
            </div>
            <div class="an-stat-sub">
                <span class="diff-badge" style="background:#f5f3ff; color:#7c3aed; font-weight: 600; font-size: 0.75rem;"><?= __('an_share_enrolled') ?></span>
            </div>
        </div>
    </div>

    <div class="an-charts">
        <!-- 1. Воронка лидов -->
        <div class="an-chart-card">
            <div class="an-chart-header">
                <h3><?= __('an_chart_funnel_title') ?></h3>
                <span><?= __('an_chart_funnel_desc') ?></span>
            </div>
            <div class="an-chart-body">
                <canvas id="trafficChart" style="max-height:100%;"></canvas>
            </div>
        </div>

        <!-- 2. Нагрузка менеджеров -->
        <div class="an-chart-card">
            <div class="an-chart-header">
                <h3><?= __('an_chart_load_title') ?></h3>
                <span><?= __('an_chart_load_desc') ?></span>
            </div>
            <div class="an-chart-body">
                <canvas id="directionsChart" style="max-height:100%;"></canvas>
            </div>
        </div>
    </div>

    <!-- 3. Таблица последних регистраций -->
    <div class="an-table-card">
        <div class="an-table-header">
            <h3><?= __('an_recent_students_title') ?></h3>
            <div class="live-pill"><span class="live-dot"></span> LIVE</div>
        </div>

        <div class="an-table-wrapper" style="overflow-x:auto;">
            <table class="an-table">
                <thead>
                    <tr>
                        <th><?= __('an_th_student') ?></th>
                        <th><?= __('an_th_phone') ?></th>
                        <th><?= __('an_th_manager') ?></th>
                        <th><?= __('an_th_status') ?></th>
                        <th style="text-align:right"><?= __('an_th_reg_date') ?></th>
                    </tr>
                </thead>
                <tbody id="visitorsTableBody">
                    <tr><td colspan="5" style="text-align:center;padding:40px;color:#94a3b8;font-size:0.875rem;"><?= __('loading') ?></td></tr>
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
