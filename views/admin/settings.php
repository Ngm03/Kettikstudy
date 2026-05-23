<div class="ad-settings-wrapper">
    <div class="ad-header">
        <div class="ad-header-left">
            <h1 class="ad-page-title"><?= __('settings_title') ?></h1>
            <p class="ad-page-subtitle"><?= __('settings_subtitle') ?></p>
        </div>
        <div id="saveStatus" class="ad-save-status">
            <svg class="ad-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="ad-save-text"><?= __('settings_saved') ?></span>
        </div>
    </div>


    <div class="ad-section">
        <div class="ad-section-header">
            <h2 class="ad-section-title">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <?= __('settings_sec_company') ?>
            </h2>
        </div>
        <div class="ad-grid">
            <div class="ad-input-group">
                <label class="ad-label"><?= __('settings_lbl_comp_name') ?></label>
                <input type="text" id="company_name" class="ad-input" placeholder="Kettik Study">
            </div>
            <div class="ad-input-group">
                <label class="ad-label"><?= __('settings_lbl_website') ?></label>
                <input type="text" id="company_website" class="ad-input" placeholder="kettik.kz">
            </div>
            <div class="ad-input-group full-width">
                <label class="ad-label"><?= __('settings_lbl_desc') ?></label>
                <textarea id="company_description" rows="2" class="ad-textarea" placeholder="<?= __('settings_ph_desc') ?>"></textarea>
            </div>
            <div class="ad-input-group full-width">
                <label class="ad-label"><?= __('settings_lbl_address') ?></label>
                <textarea id="company_address" rows="3" class="ad-textarea" placeholder="<?= __('settings_ph_address') ?>"></textarea>
            </div>
            <div class="ad-input-group">
                <label class="ad-label">Email</label>
                <input type="email" id="company_email" class="ad-input" placeholder="info@kettik.kz">
            </div>
        </div>
    </div>


    <div class="ad-section">
        <div class="ad-section-header">
            <h2 class="ad-section-title">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                <?= __('settings_sec_contacts') ?>
            </h2>
        </div>
        <div class="ad-grid">
            <div class="ad-input-group">
                <label class="ad-label"><?= __('settings_lbl_phone') ?></label>
                <input type="text" id="company_phone" class="ad-input" placeholder="+7 701 631 41 21">
            </div>
            <div class="ad-input-group">
                <label class="ad-label">WhatsApp</label>
                <input type="text" id="company_whatsapp" class="ad-input" placeholder="+77016314121">
            </div>
            <div class="ad-input-group">
                <label class="ad-label">Instagram</label>
                <input type="text" id="company_instagram" class="ad-input" placeholder="@kettik.study">
            </div>
            <div class="ad-input-group">
                <label class="ad-label">Telegram</label>
                <input type="text" id="company_telegram" class="ad-input" placeholder="@kettik_study">
            </div>
            <div class="ad-input-group full-width">
                <label class="ad-label">YouTube</label>
                <input type="text" id="company_youtube" class="ad-input" placeholder="<?= __('settings_ph_youtube') ?>">
            </div>
        </div>
    </div>


    <div class="ad-section">
        <div class="ad-section-header">
            <h2 class="ad-section-title">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <?= __('settings_sec_ai') ?>
            </h2>
        </div>
        <div class="ad-grid">
            <div class="ad-input-group">
                <label class="ad-label"><?= __('settings_lbl_bot_name') ?></label>
                <input type="text" id="ai_bot_name" class="ad-input" placeholder="<?= __('settings_ph_bot_name') ?>">
            </div>
        </div>
    </div>


    <div class="ad-section">
        <div class="ad-section-header">
            <h2 class="ad-section-title">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <?= __('settings_sec_community') ?>
            </h2>
        </div>
        <div class="ad-grid" style="grid-template-columns: 1fr;">
            <div class="ad-input-group">
                <label class="ad-label"><?= __('settings_lbl_censored') ?></label>
                <textarea id="chat_censored_words" rows="3" class="ad-textarea" placeholder="<?= __('settings_ph_censored') ?>"></textarea>
                <p class="ad-help-text"><?= __('settings_hint_censored') ?></p>
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
    max-width: 1000px;
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
    font-weight: 600;
    font-size: 0.875rem;
}
.ad-save-status.show {
    opacity: 1;
}
.ad-save-status .ad-icon {
    width: 20px;
    height: 20px;
}
.ad-save-status.saving {
    color: #64748b;
    background: #f1f5f9;
}

.ad-section {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.025);
    border: 1px solid rgba(226, 232, 240, 0.8);
    overflow: hidden;
    margin-bottom: 1.5rem;
}
.ad-section-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem 1.5rem;
}
.ad-section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.ad-section-title svg {
    color: #0052FF;
}

.ad-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    padding: 1.5rem;
}
.ad-input-group {
    display: flex;
    flex-direction: column;
}
.ad-input-group.full-width {
    grid-column: 1 / -1;
}
.ad-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.5rem;
}
.ad-input, .ad-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    font-size: 0.95rem;
    color: #334155;
    background: #f8fafc;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    box-sizing: border-box;
}
.ad-input:focus, .ad-textarea:focus {
    outline: none;
    border-color: #0052FF;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(0, 82, 255, 0.1);
}
.ad-help-text {
    font-size: 0.8rem;
    color: #94a3b8;
    margin: 0.5rem 0 0 0;
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
    font-weight: 500;
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
    .ad-grid { grid-template-columns: 1fr; gap: 1rem; padding: 1.25rem; }
    .ad-save-status { 
        align-self: flex-start; 
        font-size: 0.8rem; 
        padding: 0.4rem 0.8rem; 
    }
}
</style>

<script>
const settingFields = [
    'company_name', 'company_description', 'company_email', 'company_phone',
    'company_whatsapp', 'company_website', 'company_instagram', 'company_telegram',
    'company_youtube', 'company_address', 'ai_bot_name', 'chat_censored_words'
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
        saveStatus.innerHTML = '<svg class="ad-icon animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg><span class="ad-save-text"><?= __('settings_saving') ?></span>';
        saveStatus.classList.add('show');
    }, 150);
};

const showSaved = () => {
    saveStatus.classList.remove('show');
    setTimeout(() => {
        saveStatus.classList.remove('saving');
        saveStatus.innerHTML = '<svg class="ad-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span class="ad-save-text"><?= __('settings_saved') ?></span>';
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
        saveStatus.innerHTML = '<svg class="ad-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span class="ad-save-text text-red-600"><?= __('settings_error') ?></span>';
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
                    if (data.settings[key]) el.value = data.settings[key];
                    el.addEventListener('input', (e) => {
                        debouncedSave(key, e.target.value);
                    });
                }
            });
        }
    } catch (e) {
        console.error('Failed to load settings:', e);
    }
}

document.addEventListener('DOMContentLoaded', loadSettings);
</script>
