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

    init();
</script>
