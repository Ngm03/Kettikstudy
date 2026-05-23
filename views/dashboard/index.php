<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('dashboard_title') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/chat.css">
</head>
<body>
    <button id="sidebar-toggle" style="position:fixed; top:1rem; left:1rem; z-index:101; display:none;">☰</button>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Logo" style="height: 40px; width: auto; border-radius: 8px;">
            <span style="font-weight: 700; font-size: 1.1rem; color: #111827;">Kettik Study</span>
        </div>
        
        <nav class="nav-menu">
            <a href="#" class="nav-item active">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                <?= __('menu_main') ?>
            </a>
            <a href="#" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                <?= __('menu_my_docs') ?>
            </a>
            <a href="#" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                <?= __('status_app') ?>
            </a>
            <a href="#" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                <?= __('menu_profile') ?>
            </a>
            <a href="<?= BASE_URL ?>/admin/dashboard" class="nav-item" id="admin-link" style="display: none; color: #dc2626;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                <?= __('menu_admin') ?>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-mini-profile">
                <div class="avatar" id="user-avatar">?</div>
                <div style="flex:1;">
                    <div style="font-weight:600; font-size:0.875rem;" id="user-name">Загрузка...</div>
                    <div style="font-size:0.75rem; color:#6b7280; cursor:pointer;" onclick="logout()"><?= __('logout') ?></div>
                </div>
            </div>
        </div>
    </aside>

    <main class="main-content">
        <style>
            .welcome-card {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 16px;
                padding: 2rem;
                color: white;
                margin-bottom: 2rem;
                box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
                position: relative;
                overflow: hidden;
            }
            .welcome-card::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -20%;
                width: 400px;
                height: 400px;
                background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
                border-radius: 50%;
            }
            .welcome-content {
                display: flex;
                align-items: center;
                gap: 2rem;
                position: relative;
                z-index: 1;
            }
            .manager-photo {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                border: 3px solid rgba(255, 255, 255, 0.3);
                object-fit: cover;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            }
            .welcome-text h2 {
                margin: 0 0 0.5rem 0;
                font-size: 1.5rem;
                font-weight: 700;
            }
            .welcome-text p {
                margin: 0;
                opacity: 0.95;
                font-size: 1rem;
            }
            .quick-links {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }
            .quick-link-card {
                background: white;
                border-radius: 12px;
                padding: 1.5rem;
                text-decoration: none;
                color: #1f2937;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                transition: all 0.3s;
                display: flex;
                align-items: flex-start;
                gap: 1rem;
            }
            .quick-link-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            }
            .quick-link-icon {
                width: 48px;
                height: 48px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .quick-link-icon svg {
                width: 24px;
                height: 24px;
                color: white;
            }
            .quick-link-content h3 {
                margin: 0 0 0.5rem 0;
                font-size: 1.125rem;
                font-weight: 600;
            }
            .quick-link-content p {
                margin: 0;
                color: #6b7280;
                font-size: 0.875rem;
            }
            @media (max-width: 768px) {
                .welcome-content {
                    flex-direction: column;
                    text-align: center;
                }
                .quick-links {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <div class="welcome-card">
            <div class="welcome-content">
                <img src="https://i.pravatar.cc/150?img=<?= rand(1, 70) ?>" alt="Manager" class="manager-photo">
                <div class="welcome-text">
                    <h2><?= __('welcome_user') ?>, <?= htmlspecialchars($user['full_name']) ?>!</h2>
                    <p><?= __('welcome_desc') ?></p>
                </div>
            </div>
        </div>

        <div class="quick-links">
            <a href="<?= BASE_URL ?>/dashboard/profile" class="quick-link-card">
                <div class="quick-link-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="quick-link-content">
                    <h3><?= __('quick_profile') ?></h3>
                    <p><?= __('quick_profile_desc') ?></p>
                </div>
            </a>

            <a href="<?= BASE_URL ?>/dashboard/documents" class="quick-link-card">
                <div class="quick-link-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="quick-link-content">
                    <h3><?= __('quick_docs') ?></h3>
                    <p><?= __('quick_docs_desc') ?></p>
                </div>
            </a>

            <a href="<?= BASE_URL ?>/dashboard/contract" class="quick-link-card">
                <div class="quick-link-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="quick-link-content">
                    <h3><?= __('quick_contract') ?></h3>
                    <p><?= __('quick_contract_desc') ?></p>
                </div>
            </a>

            <a href="<?= BASE_URL ?>/chat" class="quick-link-card">
                <div class="quick-link-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
                <div class="quick-link-content">
                    <h3><?= __('quick_chat') ?></h3>
                    <p><?= __('quick_chat_desc') ?></p>
                </div>
            </a>
        </div>

        <div class="card" style="margin-bottom: 2rem;">
            <h3><?= __('progress_title') ?></h3>
            <div class="progress-steps">
                <div class="step completed">
                    <div class="step-circle">&#10003;</div>
                    <div class="step-label"><?= __('step_registration') ?></div>
                </div>
                <div class="step active">
                    <div class="step-circle">2</div>
                    <div class="step-label"><?= __('step_upload_docs') ?></div>
                </div>
                <div class="step">
                    <div class="step-circle">3</div>
                    <div class="step-label"><?= __('step_review') ?></div>
                </div>
                <div class="step">
                    <div class="step-circle">4</div>
                    <div class="step-label"><?= __('step_submit_uni') ?></div>
                </div>
                <div class="step">
                    <div class="step-circle">5</div>
                    <div class="step-label"><?= __('step_admission') ?></div>
                </div>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="card">
                <h3><?= __('status_app') ?></h3>
                <div class="stat-value"><?= __('status_processing') ?></div>
                <p class="stat-label"><?= __('status_processing_desc') ?></p>
            </div>

            <div class="card" id="profile-section" style="grid-column: span 2;">
                <div class="section-header" style="display:flex; justify-content:space-between; align-items:center;">
                     <h3><?= __('student_form_title') ?></h3>
                     <span class="badge" id="profile-status" style="background:#f3f4f6; color:#6b7280; padding:2px 8px; border-radius:4px; font-size:0.75rem;"><?= __('not_filled') ?></span>
                </div>
                <p class="stat-label" style="margin-bottom: 1rem;"><?= __('form_notice') ?></p>
                
                <form id="profile-form" onsubmit="event.preventDefault(); saveProfile();">
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem;">
                        <div class="form-group">
                            <label class="form-label" style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.5rem;"><?= __('iin_label') ?></label>
                            <input type="text" name="iin" class="form-input" style="width:100%; padding:0.6rem; border:1px solid #e5e7eb; border-radius:6px;" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.5rem;"><?= __('passport_label') ?></label>
                            <input type="text" name="passport_number" class="form-input" style="width:100%; padding:0.6rem; border:1px solid #e5e7eb; border-radius:6px;" required>
                        </div>
                         <div class="form-group">
                            <label class="form-label" style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.5rem;"><?= __('issued_by_label') ?></label>
                            <input type="text" name="passport_authority" class="form-input" style="width:100%; padding:0.6rem; border:1px solid #e5e7eb; border-radius:6px;" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.5rem;"><?= __('issue_date_label') ?></label>
                            <input type="date" name="passport_issue_date" class="form-input" style="width:100%; padding:0.6rem; border:1px solid #e5e7eb; border-radius:6px;" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.5rem;"><?= __('address_label') ?></label>
                            <input type="text" name="address_registration" class="form-input" style="width:100%; padding:0.6rem; border:1px solid #e5e7eb; border-radius:6px;" required>
                        </div>
                         <div class="form-group">
                            <label class="form-label" style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.5rem;"><?= __('phone_label') ?></label>
                            <input type="text" name="phone" id="user-phone-input" class="form-input" style="width:100%; padding:0.6rem; border:1px solid #e5e7eb; border-radius:6px;" required>
                        </div>
                    </div>
                     <div style="margin-top:1.5rem; display:flex; justify-content:flex-end;">
                        <button type="submit" class="btn btn-primary"><?= __('save_data') ?></button>
                    </div>
                </form>
            </div>

            <div class="card" style="grid-column: span 3;">
                <h3><?= __('menu_my_docs') ?></h3>
                <p class="stat-label" style="margin-bottom: 1rem;"><?= __('upload_passport_scan') ?></p>
                
                <div style="display:flex; gap:10px; margin-bottom:1.5rem; flex-wrap:wrap;">
                    <select id="doc-type" class="form-input" style="padding:0.5rem; border:1px solid #d1d5db; border-radius:6px;">
                        <option value="passport"><?= __('doc_passport') ?></option>
                        <option value="transcript"><?= __('doc_transcript') ?></option>
                        <option value="certificate"><?= __('doc_certificate') ?></option>
                        <option value="other"><?= __('doc_other') ?></option>
                    </select>
                    <input type="file" id="doc-file" style="display:none;" onchange="document.getElementById('file-label').textContent = this.files[0].name">
                    <label for="doc-file" id="file-label" class="btn btn-outline" style="padding:0.5rem 1rem; cursor:pointer;"><?= __('choose_file') ?></label>
                    <button class="btn btn-primary" onclick="uploadDocument()"><?= __('upload_btn') ?></button>
                </div>

                <ul id="docs-list" style="display:flex; flex-direction:column; gap:0.5rem;">
                    <li style="color:#6b7280; font-size:0.875rem;"><?= __('loading_list') ?></li>
                </ul>
            </div>

            <div class="card" style="grid-column: span 3; background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%); border: 1px solid #bfdbfe;">
                <div style="display:flex; align-items:center; gap:20px; flex-wrap:wrap;">
                    <img src="https://i.pravatar.cc/150?img=<?= rand(20, 50) ?>" style="width:80px; height:80px; border-radius:50%;" alt="Manager">
                    <div style="flex:1;">
                        <h3 style="margin:0; color:#1e3a8a;"><?= __('personal_manager') ?>: Алина</h3>
                        <p style="margin:0.5rem 0; color:#4b5563; font-size:0.9rem;"><?= __('manager_desc') ?></p>
                        
                        <div style="display:flex; gap:10px; margin-top:1rem; flex-wrap: wrap;">
                            <button class="btn btn-primary" onclick="requestCall()" style="background:#2563eb; border-color:#2563eb; display: flex; align-items: center; gap: 0.5rem;">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <?= __('request_call') ?>
                            </button>
                             <a href="https://wa.me/77771234567?text=Здравствуйте, я студент Kettik Study, нужна помощь" target="_blank" class="btn btn-outline" style="background:#dcfce7; color:#166534; border-color:#86efac; text-decoration:none; display: flex; align-items: center; gap: 0.5rem;">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                                <?= __('write_whatsapp') ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../chat/widget.php'; ?>
    <script src="<?= BASE_URL ?>/assets/js/chat.js"></script>

    <script>
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        fetch('<?= BASE_URL ?>/api/auth/me')
            .then(res => {
                if (!res.ok) window.location.href = '<?= BASE_URL ?>/login';
                return res.json();
            })
            .then(data => {
                if (data.user) {
                    const name = data.user.full_name;
                    document.getElementById('user-name').textContent = name;
                    document.getElementById('user-avatar').textContent = name.charAt(0).toUpperCase();

                    if (data.user.role === 'admin') {
                        document.getElementById('admin-link').style.display = 'flex';
                    }
                }
            })
            .catch(() => window.location.href = '<?= BASE_URL ?>/login');

        function logout() {
            fetch('<?= BASE_URL ?>/api/auth/logout', { method: 'POST' })
                .then(() => window.location.href = '<?= BASE_URL ?>/login');
        }

        const docsList = document.getElementById('docs-list');

        function loadDocuments() {
            fetch('<?= BASE_URL ?>/api/documents/list')
                .then(res => res.json())
                .then(data => {
                    docsList.innerHTML = '';
                    
                    if (data.status) {
                    }

                    if (data.documents && data.documents.length > 0) {
                        data.documents.forEach(doc => {
                            const li = document.createElement('li');
                            li.style.cssText = 'display:flex; justify-content:space-between; align-items:center; padding:0.75rem; background:#f9fafb; border-radius:6px; border:1px solid #e5e7eb; margin-bottom:0.5rem;';
                            
                            let statusColor = '#fbbf24'; // pending
                            let statusIcon = '🕒';
                            if (doc.status === 'approved') { statusColor = '#10b981'; statusIcon = '✔'; }
                            if (doc.status === 'rejected') { statusColor = '#ef4444'; statusIcon = '✖'; }

                            let commentHtml = '';
                            if (doc.status === 'rejected' && doc.rejection_reason) {
                                commentHtml = `<div style="font-size:0.75rem; color:#ef4444; margin-top:4px;">Причина: ${escapeHtml(doc.rejection_reason)}</div>`;
                            }

                            li.innerHTML = `
                                <div style="flex:1;">
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <div style="width:24px; height:24px; border-radius:50%; background:${statusColor}20; color:${statusColor}; display:flex; align-items:center; justify-content:center; font-size:0.8rem;">${statusIcon}</div>
                                        <div>
                                            <div style="font-weight:500;">${getTypeName(doc.type)}</div>
                                            <div style="font-size:0.75rem; color:#6b7280;">${escapeHtml(doc.original_name)}</div>
                                        </div>
                                    </div>
                                    ${commentHtml}
                                </div>
                                <button onclick="deleteDocument(${doc.id})" style="color:#ef4444; background:none; border:none; cursor:pointer; padding:5px;">&#10005;</button>
                            `;
                            docsList.appendChild(li);
                        });
                    } else {
                        docsList.innerHTML = '<li style="color:#6b7280; font-size:0.875rem;">Нет загруженных документов</li>';
                    }
                });
        }

        function updateProgress(step) {
            const steps = document.querySelectorAll('.step');
            steps.forEach((el, index) => {
                const stepNum = index + 1;
                el.classList.remove('active', 'completed');
                
                if (stepNum < step) {
                    el.classList.add('completed');
                } else if (stepNum === step) {
                    if (step >= 5) {
                        el.classList.add('completed');
                    } else {
                        el.classList.add('active');
                    }
                }
            });
        }
        
        function loadProgress() {
            fetch('<?= BASE_URL ?>/api/profile/progress')
                .then(res => res.json())
                .then(data => {
                    if (data.stage) {
                        updateProgress(data.stage.step || 1);
                        
                        const statusMap = {
                            1: { label: 'Новая заявка', desc: 'Заполните анкету и загрузите документы' },
                            2: { label: 'Прогретый лид', desc: 'Наш менеджер обрабатывает вашу заявку' },
                            3: { label: '<?= __('quick_docs') ?> на проверке', desc: 'Менеджер проверяет ваши документы' },
                            4: { label: '<?= __('quick_contract') ?> готов', desc: 'Ознакомьтесь с договором и подпишите его' },
                            5: { label: '✅ Зачислен!', desc: 'Поздравляем! Вы зачислены в университет' }
                        };
                        
                        const status = statusMap[data.stage.step] || statusMap[1];
                        const statValueEl = document.querySelector('.stat-value');
                        const statLabelEl = document.querySelector('.stat-label');
                        
                        if (statValueEl) statValueEl.textContent = status.label;
                        if (statLabelEl) statLabelEl.textContent = status.desc;
                    } else if (data.error) {
                        console.error('loadProgress: API error:', data.error);
                    }
                })
                .catch(err => {
                    console.error('loadProgress: Fetch error:', err);
                });
        }

        function getTypeName(type) {
            const types = { 'passport': 'Паспорт', 'transcript': 'Аттестат', 'certificate': 'Сертификат', 'other': 'Другое' };
            return types[type] || type;
        }

        async function uploadDocument() {
            const fileInput = document.getElementById('doc-file');
            const typeSelect = document.getElementById('doc-type');
            const file = fileInput.files[0];

            if (!file) {
                alert('Выберите файл!');
                return;
            }

            const formData = new FormData();
            formData.append('file', file);
            formData.append('type', typeSelect.value);

            const btn = document.querySelector('button[onclick="uploadDocument()"]');
            btn.textContent = 'Загрузка...';
            btn.disabled = true;

            try {
                const res = await fetch('<?= BASE_URL ?>/api/documents/upload', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();

                if (res.ok) {
                    fileInput.value = '';
                    document.getElementById('file-label').textContent = 'Выбрать файл';
                    loadDocuments();
                } else {
                    alert(data.error || 'Ошибка загрузки');
                }
            } catch (e) {
                alert('Ошибка соединения');
            } finally {
                btn.textContent = 'Загрузить';
                btn.disabled = false;
            }
        }

        function deleteDocument(id) {
            if (!confirm('Удалить документ?')) return;

            fetch('<?= BASE_URL ?>/api/documents/delete', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            }).then(() => loadDocuments());
        }

        function loadProfile() {
            fetch('<?= BASE_URL ?>/api/profile/details')
                .then(res => res.json())
                .then(data => {
                    if (data.lead && (data.lead.status === 'urgent' || data.lead.status === 'processing')) {
                        const btn = document.querySelector('button[onclick="requestCall()"]');
                        if(btn) {
                            btn.innerHTML = '✅ Ждем звонка';
                            btn.style.background = '#10b981';
                            btn.style.borderColor = '#10b981';
                            btn.disabled = true;
                        }
                    }
                });
        }

        function saveProfile() {
            const form = document.getElementById('profile-form');
            const data = {
                iin: form.elements['iin'].value,
                passport_number: form.elements['passport_number'].value,
                passport_authority: form.elements['passport_authority'].value,
                passport_issue_date: form.elements['passport_issue_date'].value,
                address_registration: form.elements['address_registration'].value,
                phone: form.elements['phone'].value
            };

            const btn = form.querySelector('button');
            const originalText = btn.textContent;
            btn.textContent = 'Сохранение...';
            btn.disabled = true;

            fetch('<?= BASE_URL ?>/api/profile/update', {
                method: 'POST',
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    alert('Данные успешно сохранены!');
                    document.getElementById('profile-status').textContent = 'Заполнено';
                    document.getElementById('profile-status').style.color = '#10b981';
                    document.getElementById('profile-status').style.background = '#d1fae5';
                } else {
                    alert('Ошибка: ' + data.error);
                }
            })
            .finally(() => {
                btn.textContent = originalText;
                btn.disabled = false;
            });
        }

        function requestCall() {
            const btn = document.querySelector('button[onclick="requestCall()"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳ Отправка...';
            btn.disabled = true;

            fetch('<?= BASE_URL ?>/api/leads/request-call', { method: 'POST' })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    alert('Заявка принята! Менеджер свяжется с вами в течение 15 минут.');
                    btn.innerHTML = '✅ Ждем звонка';
                    btn.style.background = '#10b981';
                    btn.style.borderColor = '#10b981';
                } else {
                    alert('Ошибка: ' + data.error);
                     btn.innerHTML = originalText;
                     btn.disabled = false;
                }
            })
            .catch(() => {
                alert('Ошибка сервера');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }

        loadDocuments();
        loadProgress();
        
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle');
        
        if (window.innerWidth < 768) {
            toggleBtn.style.display = 'block';
            toggleBtn.onclick = () => {
                sidebar.classList.toggle('open');
            };
        }
    </script>
</body>
</html>
