<div class="page-header">
    <h1 class="page-title"><?= __('my_documents') ?></h1>
    <p class="page-subtitle"><?= __('upload_docs_desc') ?></p>
</div>

<div class="card">
    <div class="card-title"><?= __('upload_document') ?></div>
    
    <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
        <div style="flex: 1; min-width: 250px;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-secondary);"><?= __('doc_type') ?></label>
            <select id="doc-type" class="form-select" style="width: 100%;">
                <option value="passport"><?= __('doc_passport') ?></option>
                <option value="transcript"><?= __('doc_transcript') ?></option>
                <option value="certificate"><?= __('doc_certificate') ?></option>
                <option value="other"><?= __('doc_other') ?></option>
            </select>
        </div>
    </div>

    <div class="upload-zone" id="upload-zone" onclick="document.getElementById('doc-file').click()">
        <input type="file" id="doc-file" style="display: none;" onchange="handleFileSelect(this)">
        <div style="margin-bottom: 1rem; color: var(--primary);">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
        </div>
        <div style="font-weight: 600; margin-bottom: 0.25rem;" id="upload-text"><?= __('click_or_drag') ?></div>
        <div style="font-size: 0.85rem; color: var(--text-muted);" id="upload-subtext"><?= __('file_limits') ?></div>
    </div>

    <div style="text-align: right;">
        <button class="btn btn-primary" onclick="uploadDocument()" id="btn-upload" disabled style="opacity: 0.6; cursor: not-allowed;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
            <?= __('btn_upload_doc') ?>
        </button>
    </div>
</div>

<div class="card">
    <div class="card-title"><?= __('file_list') ?></div>
    <div id="docs-list" class="doc-list">
        <div style="text-align: center; padding: 2rem; color: var(--text-muted);"><?= __('loading') ?></div>
    </div>
</div>

<script>
    const docsList = document.getElementById('docs-list');
    const uploadZone = document.getElementById('upload-zone');
    const uploadBtn = document.getElementById('btn-upload');

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    uploadZone.ondragover = (e) => { e.preventDefault(); uploadZone.classList.add('dragover'); };
    uploadZone.ondragleave = () => uploadZone.classList.remove('dragover');
    uploadZone.ondrop = (e) => {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        if (e.dataTransfer.files.length) {
            document.getElementById('doc-file').files = e.dataTransfer.files;
            handleFileSelect(document.getElementById('doc-file'));
        }
    };

    function handleFileSelect(input) {
        if (input.files.length > 0) {
            const fileName = input.files[0].name;
            document.getElementById('upload-text').textContent = fileName;
            document.getElementById('upload-subtext').textContent = '<?= __('file_selected') ?>';
            uploadBtn.removeAttribute('disabled');
            uploadBtn.style.opacity = '1';
            uploadBtn.style.cursor = 'pointer';
            uploadZone.style.borderColor = 'var(--primary)';
            uploadZone.style.background = 'var(--primary-light)';
        }
    }

    function loadDocuments() {
        fetch('<?= BASE_URL ?>/api/documents/list')
            .then(res => res.json())
            .then(data => {
                docsList.innerHTML = '';
                
                if (data.documents && data.documents.length > 0) {
                    data.documents.forEach(doc => {
                        const item = document.createElement('div');
                        item.className = 'doc-item';
                        
                        let statusBadge = '<span class="badge" style="background:#fef3c7; color:#d97706;"><?= __('status_reviewing') ?></span>';
                        let icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                        
                        if (doc.status === 'approved') { 
                            statusBadge = '<span class="badge badge-green"><?= __('status_approved') ?></span>'; 
                            icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
                        }
                        if (doc.status === 'rejected') { 
                            statusBadge = '<span class="badge" style="background:#fee2e2; color:#dc2626;"><?= __('status_rejected') ?></span>';
                            icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
                        }

                        let rejection = '';
                        if (doc.status === 'rejected' && doc.rejection_reason) {
                            rejection = `<div style="font-size:0.8rem; color:#ef4444; margin-top:4px;"><?= __('reason') ?>: ${escapeHtml(doc.rejection_reason)}</div>`;
                        }

                        item.innerHTML = `
                            <div class="doc-info">
                                <div class="doc-icon" style="${doc.status === 'approved' ? 'background:#d1fae5; color:#059669;' : ''}">
                                    ${icon}
                                </div>
                                <div class="doc-meta">
                                    <h4>${getTypeName(doc.type)}</h4>
                                    <p>${escapeHtml(doc.original_name)}</p>
                                    ${rejection}
                                </div>
                            </div>
                            <div style="display:flex; align-items:center; gap:1rem;">
                                ${statusBadge}
                                <div class="doc-actions">
                                    <button onclick="viewDocument(${doc.id})" class="btn-icon" title="Просмотр">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </button>
                                    <button onclick="deleteDocument(${doc.id})" class="btn-icon delete" title="Удалить">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </div>
                        `;
                        docsList.appendChild(item);
                    });
                } else {
                    docsList.innerHTML = `
                        <div style="text-align:center; padding:3rem 1rem;">
                            <div style="width:64px; height:64px; background:var(--bg-body); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem auto; color:var(--text-muted);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <h4 style="margin:0 0 0.5rem 0; font-size:1.1rem;"><?= __('no_documents') ?></h4>
                            <p style="color:var(--text-muted); margin:0;"><?= __('upload_to_see') ?></p>
                        </div>
                    `;
                }
            })
            .catch(err => {
                docsList.innerHTML = `<div style="color:red; text-align:center;"><?= __('upload_error') ?></div>`;
            });
    }

    function getTypeName(type) {
        const types = { 'passport': '<?= __('doc_passport') ?>', 'transcript': '<?= __('doc_transcript') ?>', 'certificate': '<?= __('doc_certificate') ?>', 'other': '<?= __('doc_other') ?>' };
        return types[type] || type;
    }

    async function uploadDocument() {
        const fileInput = document.getElementById('doc-file');
        const typeSelect = document.getElementById('doc-type');
        const file = fileInput.files[0];

        if (!file) return;

        const formData = new FormData();
        formData.append('file', file);
        formData.append('type', typeSelect.value);

        const btn = document.getElementById('btn-upload');
        const originalText = btn.innerHTML;
        btn.innerHTML = `<span class="loader"></span> <?= __('loading') ?>`;
        btn.disabled = true;

        try {
            const res = await fetch('<?= BASE_URL ?>/api/documents/upload', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();

            if (res.ok) {
                fileInput.value = '';
                document.getElementById('upload-text').textContent = '<?= __('click_or_drag') ?>';
                document.getElementById('upload-subtext').textContent = '<?= __('file_limits') ?>';
                uploadZone.style.borderColor = 'var(--border)';
                uploadZone.style.background = 'var(--bg-body)';
                btn.disabled = true;
                btn.style.opacity = '0.6';
                btn.style.cursor = 'not-allowed';
                
                loadDocuments();
            } else {
                alert(data.error || '<?= __('upload_failed') ?>');
            }
        } catch (e) {
            alert('<?= __('conn_error') ?>');
        } finally {
            btn.innerHTML = originalText;
        }
    }

    function viewDocument(id) {
        window.open('<?= BASE_URL ?>/api/documents/view?id=' + id, '_blank');
    }

    function deleteDocument(id) {
        if (!confirm('<?= __('delete_confirm') ?>')) return;

        fetch('<?= BASE_URL ?>/api/documents/delete', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        }).then(() => loadDocuments());
    }

    loadDocuments();
</script>
