document.addEventListener('DOMContentLoaded', () => {
    // Welcome name adjustment
    setTimeout(() => {
        const nameNode = document.getElementById('manName');
        if (nameNode && nameNode.textContent !== 'Главный менеджер') {
            const welcomeNode = document.getElementById('welcomeName');
            if(welcomeNode) welcomeNode.textContent = nameNode.textContent.split(' ')[0];
        }
    }, 500);

    // Initialize Dashboard
    loadStats();
    loadUrgentTasks();
    loadActionQueue();
});

// ============================================
// 1. STATS
// ============================================
function loadStats() {
    fetch(`${window.BASE_URL}/api/manager/dashboard-stats`)
        .then(res => res.json())
        .then(data => {
            if (data.success && data.stats) {
                const els = {
                    'statNewLeads': data.stats.new_leads || 0,
                    'statMyLeads': data.stats.my_leads || 0,
                    'statMyStudents': data.stats.my_students || 0
                };
                for(let id in els) {
                    const el = document.getElementById(id);
                    if(el) el.textContent = els[id];
                }
            }
        })
        .catch(console.error);
}

// ============================================
// 2. URGENT TASKS
// ============================================
function loadUrgentTasks() {
    fetch(`${window.BASE_URL}/api/manager/urgent-leads`)
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('urgentTasksContainer');
            if(!container) return;

            if (data.success && data.leads && data.leads.length > 0) {
                container.innerHTML = data.leads.map(lead => renderUrgentCard(lead)).join('');
            } else {
                container.innerHTML = `
                    <div class="col-span-full py-8 text-center text-sm font-medium text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-200 flex flex-col items-center justify-center gap-2">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Нет срочных задач на сегодня. Отличная работа!</span>
                    </div>
                `;
            }
        })
        .catch(console.error);
}

function renderUrgentCard(lead) {
    const cleanPhone = lead.phone ? lead.phone.replace(/[^0-9]/g, '') : '';
    const waLink = `https://wa.me/${cleanPhone}`;
    const date = new Date(lead.created_at).toLocaleDateString('ru-RU', {day:'2-digit', month:'short', hour:'2-digit', minute:'2-digit'});

    return `
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-red-100 hover:shadow-md hover:border-red-300 transition-all duration-300 relative group">
            <div class="absolute -top-3 -right-3 flex">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-6 w-6 bg-red-500 text-white items-center justify-center text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <div class="flex justify-between items-start mb-3">
                <div class="font-bold text-gray-900 truncate pr-4">${lead.name || 'Без имени'}</div>
                <div class="text-[0.7rem] font-medium text-gray-400 bg-gray-50 px-2 py-0.5 rounded-md border border-gray-100">${date}</div>
            </div>
            <div class="flex items-center gap-2 text-xs font-medium text-gray-600 mb-4">
                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                ${lead.phone || 'Нет телефона'}
            </div>
            
            <div class="flex gap-2 mt-auto">
                <a href="${waLink}" target="_blank" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/50 transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.996 0C5.372 0 0 5.372 0 11.996c0 2.128.56 4.133 1.545 5.908L.044 24l6.23-1.636c1.713.905 3.655 1.417 5.722 1.417 6.623 0 11.995-5.372 11.995-11.995S18.619 0 11.996 0zm0 21.602c-1.801 0-3.522-.464-5.068-1.341l-.364-.207-3.765.986.996-3.666-.226-.358a9.827 9.827 0 01-1.423-5.174c0-5.42 4.41-9.83 9.83-9.83s9.829 4.41 9.829 9.83-4.41 9.83-9.83 9.83zm5.395-7.38c-.296-.148-1.751-.865-2.023-.965-.272-.098-.47-.148-.667.148-.198.297-.766.965-.94 1.163-.173.197-.346.222-.643.074-1.68-.838-2.903-1.928-3.99-3.708-.196-.322.285-.302.85-.929.073-.082.037-.148 0-.223-.037-.074-.667-1.609-.915-2.203-.242-.58-.487-.502-.667-.512-.173-.008-.372-.01-.568-.01-.198 0-.52.074-.792.371-.272.297-1.037 1.015-1.037 2.476s1.062 2.871 1.21 3.069c.148.198 2.093 3.194 5.074 4.482 2.046.885 2.76.744 3.28.625.68-.155 1.751-.715 1.998-1.408.248-.693.248-1.287.173-1.408-.073-.122-.272-.196-.568-.344z"/></svg> 
                </a>
                <button class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors" onclick="openStatusModal(${lead.id}, '${lead.status}')">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Статус
                </button>
            </div>
        </div>
    `;
}

// ============================================
// 3. ACTION QUEUE
// ============================================
function loadActionQueue() {
    fetch(`${window.BASE_URL}/api/manager/action-queue`)
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('pendingReceiptsTable');
            if(!tbody) return;

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
        })
        .catch(console.error);
}

window.approveAction = function(type, id) {
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
};

window.rejectAction = function(type, id) {
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
};

// ============================================
// 4. STATUS MODAL (For Urgent Tasks)
// ============================================
let currentLeadId = null;

window.openStatusModal = function(id, currentStatus) {
    currentLeadId = id;
    const select = document.getElementById('statusSelect');
    if(select) select.value = currentStatus || 'contacted';
    
    const modal = document.getElementById('statusModal');
    const content = document.getElementById('statusModalContent');
    if(modal && content) {
        modal.classList.remove('opacity-0', 'pointer-events-none');
        content.classList.remove('translate-y-8');
    }
};

window.closeStatusModal = function() {
    const modal = document.getElementById('statusModal');
    const content = document.getElementById('statusModalContent');
    if(modal && content) {
        modal.classList.add('opacity-0', 'pointer-events-none');
        content.classList.add('translate-y-8');
    }
    currentLeadId = null;
};

window.saveStatus = function() {
    if (!currentLeadId) return;
    const select = document.getElementById('statusSelect');
    const status = select ? select.value : 'contacted';
    
    if (typeof showLoader === 'function') showLoader();
    fetch(`${window.BASE_URL}/api/manager/leads/status`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: currentLeadId, status })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            closeStatusModal();
            loadUrgentTasks();
            loadStats();
        } else {
            alert('Ошибка: ' + (data.error || 'Неизвестная ошибка'));
        }
    })
    .catch(console.error)
    .finally(() => {
        if (typeof hideLoader === 'function') hideLoader();
    });
};
