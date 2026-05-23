<style>
    .layout-grid {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 1.5rem;
        max-width: 1600px;
        margin: 0 auto;
    }
    
    @media (max-width: 1024px) {
        .layout-grid { grid-template-columns: 1fr; }
    }

    .card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        padding: 1.75rem;
        position: relative;
        transition: all 0.3s ease;
        border: none;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }
    .section-title { font-size: 1.125rem; font-weight: 600; color: #111827; }

    .badge {
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
    .badge.new, .badge.blue { background: #eff6ff; color: #3b82f6; }
    .badge.hot { background: #fef2f2; color: #ef4444; }
    .badge.cold { background: #f3f4f6; color: #6b7280; }
    .badge.converted { background: #f0fdf4; color: #166534; }
    
    .badge.approved { background: #dcfce7; color: #166534; }
    .badge.rejected { background: #fee2e2; color: #991b1b; }
    .badge.pending { background: #fef3c7; color: #b45309; }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        gap: 6px;
    }
    .btn-primary { background: #0052FF; color: white; box-shadow: 0 4px 12px rgba(0, 82, 255, 0.2); }
    .btn-primary:hover { background: #0044cc; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(0, 82, 255, 0.3); }
    .btn-outline { background: transparent; border: 1px solid #e5e7eb; color: #111827; }
    .btn-outline:hover { background: #f9fafb; border-color: #d1d5db; }
    .btn-sm { padding: 4px 8px; font-size: 0.75rem; }
    .btn-icon { padding: 6px; border-radius: 6px; background: transparent; color: #64748b; transition: 0.2s;}
    .btn-icon:hover { background: #f3f4f6; color: #4f46e5; }

    .profile-avatar {
        width: 64px; height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; font-weight: 700; color: #4338ca;
        margin-right: 1rem;
    }
    .contact-item { display: flex; align-items: center; gap: 8px; margin-bottom: 0.5rem; font-size: 0.9rem; color: #4b5563; }
    .contact-item svg { color: #9ca3af; width: 16px; height: 16px; }

    .metrics-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-top: 1rem; }
    .metric-box {
        background: #f8fafc; border-radius: 8px; padding: 0.75rem;
        border: 1px solid #f1f5f9;
        display: flex; flex-direction: column;
    }
    .metric-label { font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 4px; }
    .metric-value { font-size: 1.125rem; font-weight: 700; color: #0f172a; }

    .chat-layout { display: flex; flex-direction: column; height: 600px; background: #ffffff; overflow: hidden; }
    .chat-messages {
        flex: 1; overflow-y: auto; padding: 1.5rem;
        background-color: #f8fafc;
        background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
        background-size: 20px 20px;
        max-height: 500px;
    }
    .message-bubble {
        max-width: 85%;
        padding: 1rem;
        border-radius: 12px;
        font-size: 0.95rem;
        line-height: 1.6;
        position: relative;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .message-row { display: flex; margin-bottom: 1.5rem; width: 100%; animation: fadeIn 0.3s ease; }
    .message-row.user { justify-content: flex-end; }
    .message-row.ai { justify-content: flex-start; }
    
    .message-bubble.user { background: #4f46e5; color: white; border-bottom-right-radius: 2px; }
    .message-bubble.ai { background: white; color: #111827; border: 1px solid #e5e7eb; border-bottom-left-radius: 2px; }
    
    .message-meta { 
        display: flex; gap: 6px; align-items: center; 
        font-size: 0.75rem; margin-bottom: 4px; opacity: 0.8; 
    }
    .user .message-meta { justify-content: flex-end; color: #e0e7ff; }
    .ai .message-meta { justify-content: flex-start; color: #9ca3af; }

    .doc-card {
        display: flex; align-items: flex-start;
        padding: 1.25rem;
        border-radius: 16px;
        transition: all 0.3s ease;
        background: #f8fafc;
        margin-bottom: 8px;
        border: 1px solid transparent;
    }
    .doc-card:hover { 
        background: white;
        border-color: #0052FF;
        box-shadow: 0 10px 25px -5px rgba(0,82,255,0.08); 
        transform: translateY(-2px);
    }
    .doc-icon {
        width: 40px; height: 40px;
        background: #f3f4f6; color: #64748b;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        margin-right: 12px;
    }
    
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5); z-index: 1000;
        display: none; align-items: center; justify-content: center;
        backdrop-filter: blur(4px);
    }
    .modal-overlay.active { display: flex; }
    .modal {
        background: white; padding: 2.5rem; border-radius: 20px;
        width: 90%; max-width: 500px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        animation: slideUp 0.3s ease-out;
    }
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    
    .form-group { margin-bottom: 1rem; }
    .form-label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem; }
    .form-input { 
        width: 100%; padding: 0.625rem; border: 1px solid #e5e7eb; border-radius: 8px;
        font-size: 0.95rem; transition: 0.2s;
    }
    .form-input:focus { outline: none; border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
    
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    .prose a { color: #3b82f6; text-decoration: underline; }
    .prose ul { padding-left: 1.25rem; list-style-type: disc; margin: 0.5rem 0; }
    .prose strong { font-weight: 600; }

    .progress-tracker {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        margin-bottom: 1.5rem;
        gap: 0.5rem;
    }
    .progress-step {
        flex: 1;
        text-align: center;
        position: relative;
    }
    .progress-step-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        border: 2px solid white;
        box-shadow: 0 0 0 1px #e2e8f0;
    }
    .progress-step.active .progress-step-circle {
        background: #0052FF;
        color: white;
        box-shadow: 0 0 0 4px rgba(0,82,255,0.1);
    }
    .progress-step.completed .progress-step-circle {
        background: #10b981;
        color: white;
        box-shadow: 0 0 0 2px #10b981;
    }
    .progress-step-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 500;
        letter-spacing: 0.025em;
    }
    .progress-step.active .progress-step-label {
        color: #0052FF;
        font-weight: 700;
    }
    .progress-step.completed .progress-step-label {
        color: #10b981;
        font-weight: 600;
    }
    .progress-line {
        height: 2px;
        background: #f1f5f9;
        flex: 1;
        margin: 0 -0.75rem;
        margin-top: -26px;
        position: relative;
        z-index: 0;
        transition: all 0.3s ease;
    }
    .progress-line.completed {
        background: #10b981;
    }

</style>

<header class="flex justify-between items-center mb-8">
    <div class="flex items-center gap-4">
        <a href="<?= BASE_URL ?>/admin/dashboard" class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center text-gray-500 hover:text-gray-900 hover:border-gray-300 transition-all shadow-sm">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900" id="page-title">Загрузка...</h1>
            <div class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                ID: <span id="student-id-display">...</span> • <span id="student-email-display">...</span>
            </div>
        </div>
    </div>
    
        <div class="flex gap-3">
            <button onclick="openEditModal()" class="btn btn-outline bg-white">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            <?= __('btn_edit') ?>
        </button>
            <a href="#" id="download-pdf-btn" class="btn btn-primary" target="_blank">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <?= __('btn_download_pdf') ?>
        </a>
    </div>
</header>

<div class="progress-tracker" id="progress-tracker">
    <div class="progress-step" data-stage="lead">
        <div class="progress-step-circle">1</div>
        <div class="progress-step-label"><?= __('stage_lead') ?></div>
    </div>
    <div class="progress-line"></div>
    <div class="progress-step" data-stage="qualified">
        <div class="progress-step-circle">2</div>
        <div class="progress-step-label"><?= __('stage_qualified') ?></div>
    </div>
    <div class="progress-line"></div>
    <div class="progress-step" data-stage="documents">
        <div class="progress-step-circle">3</div>
        <div class="progress-step-label"><?= __('stage_docs') ?></div>
    </div>
    <div class="progress-line"></div>
    <div class="progress-step" data-stage="contract">
        <div class="progress-step-circle">4</div>
        <div class="progress-step-label"><?= __('stage_contract') ?></div>
    </div>
    <div class="progress-line"></div>
    <div class="progress-step" data-stage="paid">
        <div class="progress-step-circle">5</div>
        <div class="progress-step-label"><?= __('stage_paid') ?></div>
    </div>
</div>

<div class="layout-grid">
    <div class="flex flex-col gap-6">
        <div class="card">
            <div class="flex items-center mb-6">
                <div class="profile-avatar" id="avatar-letter">A</div>
                <div>
                    <div class="font-bold text-lg" id="profile-name">...</div>
                    <div class="text-sm text-muted"><?= __('student_role_label') ?></div>
                    <div id="profile-badge" class="mt-2"></div>
                    
                    <div class="flex gap-2 mt-3" id="quick-actions" style="display: none;">
                        <a id="btn-whatsapp" href="#" target="_blank" class="btn btn-sm btn-outline" style="background: #25D366; color: white; border: none;">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            WhatsApp
                        </a>
                        <a id="btn-email" href="mailto:" class="btn btn-sm btn-outline">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Email
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="space-y-3">
                <div class="contact-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span id="profile-email">email@example.com</span>
                </div>
                <div class="contact-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <span id="profile-phone">+7 ...</span>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100">
                <label class="form-label text-muted"><?= __('stat_title') ?></label>
                <div class="metrics-grid">
                    <div class="metric-box">
                        <div class="metric-label"><?= __('stat_rating') ?></div>
                        <div class="metric-value" id="stat-score">-</div>
                    </div>
                        <div class="metric-box">
                        <div class="metric-label"><?= __('stat_budget') ?></div>
                        <div class="metric-value text-green-600" id="stat-budget">-</div>
                    </div>
                        <div class="metric-box">
                        <div class="metric-label">GPA</div>
                        <div class="metric-value" id="stat-gpa">-</div>
                    </div>
                        <div class="metric-box">
                        <div class="metric-label"><?= __('stat_language') ?></div>
                        <div class="metric-value text-sm" id="stat-lang">-</div>
                    </div>
                </div>
                
                <div class="metrics-grid mt-4">
                    <div class="metric-box">
                        <div class="metric-label"><?= __('stat_city') ?></div>
                        <div class="metric-value text-sm" id="stat-city">-</div>
                    </div>
                    <div class="metric-box">
                        <div class="metric-label"><?= __('stat_status') ?></div>
                        <div class="metric-value text-sm" id="stat-enrolled">-</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
                <div class="section-header">
                <h3 class="section-title"><?= __('notes_title') ?></h3>
                <svg class="text-gray-400" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
            <textarea id="admin-notes" class="form-input text-sm bg-gray-50 border-0" rows="6" placeholder="<?= __('notes_placeholder') ?>"></textarea>
            <div class="flex justify-end mt-3">
                    <button onclick="saveNotes()" class="btn btn-primary btn-sm"><?= __('btn_save') ?></button>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-6">
        
        <div class="card">
            <div class="section-header">
                <h3 class="section-title"><?= __('docs_title') ?></h3>
                    <span class="badge cold" id="docs-count">0 док.</span>
            </div>
            <div id="docs-list" class="flex flex-col gap-3">
            </div>
        </div>

        <div class="card p-0 overflow-hidden flex flex-col h-[600px]">
            <div class="p-4 border-b border-gray-100 bg-white flex justify-between items-center z-10 relative shadow-sm">
                <h3 class="font-bold text-gray-800"><?= __('chat_history_title') ?></h3>
                <div class="text-xs text-muted"><?= __('chat_readonly') ?></div>
            </div>
            <div class="chat-messages" id="chat-history">
            </div>
        </div>

    </div>
</div>

<div class="modal-overlay" id="edit-modal">
    <div class="modal">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold"><?= __('edit_profile_title') ?></h2>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <div class="space-y-4 max-h-[70vh] overflow-y-auto pr-2">
            <div>
                <label class="form-label"><?= __('label_fio') ?></label>
                <input type="text" id="edit-name" class="form-input">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                        <label class="form-label"><?= __('label_phone') ?></label>
                        <input type="text" id="edit-phone" class="form-input">
                </div>
                <div>
                        <label class="form-label"><?= __('label_email') ?></label>
                        <input type="email" id="edit-email" class="form-input">
                </div>
            </div>
            <hr class="border-gray-100 my-2">
            <div class="grid grid-cols-2 gap-4">
                <div>
                        <label class="form-label">Бюджет</label>
                        <input type="text" id="edit-budget" class="form-input" placeholder="например: 1 млн тенге">
                </div>
                <div>
                        <label class="form-label">GPA</label>
                        <input type="number" step="0.1" id="edit-gpa" class="form-input">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                <label class="form-label">Статус</label>
                <select id="edit-status" class="form-input">
                    <option value="new">NEW</option>
                    <option value="hot">HOT</option>
                    <option value="cold">COLD</option>
                    <option value="converted">CONVERTED</option>
                </select>
            </div>
            <hr class="border-gray-100 my-2">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label"><?= __('label_student_role') ?></label>
                    <select id="edit-enrolled-role" class="form-input">
                        <option value=""><?= __('role_not_assigned') ?></option>
                        <option value="enrolled"><?= __('role_enrolled') ?></option>
                    </select>
                </div>
                <div>
                    <label class="form-label"><?= __('stat_city') ?></label>
                    <select id="edit-city" class="form-input">
                        <option value=""><?= __('not_selected') ?></option>
                    </select>
                </div>
            </div>
            <hr class="border-gray-100 my-2">
            <div>
                <label class="form-label">Прикрепленный Менеджер</label>
                <select id="edit-manager" class="form-input">
                    <option value="">Не назначен</option>
                </select>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <button onclick="closeEditModal()" class="btn btn-outline"><?= __('btn_cancel') ?></button>
            <button onclick="saveStudentDetails()" class="btn btn-primary"><?= __('btn_save_changes') ?></button>
        </div>
    </div>
</div>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const studentId = urlParams.get('id');
    let currentData = null;

    function loadData() {
        if(!studentId) { alert('No ID provided'); return; }
        
        document.getElementById('download-pdf-btn').href = `<?= BASE_URL ?>/api/admin/download-pdf?id=${studentId}`;

        fetch(`<?= BASE_URL ?>/api/admin/student-details?id=${studentId}`)
            .then(res => res.json())
            .then(data => {
                if(data.error) { alert(data.error); return; }
                currentData = data;
                renderPage(data);
                
                if (data.stage) {
                    updateProgressTracker(data.stage);
                }
            })
            .catch(err => console.error(err));
    }



    function renderDocs(docs) {
        const container = document.getElementById('docs-list');
        container.innerHTML = '';
        document.getElementById('docs-count').textContent = (docs ? docs.length : 0) + ' док.';
        
        if (!docs || docs.length === 0) {
            container.innerHTML = `<div class="text-center text-muted py-4 text-sm"><?= __('no_docs_loaded') ?></div>`;
            return;
        }

        docs.forEach(doc => {
            const el = document.createElement('div');
            el.className = 'doc-card';
            
            let statusColor = 'bg-gray-100 text-gray-500';
            let statusText = '<?= __('doc_status_pending') ?>';
            if(doc.status === 'approved') { statusColor = 'bg-green-100 text-green-700'; statusText = '<?= __('doc_status_approved') ?>'; }
            if(doc.status === 'rejected') { statusColor = 'bg-red-100 text-red-700'; statusText = '<?= __('doc_status_rejected') ?>'; }
            if(doc.status === 'pending') { statusColor = 'bg-yellow-100 text-yellow-700'; statusText = '<?= __('doc_status_pending') ?>'; }

            const typeNames = {'passport': 'Паспорт', 'transcript': 'Аттестат', 'certificate': 'Сертификат'};
            const docName = typeNames[doc.type] || doc.type;

            let reasonHtml = '';
            if (doc.status === 'rejected' && doc.rejection_reason) {
                reasonHtml = `<div class="text-xs text-red-600 bg-red-50 p-1 rounded mt-1"><?= __('reason_label') ?>: ${doc.rejection_reason}</div>`;
            }

            el.innerHTML = `
                <div class="doc-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="font-medium text-sm text-gray-900 truncate" title="${doc.original_name}">${doc.original_name}</div>
                            <div class="text-xs text-muted mb-1">${docName}</div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-xs font-bold uppercase ${statusColor}">${statusText}</span>
                    </div>
                    
                    ${reasonHtml}

                    <div class="flex gap-2 mt-2">
                        <a href="<?= BASE_URL ?>/api/documents/view?id=${doc.id}" target="_blank" class="text-xs text-blue-600 hover:underline"><?= __('btn_view') ?></a>
                        <div class="flex-1"></div>
                        
                        <button onclick="updateDoc(${doc.id}, 'approved')" class="btn-icon text-green-600 hover:bg-green-50" title="<?= __('title_approve') ?>">
                             <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                        <button onclick="updateDoc(${doc.id}, 'rejected')" class="btn-icon text-red-600 hover:bg-red-50" title="<?= __('title_reject') ?>">
                             <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(el);
        });
    }

    function renderChat(historyStr) {
        const container = document.getElementById('chat-history');
        if (!historyStr) {
            container.innerHTML = '<div class="text-center text-muted py-10"><?= __('history_empty') ?></div>';
            return;
        }

        try {
            const history = typeof historyStr === 'string' ? JSON.parse(historyStr) : historyStr;
            container.innerHTML = '';
            
            history.forEach(msg => {
                const isUser = (msg.role === 'user' || msg.sender === 'user');
                const content = msg.content || msg.text || '';
                
                const row = document.createElement('div');
                row.className = `message-row ${isUser ? 'user' : 'ai'}`;
                
                const bubble = document.createElement('div');
                bubble.className = `message-bubble ${isUser ? 'user' : 'ai'}`;

                const meta = document.createElement('div');
                meta.className = 'message-meta';
                meta.innerHTML = isUser ? '<?= __('chat_you') ?>' : 'AI Assistant';
                
                const text = document.createElement('div');
                text.className = 'prose';
                text.innerHTML = parseMarkdown(content);

                bubble.appendChild(meta);
                bubble.appendChild(text);
                row.appendChild(bubble);
                container.appendChild(row);
            });
            
            setTimeout(() => { container.scrollTop = container.scrollHeight; }, 50);

        } catch (e) {
            console.error(e);
            container.innerHTML = '<div class="text-center text-danger"><?= __('chat_error_parse') ?></div>';
        }
    }


    function updateDoc(id, status) {
        let reason = null;
        if (status === 'rejected') {
            reason = prompt('<?= __('prompt_reject_reason') ?>');
            if (reason === null) return;
            if (!reason.trim()) return alert('<?= __('error_reason_required') ?>');
        } else {
             if(!confirm('<?= __('confirm_approve_doc') ?>')) return;
        }

        fetch('<?= BASE_URL ?>/api/admin/doc-status', {
            method: 'POST', 
            body: JSON.stringify({ id, status, reason })
        }).then(() => loadData());
    }

    function saveNotes() {
        const notes = document.getElementById('admin-notes').value;
        fetch('<?= BASE_URL ?>/api/admin/student-notes', {
            method: 'POST',
            body: JSON.stringify({ id: studentId, notes })
        }).then(res=>res.json()).then(d => {
            if(d.success) alert('<?= __('msg_note_saved') ?>');
        });
    }

    const modal = document.getElementById('edit-modal');
    
    async function openEditModal() {
        if(!currentData) return;
        
        await loadCities();
        
        const u = currentData.user;
        const l = currentData.lead || {};
        
        document.getElementById('edit-name').value = u.full_name;
        document.getElementById('edit-email').value = u.email;
        document.getElementById('edit-phone').value = u.phone || '';
        
        document.getElementById('edit-budget').value = l.budget || '';
        document.getElementById('edit-gpa').value = l.gpa || 0;
        document.getElementById('edit-score').value = l.score || 0;
        document.getElementById('edit-status').value = l.status || 'new';
        
        const managerSelect = document.getElementById('edit-manager');
        if (currentData.managers && managerSelect.options.length <= 1) {
            currentData.managers.forEach(m => {
                const opt = document.createElement('option');
                opt.value = m.id;
                opt.textContent = m.name;
                managerSelect.appendChild(opt);
            });
        }
        document.getElementById('edit-manager').value = u.manager_id || '';

        document.getElementById('edit-enrolled-role').value = u.enrolled_role || '';
        document.getElementById('edit-city').value = u.city_id || '';
        
        if (currentData.stage && currentData.stage.step >= 5) {
            document.getElementById('edit-enrolled-role').value = 'enrolled';
        }

        modal.classList.add('active');
    }
    
    function closeEditModal() {
        modal.classList.remove('active');
    }
    
    function saveStudentDetails() {
        const payload = {
            id: studentId,
            full_name: document.getElementById('edit-name').value,
            email: document.getElementById('edit-email').value,
            phone: document.getElementById('edit-phone').value,
            
            budget: document.getElementById('edit-budget').value,
            gpa: document.getElementById('edit-gpa').value,
            score: document.getElementById('edit-score').value,
            status: document.getElementById('edit-status').value,
            
            enrolled_role: document.getElementById('edit-enrolled-role').value,
            city_id: document.getElementById('edit-city').value || null,
            manager_id: document.getElementById('edit-manager').value || null,
        };
        
        fetch('<?= BASE_URL ?>/api/admin/update-details', {
            method: 'POST',
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                closeEditModal();
                loadData();
                alert('<?= __('msg_data_updated') ?>');
            } else {
                alert('<?= __('msg_error') ?>' + (data.error || 'Unknown'));
            }
        });
    }
    
    let citiesLoaded = false;
    async function loadCities() {
        if (citiesLoaded) return; // Загружаем только один раз
        
        try {
            const res = await fetch('<?= BASE_URL ?>/api/cities/list');
            const data = await res.json();
            
            const select = document.getElementById('edit-city');
            if (data.cities && select) {
                while (select.options.length > 1) {
                    select.remove(1);
                }
                
                data.cities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.id;
                    option.textContent = `${city.name_ru} (${city.name_pl})`;
                    select.appendChild(option);
                });
                citiesLoaded = true;
            }
        } catch (error) {
            console.error('Failed to load cities:', error);
        }
    }

    function getScoreColor(s) {
        if(s >= 80) return '#16a34a';
        if(s >= 50) return '#ea580c';
        return '#dc2626';
    }

    function parseMarkdown(text) {
        if (!text) return '';
        return text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2" target="_blank">$1</a>')
            .replace(/\n/g, '<br>');
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadData();
    });

    function safeSetText(id, text) {
        const el = document.getElementById(id);
        if (el) el.textContent = text;
    }
    
    function safeSetHTML(id, html) {
        const el = document.getElementById(id);
        if (el) el.innerHTML = html;
    }
    
    function updateProgressTracker(stageData) {
        const currentStep = stageData.step || 1;
        const steps = document.querySelectorAll('.progress-step');
        const lines = document.querySelectorAll('.progress-line');
        
        steps.forEach((step, index) => {
            const stepNumber = index + 1;
            step.classList.remove('active', 'completed');
            
            if (stepNumber < currentStep) {
                step.classList.add('completed');
            } else if (stepNumber === currentStep) {
                if (currentStep >= 5) {
                    step.classList.add('completed');
                } else {
                    step.classList.add('active');
                }
            }
        });
        
        lines.forEach((line, index) => {
            line.classList.remove('completed');
            if (index + 1 < currentStep || (currentStep >= 5 && index + 1 === currentStep)) {
                line.classList.add('completed');
            }
        });
    }
    
    function renderPage(data) {
        const u = data.user;
        const l = data.lead || {};
        
        document.title = `${u.full_name} | Admin`;
        safeSetText('page-title', u.full_name);
        safeSetText('student-id-display', `#${u.id}`);
        safeSetText('student-email-display', u.email);

        safeSetText('avatar-letter', u.full_name.charAt(0));
        safeSetText('profile-name', u.full_name);
        safeSetText('profile-email', u.email);
        safeSetText('profile-phone', u.phone || '<?= __('no_phone') ?>');
        
        const regDate = u.created_at ? new Date(u.created_at).toLocaleDateString() : '<?= __('unknown_date') ?>';
        safeSetText('profile-reg', regDate !== 'Invalid Date' ? regDate : '<?= __('unknown_date') ?>');
        
        const adminNotes = document.getElementById('admin-notes');
        if(adminNotes) adminNotes.value = u.admin_notes || '';

        const status = (l.status || 'new').toUpperCase();
        const score = l.score || 0;
        let badgeClass = 'new';
        if(status === 'HOT') badgeClass = 'hot';
        if(status === 'COLD') badgeClass = 'cold';
        if(status === 'CONVERTED') badgeClass = 'converted';
        
        safeSetHTML('profile-badge', `<span class="badge ${badgeClass}">${status}</span>`);

        safeSetText('stat-score', score + '%');
        const scoreEl = document.getElementById('stat-score');
        if(scoreEl) scoreEl.style.color = getScoreColor(score);
        
        safeSetText('stat-budget', l.budget || '-');
        safeSetText('stat-gpa', l.gpa || '-');
        safeSetText('stat-lang', l.language_level || '-');
        
        if (u.city_id) {
            fetch('/study/public/api/cities/list')
                .then(res => res.json())
                .then(data => {
                    const city = data.cities?.find(c => c.id == u.city_id);
                    safeSetText('stat-city', city ? city.name_ru : 'ID: ' + u.city_id);
                })
                .catch(() => safeSetText('stat-city', 'ID: ' + u.city_id));
        } else {
            safeSetText('stat-city', 'Не выбран');
        }
        
        if (u.enrolled_role === 'enrolled') {
            safeSetHTML('stat-enrolled', '<span style="color: #16a34a; font-weight: 600;"><?= __('status_enrolled_ok') ?></span>');
        } else {
            safeSetText('stat-enrolled', '<?= __('status_not_enrolled') ?>');
        }

        renderDocs(data.documents);

        renderChat(l.chat_history);
        
        if (data.stage && data.stage.stage === 'qualified') {
            const quickActions = document.getElementById('quick-actions');
            if (quickActions) {
                quickActions.style.display = 'flex';
                const btnWhatsApp = document.getElementById('btn-whatsapp');
                const btnEmail = document.getElementById('btn-email');
                const phone = u.phone ? u.phone.replace(/[^0-9]/g, '') : '';
                if (btnWhatsApp && phone) {
                   btnWhatsApp.href = `https://wa.me/${phone}?text=Здравствуйте! Kettik Study - мы готовы помочь с поступлением в Польшу`;
                }
                if (btnEmail) {
                    btnEmail.href = `mailto:${u.email}?subject=Kettik Study - Консультация по поступлению&body=Здравствуйте, ${u.full_name}!`;
                }
            }
        }
    }

</script>
