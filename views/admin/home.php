<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 900px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 500px) { 
        .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; } 
        .stat-card { padding: 12px 10px; gap: 8px; }
        .stat-icon { width: 36px; height: 36px; border-radius: 10px; }
        .stat-icon svg { width: 18px; height: 18px; }
        .stat-num { font-size: 1.3rem; }
        .stat-label { font-size: 0.65rem; }
    }

    .stat-card {
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
    .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); transform: translateY(-1px); }
    .stat-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon svg { width: 20px; height: 20px; }
    .stat-num {
        font-size: 1.6rem;
        font-weight: 800;
        line-height: 1;
        color: #1e293b;
    }
    .stat-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 2px;
    }

    .panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    .panel-toolbar {
        padding: 14px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
        background: #f8fafc;
    }

    .search-wrap {
        flex: 1;
        min-width: 200px;
        position: relative;
    }
    .search-wrap svg {
        position: absolute;
        left: 12px; top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        width: 16px; height: 16px;
        pointer-events: none;
    }
    .search-wrap input {
        width: 100%;
        padding: 9px 14px 9px 38px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.875rem;
        font-family: 'Inter', sans-serif;
        color: #1e293b;
        outline: none;
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-wrap input:focus { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }

    .filter-chips { display: flex; gap: 6px; flex-wrap: wrap; }
    .fchip {
        display: flex; align-items: center; gap: 5px;
        padding: 7px 13px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #fff;
        color: #64748b;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.18s;
        font-family: 'Inter', sans-serif;
    }
    .fchip:hover { background: #f1f5f9; }
    .fchip.active { background: #fef2f2; color: #dc2626; border-color: #fca5a5; font-weight: 600; }
    .fchip.active-hot { background: #fffbeb; color: #d97706; border-color: #fcd34d; font-weight: 600; }
    .chip-badge {
        background: rgba(0,0,0,0.06);
        border-radius: 5px;
        padding: 1px 5px;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .students-table { width: 100%; border-collapse: collapse; }
    .students-table th {
        text-align: left;
        padding: 12px 20px;
        background: #f8fafc;
        color: #94a3b8;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
    }
    .students-table td {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        font-size: 0.875rem;
        vertical-align: middle;
    }
    .students-table tbody tr:last-child td { border-bottom: none; }
    .students-table tbody tr:hover { background: #fafafa; }
    .students-table tbody tr.row-urgent { background: #fef2f2 !important; }

    .student-name { font-weight: 600; color: #1e293b; font-size: 0.875rem; }
    .student-email { font-size: 0.75rem; color: #94a3b8; margin-top: 1px; }

    .sbadge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 9px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #f8fafc;
        padding: 6px 10px;
        font-size: 0.8rem;
        font-family: 'Inter', sans-serif;
        color: #374151;
        outline: none;
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .status-select:focus { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.08); }

    .action-btns { display: flex; gap: 6px; align-items: center; }
    .btn-wa {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 12px;
        border-radius: 8px;
        background: rgba(34,197,94,0.1);
        color: #16a34a;
        border: 1px solid rgba(34,197,94,0.2);
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.18s;
    }
    .btn-wa:hover { background: rgba(34,197,94,0.18); transform: translateY(-1px); }
    .btn-view {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 12px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.18s;
    }
    .btn-view:hover { background: #e2e8f0; }
    .btn-take {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 12px;
        border-radius: 8px;
        background: #ef4444;
        color: #fff;
        border: none;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 2px 8px rgba(239,68,68,0.3);
        transition: all 0.18s;
    }
    .btn-take:hover { background: #dc2626; transform: translateY(-1px); }

    .mobile-cards { display: none; padding: 12px; }
    .student-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 10px;
        transition: box-shadow 0.2s;
    }
    .student-card.card-urgent { border-color: #fca5a5; background: #fff8f8; }
    .student-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    .card-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; margin-bottom: 10px; }
    .card-info {}
    .card-name { font-weight: 700; font-size: 0.9rem; color: #1e293b; }
    .card-email { font-size: 0.75rem; color: #94a3b8; margin-top: 2px; }
    .card-date { font-size: 0.7rem; color: #cbd5e1; margin-top: 2px; }
    .card-row { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; flex-wrap: wrap; }
    .card-actions { display: flex; gap: 6px; margin-top: 10px; flex-wrap: wrap; }
    .card-actions a, .card-actions button { flex: 1; min-width: 100px; justify-content: center; }

    @media (max-width: 640px) {
        .desktop-table { display: none; }
        .mobile-cards { display: block; }
        .panel-toolbar { padding: 10px 12px; }
        .filter-chips { width: 100%; }
    }

    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-state svg { width: 48px; height: 48px; color: #e2e8f0; margin-bottom: 12px; }
    .empty-state p { color: #94a3b8; font-size: 0.9rem; }

    @keyframes pulse-red {
        0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.5); }
        70% { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
        100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }
    .urgent-pulse { animation: pulse-red 2s infinite; }
</style>

<div class="stats-grid" id="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#eff6ff;">
            <svg fill="none" viewBox="0 0 24 24" stroke="#3b82f6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <div class="stat-num" id="sn-total">—</div>
            <div class="stat-label"><?= __('admin_total_students') ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fef2f2;">
            <svg fill="none" viewBox="0 0 24 24" stroke="#ef4444"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
        </div>
        <div>
            <div class="stat-num" id="sn-urgent">—</div>
            <div class="stat-label"><?= __('admin_wait_call') ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fffbeb;">
            <svg fill="none" viewBox="0 0 24 24" stroke="#f59e0b"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
        </div>
        <div>
            <div class="stat-num" id="sn-hot">—</div>
            <div class="stat-label"><?= __('admin_hot_leads') ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#f0fdf4;">
            <svg fill="none" viewBox="0 0 24 24" stroke="#22c55e"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <div class="stat-num" id="sn-enrolled">—</div>
            <div class="stat-label"><?= __('admin_enrolled') ?></div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-toolbar">
        <div class="search-wrap">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="searchStudent" placeholder="<?= __('admin_search_ph') ?>">
        </div>
        <div class="filter-chips">
            <button class="fchip active" data-type="all" onclick="filterList('all',this)">
                <?= __('admin_filter_all') ?> <span id="count-all" class="chip-badge">0</span>
            </button>
            <button class="fchip" data-type="urgent" onclick="filterList('urgent',this)">
                🔴 <?= __('admin_filter_urgent') ?> <span id="count-urgent" class="chip-badge">0</span>
            </button>
            <button class="fchip" data-type="hot" onclick="filterList('hot',this)">
                🔥 <?= __('admin_filter_hot') ?> <span id="count-hot" class="chip-badge">0</span>
            </button>
        </div>
    </div>

    <div class="desktop-table" style="overflow-x:auto;">
        <table class="students-table">
            <thead>
                <tr>
                    <th><?= __('admin_student') ?></th>
                    <th><?= __('admin_date') ?></th>
                    <th><?= __('admin_status') ?></th>
                    <th><?= __('admin_interest') ?></th>
                    <th style="text-align:right"><?= __('admin_actions') ?></th>
                </tr>
            </thead>
            <tbody id="students-list">
                <tr><td colspan="5" class="empty-state"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg><p><?= __('admin_loading') ?></p></td></tr>
            </tbody>
        </table>
    </div>

    <div class="mobile-cards" id="mobile-cards-list"></div>
</div>

<audio id="alert-sound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>

<script>
window.AppConfig = {
    baseUrl: '<?= BASE_URL ?>',
    lang: {
        status_new: '<?= __('admin_status_new') ?>',
        status_hot: '<?= __('admin_status_hot') ?>',
        status_urgent: '<?= __('admin_status_urgent') ?>',
        status_processing: '<?= __('admin_status_processing') ?>',
        status_qualified: '<?= __('admin_status_qualified') ?>',
        status_documents: '<?= __('admin_status_documents') ?>',
        status_visa: '<?= __('admin_status_visa') ?>',
        status_enrolled: '<?= __('admin_status_enrolled') ?>',
        status_lost: '<?= __('admin_status_lost') ?>',
        btn_view: '<?= __('admin_btn_view') ?>',
        btn_take: '<?= __('admin_btn_take') ?>',
        no_students_filter: '<?= __('admin_no_students_filter') ?>',
        no_students: '<?= __('admin_no_students') ?>',
        interest: '<?= __('admin_interest') ?>',
        status_label: '<?= __('admin_status') ?>',
        status_error: '<?= __('admin_status_error') ?>',
        confirm_take: '<?= __('admin_confirm_take') ?>',
        handled: 'Запрос обработан',
        confirm_handled: 'Подтвердите, что запрос обработан'
    }
};
</script>
<script src="<?= BASE_URL ?>/assets/js/admin_home.js"></script>

<style>
@keyframes pulse-red {
    0%   { box-shadow: 0 0 0 0 rgba(239,68,68,0.5); }
    70%  { box-shadow: 0 0 0 8px rgba(239,68,68,0); }
    100% { box-shadow: 0 0 0 0 rgba(239,68,68,0); }
}
.urgent-pulse { animation: pulse-red 2s infinite; }
</style>
