<div class="ad-settings-wrapper">
    <div class="ad-header">
        <div class="ad-header-left">
            <h1 class="ad-page-title">Настройки Платформы</h1>
            <p class="ad-page-subtitle">Управление глобальными параметрами платформы. Все изменения сохраняются автоматически.</p>
        </div>
        <div id="saveStatus" class="ad-save-status">
            <svg class="ad-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="ad-save-text"><?= __('settings_saved') ?></span>
        </div>
    </div>

    <!-- Основная секция настроек -->
    <div class="ad-section">
        <div class="ad-section-header">
            <h2 class="ad-section-title">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #0052FF; width:20px; height:20px; display:inline-block; vertical-align:middle; margin-right:6px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                Глобальные параметры продукта
            </h2>
        </div>
        
        <div class="ad-settings-content">
            <!-- 1. Контактный email -->
            <div class="setting-field-card">
                <div class="field-info">
                    <span class="field-title">Контактный email платформы</span>
                    <p class="field-desc">Используется для отправки системных писем, уведомлений и обратной связи пользователей.</p>
                </div>
                <div class="field-control">
                    <div style="position: relative; width: 100%;">
                        <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;">✉️</span>
                        <input type="email" id="platform_email" class="ad-input input-with-icon" placeholder="info@kettik.kz" style="padding-left: 38px;">
                    </div>
                </div>
            </div>

            <!-- 2. Режим технических работ -->
            <div class="setting-field-card">
                <div class="field-info">
                    <span class="field-title">Режим технических работ (Maintenance Mode)</span>
                    <p class="field-desc">При включении публичная часть сайта блокируется, и студенты увидят страницу обслуживания.</p>
                </div>
                <div class="field-control">
                    <label class="switch-container">
                        <input type="checkbox" id="maintenance_mode">
                        <span class="switch-slider"></span>
                    </label>
                </div>
            </div>

            <!-- 3. URL Пользовательского соглашения -->
            <div class="setting-field-card">
                <div class="field-info">
                    <span class="field-title">URL пользовательского соглашения</span>
                    <p class="field-desc">Адрес веб-страницы или PDF-файла с правилами пользования платформой и офертой.</p>
                </div>
                <div class="field-control">
                    <div style="position: relative; width: 100%;">
                        <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;">🔗</span>
                        <input type="url" id="terms_url" class="ad-input input-with-icon" placeholder="https://kettik.kz/terms" style="padding-left: 38px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="toast" class="ad-toast">
        <svg class="ad-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span id="toastText"><?= __('settings_toast_saved') ?></span>
    </div>
</div>

<style>
.ad-settings-wrapper {
    max-width: 900px;
    margin: 0 auto;
    padding: 1rem;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    color: #1e293b;
}

.ad-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}
.ad-page-title {
    font-size: 1.875rem;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.025em;
    margin: 0 0 0.5rem 0;
}
.ad-page-subtitle {
    color: #64748b;
    font-size: 0.95rem;
    margin: 0;
}

.ad-save-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #10b981;
    opacity: 0;
    transition: opacity 0.3s ease;
    background: #ecfdf5;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.825rem;
    border: 1px solid #d1fae5;
}
.ad-save-status.show {
    opacity: 1;
}
.ad-save-status .ad-icon {
    width: 16px;
    height: 16px;
}
.ad-save-status.saving {
    color: #475569;
    background: #f8fafc;
    border-color: #e2e8f0;
}

.ad-section {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
    border: 1px solid rgba(226, 232, 240, 0.8);
    overflow: hidden;
    margin-bottom: 1.5rem;
}
.ad-section-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1.25rem 1.5rem;
}
.ad-section-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
}

.ad-settings-content {
    padding: 0.5rem 1.5rem;
}

.setting-field-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 0;
    border-bottom: 1px solid #f1f5f9;
    gap: 2rem;
}
.setting-field-card:last-child {
    border-bottom: none;
}

.field-info {
    flex: 1;
    min-width: 0;
}
.field-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1e293b;
    display: block;
    margin-bottom: 0.25rem;
}
.field-desc {
    font-size: 0.82rem;
    color: #64748b;
    margin: 0;
    line-height: 1.4;
}

.field-control {
    width: 320px;
    display: flex;
    justify-content: flex-end;
}

.ad-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    font-size: 0.92rem;
    color: #334155;
    background: #f8fafc;
    transition: all 0.2s;
    box-sizing: border-box;
}
.ad-input:focus {
    outline: none;
    border-color: #0052FF;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(0, 82, 255, 0.1);
}

