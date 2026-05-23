<style>
    .ms-table-wrapper {
        background: #fff;
        border: 1px solid var(--man-border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .ms-toolbar {
        padding: 16px 24px;
        border-bottom: 1px solid var(--man-border);
        display: flex; gap: 16px; align-items: center;
        background: #f8fafc;
    }
    .ms-search {
        flex: 1; min-width: 250px;
        position: relative;
    }
    .ms-search svg {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; width: 18px; height: 18px;
    }
    .ms-search input {
        width: 100%; padding: 10px 14px 10px 38px;
        border: 1px solid #cbd5e1; border-radius: 8px;
        font-family: 'Inter'; font-size: 0.9rem; outline: none;
    }
    .ms-search input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
    
    .ms-table { width: 100%; border-collapse: collapse; text-align: left; }
    .ms-table th {
        padding: 14px 24px; font-size: 0.75rem; text-transform: uppercase;
        color: #64748b; background: #f8fafc; border-bottom: 1px solid var(--man-border);
        font-weight: 700; letter-spacing: 0.5px;
    }
    .ms-table td {
        padding: 16px 24px; border-bottom: 1px solid #f1f5f9;
        color: #1e293b; font-size: 0.9rem;
    }
    .ms-table tbody tr:last-child td { border-bottom: none; }
    .ms-table tbody tr:hover { background: #fafafa; }
    
    .ms-user { display: flex; align-items: center; gap: 12px; }
    .ms-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: #eff6ff; color: #3b82f6;
        display: flex; align-items: center; justify-content: center;
        font-weight: 600; font-size: 0.95rem;
    }
    .ms-name { font-weight: 600; color: #0f172a; margin-bottom: 2px; }
    .ms-email { font-size: 0.75rem; color: #64748b; }
    
    .ms-badge {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 4px 10px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
    }
    .b-pending { background: #fef3c7; color: #b45309; }
    .b-approved { background: #dcfce7; color: #166534; }
    .b-missing { background: #fee2e2; color: #991b1b; }
    
    .ms-actions { display: flex; gap: 8px; }
    .ms-btn {
        width: 32px; height: 32px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        border: none; cursor: pointer; transition: 0.2s;
    }
    .ms-btn:hover { transform: scale(1.05); }
    .ms-btn-msg { background: #eff6ff; color: #3b82f6; }
    .ms-btn-msg:hover { background: #dbeafe; }

    @media (max-width: 800px) {
        .ms-table { display: block; overflow-x: auto; white-space: nowrap; }
    }
</style>

<div class="ms-table-wrapper">
    <div class="ms-toolbar">
        <div class="ms-search">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="msSearchInput" placeholder="<?= __('man_search_ph') ?>" onkeyup="filterStudents()">
        </div>
    </div>
    
    <table class="ms-table">
        <thead>
            <tr>
                <th><?= __('man_th_student') ?></th>
                <th><?= __('man_th_contacts') ?></th>
                <th><?= __('man_th_reg_date') ?></th>
                <th><?= __('man_th_doc_status') ?></th>
                <th><?= __('man_th_actions') ?></th>
            </tr>
        </thead>
        <tbody id="msTbody">
            <tr><td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;"><?= __('man_loading') ?></td></tr>
        </tbody>
    </table>
</div>

<script>
let allStudents = [];

function loadStudents() {
    showLoader();
    fetch(`${window.BASE_URL}/api/manager/students`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                allStudents = data.students || [];
                renderStudents(allStudents);
            }
        })
        .finally(() => hideLoader());
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
        tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 40px; color: #64748b;"><?= __('man_not_found') ?></td></tr>`;
        return;
    }

    tbody.innerHTML = list.map(s => {
        const name = escapeHtml(s.full_name || '<?= __('man_no_name') ?>');
        const initial = name.charAt(0).toUpperCase();

        let docStatusTxt = '<?= __('man_no_docs') ?>';
        let badgeClass = 'b-missing';
        if (s.document_status === 'pending') { docStatusTxt = '<?= __('man_doc_pending') ?>'; badgeClass = 'b-pending'; }
        if (s.document_status === 'approved') { docStatusTxt = '<?= __('man_doc_approved') ?>'; badgeClass = 'b-approved'; }

        const date = new Date(s.created_at).toLocaleDateString('ru-RU', {day:'2-digit', month:'short', year: 'numeric'});

        return `
            <tr>
                <td>
                    <div class="ms-user">
                        <div class="ms-avatar">${initial}</div>
                        <div>
                            <div class="ms-name">${name}</div>
                            <div class="ms-email">${escapeHtml(s.email || '')}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div style="font-weight: 500;">${escapeHtml(s.phone || '—')}</div>
                </td>
                <td style="color:#64748b; font-size:0.85rem;">${date}</td>
                <td><span class="ms-badge ${badgeClass}">${docStatusTxt}</span></td>
                <td>
                    <div class="ms-actions">
                        <a href="${window.BASE_URL}/manager/student?id=${s.id}" class="ms-btn ms-btn-view" title="<?= __('man_btn_view_profile') ?>" style="background:#f3f4f6; color:#4b5563;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <button onclick="startPrivateChat(${s.id})" class="ms-btn ms-btn-msg" title="<?= __('man_btn_write_msg') ?>">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
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

function startPrivateChat(studentId) {
    showLoader();
    fetch(`${window.BASE_URL}/api/chat/start-private`, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({student_id: studentId})
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            window.location.href = `${window.BASE_URL}/manager/chat?room_id=${data.room_id}`;
        } else {
            alert('<?= __('man_err_create_chat') ?>' + (data.error || '<?= __('man_err_unknown') ?>'));
        }
    })
    .catch(err => {
        console.error(err);
        alert('<?= __('man_err_request') ?>');
    })
    .finally(() => hideLoader());
}

document.addEventListener('DOMContentLoaded', loadStudents);
</script>
