<style>
    .md-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    .md-stat-card {
        background: #fff;
        border: 1px solid var(--man-border);
        border-radius: 16px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .md-stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.06); }
    .md-stat-icon {
        width: 56px; height: 56px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .md-stat-icon svg { width: 28px; height: 28px; }
    
    .md-stat-info { flex: 1; min-width: 0; }
    .md-stat-num {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1;
        color: var(--man-text);
        margin-bottom: 6px;
    }
    .md-stat-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .icon-blue { background: #eff6ff; color: #3b82f6; }
    .icon-green { background: #f0fdf4; color: #22c55e; }
    .icon-amber { background: #fffbeb; color: #f59e0b; }

    .md-banner {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        border-radius: 20px;
        padding: 32px;
        color: #fff;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .md-banner-content { position: relative; z-index: 2; max-width: 600px; }
    .md-banner h2 { font-size: 1.8rem; font-weight: 700; margin-bottom: 8px; }
    .md-banner p { font-size: 1.05rem; color: #cbd5e1; line-height: 1.5; }
    
    .md-banner-bg {
        position: absolute; right: 0; top: -50px;
        opacity: 0.1; width: 300px; height: 300px;
        color: #fff; z-index: 1;
    }

    @media (max-width: 900px) {
        .md-grid { grid-template-columns: 1fr; gap: 12px; }
        .md-banner { padding: 24px; }
    }
</style>

<div class="md-banner">
    <div class="md-banner-content">
        <h2><?= __('man_hello') ?> <span id="welcomeName"><?= __('man_top_manager') ?></span> 👋</h2>
        <p><?= __('man_welcome') ?></p>
    </div>
    <svg class="md-banner-bg" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 18.5l-10-5V10l10 5 10-5v5.5l-10 5z"/></svg>
</div>

<div class="md-grid">
    <div class="md-stat-card">
        <div class="md-stat-icon icon-amber">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <div class="md-stat-info">
            <div class="md-stat-num" id="statNewLeads">—</div>
            <div class="md-stat-label"><?= __('man_stat_free_leads') ?></div>
        </div>
    </div>
    
    <div class="md-stat-card cursor-pointer" onclick="window.location.href='<?= BASE_URL ?>/manager/leads'" style="cursor: pointer;">
        <div class="md-stat-icon icon-blue">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
        <div class="md-stat-info">
            <div class="md-stat-num" id="statMyLeads">—</div>
            <div class="md-stat-label"><?= __('man_stat_my_leads') ?></div>
        </div>
    </div>

    <div class="md-stat-card cursor-pointer" onclick="window.location.href='<?= BASE_URL ?>/manager/students'" style="cursor: pointer;">
        <div class="md-stat-icon icon-green">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
        </div>
        <div class="md-stat-info">
            <div class="md-stat-num" id="statMyStudents">—</div>
            <div class="md-stat-label"><?= __('man_stat_my_students') ?></div>
        </div>
    </div>
</div>

<div class="mb-8">
    <div class="px-1 mb-6 flex items-center justify-between">
        <h3 class="text-xl font-black text-gray-900 flex items-center gap-3">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            Рабочий стол: Задачи на сегодня
        </h3>
        <div class="flex gap-2">
            <span class="px-3 py-1 bg-red-100 text-red-700 font-bold rounded-full text-xs" id="badgeP1">0 горящих</span>
            <span class="px-3 py-1 bg-amber-100 text-amber-700 font-bold rounded-full text-xs" id="badgeP2">0 follow-up</span>
        </div>
    </div>
    
    <div id="dailyTasksContainer" class="flex flex-col gap-4">
        <div class="py-12 text-center text-sm font-medium text-gray-500 bg-white rounded-2xl border border-dashed border-gray-200">
            Загрузка списка задач...
        </div>
    </div>
</div>

<!-- Modal for Status Change -->
<div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300" id="statusModal">
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md transform translate-y-8 transition-transform duration-300" id="statusModalContent">
        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            <?= __('man_modal_change_status') ?>
        </h3>
        <select id="statusSelect" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-gray-700 mb-6 transition-all">
            <option value="new"><?= __('man_status_new') ?></option>
            <option value="contacted"><?= __('man_status_contacted') ?></option>
            <option value="contract">На этапе договора / Ждет счет</option>
            <option value="ready_to_pay">Готов к оплате</option>
            <option value="converted"><?= __('man_status_converted') ?></option>
            <option value="rejected"><?= __('man_status_rejected') ?></option>
        </select>
        <div class="flex justify-end gap-3">
            <button class="px-5 py-2.5 rounded-xl font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors" onclick="closeStatusModal()"><?= __('man_btn_cancel') ?></button>
            <button class="px-5 py-2.5 rounded-xl font-semibold text-white bg-blue-600 hover:bg-blue-700 shadow-sm shadow-blue-600/20 transition-all" onclick="saveStatus()"><?= __('man_btn_save') ?></button>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>/assets/js/manager_dashboard.js?v=<?= time() ?>"></script>
