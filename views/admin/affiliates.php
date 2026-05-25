<style>
    .am-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px; }
    .am-title { font-size: 1.4rem; font-weight: 800; color: #0f172a; margin: 0 0 4px; }
    .am-subtitle { font-size: 0.85rem; color: #64748b; margin: 0; }
    
    .am-btn-primary {
        display: inline-flex; align-items: center; gap: 8px;
        background: #a855f7; color: #fff; border: none;
        padding: 10px 18px; border-radius: 12px; font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(168,85,247,0.25);
    }
    .am-btn-primary:hover { background: #9333ea; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(168,85,247,0.3); }

    .am-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }

    .am-card {
        background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; display: flex; flex-direction: column; gap: 16px; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .am-card:hover { box-shadow: 0 12px 24px rgba(0,0,0,0.08); border-color: #cbd5e1; transform: translateY(-4px); }

    .am-card-top { display: flex; align-items: center; gap: 14px; }
    .am-avatar {
        width: 52px; height: 52px; border-radius: 50%; background: #f3e8ff; color: #a855f7;
        display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 700; flex-shrink: 0;
    }
    .am-info { flex: 1; min-width: 0; }
    .am-name { font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 2px; }
    .am-phone { font-size: 0.8rem; font-weight: 600; color: #a855f7; text-decoration: none; }
    .am-phone:hover { color: #9333ea; }
    
    .ref-code-box {
        background: #f8fafc; padding: 8px 12px; border-radius: 8px; border: 1px dashed #cbd5e1;
        font-family: monospace; font-size: 0.85rem; color: #475569; text-align: center; font-weight: 600;
    }

    .am-actions { display: flex; gap: 8px; margin-top: auto; padding-top: 16px; border-top: 1px solid #f1f5f9; }
    .am-btn { flex: 1; padding: 8px; border-radius: 10px; font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: all 0.2s; border: none; text-align: center; }
    .am-btn-del { background: #fef2f2; color: #ef4444; }
    .am-btn-del:hover { background: #fee2e2; }

    .am-empty { background: #fff; border: 1px dashed #cbd5e1; border-radius: 16px; padding: 60px 20px; text-align: center; }
    .am-empty h3 { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0 0 6px; }
    .am-empty p { font-size: 0.9rem; color: #64748b; margin: 0; }

    .am-modal-overlay { position: fixed; inset: 0; background: rgba(15,23,42,0.6); backdrop-filter: blur(4px); z-index: 9999 !important; display: flex; align-items: center; justify-content: center; padding: 20px; opacity: 0; visibility: hidden; transition: all 0.3s; }
    .am-modal-overlay.open { opacity: 1; visibility: visible; }
    .am-modal { background: #fff; width: 100%; max-width: 420px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); transform: scale(0.95) translateY(10px); transition: all 0.3s; display: flex; flex-direction: column; padding: 24px; }
    .am-modal-overlay.open .am-modal { transform: scale(1) translateY(0); }
    .am-form-input { width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; margin-top: 8px; margin-bottom: 20px; }
</style>

<div class="am-header">
    <div>
        <h1 class="am-title">SMM Партнеры</h1>
        <p class="am-subtitle">Управление партнерской программой</p>
    </div>
    <button onclick="openModal()" class="am-btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Добавить SMM
    </button>
</div>

<?php if (empty($affiliates)): ?>
    <div class="am-empty">
        <h3>Нет партнеров</h3>
        <p>Добавьте первого SMM-партнера, чтобы начать работу.</p>
    </div>
<?php else: ?>
    <div class="am-grid">
        <?php foreach ($affiliates as $m): ?>
        <div class="am-card">
            <div class="am-card-top">
                <div class="am-avatar"><?= mb_strtoupper(mb_substr($m['name'], 0, 1)) ?></div>
                <div class="am-info">
                    <div class="am-name"><?= htmlspecialchars($m['name']) ?></div>
                    <div class="am-phone"><?= htmlspecialchars($m['email']) ?></div>
                </div>
            </div>
            
            <div class="ref-code-box">
                Код: <?= htmlspecialchars($m['affiliate_code']) ?>
            </div>

            <div class="am-actions">
                <button onclick="removeAffiliate(<?= $m['id'] ?>)" class="am-btn am-btn-del">Удалить из партнеров</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div id="affiliateModal" class="am-modal-overlay">
    <div class="am-modal">
        <h3 style="margin-top:0; font-weight: 800;">Добавить партнера</h3>
        <p style="color: #64748b; font-size: 0.85rem; margin-bottom: 20px;">Выберите студента, чтобы сделать его SMM-партнером.</p>
        
        <form onsubmit="submitAffiliate(event)">
            <label style="font-size: 0.85rem; font-weight: 600;">Пользователь</label>
            <div style="position: relative; margin-top: 8px; margin-bottom: 20px;">
                <input type="hidden" name="user_id" id="user_id_select" required>
                
                <input type="text" id="smm_search_input" class="am-form-input" style="margin-top:0; margin-bottom:0;"
                       placeholder="Поиск по имени или email..." 
                       autocomplete="off">
                       
                <div id="smm_search_dropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; max-height: 200px; overflow-y: auto; background: #fff; border: 1px solid #cbd5e1; border-top: none; border-radius: 0 0 10px 10px; z-index: 10; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <?php if(!empty($students)): foreach($students as $st): ?>
                        <div class="smm-option" data-id="<?= $st['id'] ?>" data-search="<?= strtolower(htmlspecialchars($st['full_name'] . ' ' . $st['email'] . ' ' . $st['phone'])) ?>" style="padding: 10px 14px; cursor: pointer; border-bottom: 1px solid #f1f5f9; transition: background 0.2s;">
                            <div style="font-weight: 600; color: #1e293b; font-size: 0.9rem;"><?= htmlspecialchars($st['full_name'] ?: 'Без имени') ?></div>
                            <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">
                                <?= htmlspecialchars($st['email']) ?>
                                <?= $st['phone'] ? ' • ' . htmlspecialchars($st['phone']) : '' ?>
                            </div>
                        </div>
                    <?php endforeach; else: ?>
                        <div style="padding: 10px 14px; color: #64748b; font-size: 0.85rem; text-align: center;">Нет студентов</div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div style="display: flex; gap: 12px;">
                <button type="button" onclick="closeModal()" class="am-btn" style="background:#f1f5f9;">Отмена</button>
                <button type="submit" class="am-btn am-btn-primary" style="margin:0;">Добавить</button>
            </div>
        </form>
    </div>
</div>

<script>
    const aModal = document.getElementById('affiliateModal');

    function openModal() { aModal.classList.add('open'); }
    function closeModal() { 
        aModal.classList.remove('open'); 
        setTimeout(() => {
            document.getElementById('smm_search_input').value = '';
            document.getElementById('user_id_select').value = '';
            document.querySelectorAll('.smm-option').forEach(opt => opt.style.display = 'block');
        }, 300);
    }

    // Custom Select JS for SMM
    const searchInput = document.getElementById('smm_search_input');
    const searchDropdown = document.getElementById('smm_search_dropdown');
    const selectedUserId = document.getElementById('user_id_select');
    const userOptions = document.querySelectorAll('.smm-option');

    searchInput.addEventListener('focus', () => {
        searchDropdown.style.display = 'block';
    });

    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
            searchDropdown.style.display = 'none';
        }
    });

    searchInput.addEventListener('input', (e) => {
        const q = e.target.value.toLowerCase();
        searchDropdown.style.display = 'block';
        userOptions.forEach(opt => {
            if (opt.dataset.search.includes(q)) {
                opt.style.display = 'block';
            } else {
                opt.style.display = 'none';
            }
        });
        if (q === '') {
            selectedUserId.value = '';
        }
    });

    userOptions.forEach(opt => {
        opt.addEventListener('click', () => {
            const nameEl = opt.querySelector('div:first-child');
            const emailEl = opt.querySelector('div:last-child');
            
            searchInput.value = nameEl.textContent.trim() + ' (' + emailEl.textContent.trim().split('•')[0].trim() + ')';
            selectedUserId.value = opt.dataset.id;
            searchDropdown.style.display = 'none';
            
            userOptions.forEach(o => o.style.background = 'transparent');
            opt.style.background = '#f1f5f9';
        });
        
        opt.addEventListener('mouseenter', () => { opt.style.background = '#f8fafc'; });
        opt.addEventListener('mouseleave', () => { 
            if(selectedUserId.value !== opt.dataset.id) opt.style.background = 'transparent'; 
            else opt.style.background = '#f1f5f9'; 
        });
    });

    function submitAffiliate(e) {
        e.preventDefault();
        const userId = document.getElementById('user_id_select').value;
        if (!userId) return;

        fetch('<?= BASE_URL ?>/api/admin/users/make-affiliate', {
            method: 'POST',
            body: JSON.stringify({ id: userId })
        })
        .then(r => r.json())
        .then(d => {
            if (d.success) location.reload();
            else alert(d.error || 'Ошибка');
        });
    }

    function removeAffiliate(id) {
        if (!confirm('Вернуть пользователя в статус студента?')) return;
        fetch('<?= BASE_URL ?>/api/admin/users/remove-affiliate', {
            method: 'POST',
            body: JSON.stringify({ id })
        })
        .then(r => r.json())
        .then(d => {
            if (d.success) location.reload();
            else alert('Ошибка');
        });
    }
</script>
