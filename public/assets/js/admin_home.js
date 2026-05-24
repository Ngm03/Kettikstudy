let allStudents = [];
let currentFilter = 'all';
let prevUrgentCount = 0;

const statusColors = {
    new:        { bg:'#dbeafe', text:'#1e40af', label: window.AppConfig.lang.status_new },
    hot:        { bg:'#fee2e2', text:'#991b1b', label: window.AppConfig.lang.status_hot },
    urgent:     { bg:'#ef4444', text:'#ffffff', label: window.AppConfig.lang.status_urgent },
    processing: { bg:'#fef9c3', text:'#92400e', label: window.AppConfig.lang.status_processing },
    qualified:  { bg:'#e0e7ff', text:'#3730a3', label: window.AppConfig.lang.status_qualified },
    documents:  { bg:'#fce7f3', text:'#9d174d', label: window.AppConfig.lang.status_documents },
    visa:       { bg:'#ede9fe', text:'#5b21b6', label: window.AppConfig.lang.status_visa },
    enrolled:   { bg:'#dcfce7', text:'#166534', label: window.AppConfig.lang.status_enrolled },
    lost:       { bg:'#f3f4f6', text:'#6b7280', label: window.AppConfig.lang.status_lost },
};

function filterList(type, btn) {
    currentFilter = type;
    document.querySelectorAll('.fchip').forEach(b => {
        b.classList.remove('active','active-hot');
    });
    btn.classList.add(type === 'hot' ? 'active-hot' : 'active');
    renderTable();
}

function getFiltered() {
    const q = document.getElementById('searchStudent').value.toLowerCase();
    return allStudents.filter(s => {
        const matchSearch = s.full_name.toLowerCase().includes(q) ||
            (s.email && s.email.toLowerCase().includes(q)) ||
            (s.phone && s.phone.includes(q));
        if (!matchSearch) return false;
        
        const isUrgent = String(s.is_urgent) === 'true' || String(s.is_urgent) === '1' || s.lead_status === 'urgent';
        if (currentFilter === 'urgent') return isUrgent;
        
        if (currentFilter === 'hot') return s.lead_score >= 70;
        return true;
    });
}

function buildStatusBadge(status) {
    const st = statusColors[status] || { bg:'#f3f4f6', text:'#374151', label: status };
    return `<span class="sbadge" style="background:${st.bg};color:${st.text}">${st.label}</span>`;
}

function buildActions(s, isMobile) {
    let wa = '';
    if (s.phone) {
        const clean = s.phone.replace(/\D/g,'');
        wa = `<a href="https://wa.me/${clean}?text=Здравствуйте%2C+${encodeURIComponent(s.full_name)}!" target="_blank" class="btn-wa">
            <svg width="13" height="13" fill="currentColor" viewBox="0 0 16 16"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg>
            WhatsApp
        </a>`;
    }
    const viewBtn = `<a href="${window.AppConfig.baseUrl}/admin/student?id=${s.id}" class="btn-view">${window.AppConfig.lang.btn_view}</a>`;
    
    const isNew = (s.lead_status === 'new' || !s.lead_status);
    const btnText = isNew ? window.AppConfig.lang.btn_take : window.AppConfig.lang.handled;
    const btnStyle = isNew ? '' : 'style="background:#10b981; border-color:#10b981;"';
    
    const isUrgent = String(s.is_urgent) === 'true' || String(s.is_urgent) === '1' || s.lead_status === 'urgent';
    const takeBtn = isUrgent
        ? `<button onclick="takeLead(${s.id})" class="btn-take" ${btnStyle}>${btnText}</button>`
        : '';
    return `${takeBtn}${wa}${viewBtn}`;
}

