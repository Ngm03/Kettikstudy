<div class="mb-8">
    <div class="bg-gray-100 p-1.5 rounded-xl inline-flex gap-1" id="filterTabs">
        <button class="filter-btn active-tab px-5 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 bg-white shadow-sm text-gray-900" onclick="setFilter('all', this)"><?= __('man_filter_all') ?></button>
        <button class="filter-btn px-5 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 text-gray-500 hover:text-gray-700 hover:bg-gray-200/50" onclick="setFilter('new', this)"><?= __('man_filter_free') ?></button>
        <button class="filter-btn px-5 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 text-gray-500 hover:text-gray-700 hover:bg-gray-200/50" onclick="setFilter('mine', this)"><?= __('man_filter_mine') ?></button>
    </div>
</div>

<div class="flex gap-6 overflow-x-auto pb-6 min-h-[calc(100vh-220px)] snap-x">
    <!-- Column: Free -->
    <div class="flex-1 min-w-[320px] max-w-[400px] bg-gray-50/50 rounded-3xl p-5 border border-gray-100 flex flex-col gap-4 snap-center relative">
        <div class="flex justify-between items-center px-1 mb-2">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <?= __('man_col_free') ?>
            </h3>
            <span class="bg-white px-2.5 py-1 rounded-lg shadow-sm text-xs font-bold text-gray-600 border border-gray-100" id="count-new">0</span>
        </div>
        <div class="flex flex-col gap-4" id="list-new"></div>
    </div>

    <!-- Column: Working -->
    <div class="flex-1 min-w-[320px] max-w-[400px] bg-gray-50/50 rounded-3xl p-5 border border-gray-100 flex flex-col gap-4 snap-center relative">
        <div class="flex justify-between items-center px-1 mb-2">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <?= __('man_col_working') ?>
            </h3>
            <span class="bg-white px-2.5 py-1 rounded-lg shadow-sm text-xs font-bold text-gray-600 border border-gray-100" id="count-contacted">0</span>
        </div>
        <div class="flex flex-col gap-4" id="list-contacted"></div>
    </div>

    <!-- Column: Done -->
    <div class="flex-1 min-w-[320px] max-w-[400px] bg-gray-50/50 rounded-3xl p-5 border border-gray-100 flex flex-col gap-4 snap-center relative">
        <div class="flex justify-between items-center px-1 mb-2">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <?= __('man_col_done') ?>
            </h3>
            <span class="bg-white px-2.5 py-1 rounded-lg shadow-sm text-xs font-bold text-gray-600 border border-gray-100" id="count-done">0</span>
        </div>
        <div class="flex flex-col gap-4" id="list-done"></div>
    </div>
</div>

<!-- Modal -->
<div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300" id="statusModal">
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md transform translate-y-8 transition-transform duration-300" id="statusModalContent">
        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            <?= __('man_modal_change_status') ?>
        </h3>
        <select id="statusSelect" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-gray-700 mb-6 transition-all">
            <option value="new"><?= __('man_status_new') ?></option>
            <option value="contacted"><?= __('man_status_contacted') ?></option>
            <option value="converted"><?= __('man_status_converted') ?></option>
            <option value="rejected"><?= __('man_status_rejected') ?></option>
        </select>
        <div class="flex justify-end gap-3">
            <button class="px-5 py-2.5 rounded-xl font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors" onclick="closeStatusModal()"><?= __('man_btn_cancel') ?></button>
            <button class="px-5 py-2.5 rounded-xl font-semibold text-white bg-blue-600 hover:bg-blue-700 shadow-sm shadow-blue-600/20 transition-all" onclick="saveStatus()"><?= __('man_btn_save') ?></button>
        </div>
    </div>
</div>

<script>
let allLeads = [];
let viewingFilter = 'all'; // all, new, mine
let currentLeadId = null;

function loadLeads() {
    if (typeof showLoader === 'function') showLoader();
    fetch(`${window.BASE_URL}/api/manager/leads`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                allLeads = data.leads || [];
                renderBoard();
            }
        })
        .finally(() => { if (typeof hideLoader === 'function') hideLoader(); });
}

function setFilter(filter, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => {
        b.className = 'filter-btn px-5 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 text-gray-500 hover:text-gray-700 hover:bg-gray-200/50';
    });
    btn.className = 'filter-btn active-tab px-5 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 bg-white shadow-sm text-gray-900';
    viewingFilter = filter;
    renderBoard();
}

