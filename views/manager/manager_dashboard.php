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

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-white">
        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Единая очередь задач (Action Queue)
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-4">Студент</th>
                    <th class="px-6 py-4 hidden sm:table-cell">Тип / Сумма</th>
                    <th class="px-6 py-4 hidden md:table-cell">Файл</th>
                    <th class="px-6 py-4 text-right">Действия</th>
                </tr>
            </thead>
            <tbody id="pendingReceiptsTable" class="divide-y divide-gray-100 bg-white">
                <tr><td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">Загрузка задач...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        const nameNode = document.getElementById('manName');
        if (nameNode && nameNode.textContent !== '<?= __('man_top_manager') ?>') {
            document.getElementById('welcomeName').textContent = nameNode.textContent.split(' ')[0]; // First name
        }
    }, 500);

    fetch(`${window.BASE_URL}/api/manager/dashboard-stats`)
        .then(res => res.json())
        .then(data => {
            if (data.success && data.stats) {
                document.getElementById('statNewLeads').textContent = data.stats.new_leads || 0;
                document.getElementById('statMyLeads').textContent = data.stats.my_leads || 0;
                document.getElementById('statMyStudents').textContent = data.stats.my_students || 0;
            }
        });

    loadActionQueue();
});

function loadActionQueue() {
    fetch(`${window.BASE_URL}/api/manager/action-queue`)
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('pendingReceiptsTable');
            tbody.innerHTML = '';
            if (data.success && data.actions && data.actions.length > 0) {
                data.actions.forEach(a => {
                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-blue-50/30 transition-colors group';
                    
                    const date = new Date(a.date).toLocaleDateString('ru-RU', {hour: '2-digit', minute:'2-digit'});
                    
                    let metaInfo = '';
                    let fileLink = '';
                    let actionButtons = '';
                    
                    if (a.action_type === 'receipt') {
                        metaInfo = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 text-xs font-medium"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>${a.meta || 'Чек'}</span>`;
                        fileLink = `<a href="${window.BASE_URL}/api/payments/view-receipt?id=${a.id}" target="_blank" class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>Открыть</a>`;
                        actionButtons = `
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="approveAction('receipt', ${a.id})" class="p-2 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors tooltip" title="Одобрить">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                                <button onclick="rejectAction('receipt', ${a.id})" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors tooltip" title="Отклонить">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        `;
                    } else {
                        const typeLabels = { passport: 'Паспорт', transcript: 'Аттестат', certificate: 'Сертификат' };
                        const docType = typeLabels[a.item_type] || 'Документ';
                        metaInfo = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-600 border border-blue-100 text-xs font-medium"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>${docType}</span>`;
                        fileLink = `<a href="${window.BASE_URL}/api/documents/view?id=${a.id}" target="_blank" class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>Открыть</a>`;
                        actionButtons = `
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="approveAction('document', ${a.id})" class="p-2 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors tooltip" title="Одобрить">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                                <button onclick="rejectAction('document', ${a.id})" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors tooltip" title="Отклонить">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        `;
                    }

                    tr.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="ml-0">
                                    <div class="text-sm font-medium text-gray-900">
                                        <a href="${window.BASE_URL}/manager/student?id=${a.student_id}" class="hover:text-blue-600 transition-colors">${a.student_name}</a>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-0.5">${date}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                            ${metaInfo}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                            ${fileLink}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            ${actionButtons}
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="4" class="px-6 py-12 text-center text-sm font-medium text-emerald-600 bg-emerald-50/50"><div class="flex flex-col items-center justify-center gap-2"><svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><span>Очередь задач пуста! Отличная работа.</span></div></td></tr>';
            }
        });
}

function approveAction(type, id) {
    if (type === 'receipt') {
        if (!confirm('Подтвердить получение оплаты? Студент будет переведен в статус "enrolled".')) return;
        fetch(`${window.BASE_URL}/api/admin/receipts/approve`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        }).then(res => res.json()).then(data => {
            if (data.success) { alert('Чек одобрен!'); loadActionQueue(); }
            else alert('Ошибка: ' + (data.error || 'Неизвестная ошибка'));
        });
    } else if (type === 'document') {
        fetch(`${window.BASE_URL}/api/admin/doc-status`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id, status: 'approved' })
        }).then(res => res.json()).then(data => {
            if (data.success) { alert('Документ одобрен!'); loadActionQueue(); }
            else alert('Ошибка: ' + (data.error || 'Неизвестная ошибка'));
        });
    }
}

function rejectAction(type, id) {
    const reason = prompt('Укажите причину отклонения:');
    if (reason === null) return;
    if (reason.trim() === '') { alert('Причина обязательна'); return; }
    
    if (type === 'receipt') {
        fetch(`${window.BASE_URL}/api/admin/receipts/reject`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id, reason: reason })
        }).then(res => res.json()).then(data => {
            if (data.success) { alert('Чек отклонен.'); loadActionQueue(); }
            else alert('Ошибка: ' + (data.error || 'Неизвестная ошибка'));
        });
    } else if (type === 'document') {
        fetch(`${window.BASE_URL}/api/admin/doc-status`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id, status: 'rejected', reason: reason })
        }).then(res => res.json()).then(data => {
            if (data.success) { alert('Документ отклонен.'); loadActionQueue(); }
            else alert('Ошибка: ' + (data.error || 'Неизвестная ошибка'));
        });
    }
}
</script>