function renderTable() {
    const filtered = getFiltered();
    const tbody = document.getElementById('students-list');
    const mobileList = document.getElementById('mobile-cards-list');

    tbody.innerHTML = '';
    mobileList.innerHTML = '';

    if (filtered.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5"><div class="empty-state">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <p>${window.AppConfig.lang.no_students_filter}</p>
        </div></td></tr>`;
        mobileList.innerHTML = `<div class="empty-state">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:36px;height:36px;color:#e2e8f0;margin:0 auto 8px;display:block;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p>${window.AppConfig.lang.no_students}</p>
        </div>`;
        return;
    }

    filtered.forEach(s => {
        const isUrgent = String(s.is_urgent) === 'true' || String(s.is_urgent) === '1' || s.lead_status === 'urgent';
        const date = new Date(s.created_at).toLocaleDateString('ru-RU');
        const score = s.lead_score ? (s.lead_score >= 70 ? `🔥 ${s.lead_score}` : s.lead_score) : '—';

        const tr = document.createElement('tr');
        if (isUrgent) tr.className = 'row-urgent';
        tr.innerHTML = `
            <td>
                <div class="student-name">${s.full_name}</div>
                <div class="student-email">${s.email || ''}</div>
            </td>
            <td style="color:#94a3b8;font-size:0.8rem;">${date}</td>
            <td>
                <select onchange="updateStatus(${s.id}, this.value)" class="status-select">
                    ${Object.entries(statusColors).map(([v,c]) =>
                        `<option value="${v}" ${s.lead_status===v?'selected':''}>${c.label}</option>`
                    ).join('')}
                </select>
            </td>
            <td style="font-size:0.85rem;">${score}</td>
            <td style="text-align:right;">
                <div class="action-btns" style="justify-content:flex-end;">
                    ${buildActions(s, false)}
                </div>
            </td>
        `;
        tbody.appendChild(tr);

        const card = document.createElement('div');
        card.className = `student-card${isUrgent?' card-urgent':''}`;
        card.innerHTML = `
            <div class="card-top">
                <div class="card-info">
                    <div class="card-name">${s.full_name}</div>
                    <div class="card-email">${s.email || ''}</div>
                    <div class="card-date">${date}</div>
                </div>
                ${buildStatusBadge(s.lead_status)}
            </div>
            <div class="card-row">
                <span style="font-size:0.75rem;color:#94a3b8;">${window.AppConfig.lang.interest}:</span>
                <span style="font-size:0.82rem;font-weight:600;">${score}</span>
            </div>
            <div class="card-row">
                <span style="font-size:0.75rem;color:#94a3b8;">${window.AppConfig.lang.status_label}:</span>
                <select onchange="updateStatus(${s.id}, this.value)" class="status-select" style="font-size:0.78rem;padding:5px 8px;">
                    ${Object.entries(statusColors).map(([v,c]) =>
                        `<option value="${v}" ${s.lead_status===v?'selected':''}>${c.label}</option>`
                    ).join('')}
                </select>
            </div>
            <div class="card-actions">
                ${buildActions(s, true)}
            </div>
        `;
        mobileList.appendChild(card);
    });
}

function updateStatus(id, newStatus) {
    const s = allStudents.find(x => x.id == id);
    if (s) s.lead_status = newStatus;
    fetch(`${window.AppConfig.baseUrl}/api/admin/lead-status`, {
        method: 'POST',
        body: JSON.stringify({ id, status: newStatus })
    }).then(r => r.json()).then(data => {
        if (!data.success) { alert(window.AppConfig.lang.status_error); loadStudents(); }
        else renderTable();
    });
}

function takeLead(id) {
    const s = allStudents.find(x => x.id == id);
    const isNew = (s && (s.lead_status === 'new' || !s.lead_status));
    
    if (isNew) {
        if (!confirm(window.AppConfig.lang.confirm_take)) return;
    } else {
        if (!confirm(window.AppConfig.lang.confirm_handled)) return;
    }
    
    fetch(`${window.AppConfig.baseUrl}/api/admin/clear-urgent`, {
        method: 'POST',
        body: JSON.stringify({ id })
    }).then(r => r.json()).then(data => {
        if (isNew || s.lead_status === 'urgent') {
            updateStatus(id, 'processing');
        } else {
            loadStudents();
        }
    }).catch(e => loadStudents());
}

function loadStudents() {
    fetch(`${window.AppConfig.baseUrl}/api/admin/students`)
        .then(r => r.json())
        .then(data => {
            if (!data.students) return;
            allStudents = data.students;

            const total    = allStudents.length;
            const urgent   = allStudents.filter(s => String(s.is_urgent) === 'true' || String(s.is_urgent) === '1' || s.lead_status === 'urgent').length;
            const hot      = allStudents.filter(s => s.lead_score >= 70).length;
            const enrolled = allStudents.filter(s => s.lead_status === 'enrolled').length;

            document.getElementById('sn-total').textContent    = total;
            document.getElementById('sn-urgent').textContent   = urgent;
            document.getElementById('sn-hot').textContent      = hot;
            document.getElementById('sn-enrolled').textContent = enrolled;

            document.getElementById('count-all').textContent    = total;
            document.getElementById('count-urgent').textContent = urgent;
            document.getElementById('count-hot').textContent    = hot;

            const urgentBtn = document.querySelector('[data-type="urgent"]');
            if (urgent > 0) {
                urgentBtn.classList.add('urgent-pulse');
                if (urgent > prevUrgentCount) {
                    try { document.getElementById('alert-sound').play().catch(()=>{}); } catch(e) {}
                }
            } else {
                urgentBtn.classList.remove('urgent-pulse');
            }
            prevUrgentCount = urgent;

            const dot = document.getElementById('notifBadgeDot');
            if (dot) dot.classList.toggle('visible', urgent > 0);

            renderTable();
        });
}

document.getElementById('searchStudent').addEventListener('input', renderTable);
setInterval(loadStudents, 30000);
loadStudents();
