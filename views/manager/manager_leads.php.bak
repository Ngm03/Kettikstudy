<style>
    .ml-filters {
        display: flex; gap: 10px; margin-bottom: 20px;
        flex-wrap: wrap;
    }
    .ml-filter-btn {
        padding: 8px 16px; border-radius: 20px;
        background: #fff; border: 1px solid var(--man-border);
        color: #475569; font-size: 0.85rem; font-weight: 600;
        cursor: pointer; transition: 0.2s;
    }
    .ml-filter-btn:hover { background: #f1f5f9; }
    .ml-filter-btn.active {
        background: var(--man-sidebar-active);
        color: #fff; border-color: var(--man-sidebar-active);
    }
    
    .ml-board {
        display: flex; gap: 20px;
        overflow-x: auto; padding-bottom: 20px;
        min-height: calc(100vh - 220px);
    }
    .ml-column {
        flex: 1; min-width: 300px; max-width: 400px;
        background: #e2e8f0; border-radius: 12px;
        display: flex; flex-direction: column;
        padding: 12px; gap: 12px;
    }
    .ml-col-header {
        font-weight: 700; font-size: 0.95rem; color: #1e293b;
        display: flex; justify-content: space-between; align-items: center;
        padding: 0 4px 8px;
        border-bottom: 2px solid rgba(0,0,0,0.05);
    }
    .ml-col-count {
        background: #cbd5e1; color: #334155;
        font-size: 0.75rem; padding: 2px 8px; border-radius: 10px;
    }

    .ml-card {
        background: #fff; border-radius: 10px;
        padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        cursor: grab; transition: transform 0.2s;
        border: 1px solid transparent;
    }
    .ml-card:active { cursor: grabbing; }
    .ml-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    
    .ml-card-header { display: flex; justify-content: space-between; margin-bottom: 8px; }
    .ml-name { font-weight: 700; font-size: 1rem; color: #0f172a; }
    .ml-time { font-size: 0.7rem; color: #94a3b8; }
    
    .ml-info-row { display: flex; align-items: center; gap: 6px; font-size: 0.8rem; color: #475569; margin-bottom: 4px; }
    .ml-info-row svg { width: 14px; height: 14px; color: #94a3b8; }
    
    .ml-city { display: inline-block; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; margin-top: 6px; }
    
    .ml-actions { margin-top: 12px; display: flex; gap: 8px; }
    .ml-btn {
        flex: 1; padding: 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 600;
        cursor: pointer; border: none; transition: 0.2s;
        display: flex; align-items: center; justify-content: center; gap: 4px;
    }
    .ml-btn-primary { background: #3b82f6; color: #fff; }
    .ml-btn-primary:hover { background: #2563eb; }
    .ml-btn-whatsapp { background: #22c55e; color: #fff; }
    .ml-btn-whatsapp:hover { background: #16a34a; }
    
    .ml-modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.4); backdrop-filter: blur(2px);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; pointer-events: none; transition: 0.2s; z-index: 1000;
    }
    .ml-modal-overlay.active { opacity: 1; pointer-events: all; }
    .ml-modal {
        background: #fff; border-radius: 12px; padding: 24px;
        width: 100%; max-width: 400px; transform: translateY(20px); transition: 0.3s;
    }
    .ml-modal-overlay.active .ml-modal { transform: translateY(0); }
    .ml-modal h3 { font-size: 1.1rem; margin-bottom: 16px; color: #0f172a; }
    .ml-select { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; margin-bottom: 16px; font-family: 'Inter'; outline: none; }
    .ml-modal-actions { display: flex; gap: 10px; justify-content: flex-end; }
    .ml-modal-btn { padding: 8px 16px; border-radius: 8px; cursor: pointer; border: none; font-weight: 600; }
    .ml-modal-cancel { background: #f1f5f9; color: #475569; }
    .ml-modal-save { background: #3b82f6; color: #fff; }
</style>

<div class="ml-filters">
    <button class="ml-filter-btn active" onclick="setFilter('all', this)"><?= __('man_filter_all') ?></button>
    <button class="ml-filter-btn" onclick="setFilter('new', this)"><?= __('man_filter_free') ?></button>
    <button class="ml-filter-btn" onclick="setFilter('mine', this)"><?= __('man_filter_mine') ?></button>
</div>

<div class="ml-board">
    <div class="ml-column" id="col-new">
        <div class="ml-col-header">
            <?= __('man_col_free') ?> <span class="ml-col-count" id="count-new">0</span>
        </div>
        <div class="ml-list" id="list-new"></div>
    </div>

    <div class="ml-column" id="col-contacted">
        <div class="ml-col-header">
            <?= __('man_col_working') ?> <span class="ml-col-count" id="count-contacted">0</span>
        </div>
        <div class="ml-list" id="list-contacted"></div>
    </div>

    <div class="ml-column" id="col-done">
        <div class="ml-col-header">
            <?= __('man_col_done') ?> <span class="ml-col-count" id="count-done">0</span>
        </div>
        <div class="ml-list" id="list-done"></div>
    </div>
</div>

<div class="ml-modal-overlay" id="statusModal">
    <div class="ml-modal">
        <h3><?= __('man_modal_change_status') ?></h3>
        <select id="statusSelect" class="ml-select">
            <option value="new"><?= __('man_status_new') ?></option>
            <option value="contacted"><?= __('man_status_contacted') ?></option>
            <option value="converted"><?= __('man_status_converted') ?></option>
            <option value="rejected"><?= __('man_status_rejected') ?></option>
        </select>
        <div class="ml-modal-actions">
            <button class="ml-modal-btn ml-modal-cancel" onclick="closeStatusModal()"><?= __('man_btn_cancel') ?></button>
            <button class="ml-modal-btn ml-modal-save" onclick="saveStatus()"><?= __('man_btn_save') ?></button>
        </div>
    </div>
</div>

<script>
let allLeads = [];
let viewingFilter = 'all'; // all, new, mine
let currentLeadId = null;

function loadLeads() {
    showLoader();
    fetch(`${window.BASE_URL}/api/manager/leads`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                allLeads = data.leads || [];
                renderBoard();
            }
        })
        .finally(() => hideLoader());
}

function setFilter(filter, btn) {
    document.querySelectorAll('.ml-filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
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
            actionsHtml = `<button class="ml-btn ml-btn-primary" onclick="claimLead(${lead.id})"><?= __('man_btn_claim') ?></button>`;
        } else {
            actionsHtml = `
                <a href="${waLink}" target="_blank" class="ml-btn ml-btn-whatsapp">
                    <svg fill="currentColor" viewBox="0 0 24 24" width="16" height="16"><path d="M11.996 0C5.372 0 0 5.372 0 11.996c0 2.128.56 4.133 1.545 5.908L.044 24l6.23-1.636c1.713.905 3.655 1.417 5.722 1.417 6.623 0 11.995-5.372 11.995-11.995S18.619 0 11.996 0zm0 21.602c-1.801 0-3.522-.464-5.068-1.341l-.364-.207-3.765.986.996-3.666-.226-.358a9.827 9.827 0 01-1.423-5.174c0-5.42 4.41-9.83 9.83-9.83s9.829 4.41 9.829 9.83-4.41 9.83-9.83 9.83zm5.395-7.38c-.296-.148-1.751-.865-2.023-.965-.272-.098-.47-.148-.667.148-.198.297-.766.965-.94 1.163-.173.197-.346.222-.643.074-1.68-.838-2.903-1.928-3.99-3.708-.196-.322.285-.302.85-.929.073-.082.037-.148 0-.223-.037-.074-.667-1.609-.915-2.203-.242-.58-.487-.502-.667-.512-.173-.008-.372-.01-.568-.01-.198 0-.52.074-.792.371-.272.297-1.037 1.015-1.037 2.476s1.062 2.871 1.21 3.069c.148.198 2.093 3.194 5.074 4.482 2.046.885 2.76.744 3.28.625.68-.155 1.751-.715 1.998-1.408.248-.693.248-1.287.173-1.408-.073-.122-.272-.196-.568-.344z"/></svg> 
                    WhatsApp
                </a>
                <button class="ml-btn" style="background:#f1f5f9; color:#475569;" onclick="openStatusModal(${lead.id}, '${lead.status}')"><?= __('man_btn_status') ?></button>
            `;
        }

        const cardHtml = `
            <div class="ml-card">
                <div class="ml-card-header">
                    <div class="ml-name">${lead.name || '<?= __('man_no_name') ?>'}</div>
                    <div class="ml-time">${date}</div>
                </div>
                <div class="ml-info-row">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    ${lead.phone || '<?= __('man_no_phone') ?>'}
                </div>
                ${lead.city ? `<div class="ml-city">${lead.city}</div>` : ''}
                
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
    showLoader();
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
            hideLoader();
        }
    });
}

function openStatusModal(id, currentStatus) {
    currentLeadId = id;
    document.getElementById('statusSelect').value = currentStatus || 'contacted';
    document.getElementById('statusModal').classList.add('active');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.remove('active');
    currentLeadId = null;
}

function saveStatus() {
    if (!currentLeadId) return;
    const status = document.getElementById('statusSelect').value;
    
    showLoader();
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
            hideLoader();
        }
    });
}

document.addEventListener('DOMContentLoaded', loadLeads);
</script>
