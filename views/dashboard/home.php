<div class="page-header">
    <h1 class="page-title"><?= __('application_overview') ?></h1>
    <p class="page-subtitle"><?= __('track_status') ?></p>
</div>

<div class="dashboard-home-grid">
    
    <div class="card">
        <h3 class="card-title"><?= __('admission_path') ?></h3>
        
        <div class="timeline">
            <div id="timeline-container">
                <p><?= __('loading') ?></p>
            </div>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        
        <div class="card">
            <h3 class="card-title"><?= __('current_status') ?></h3>
            <span class="badge badge-blue" id="main-status-badge"><?= __('in_progress') ?></span>
            <p style="margin-top: 1rem; font-size: 0.9rem; color: var(--text-muted);" id="main-status-desc">
                <?= __('docs_review') ?>
            </p>
        </div>

        <div class="card" id="payment-card" style="display: none; border-left: 4px solid #3b82f6;">
            <h3 class="card-title">Оплата услуг</h3>
            <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem;">
                Для завершения поступления загрузите чек об оплате услуг.
            </p>
            
            <div id="payment-form-container">
                <input type="number" id="payment-amount" placeholder="Сумма (например: 150000)" style="width: 100%; padding: 8px; margin-bottom: 8px; border: 1px solid var(--border); border-radius: 6px;">
                
                <div class="upload-zone" id="payment-upload-zone" onclick="document.getElementById('receipt-file').click()" style="margin-bottom: 1rem; border: 2px dashed var(--border); padding: 1.5rem; text-align: center; border-radius: 8px; cursor: pointer;">
                    <input type="file" id="receipt-file" style="display: none;" accept="image/jpeg,image/png,application/pdf" onchange="handleReceiptSelect(this)">
                    <div style="font-weight: 600; color: var(--primary);" id="receipt-upload-text">Нажмите, чтобы выбрать файл чека</div>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">JPG, PNG или PDF (до 5 МБ)</div>
                </div>
                
                <button class="btn btn-primary" id="btn-submit-receipt" onclick="submitReceipt()" disabled style="width: 100%; opacity: 0.5;">Отправить чек на проверку</button>
            </div>
            
            <div id="payment-status-container" style="display: none; padding: 1rem; background: #f0fdf4; border-radius: 8px; margin-top: 1rem;">
                <div style="font-weight: 600; color: #166534; display: flex; align-items: center; gap: 8px;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Чек загружен и отправлен на проверку
                </div>
                <div style="font-size: 0.85rem; color: #166534; margin-top: 4px;" id="payment-status-text">Ожидайте подтверждения менеджера.</div>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title"><?= __('your_manager') ?></h3>
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div class="manager-row">
                    <div id="manager-avatar-container">
                        <div class="manager-initials-lg" id="manager-initials">?</div>
                        <img src="" class="manager-img" id="manager-photo" style="display: none;">
                    </div>
                    <div class="manager-info">
                        <h4 style="margin:0; font-weight:600;" id="manager-name"><?= __('assigning') ?></h4>
                        <span style="font-size:0.85rem; color:var(--text-muted);"><?= __('personal_consultant') ?></span>
                    </div>
                </div>
                
                <div class="manager-actions">
                    <button class="btn btn-whatsapp" onclick="openManagerWhatsApp()">
                         <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg>
                        WhatsApp
                    </button>
                    <button class="btn btn-primary" style="flex:1;" onclick="requestCall()">
                        <?= __('request_call') ?>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    const stepsConfig = [
        { id: 1, label: '<?= __('step_register') ?>', desc: '<?= __('step_register_desc') ?>' },
        { id: 2, label: '<?= __('step_docs') ?>', desc: '<?= __('step_docs_desc') ?>' },
        { id: 3, label: '<?= __('step_review') ?>', desc: '<?= __('step_review_desc') ?>' },
        { id: 4, label: '<?= __('step_apply') ?>', desc: '<?= __('step_apply_desc') ?>' },
        { id: 5, label: '<?= __('step_enroll') ?>', desc: '<?= __('step_enroll_desc') ?>' }
    ];

    let currentStep = 1;
    let managerPhone = '';
    let studentName = '';

    function init() {
        fetchData();
    }

    function fetchData() {
        fetch('<?= BASE_URL ?>/api/profile/progress')
            .then(r => r.json())
            .then(data => {
                if(data.stage) {
                    currentStep = data.stage.step;
                    renderTimeline();
                    updateStatusCard();
                    
                    // Show payment card if step is 4 or 5
                    if (currentStep >= 4) {
                        const pc = document.getElementById('payment-card');
                        if (pc) pc.style.display = 'block';
                        checkReceiptStatus();
                    }
                }
            });

        fetch('<?= BASE_URL ?>/api/profile/details')
            .then(r => r.json())
            .then(data => {
                if(data.user) studentName = data.user.full_name;
                
                if(data.details && data.details.manager_name) {
                    document.getElementById('manager-name').textContent = data.details.manager_name;
                    managerPhone = data.details.manager_phone || '';
                    
                    if(data.details.manager_photo) {
                        const img = document.getElementById('manager-photo');
                        img.src = `<?= BASE_URL ?>/uploads/managers/${data.details.manager_photo}`;
                        img.style.display = 'block';
                        document.getElementById('manager-initials').style.display = 'none';
                    } else {
                        const initials = data.details.manager_name.split(' ').map(n => n[0]).join('').substring(0,2);
                        document.getElementById('manager-initials').textContent = initials;
                    }
                }
            });
    }

    function renderTimeline() {
        const container = document.getElementById('timeline-container');
        container.innerHTML = '';

        stepsConfig.forEach((step, index) => {
            const stepNum = index + 1;
            let statusClass = '';
            
            if (stepNum < currentStep || (currentStep === 5 && stepNum === 5)) {
                statusClass = 'completed';
            } else if (stepNum === currentStep) {
                statusClass = 'active';
            }

            const item = document.createElement('div');
            item.className = `timeline-item ${statusClass}`;
            
            let markerContent = '';
            if (statusClass === 'completed') {
                markerContent = `<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>`;
            }

            item.innerHTML = `
                <div class="timeline-marker">${markerContent}</div>
                <div class="timeline-content">
                    <h4>${step.label}</h4>
                    <p>${step.desc}</p>
                </div>
            `;
            container.appendChild(item);
        });
    }
    
    function updateStatusCard() {
        const statusMap = {
            1: '<?= __('status_new') ?>',
            2: '<?= __('status_collect') ?>',
            3: '<?= __('status_check') ?>',
            4: '<?= __('status_wait') ?>',
            5: '<?= __('status_enrolled') ?>'
        };
        const statusText = statusMap[currentStep] || '<?= __('in_progress') ?>';
        document.getElementById('main-status-badge').textContent = statusText;
        
        if (currentStep === 5) {
             document.getElementById('main-status-badge').className = 'badge badge-green';
             document.getElementById('main-status-desc').textContent = '<?= __('status_enrolled_desc') ?>';
        }
    }

    function openManagerWhatsApp() {
        const phone = managerPhone.replace(/\D/g, '') || '77777777777';
        const text = `<?= __('whatsapp_hello') ?>`.replace('{name}', studentName);
        window.open(`https://wa.me/${phone}?text=${encodeURIComponent(text)}`, '_blank');
    }

    function requestCall() {
        alert('<?= __('call_requested') ?>');
    }

    function checkReceiptStatus() {
        fetch('<?= BASE_URL ?>/api/payments/my-receipts')
            .then(res => res.json())
            .then(data => {
                if (data.success && data.receipts && data.receipts.length > 0) {
                    const latest = data.receipts[0];
                    const formContainer = document.getElementById('payment-form-container');
                    const statusContainer = document.getElementById('payment-status-container');
                    const statusText = document.getElementById('payment-status-text');
                    
                    if (latest.status === 'pending') {
                        formContainer.style.display = 'none';
                        statusContainer.style.display = 'block';
                        statusContainer.style.background = '#fffbeb';
                        statusContainer.style.color = '#b45309';
                        statusText.style.color = '#b45309';
                        statusText.innerHTML = 'Чек на проверке у менеджера. <a href="<?= BASE_URL ?>/api/payments/view-receipt?id=' + latest.id + '" target="_blank" style="color: inherit; text-decoration: underline;">Посмотреть файл</a>';
                        statusContainer.querySelector('div').style.color = '#b45309';
                    } else if (latest.status === 'approved') {
                        formContainer.style.display = 'none';
                        statusContainer.style.display = 'block';
                        statusContainer.style.background = '#f0fdf4';
                        statusText.innerHTML = 'Оплата подтверждена! Вы зачислены.';
                    } else if (latest.status === 'rejected') {
                        // Allow re-upload
                        formContainer.style.display = 'block';
                        statusContainer.style.display = 'block';
                        statusContainer.style.background = '#fef2f2';
                        statusContainer.querySelector('div').style.color = '#991b1b';
                        statusContainer.querySelector('div').innerHTML = '❌ Ваш чек отклонен';
                        statusText.style.color = '#991b1b';
                        statusText.textContent = 'Причина: ' + (latest.rejection_reason || 'Обратитесь к менеджеру');
                    }
                }
            });
    }

    function handleReceiptSelect(input) {
        if (input.files.length > 0) {
            document.getElementById('receipt-upload-text').textContent = input.files[0].name;
            const btn = document.getElementById('btn-submit-receipt');
            btn.removeAttribute('disabled');
            btn.style.opacity = '1';
        }
    }

    function submitReceipt() {
        const fileInput = document.getElementById('receipt-file');
        const amount = document.getElementById('payment-amount').value;
        const file = fileInput.files[0];
        
        if (!file) return;

        const formData = new FormData();
        formData.append('file', file);
        if (amount) formData.append('amount', amount);

        const btn = document.getElementById('btn-submit-receipt');
        btn.innerHTML = 'Отправка...';
        btn.disabled = true;

        fetch('<?= BASE_URL ?>/api/payments/upload-receipt', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                checkReceiptStatus();
            } else {
                alert('Ошибка: ' + (data.error || 'Не удалось загрузить чек'));
                btn.innerHTML = 'Отправить чек на проверку';
                btn.disabled = false;
            }
        })
        .catch(err => {
            alert('Ошибка соединения');
            btn.innerHTML = 'Отправить чек на проверку';
            btn.disabled = false;
        });
    }

    // Initialize receipt status check
    document.addEventListener('DOMContentLoaded', () => {
        // Show payment card if step >= 4 (Contract/Wait or Enrolled)
        if (currentStep >= 4) {
            document.getElementById('payment-card').style.display = 'block';
            checkReceiptStatus();
        }
    });

    init();
</script>
