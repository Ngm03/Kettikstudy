<div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 mb-8 relative overflow-hidden shadow-sm border border-blue-100/50">
    <div class="relative z-10 max-w-2xl">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-2"><?= __('man_hello') ?> <span id="welcomeName" class="text-blue-600"><?= __('man_top_manager') ?></span> 👋</h2>
        <p class="text-lg text-gray-600"><?= __('man_welcome') ?></p>
    </div>
    <!-- Decorative background elements -->
    <div class="absolute -top-12 -right-12 w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
    <div class="absolute -bottom-12 right-20 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card 1: Free Leads -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-gray-900" id="statNewLeads">—</div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wide mt-1"><?= __('man_stat_free_leads') ?></div>
            </div>
        </div>
    </div>
    
    <!-- Card 2: My Leads -->
    <div onclick="window.location.href='<?= BASE_URL ?>/manager/leads'" class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 cursor-pointer group">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-gray-900" id="statMyLeads">—</div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wide mt-1"><?= __('man_stat_my_leads') ?></div>
            </div>
        </div>
    </div>

    <!-- Card 3: My Students -->
    <div onclick="window.location.href='<?= BASE_URL ?>/manager/students'" class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 cursor-pointer group">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-gray-900" id="statMyStudents">—</div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wide mt-1"><?= __('man_stat_my_students') ?></div>
            </div>
        </div>
    </div>
</div>


<div class="md-stat-card" style="display: block; margin-bottom: 24px;">
    <h3 style="margin-bottom: 16px; font-size: 1.2rem; color: var(--man-text);">⚡ Единая очередь задач (Action Queue)</h3>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--man-border); color: #64748b; font-size: 0.85rem; text-transform: uppercase;">
                    <th style="padding: 12px 8px;">Студент</th>
                    <th style="padding: 12px 8px;">Тип / Сумма</th>
                    <th style="padding: 12px 8px;">Файл</th>
                    <th style="padding: 12px 8px;">Действия</th>
                </tr>
            </thead>
            <tbody id="pendingReceiptsTable">
                <tr><td colspan="4" style="padding: 16px 8px; text-align: center; color: #64748b;">Загрузка...</td></tr>
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
                    tr.style.borderBottom = '1px solid var(--man-border)';
                    
                    const date = new Date(a.date).toLocaleDateString('ru-RU', {hour: '2-digit', minute:'2-digit'});
                    
                    let metaInfo = '';
                    let fileLink = '';
                    let actionButtons = '';
                    
                    if (a.action_type === 'receipt') {
                        metaInfo = `💰 Чек: <br><span style="font-weight:600">${a.meta || 'Не указано'}</span>`;
                        fileLink = `<a href="${window.BASE_URL}/api/payments/view-receipt?id=${a.id}" target="_blank" style="color: #3b82f6; text-decoration: none; font-size: 0.85rem;">📂 Открыть чек</a>`;
                        actionButtons = `
                            <button onclick="approveAction('receipt', ${a.id})" style="background: #22c55e; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.8rem; margin-right: 4px;">✅ Одобрить</button>
                            <button onclick="rejectAction('receipt', ${a.id})" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.8rem;">❌ Отклонить</button>
                        `;
                    } else {
                        const typeLabels = { passport: 'Паспорт', transcript: 'Аттестат', certificate: 'Сертификат' };
                        const docType = typeLabels[a.item_type] || 'Документ';
                        metaInfo = `📄 ${docType}`;
                        fileLink = `<a href="${window.BASE_URL}/api/documents/view?id=${a.id}" target="_blank" style="color: #3b82f6; text-decoration: none; font-size: 0.85rem;">📂 Открыть док</a>`;
                        actionButtons = `
                            <button onclick="approveAction('document', ${a.id})" style="background: #22c55e; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.8rem; margin-right: 4px;">✅ Одобрить</button>
                            <button onclick="rejectAction('document', ${a.id})" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.8rem;">❌ Отклонить</button>
                        `;
                    }

                    tr.innerHTML = `
                        <td style="padding: 12px 8px; font-weight: 500;">
                            <a href="${window.BASE_URL}/manager/student?id=${a.student_id}" style="color: inherit; text-decoration: none;">${a.student_name}</a>
                            <div style="font-size: 0.75rem; color: #64748b; font-weight: normal;">${date}</div>
                        </td>
                        <td style="padding: 12px 8px; font-size: 0.9rem;">${metaInfo}</td>
                        <td style="padding: 12px 8px;">${fileLink}</td>
                        <td style="padding: 12px 8px;">${actionButtons}</td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="4" style="padding: 16px 8px; text-align: center; color: #64748b;">✅ Очередь задач пуста!</td></tr>';
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