/* Beautiful custom toggle switch */
.switch-container {
    position: relative;
    display: inline-block;
    width: 56px;
    height: 30px;
}
.switch-container input {
    opacity: 0;
    width: 0;
    height: 0;
}
.switch-slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #cbd5e1;
    transition: .3s;
    border-radius: 34px;
}
.switch-slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .3s;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
input:checked + .switch-slider {
    background-color: #10b981;
}
input:focus + .switch-slider {
    box-shadow: 0 0 1px #10b981;
}
input:checked + .switch-slider:before {
    transform: translateX(26px);
}

.ad-toast {
    position: fixed;
    bottom: 1.5rem;
    right: 1.5rem;
    background: #10b981;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    transform: translateY(150%);
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 50;
    font-weight: 600;
}
.ad-toast.show {
    transform: translateY(0);
    opacity: 1;
}
.ad-toast .ad-icon {
    width: 20px;
    height: 20px;
}

@media (max-width: 768px) {
    .ad-settings-wrapper { padding: 0.75rem; }
    .ad-header { flex-direction: column; align-items: flex-start; gap: 0.75rem; }
    .setting-field-card { flex-direction: column; align-items: flex-start; gap: 1rem; padding: 1.25rem 0; }
    .field-control { width: 100%; justify-content: flex-start; }
}
</style>

<script>
const settingFields = [
    'platform_email', 'maintenance_mode', 'terms_url'
];

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

const saveStatus = document.getElementById('saveStatus');
const toastInfo = document.getElementById('toast');

const showSaving = () => {
    saveStatus.classList.remove('show');
    setTimeout(() => {
        saveStatus.classList.add('saving');
        saveStatus.innerHTML = '<svg class="ad-icon animate-spin" fill="none" viewBox="0 0 24 24" style="animation: spin 1s linear infinite; width:16px; height:16px; display:inline-block; vertical-align:middle; margin-right:6px;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" style="opacity:0.25;"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" style="opacity:0.75;"></path></svg><span class="ad-save-text"><?= __('settings_saving') ?></span>';
        saveStatus.classList.add('show');
    }, 150);
};

const showSaved = () => {
    saveStatus.classList.remove('show');
    setTimeout(() => {
        saveStatus.classList.remove('saving');
        saveStatus.innerHTML = '<svg class="ad-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px; height:16px; display:inline-block; vertical-align:middle; margin-right:6px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span class="ad-save-text"><?= __('settings_saved') ?></span>';
        saveStatus.classList.add('show');
        
        toastInfo.classList.add('show');
        
        setTimeout(() => {
            saveStatus.classList.remove('show');
            toastInfo.classList.remove('show');
        }, 2500);
    }, 150);
};

const showSaveError = () => {
    saveStatus.classList.remove('show');
    setTimeout(() => {
        saveStatus.classList.remove('saving');
        saveStatus.innerHTML = '<svg class="ad-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px; height:16px; display:inline-block; vertical-align:middle; margin-right:6px; color:#dc2626;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span class="ad-save-text" style="color:#dc2626;"><?= __('settings_error') ?></span>';
        saveStatus.classList.add('show');
        setTimeout(() => saveStatus.classList.remove('show'), 3000);
    }, 150);
}

const autoSave = async (key, value) => {
    showSaving();
    try {
        const settings = { [key]: value };
        const res = await fetch(`${BASE_URL}/api/admin/settings`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ settings })
        });
        const data = await res.json();
        if (data.success) {
            showSaved();
        } else {
            console.error('Save failed');
            showSaveError();
        }
    } catch (e) {
        console.error('Network error', e);
        showSaveError();
    }
};

const debouncedSave = debounce(autoSave, 1000);

async function loadSettings() {
    try {
        const res = await fetch(`${BASE_URL}/api/admin/settings`);
        const data = await res.json();
        if (data.settings) {
            settingFields.forEach(key => {
                const el = document.getElementById(key);
                if (el) {
                    if (el.type === 'checkbox') {
                        el.checked = data.settings[key] === '1';
                        el.addEventListener('change', (e) => {
                            autoSave(key, e.target.checked ? '1' : '0');
                        });
                    } else {
                        el.value = data.settings[key] || '';
                        el.addEventListener('input', (e) => {
                            debouncedSave(key, e.target.value);
                        });
                    }
                }
            });
        }
    } catch (e) {
        console.error('Failed to load settings:', e);
    }
}

document.addEventListener('DOMContentLoaded', loadSettings);
</script>
