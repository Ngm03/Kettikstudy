<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row gap-4 items-center justify-between">
        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <?= __('man_th_student') ?>
        </h3>
        <div class="relative w-full md:w-80 group">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" id="msSearchInput" placeholder="<?= __('man_search_ph') ?>" onkeyup="filterStudents()" class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm transition-all focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 placeholder-gray-400 shadow-sm">
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-4"><?= __('man_th_student') ?></th>
                    <th class="px-6 py-4 hidden sm:table-cell"><?= __('man_th_contacts') ?></th>
                    <th class="px-6 py-4 hidden lg:table-cell"><?= __('man_th_reg_date') ?></th>
                    <th class="px-6 py-4 hidden md:table-cell"><?= __('man_th_doc_status') ?></th>
                    <th class="px-6 py-4 text-right"><?= __('man_th_actions') ?></th>
                </tr>
            </thead>
            <tbody id="msTbody" class="divide-y divide-gray-50">
                <tr><td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="animate-spin w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <?= __('man_loading') ?>
                    </div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

<script>
let allStudents = [];

function loadStudents() {
    if (typeof showLoader === 'function') showLoader();
    fetch(`${window.BASE_URL}/api/manager/students`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                allStudents = data.students || [];
                renderStudents(allStudents);
            }
        })
        .finally(() => { if (typeof hideLoader === 'function') hideLoader(); });
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function renderStudents(list) {
    const tbody = document.getElementById('msTbody');
    if (!list.length) {
        tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500"><?= __('man_not_found') ?></td></tr>`;
        return;
    }

    tbody.innerHTML = list.map(s => {
        const name = escapeHtml(s.full_name || '<?= __('man_no_name') ?>');
        const initial = name.charAt(0).toUpperCase();

        let docBadgeHtml = '';
        if (s.document_status === 'pending') {
            docBadgeHtml = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-600 border border-amber-100 text-xs font-bold uppercase tracking-wider"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><?= __('man_doc_pending') ?></span>`;
        } else if (s.document_status === 'approved') {
            docBadgeHtml = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 text-xs font-bold uppercase tracking-wider"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><?= __('man_doc_approved') ?></span>`;
        } else {
            docBadgeHtml = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-red-600 border border-red-100 text-xs font-bold uppercase tracking-wider"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg><?= __('man_no_docs') ?></span>`;
        }

        const date = new Date(s.created_at).toLocaleDateString('ru-RU', {day:'2-digit', month:'short', year: 'numeric'});

        return `
            <tr class="hover:bg-blue-50/30 transition-colors group">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg flex-shrink-0 group-hover:scale-105 transition-transform duration-300 border border-indigo-100/50">${initial}</div>
                        <div>
                            <div class="text-sm font-bold text-gray-900 mb-0.5">${name}</div>
                            <div class="text-[0.7rem] font-medium text-gray-400 tracking-wide">${escapeHtml(s.email || '')}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                    <div class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        ${escapeHtml(s.phone || '—')}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell text-sm text-gray-500 font-medium">
                    ${date}
                </td>
                <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                    ${docBadgeHtml}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right">
                    <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                        <a href="${window.BASE_URL}/manager/student?id=${s.id}" class="p-2.5 rounded-lg bg-gray-50 text-gray-500 hover:text-blue-600 hover:bg-blue-100 transition-colors tooltip" title="<?= __('man_btn_view_profile') ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <button onclick="contactStudent('${s.phone || ''}', '${s.email || ''}')" class="p-2.5 rounded-lg bg-gray-50 text-gray-500 hover:text-green-600 hover:bg-green-100 transition-colors tooltip" title="<?= __('man_btn_write_msg') ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

function filterStudents() {
    const q = document.getElementById('msSearchInput').value.toLowerCase();
    const filtered = allStudents.filter(s => {
        return (s.full_name || '').toLowerCase().includes(q) ||
               (s.email || '').toLowerCase().includes(q) ||
               (s.phone || '').toLowerCase().includes(q);
    });
    renderStudents(filtered);
}

function contactStudent(phone, email) {
    if (phone && phone.trim() !== '') {
        const cleanPhone = phone.replace(/[^\d]/g, '');
        window.open(`https://wa.me/${cleanPhone}`, '_blank');
    } else if (email && email.trim() !== '') {
        window.open(`mailto:${email}`, '_blank');
    } else {
        alert('У студента нет ни телефона, ни email.');
    }
}

document.addEventListener('DOMContentLoaded', loadStudents);
</script>
