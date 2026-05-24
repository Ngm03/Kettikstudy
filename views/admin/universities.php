<style>
    .au-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .au-title-wrap {}
    .au-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px;
    }
    .au-subtitle {
        font-size: 0.85rem;
        color: #64748b;
        margin: 0;
    }
    
    .au-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #3b82f6;
        color: #fff;
        border: none;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(59,130,246,0.25);
    }
    .au-btn-primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(59,130,246,0.3);
    }
    .au-btn-primary:active { transform: translateY(0); }

    .au-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .au-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .au-card:hover {
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
        border-color: #cbd5e1;
        transform: translateY(-4px);
    }

    .au-del-btn {
        position: absolute;
        top: 10px; right: 10px;
        width: 32px; height: 32px;
        border-radius: 50%;
        background: #fef2f2;
        color: #ef4444;
        display: flex; align-items: center; justify-content: center;
        border: none;
        cursor: pointer;
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.2s;
    }
    .au-card:hover .au-del-btn { opacity: 1; transform: scale(1); }
    .au-del-btn:hover { background: #fee2e2; color: #dc2626; transform: scale(1.1) !important; }

    .au-logo-wrap {
        height: 80px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .au-logo {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        filter: grayscale(100%);
        opacity: 0.7;
        transition: all 0.3s ease;
    }
    .au-card:hover .au-logo {
        filter: grayscale(0%);
        opacity: 1;
    }

    .au-info {
        text-align: center;
        width: 100%;
    }
    .au-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 6px;
        line-height: 1.3;
    }
    .au-link {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #3b82f6;
        text-decoration: none;
        transition: color 0.2s;
    }
    .au-link:hover { color: #1d4ed8; text-decoration: underline; }

    .au-empty {
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
    .au-empty-icon {
        width: 64px; height: 64px;
        background: #f8fafc;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #94a3b8;
        margin-bottom: 16px;
    }
    .au-empty-icon svg { width: 32px; height: 32px; }
    .au-empty h3 { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0 0 6px; }
    .au-empty p { font-size: 0.9rem; color: #64748b; margin: 0; }

    .au-modal-overlay {
        position: fixed; inset: 0;
        background: rgba(15,23,42,0.6);
        backdrop-filter: blur(4px);
        z-index: 9999 !important;
        display: flex; align-items: center; justify-content: center;
        padding: 20px;
        opacity: 0; visibility: hidden;
        transition: all 0.3s;
    }
    .au-modal-overlay.open { opacity: 1; visibility: visible; }
    
    .au-modal {
        background: #fff;
        width: 100%; max-width: 480px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        transform: scale(0.95) translateY(10px);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex; flex-direction: column;
    }
    .au-modal-overlay.open .au-modal { transform: scale(1) translateY(0); }

    .au-modal-header {
        display: flex; justify-content: space-between; align-items: center;
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
    }
    .au-modal-title { font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0; }
    .au-modal-close {
        background: #f1f5f9; border: none;
        width: 32px; height: 32px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: #64748b; cursor: pointer; transition: all 0.2s;
    }
    .au-modal-close:hover { background: #e2e8f0; color: #1e293b; }

    .au-modal-body { padding: 24px; }
    .au-form-group { margin-bottom: 20px; }
    .au-form-label { display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px; }
    .au-form-input {
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
    .au-form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.15); }

    .au-file-drop {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;
        padding: 30px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        overflow: hidden;
    }
    .au-file-drop:hover { border-color: #94a3b8; background: #f1f5f9; }
    .au-file-drop.has-file { padding: 10px; border-style: solid; border-color: #e2e8f0; background: #fff; }
    
    .au-file-placeholder { display: flex; flex-direction: column; align-items: center; gap: 8px; }
    .au-file-placeholder svg { width: 32px; height: 32px; color: #94a3b8; }
    .au-file-placeholder span { font-size: 0.85rem; color: #64748b; font-weight: 500; }
    
    .au-file-preview { display: none; width: 100%; height: 120px; object-fit: contain; }
    .au-file-drop.has-file .au-file-placeholder { display: none; }
    .au-file-drop.has-file .au-file-preview { display: block; }

    .au-btn-submit {
        width: 100%;
        background: #3b82f6; color: #fff;
        border: none; padding: 12px;
        border-radius: 12px;
        font-size: 0.95rem; font-weight: 700;
        cursor: pointer; transition: all 0.2s;
        display: flex; justify-content: center; align-items: center; gap: 8px;
    }
    .au-btn-submit:hover { background: #2563eb; }
    .au-btn-submit:disabled { opacity: 0.7; cursor: not-allowed; }

    @media (max-width: 600px) {
        .au-header { flex-direction: column; align-items: flex-start; gap: 12px; }
        .au-btn-primary { width: 100%; justify-content: center; }
        .au-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
        .au-card { padding: 12px 8px; gap: 10px; }
        .au-logo-wrap { height: 50px; }
        .au-name { font-size: 0.85rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .au-link { font-size: 0.7rem; }
        .au-del-btn { opacity: 1; transform: scale(1); width: 28px; height: 28px; top: 6px; right: 6px; }
    }
    @media (max-width: 380px) {
        .au-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="au-header">
    <div class="au-title-wrap">
        <h1 class="au-title"><?= __('uni_title') ?></h1>
        <p class="au-subtitle"><?= __('uni_subtitle') ?></p>
    </div>
    <button onclick="openModal()" class="au-btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        <?= __('uni_add_btn') ?>
    </button>
</div>

<?php if (empty($universities)): ?>
    <div class="au-empty">
        <div class="au-empty-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <h3><?= __('uni_empty_title') ?></h3>
        <p><?= __('uni_empty_desc') ?></p>
    </div>
<?php else: ?>
    <div class="au-grid">
        <?php foreach ($universities as $uni): ?>
        <div class="au-card">
            <button onclick="deleteUni(<?= $uni['id'] ?>)" class="au-del-btn" title="<?= __('uni_delete_title') ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
            
            <div class="au-logo-wrap">
                <img src="<?= BASE_URL . $uni['logo_path'] ?>" alt="<?= htmlspecialchars($uni['name']) ?>" class="au-logo">
            </div>
            
            <div class="au-info">
                <div class="au-name" title="<?= htmlspecialchars($uni['name']) ?>">
                    <?= htmlspecialchars($uni['name']) ?>
                </div>
                <?php if($uni['website_url']): ?>
                    <a href="<?= htmlspecialchars($uni['website_url']) ?>" target="_blank" class="au-link">
                        <?= __('uni_go_to_site') ?> 
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div id="addModal" class="au-modal-overlay">
    <div class="au-modal">
        <div class="au-modal-header">
            <h3 class="au-modal-title"><?= __('uni_modal_title') ?></h3>
            <button onclick="closeModal()" class="au-modal-close" title="<?= __('uni_modal_close') ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="au-modal-body">
            <form id="addForm" onsubmit="submitForm(event)">
                <div class="au-form-group">
                    <label class="au-form-label"><?= __('uni_lbl_name') ?></label>
                    <input type="text" name="name" required placeholder="<?= __('uni_ph_name') ?>" class="au-form-input">
                </div>
                
                <div class="au-form-group">
                    <label class="au-form-label"><?= __('uni_lbl_url') ?></label>
                    <input type="url" name="website_url" placeholder="https://..." class="au-form-input">
                </div>
                
                <div class="au-form-group">
                    <label class="au-form-label"><?= __('uni_lbl_logo') ?></label>
                    <input type="file" name="logo" id="logoInput" required accept="image/*" style="display:none;" onchange="previewImage(this)">
                    <label for="logoInput" class="au-file-drop" id="fileDrop">
                        <div class="au-file-placeholder">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            <span><?= __('uni_drop_text') ?></span>
                        </div>
                        <img id="logoPreview" class="au-file-preview">
                    </label>
                </div>
                
                <div style="margin-top: 24px;">
                    <button type="submit" id="submitBtn" class="au-btn-submit">
                        <?= __('uni_btn_submit') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('addModal');
    const form = document.getElementById('addForm');
    const fileDrop = document.getElementById('fileDrop');

    function openModal() { 
        modal.classList.add('open');
    }

    function closeModal() { 
        modal.classList.remove('open');
        setTimeout(() => {
            form.reset();
            fileDrop.classList.remove('has-file');
            document.getElementById('logoPreview').src = '';
        }, 300);
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logoPreview').src = e.target.result;
                fileDrop.classList.add('has-file');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function submitForm(e) {
        e.preventDefault();
        const btn = document.getElementById('submitBtn');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = `<svg style="animation: spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.25"></circle><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> <?= __('uni_saving') ?>`;
        btn.disabled = true;

        const formData = new FormData(e.target);
        
        fetch(`${window.BASE_URL}/admin/universities/create`, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert(data.error || '<?= __('uni_err_upload') ?>');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        })
        .catch(err => {
            alert('<?= __('uni_err_network') ?>');
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }

    function deleteUni(id) {
        if(!confirm('<?= __('uni_confirm_delete') ?>')) return;
        
        fetch(`${window.BASE_URL}/admin/universities/delete`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({id})
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('<?= __('uni_err_delete') ?>' + (data.error || '<?= __('uni_err_unknown') ?>'));
            }
        });
    }

    const style = document.createElement('style');
    style.innerHTML = `@keyframes spin { to { transform: rotate(360deg); } }`;
    document.head.appendChild(style);
</script>
