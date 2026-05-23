<div class="top-bar">
    <div class="page-title">
        <h1><?= __('student_profile') ?></h1>
        <p><?= __('fill_personal_data') ?></p>
    </div>
</div>

<div class="card" id="profile-section">
    <div class="section-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; padding-bottom:1rem; border-bottom:1px solid #e5e7eb;">
        <h3><?= __('questionnaire') ?></h3>
        <span class="badge" id="profile-status" style="background:#f3f4f6; color:#6b7280; padding:4px 10px; border-radius:20px; font-size:0.75rem; font-weight:600;"><?= __('not_filled') ?></span>
    </div>

    <form id="profile-form" onsubmit="event.preventDefault(); saveProfile();">
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1.5rem;">
            <div class="form-group">
                <label class="form-label" style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.5rem; color:#374151;"><?= __('iin') ?></label>
                <input type="text" name="iin" class="form-input" style="width:100%; padding:0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:1rem;" required>
            </div>
            <div class="form-group">
                <label class="form-label" style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.5rem; color:#374151;"><?= __('passport_num') ?></label>
                <input type="text" name="passport_number" class="form-input" style="width:100%; padding:0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:1rem;" required>
            </div>
            <div class="form-group">
                <label class="form-label" style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.5rem; color:#374151;"><?= __('issued_by') ?></label>
                <input type="text" name="passport_authority" class="form-input" style="width:100%; padding:0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:1rem;" required>
            </div>
            <div class="form-group">
                <label class="form-label" style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.5rem; color:#374151;"><?= __('issue_date') ?></label>
                <input type="date" name="passport_issue_date" class="form-input" style="width:100%; padding:0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:1rem;" required>
            </div>
            <div class="form-group">
                <label class="form-label" style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.5rem; color:#374151;"><?= __('reg_address') ?></label>
                <input type="text" name="address_registration" class="form-input" style="width:100%; padding:0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:1rem;" required>
            </div>
            <div class="form-group">
                <label class="form-label" style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.5rem; color:#374151;"><?= __('phone') ?></label>
                <input type="text" name="phone" id="user-phone-input" class="form-input" style="width:100%; padding:0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:1rem;" required>
            </div>
        </div>
        <div style="margin-top:2rem; display:flex; justify-content:flex-end;">
            <button type="submit" class="btn btn-primary" style="display:flex; align-items:center; gap:8px; padding: 0.75rem 1.5rem; font-size:1rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                <?= __('save_data') ?>
            </button>
        </div>
    </form>
</div>

<div class="card" id="program-section" style="margin-top:1.5rem;">
    <div class="section-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; padding-bottom:1rem; border-bottom:1px solid #e5e7eb;">
        <h3><?= __('program_choice') ?></h3>
        <span class="badge" id="program-status" style="background:#f3f4f6; color:#6b7280; padding:4px 10px; border-radius:20px; font-size:0.75rem; font-weight:600;"><?= __('not_selected') ?></span>
    </div>

    <form id="program-form" onsubmit="event.preventDefault(); saveProgram();">
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1.5rem;">
            <div class="form-group">
                <label class="form-label" style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.5rem; color:#374151;"><?= __('study_country') ?></label>
                <select name="desired_country" id="desired-country" class="form-input" style="width:100%; padding:0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:1rem; background:white;" required>
                    <option value=""><?= __('select_country') ?></option>
                    <option value="Польша"><?= __('poland') ?></option>
                    <option value="Чехия"><?= __('czechia') ?></option>
                    <option value="Венгрия"><?= __('hungary') ?></option>
                    <option value="Словакия"><?= __('slovakia') ?></option>
                    <option value="Германия"><?= __('germany') ?></option>
                    <option value="Турция"><?= __('turkey') ?></option>
                    <option value="Малайзия"><?= __('malaysia') ?></option>
                    <option value="Другая"><?= __('other') ?></option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.5rem; color:#374151;"><?= __('university') ?></label>
                <select name="desired_university_id" id="desired-university" class="form-input" style="width:100%; padding:0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:1rem; background:white;" required>
                    <option value=""><?= __('loading') ?></option>
                </select>
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label class="form-label" style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.5rem; color:#374151;"><?= __('faculty_major') ?></label>
                <input type="text" name="desired_program" id="desired-program" class="form-input" style="width:100%; padding:0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:1rem;">
            </div>
        </div>
        <div style="margin-top:2rem; display:flex; justify-content:flex-end;">
            <button type="submit" class="btn btn-primary" style="display:flex; align-items:center; gap:8px; padding: 0.75rem 1.5rem; font-size:1rem; background:#10b981; border-color:#10b981;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                <?= __('confirm_choice') ?>
            </button>
        </div>
    </form>