function renderBoard() {
    const listNew = document.getElementById('list-new');
    const listContacted = document.getElementById('list-contacted');
    const listDone = document.getElementById('list-done');

    listNew.innerHTML = '';
    listContacted.innerHTML = '';
    listDone.innerHTML = '';

    let cNew = 0, cCont = 0, cDone = 0;

    allLeads.forEach(lead => {
        if (viewingFilter === 'new' && lead.manager_id !== null) return;
        if (viewingFilter === 'mine' && lead.manager_id === null) return;

        const date = new Date(lead.created_at).toLocaleDateString('ru-RU', {day:'2-digit', month:'short', hour:'2-digit', minute:'2-digit'});
        const cleanPhone = lead.phone ? lead.phone.replace(/[^0-9]/g, '') : '';
        const waLink = `https://wa.me/${cleanPhone}`;

        let isMine = lead.manager_id !== null;
        
        let actionsHtml = '';
        if (!isMine) {
            actionsHtml = `<button class="w-full mt-4 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm shadow-blue-600/20 transition-all" onclick="claimLead(${lead.id})">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                <?= __('man_btn_claim') ?>
            </button>`;
        } else {
            actionsHtml = `
                <div class="flex gap-2 mt-4">
                    <a href="${waLink}" target="_blank" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/50 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.996 0C5.372 0 0 5.372 0 11.996c0 2.128.56 4.133 1.545 5.908L.044 24l6.23-1.636c1.713.905 3.655 1.417 5.722 1.417 6.623 0 11.995-5.372 11.995-11.995S18.619 0 11.996 0zm0 21.602c-1.801 0-3.522-.464-5.068-1.341l-.364-.207-3.765.986.996-3.666-.226-.358a9.827 9.827 0 01-1.423-5.174c0-5.42 4.41-9.83 9.83-9.83s9.829 4.41 9.829 9.83-4.41 9.83-9.83 9.83zm5.395-7.38c-.296-.148-1.751-.865-2.023-.965-.272-.098-.47-.148-.667.148-.198.297-.766.965-.94 1.163-.173.197-.346.222-.643.074-1.68-.838-2.903-1.928-3.99-3.708-.196-.322.285-.302.85-.929.073-.082.037-.148 0-.223-.037-.074-.667-1.609-.915-2.203-.242-.58-.487-.502-.667-.512-.173-.008-.372-.01-.568-.01-.198 0-.52.074-.792.371-.272.297-1.037 1.015-1.037 2.476s1.062 2.871 1.21 3.069c.148.198 2.093 3.194 5.074 4.482 2.046.885 2.76.744 3.28.625.68-.155 1.751-.715 1.998-1.408.248-.693.248-1.287.173-1.408-.073-.122-.272-.196-.568-.344z"/></svg> 
                        WhatsApp
                    </a>
                    <button class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors" onclick="openStatusModal(${lead.id}, '${lead.status}')">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <?= __('man_btn_status') ?>
                    </button>
                </div>
            `;
        }

        const cardHtml = `
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition-all duration-300 relative group">
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-blue-100 rounded-r-md opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="flex justify-between items-start mb-3">
                    <div class="font-bold text-gray-900">${lead.name || '<?= __('man_no_name') ?>'}</div>
                    <div class="text-[0.7rem] font-medium text-gray-400 bg-gray-50 px-2 py-0.5 rounded-md border border-gray-100">${date}</div>
                </div>
                <div class="flex items-center gap-2 text-xs font-medium text-gray-600 mb-2">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    ${lead.phone || '<?= __('man_no_phone') ?>'}
                </div>
                ${lead.city ? `<div class="inline-flex items-center gap-1 bg-indigo-50 text-indigo-600 px-2.5 py-1 rounded-md text-[0.7rem] font-bold uppercase tracking-wider border border-indigo-100/50 mt-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>${lead.city}</div>` : ''}
                
                ${actionsHtml}
            </div>
        `;

        if (lead.manager_id === null || lead.status === 'new') {
            listNew.insertAdjacentHTML('beforeend', cardHtml);
            cNew++;
        } else if (lead.status === 'contacted') {
            listContacted.insertAdjacentHTML('beforeend', cardHtml);
            cCont++;
        } else {
            listDone.insertAdjacentHTML('beforeend', cardHtml);
            cDone++;
        }
    });

    document.getElementById('count-new').textContent = cNew;
    document.getElementById('count-contacted').textContent = cCont;
    document.getElementById('count-done').textContent = cDone;
}

function claimLead(id) {
    if (typeof showLoader === 'function') showLoader();
    fetch(`${window.BASE_URL}/api/manager/leads/claim`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            loadLeads(); // Reload
        } else {
            alert(data.error || '<?= __('man_err_unknown') ?>');
            if (typeof hideLoader === 'function') hideLoader();
        }
    });
}

function openStatusModal(id, currentStatus) {
    currentLeadId = id;
    document.getElementById('statusSelect').value = currentStatus || 'contacted';
    const modal = document.getElementById('statusModal');
    const content = document.getElementById('statusModalContent');
    modal.classList.remove('opacity-0', 'pointer-events-none');
    content.classList.remove('translate-y-8');
}

function closeStatusModal() {
    const modal = document.getElementById('statusModal');
    const content = document.getElementById('statusModalContent');
    modal.classList.add('opacity-0', 'pointer-events-none');
    content.classList.add('translate-y-8');
    currentLeadId = null;
}

function saveStatus() {
    if (!currentLeadId) return;
    const status = document.getElementById('statusSelect').value;
    
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
            loadLeads();
        } else {
            alert('<?= __('msg_error') ?>' + (data.error || '<?= __('man_err_unknown') ?>'));
            if (typeof hideLoader === 'function') hideLoader();
        }
    });
}

document.addEventListener('DOMContentLoaded', loadLeads);
</script>
