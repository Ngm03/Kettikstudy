<style>
    .am-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .am-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px;
    }
    .am-subtitle {
        font-size: 0.85rem;
        color: #64748b;
        margin: 0;
    }
    
    .am-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #10b981;
        color: #fff;
        border: none;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(16,185,129,0.25);
    }
    .am-btn-primary:hover {
        background: #059669;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(16,185,129,0.3);
    }

    .am-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .am-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .am-card:hover {
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
        border-color: #cbd5e1;
        transform: translateY(-4px);
    }

    .am-card-top {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    
    .am-avatar {
        width: 52px; height: 52px;
        border-radius: 50%;
        background: #ecfdf5;
        color: #10b981;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; font-weight: 700;
        flex-shrink: 0;
        overflow: hidden;
        border: 2px solid #fff;
        box-shadow: 0 2px 8px rgba(16,185,129,0.15);
    }
    .am-avatar img {
        width: 100%; height: 100%; object-fit: cover;
    }

    .am-info {
        flex: 1;
        min-width: 0;
    }
    .am-name {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 2px;
        line-height: 1.2;
    }
    .am-phone {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #10b981;
        text-decoration: none;
        transition: color 0.2s;
    }
    .am-phone:hover { color: #059669; }

    .am-status-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .status-active { background: #ecfdf5; color: #059669; }
    .status-active::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #10b981; }
    .status-inactive { background: #f1f5f9; color: #64748b; }
    .status-inactive::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #94a3b8; }

    .am-actions {
        display: flex; gap: 8px;
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }
    
    .am-btn {
        flex: 1;
        padding: 8px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        text-align: center;
    }
    .am-btn-toggle-on { background: #ecfdf5; color: #10b981; }
    .am-btn-toggle-on:hover { background: #d1fae5; }
    .am-btn-toggle-off { background: #fffbeb; color: #d97706; }
    .am-btn-toggle-off:hover { background: #fef3c7; }
    
    .am-btn-del {
        flex: none; width: 34px;
        background: #fef2f2; color: #ef4444;
        display: flex; align-items: center; justify-content: center;
    }
    .am-btn-del:hover { background: #fee2e2; transform: scale(1.05); }

    .am-empty {
        background: #fff;
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
        padding: 60px 20px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .am-empty-icon {
        width: 64px; height: 64px;
        background: #ecfdf5;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #10b981;
        margin-bottom: 16px;
    }
    .am-empty-icon svg { width: 32px; height: 32px; }
    .am-empty h3 { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0 0 6px; }
    .am-empty p { font-size: 0.9rem; color: #64748b; margin: 0; }

    .am-modal-overlay {
        position: fixed; inset: 0;
        background: rgba(15,23,42,0.6);
        backdrop-filter: blur(4px);
        z-index: 9999 !important;
        display: flex; align-items: center; justify-content: center;
        padding: 20px;
        opacity: 0; visibility: hidden;
        transition: all 0.3s;
    }
    .am-modal-overlay.open { opacity: 1; visibility: visible; }
    
    .am-modal {
        background: #fff;
        width: 100%; max-width: 420px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        transform: scale(0.95) translateY(10px);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex; flex-direction: column;
    }
    .am-modal-overlay.open .am-modal { transform: scale(1) translateY(0); }

    .am-modal-header {
        display: flex; justify-content: space-between; align-items: center;
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
    }
    .am-modal-title { font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0; }
    .am-modal-close {
        background: #f1f5f9; border: none;
        width: 32px; height: 32px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: #64748b; cursor: pointer; transition: all 0.2s;
    }
    .am-modal-close:hover { background: #e2e8f0; color: #1e293b; }

    .am-modal-body { padding: 24px; }
    .am-form-group { margin-bottom: 20px; }
    .am-form-label { display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px; }
    .am-form-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 0.95rem;
        font-family: inherit;
        color: #1e293b;
        transition: all 0.2s;
        outline: none;
        background: #fff;
        box-sizing: border-box;
    }
    .am-form-input:focus { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,0.15); }
    .am-form-hint { font-size: 0.75rem; color: #94a3b8; margin-top: 6px; }

    .am-photo-upload {
        display: flex; align-items: center; gap: 16px;
    }
    .am-photo-preview-wrap {
        width: 64px; height: 64px;
        border-radius: 50%;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .am-photo-preview-wrap img { width: 100%; height: 100%; object-fit: cover; opacity: 0.5; }
    .am-photo-btn {
        background: #fff; border: 1px solid #cbd5e1;
        padding: 8px 16px; border-radius: 10px;
        font-size: 0.85rem; font-weight: 600; color: #334155;
        cursor: pointer; transition: all 0.2s;
    }
    .am-photo-btn:hover { border-color: #10b981; color: #10b981; }

    .am-btn-submit {
        width: 100%;
        background: #10b981; color: #fff;
        border: none; padding: 12px;
        border-radius: 12px;
        font-size: 0.95rem; font-weight: 700;
        cursor: pointer; transition: all 0.2s;
        display: flex; justify-content: center; align-items: center; gap: 8px;
    }
    .am-btn-submit:hover { background: #059669; }
    .am-btn-submit:disabled { opacity: 0.7; cursor: not-allowed; }

    @media (max-width: 600px) {
        .am-header { flex-direction: column; align-items: flex-start; gap: 12px; }
        .am-btn-primary { width: 100%; justify-content: center; }
        .am-grid { grid-template-columns: 1fr; gap: 12px; }
        .am-card { padding: 16px; }
    }
</style>

<div class="am-header">
    <div>
        <h1 class="am-title"><?= __('managers_title') ?></h1>
        <p class="am-subtitle"><?= __('managers_subtitle') ?></p>
    </div>
    <button onclick="openManagerModal()" class="am-btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        <?= __('managers_add_btn') ?>
    </button>
</div>

<?php if (empty($managers)): ?>
    <div class="am-empty">
        <div class="am-empty-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <h3><?= __('managers_empty_title') ?></h3>
        <p><?= __('managers_empty_desc') ?></p>
    </div>
<?php else: ?>
    <div class="am-grid">
        <?php foreach ($managers as $m): ?>
        <div class="am-card">
            <div class="am-card-top">
                <div class="am-avatar">
                    <?php if (!empty($m['photo'])): ?>
                        <img src="<?= BASE_URL ?>/uploads/managers/<?= htmlspecialchars($m['photo']) ?>" alt="<?= htmlspecialchars($m['name']) ?>">
                    <?php else: ?>
                        <?= mb_strtoupper(mb_substr($m['name'], 0, 1)) ?>
                    <?php endif; ?>
                </div>
                <div class="am-info">
                    <div class="am-name" title="<?= htmlspecialchars($m['name']) ?>"><?= htmlspecialchars($m['name']) ?></div>
                    <a href="https://wa.me/<?= preg_replace('/[^\d]/', '', $m['phone']) ?>" target="_blank" class="am-phone">
                        <svg viewBox="0 0 16 16" fill="currentColor" width="12" height="12"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326z"/></svg>
                        <?= htmlspecialchars($m['phone']) ?>
                    </a>
                </div>
            </div>
            
            <div>
                <span class="am-status-badge <?= $m['is_active'] ? 'status-active' : 'status-inactive' ?>">
                    <?= $m['is_active'] ? __('managers_status_active') : __('managers_status_inactive') ?>
                </span>
            </div>

            <div class="am-actions">
                <button onclick="toggleManager(<?= $m['id'] ?>)" class="am-btn <?= $m['is_active'] ? 'am-btn-toggle-off' : 'am-btn-toggle-on' ?>">
                    <?= $m['is_active'] ? __('managers_btn_disable') : __('managers_btn_enable') ?>
                </button>
                <button onclick="deleteManager(<?= $m['id'] ?>)" class="am-btn am-btn-del" title="<?= __('managers_title_delete') ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div id="managerModal" class="am-modal-overlay">
    <div class="am-modal">
        <div class="am-modal-header">
            <h3 class="am-modal-title"><?= __('managers_modal_title') ?></h3>
            <button onclick="closeManagerModal()" class="am-modal-close" title="<?= __('managers_title_close') ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="am-modal-body">
            <form id="managerForm" onsubmit="submitManager(event)" enctype="multipart/form-data">
                <div class="am-form-group" style="margin-bottom: 24px;">
                    <label class="am-form-label"><?= ($translatedSelect = __('global_select_user')) === 'global_select_user' ? 'Выберите пользователя' : $translatedSelect ?></label>
                    <select name="user_id" required class="am-form-input">
                        <option value=""><?= ($translatedOpt = __('global_select_user')) === 'global_select_user' ? '-- Выберите пользователя --' : '-- ' . $translatedOpt . ' --' ?></option>
                        <?php if(!empty($students)): foreach($students as $st): ?>
                            <option value="<?= $st['id'] ?>">
                                <?= htmlspecialchars($st['full_name'] ?: $st['email']) ?>
                                <?= $st['phone'] ? '(' . htmlspecialchars($st['phone']) . ')' : '' ?>
                            </option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                
                <div>
                    <button type="submit" id="submitBtn" class="am-btn-submit">
                        <?= __('managers_btn_submit') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const mModal = document.getElementById('managerModal');
    const form = document.getElementById('managerForm');

    function openManagerModal() { 
        mModal.classList.add('open');
    }

    function closeManagerModal() { 
        mModal.classList.remove('open');
        setTimeout(() => {
            form.reset();
        }, 300);
    }

    mModal.addEventListener('click', (e) => {
        if (e.target === mModal) closeManagerModal();
    });



    function submitManager(e) {
        e.preventDefault();
        const btn = document.getElementById('submitBtn');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = `<svg style="animation: spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.25"></circle><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> <?= __('managers_saving') ?>`;
        btn.disabled = true;

        const fd = new FormData(e.target);
        
        fetch(`${window.BASE_URL}/admin/managers/create`, {
            method: 'POST',
            body: fd
        })
        .then(r => r.json())
        .then(d => {
            if (d.success) location.reload();
            else { alert(d.error || '<?= __('managers_error') ?>'); btn.innerHTML = originalText; btn.disabled = false; }
        })
        .catch(err => {
            alert('<?= __('managers_error_network') ?>');
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }

    function toggleManager(id) {
        fetch(`${window.BASE_URL}/admin/managers/toggle`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({id})
        })
        .then(r => r.json())
        .then(d => { if (d.success) location.reload(); else alert('<?= __('managers_error') ?>'); });
    }

    function deleteManager(id) {
        if (!confirm('<?= __('managers_confirm_delete') ?>')) return;
        fetch(`${window.BASE_URL}/admin/managers/delete`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({id})
        })
        .then(r => r.json())
        .then(d => { if (d.success) location.reload(); else alert('<?= __('managers_error') ?>'); });
    }

    const style = document.createElement('style');
    style.innerHTML = `@keyframes spin { to { transform: rotate(360deg); } }`;
    document.head.appendChild(style);
</script>
