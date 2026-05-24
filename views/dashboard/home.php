<div class="mb-8">
    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight"><?= __('application_overview') ?></h1>
    <p class="text-sm md:text-base text-gray-500 mt-2 font-medium"><?= __('track_status') ?></p>
</div>

<div class="flex flex-col lg:grid lg:grid-cols-3 gap-8">
    
    <!-- LEFT COLUMN: TIMELINE -->
    <div class="lg:col-span-2 order-2 lg:order-1 flex flex-col gap-6">
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-8 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <?= __('admission_path') ?>
            </h3>
            
            <div class="relative pl-4 md:pl-8">
                <!-- Vertical Background Line -->
                <div class="absolute left-[27px] md:left-[43px] top-6 bottom-6 w-0.5 bg-gray-100 rounded-full z-0"></div>
                <!-- Dynamic gradient line overlay will be handled in JS -->
                
                <div id="timeline-container" class="relative z-10 flex flex-col gap-8">
                    <p class="text-sm text-gray-500 flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <?= __('loading') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: STATUS, MANAGER, PAYMENT -->
    <div class="lg:col-span-1 order-1 lg:order-2 flex flex-col gap-6">
        
        <!-- Current Status -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4"><?= __('current_status') ?></h3>
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-blue-50 text-blue-600 border border-blue-100 text-sm font-bold" id="main-status-badge">
                <?= __('in_progress') ?>
            </span>
            <p class="mt-4 text-sm font-medium text-gray-500 leading-relaxed" id="main-status-desc">
                <?= __('docs_review') ?>
            </p>
        </div>

        <!-- Manager Card -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-bl-full -z-10"></div>
            
            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-5"><?= __('your_manager') ?></h3>
            
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-extrabold text-xl shadow-sm border border-indigo-100/50 flex-shrink-0" id="manager-initials-container">
                    <span id="manager-initials">?</span>
                </div>
                <img src="" class="w-16 h-16 rounded-2xl object-cover shadow-sm hidden border border-gray-100 flex-shrink-0" id="manager-photo">
                
                <div>
                    <h4 class="text-lg font-bold text-gray-900 leading-tight" id="manager-name"><?= __('assigning') ?></h4>
                    <span class="text-xs font-semibold text-indigo-600/80 uppercase tracking-wide mt-1 block"><?= __('personal_consultant') ?></span>
                </div>
            </div>
            
            <div class="flex flex-col gap-3">
                <button class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-bold text-white bg-emerald-500 hover:bg-emerald-600 shadow-lg shadow-emerald-500/30 transition-all transform hover:-translate-y-0.5" onclick="openManagerWhatsApp()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg>
                    WhatsApp
                </button>
                <button class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors" onclick="requestCall()">
                    <?= __('request_call') ?>
                </button>
            </div>
        </div>

        <!-- Payment Card -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border-2 border-blue-500/20 hidden relative overflow-hidden" id="payment-card">
            <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
            
            <h3 class="text-lg font-bold text-gray-900 mb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                Оплата услуг
            </h3>
            <p class="text-sm font-medium text-gray-500 mb-5 leading-relaxed">
                Для завершения поступления загрузите чек об оплате услуг.
            </p>
            
            <div id="payment-form-container">
                <input type="number" id="payment-amount" placeholder="Сумма (например: 150000)" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-medium text-gray-900 placeholder-gray-400 mb-4 transition-all">
                
                <div class="border-2 border-dashed border-gray-300 hover:border-blue-500 bg-gray-50 hover:bg-blue-50/50 transition-all rounded-2xl p-6 text-center cursor-pointer mb-5 group" id="payment-upload-zone" onclick="document.getElementById('receipt-file').click()">
                    <input type="file" id="receipt-file" class="hidden" accept="image/jpeg,image/png,application/pdf" onchange="handleReceiptSelect(this)">
                    <div class="w-12 h-12 bg-white rounded-full shadow-sm border border-gray-100 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    </div>
                    <div class="font-bold text-gray-700 group-hover:text-blue-600 transition-colors" id="receipt-upload-text">Нажмите или перетащите чек</div>
                    <div class="font-medium text-xs text-gray-400 mt-1">JPG, PNG или PDF (до 5 МБ)</div>
                </div>
                
                <button class="w-full px-4 py-3 rounded-xl font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/30 transition-all disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed" id="btn-submit-receipt" onclick="submitReceipt()" disabled>
                    Отправить чек на проверку
                </button>
            </div>
            
            <div id="payment-status-container" class="hidden p-5 bg-emerald-50 border border-emerald-100 rounded-2xl mt-4">
                <div class="font-bold text-emerald-700 flex items-center gap-2 mb-1" id="payment-status-title">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Чек загружен и отправлен
                </div>
                <div class="font-medium text-sm text-emerald-600/80" id="payment-status-text">Ожидайте подтверждения менеджера.</div>
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
        initDragAndDrop();
    }

    function initDragAndDrop() {
        const zone = document.getElementById('payment-upload-zone');
        if(!zone) return;

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            zone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults (e) { e.preventDefault(); e.stopPropagation(); }

        ['dragenter', 'dragover'].forEach(eventName => {
            zone.addEventListener(eventName, () => {
                zone.classList.add('border-blue-500', 'bg-blue-50/50');
                zone.classList.remove('border-gray-300', 'bg-gray-50');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            zone.addEventListener(eventName, () => {
                zone.classList.remove('border-blue-500', 'bg-blue-50/50');
                zone.classList.add('border-gray-300', 'bg-gray-50');
            }, false);
        });

        zone.addEventListener('drop', (e) => {
            let dt = e.dataTransfer;
            let files = dt.files;
            if(files.length > 0) {
                const input = document.getElementById('receipt-file');
                input.files = files;
                handleReceiptSelect(input);
            }
        }, false);
    }

    function fetchData() {
        fetch('<?= BASE_URL ?>/api/profile/progress')
            .then(r => r.json())
            .then(data => {
                if(data.stage) {
                    currentStep = data.stage.step;
                    renderTimeline();
                    updateStatusCard();
                    
                    if (currentStep >= 4) {
                        const pc = document.getElementById('payment-card');
                        if (pc) pc.classList.remove('hidden');
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
                        img.classList.remove('hidden');
                        document.getElementById('manager-initials-container').classList.add('hidden');
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
        
        let completedSteps = 0;

        stepsConfig.forEach((step, index) => {
            const stepNum = index + 1;
            let status = 'future';
            
            if (stepNum < currentStep || (currentStep === 5 && stepNum === 5)) {
                status = 'completed';
                completedSteps++;
            } else if (stepNum === currentStep) {
                status = 'active';
            }

            const item = document.createElement('div');
            item.className = 'relative flex gap-4 md:gap-6 items-start group';
            
            let markerHtml = '';
            let contentClass = '';
            
            if (status === 'completed') {
                markerHtml = `<div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shadow-sm relative z-10 border-2 border-white"><svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg></div>`;
                contentClass = 'text-gray-900';
            } else if (status === 'active') {
                markerHtml = `<div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/40 ring-4 ring-blue-500/20 relative z-10 border-2 border-white"><span class="font-bold text-sm md:text-base">0${stepNum}</span></div>`;
                contentClass = 'text-gray-900';
            } else {
                markerHtml = `<div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center relative z-10 border-2 border-white transition-colors group-hover:bg-gray-200"><span class="font-bold text-sm md:text-base">0${stepNum}</span></div>`;
                contentClass = 'text-gray-400';
            }

            item.innerHTML = `
                ${markerHtml}
                <div class="flex-1 pb-10">
                    <h4 class="text-base md:text-lg font-bold ${contentClass} mb-1 leading-tight">${step.label}</h4>
                    <p class="text-sm md:text-base font-medium text-gray-500 ${status === 'future' ? 'opacity-60' : ''}">${step.desc}</p>
                </div>
            `;
            container.appendChild(item);
        });

        // Add dynamic gradient line if there's progress
        if (completedSteps > 0) {
            const activeLine = document.createElement('div');
            activeLine.className = 'absolute left-[27px] md:left-[43px] top-6 w-1 bg-gradient-to-b from-blue-600 to-emerald-500 rounded-full transition-all duration-1000 ease-out z-0';
            activeLine.style.height = '0%';
            activeLine.style.bottom = 'auto';
            // Need to insert it before container
            const parent = container.parentElement;
            // Check if one already exists to avoid duplicates on re-render
            const existing = parent.querySelector('.bg-gradient-to-b');
            if (existing) existing.remove();
            parent.insertBefore(activeLine, container);
            
            // Animate height
            setTimeout(() => {
                const stepHeight = 100 / (stepsConfig.length - 1);
                activeLine.style.height = `calc(${completedSteps * stepHeight}% - ${currentStep === 5 ? 0 : 20}px)`;
                if (currentStep === 5) activeLine.style.height = 'calc(100% - 24px)';
            }, 100);
        }
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
        const badge = document.getElementById('main-status-badge');
        badge.textContent = statusText;
        
        if (currentStep === 5) {
             badge.className = 'inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 text-sm font-bold';
             document.getElementById('main-status-desc').textContent = '<?= __('status_enrolled_desc') ?>';
        }
    }

    function openManagerWhatsApp() {
        const phone = managerPhone.replace(/\D/g, '') || '77777777777';
        const text = `<?= __('whatsapp_hello') ?>`.replace('{name}', studentName);
        window.open(`https://wa.me/${phone}?text=${encodeURIComponent(text)}`, '_blank');
    }

    function requestCall() {
        fetch('<?= BASE_URL ?>/api/leads/request-call', {
            method: 'POST'
        }).then(r => r.json()).then(data => {
            if (data.success) {
                alert('<?= __('call_requested') ?>');
            } else {
                alert('Ошибка. Попробуйте еще раз.');
            }
        }).catch(e => {
            alert('Ошибка. Попробуйте еще раз.');
        });
    }

    function checkReceiptStatus() {
        fetch('<?= BASE_URL ?>/api/payments/my-receipts')
            .then(res => res.json())
            .then(data => {
                if (data.success && data.receipts && data.receipts.length > 0) {
                    const latest = data.receipts[0];
                    const formContainer = document.getElementById('payment-form-container');
                    const statusContainer = document.getElementById('payment-status-container');
                    const statusTitle = document.getElementById('payment-status-title');
                    const statusText = document.getElementById('payment-status-text');
                    
                    if (latest.status === 'pending') {
                        formContainer.classList.add('hidden');
                        statusContainer.classList.remove('hidden');
                        statusContainer.className = 'p-5 bg-amber-50 border border-amber-100 rounded-2xl mt-4';
                        statusTitle.className = 'font-bold text-amber-700 flex items-center gap-2 mb-1';
                        statusTitle.innerHTML = `<svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Чек на проверке`;
                        statusText.className = 'font-medium text-sm text-amber-600/80';
                        statusText.innerHTML = 'Ожидайте подтверждения менеджера. <a href="<?= BASE_URL ?>/api/payments/view-receipt?id=' + latest.id + '" target="_blank" class="underline hover:text-amber-800">Посмотреть файл</a>';
                    } else if (latest.status === 'approved') {
                        formContainer.classList.add('hidden');
                        statusContainer.classList.remove('hidden');
                        statusContainer.className = 'p-5 bg-emerald-50 border border-emerald-100 rounded-2xl mt-4';
                        statusTitle.className = 'font-bold text-emerald-700 flex items-center gap-2 mb-1';
                        statusTitle.innerHTML = `<svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Оплата подтверждена!`;
                        statusText.className = 'font-medium text-sm text-emerald-600/80';
                        statusText.textContent = 'Вы зачислены. Добро пожаловать!';
                    } else if (latest.status === 'rejected') {
                        // Allow re-upload
                        formContainer.classList.remove('hidden');
                        statusContainer.classList.remove('hidden');
                        statusContainer.className = 'p-5 bg-red-50 border border-red-100 rounded-2xl mt-4';
                        statusTitle.className = 'font-bold text-red-700 flex items-center gap-2 mb-1';
                        statusTitle.innerHTML = `<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Ваш чек отклонен`;
                        statusText.className = 'font-medium text-sm text-red-600/80';
                        statusText.textContent = 'Причина: ' + (latest.rejection_reason || 'Обратитесь к менеджеру');
                    }
                }
            });
    }

    function handleReceiptSelect(input) {
        if (input.files && input.files.length > 0) {
            document.getElementById('receipt-upload-text').textContent = input.files[0].name;
            const btn = document.getElementById('btn-submit-receipt');
            btn.removeAttribute('disabled');
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
        btn.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2 inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Отправка...';
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

    // Initialize receipt status check is already in fetchData() when currentStep >= 4

    document.addEventListener('DOMContentLoaded', init);
</script>