</div>

<script>
    let universitiesData = [];

    function loadUniversities() {
        fetch('<?= BASE_URL ?>/api/universities/list')
            .then(res => res.json())
            .then(data => {
                universitiesData = data.universities || [];
                const select = document.getElementById('desired-university');
                select.innerHTML = '<option value=""><?= __('select_university') ?></option>';
                universitiesData.forEach(u => {
                    const opt = document.createElement('option');
                    opt.value = u.id;
                    opt.textContent = u.name;
                    select.appendChild(opt);
                });
            });
    }

    function loadProfile() {
        fetch('<?= BASE_URL ?>/api/profile/details')
            .then(res => res.json())
            .then(data => {
                if(data.user) {
                    document.getElementById('user-phone-input').value = data.user.phone || '';
                }
                if(data.details) {
                    const d = data.details;
                    const form = document.getElementById('profile-form');
                    form.elements['iin'].value = d.iin || '';
                    form.elements['passport_number'].value = d.passport_number || '';
                    form.elements['passport_authority'].value = d.passport_authority || '';
                    form.elements['passport_issue_date'].value = d.passport_issue_date || '';
                    form.elements['address_registration'].value = d.address_registration || '';

                    if (d.iin || d.passport_number) {
                        document.getElementById('profile-status').textContent = '<?= __('filled') ?>';
                        document.getElementById('profile-status').style.color = '#10b981';
                        document.getElementById('profile-status').style.background = '#d1fae5';
                    }

                    if (d.desired_country) {
                        document.getElementById('desired-country').value = d.desired_country;
                    }
                    if (d.desired_university_id) {
                        setTimeout(() => {
                            document.getElementById('desired-university').value = d.desired_university_id;
                        }, 500);
                    }
                    if (d.desired_program) {
                        document.getElementById('desired-program').value = d.desired_program;
                    }
                    if (d.desired_country || d.desired_university_id) {
                        document.getElementById('program-status').textContent = '<?= __('selected') ?>';
                        document.getElementById('program-status').style.color = '#10b981';
                        document.getElementById('program-status').style.background = '#d1fae5';
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

        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<?= __('loading') ?>';
        btn.disabled = true;

        fetch('<?= BASE_URL ?>/api/profile/update', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                alert('<?= __('data_saved') ?>');
                document.getElementById('profile-status').textContent = '<?= __('filled') ?>';
                document.getElementById('profile-status').style.color = '#10b981';
                document.getElementById('profile-status').style.background = '#d1fae5';
            } else {
                alert('<?= __('error_prefix') ?>' + (data.error || '<?= __('unknown_error') ?>'));
            }
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }

    function saveProgram() {
        const form = document.getElementById('program-form');
        const data = {
            desired_country: form.elements['desired_country'].value,
            desired_university_id: form.elements['desired_university_id'].value || null,
            desired_program: form.elements['desired_program'].value
        };

        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<?= __('loading') ?>';
        btn.disabled = true;

        fetch('<?= BASE_URL ?>/api/profile/update', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                alert('<?= __('program_saved') ?>');
                document.getElementById('program-status').textContent = '<?= __('selected') ?>';
                document.getElementById('program-status').style.color = '#10b981';
                document.getElementById('program-status').style.background = '#d1fae5';
            } else {
                alert('<?= __('error_prefix') ?>' + (data.error || '<?= __('unknown_error') ?>'));
            }
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }

    loadUniversities();
    loadProfile();
</script>
