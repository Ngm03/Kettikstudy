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
