let trafficChartInstance = null;
let directionsChartInstance = null;
let isLoading = false;

// Чтение локализованных строк из глобального конфигурационного объекта
const statusLabels = {
    new: window.I18N_ANALYTICS?.status_new || 'Новый',
    hot: window.I18N_ANALYTICS?.status_hot || 'Горячий',
    urgent: window.I18N_ANALYTICS?.status_urgent || 'Срочный 🔴',
    processing: window.I18N_ANALYTICS?.status_processing || 'В работе',
    qualified: window.I18N_ANALYTICS?.status_qualified || 'Квалифицирован',
    documents: window.I18N_ANALYTICS?.status_documents || 'Документы',
    visa: window.I18N_ANALYTICS?.status_visa || 'Виза',
    enrolled: window.I18N_ANALYTICS?.status_enrolled || 'Зачислен ✓',
    lost: window.I18N_ANALYTICS?.status_lost || 'Проигран'
};

const statusColors = {
    new:        { bg:'#dbeafe', text:'#1e40af' },
    hot:        { bg:'#fee2e2', text:'#991b1b' },
    urgent:     { bg:'#ef4444', text:'#ffffff' },
    processing: { bg:'#fef9c3', text:'#92400e' },
    qualified:  { bg:'#e0e7ff', text:'#3730a3' },
    documents:  { bg:'#fce7f3', text:'#9d174d' },
    visa:       { bg:'#ede9fe', text:'#5b21b6' },
    enrolled:   { bg:'#dcfce7', text:'#166534' },
    lost:       { bg:'#f3f4f6', text:'#6b7280' },
};

async function loadAnalytics() {
    if (isLoading) return;
    isLoading = true;

    try {
        const response = await fetch(`${window.BASE_URL}/api/analytics/dashboard`);
        const text = await response.text();
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error('JSON Parse Error:', text);
            return;
        }

        if (!data.success) return;

        // 1. Заполняем виджеты
        document.getElementById('visitors-count').textContent = data.today.visitors;
        document.getElementById('leads-count').textContent = data.today.leads;
        document.getElementById('qualified-count').textContent = data.today.qualified;
        document.getElementById('conversion-rate').textContent = data.today.conversion + '%';

        // 2. Рассчитываем и выводим динамику (разницу с предыдущим периодом)
        const updateDiff = (current, yesterday, elementId) => {
            const diff = current - yesterday;
            const element = document.getElementById(elementId);

            if (!element) return;

            let icon = '';
            if (diff > 0) {
                icon = '▲ ';
                element.innerHTML = `<span class="diff-badge" style="background:#ecfdf5; color:#059669; font-weight:700; padding:2px 8px; border-radius:6px; font-size:0.75rem;">${icon}+${diff} (${window.I18N_ANALYTICS?.vs_prev_30_days || 'vs пред. 30 дней'})</span>`;
            } else if (diff < 0) {
                icon = '▼ ';
                element.innerHTML = `<span class="diff-badge" style="background:#fef2f2; color:#dc2626; font-weight:700; padding:2px 8px; border-radius:6px; font-size:0.75rem;">${icon}${diff} (${window.I18N_ANALYTICS?.vs_prev_30_days || 'vs пред. 30 дней'})</span>`;
            } else {
                element.innerHTML = `<span class="diff-badge" style="background:#f1f5f9; color:#64748b; font-weight:600; padding:2px 8px; border-radius:6px; font-size:0.75rem;">${window.I18N_ANALYTICS?.no_changes || 'Без изменений'}</span>`;
            }
        };

        updateDiff(data.today.leads, data.yesterday.leads, 'leads-diff');
        updateDiff(data.today.qualified, data.yesterday.qualified, 'qualified-diff');

        // Очищаем старые графики перед перерисовкой
        if (trafficChartInstance) {
            trafficChartInstance.destroy();
        }
        if (directionsChartInstance) {
            directionsChartInstance.destroy();
        }

        // 3. Круговой график: Распределение по статусам воронки (Pipeline Funnel)
        const trafficCtx = document.getElementById('trafficChart').getContext('2d');

        const funnelLabels = data.pipeline_funnel.map(f => {
            const normalizedStatus = strtolowerTrim(f.status);
            return statusLabels[normalizedStatus] || f.status;
        });
        const funnelData = data.pipeline_funnel.map(f => f.count);

        const palette = [
            '#3b82f6', // blue
            '#10b981', // green
            '#f59e0b', // amber
            '#ef4444', // red
            '#8b5cf6', // purple
            '#ec4899', // pink
            '#64748b', // slate
            '#6366f1', // indigo
        ];

        trafficChartInstance = new Chart(trafficCtx, {
            type: 'doughnut',
            data: {
                labels: funnelLabels,
                datasets: [{
                    data: funnelData,
                    backgroundColor: palette,
                    borderWidth: 0,
                    hoverOffset: 12,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            padding: 16,
                            font: { family: "'Inter', sans-serif", size: 12, weight: '500' },
                            color: '#64748b'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { family: "'Inter', sans-serif", size: 13, weight: '700' },
                        bodyFont: { family: "'Inter', sans-serif", size: 13 },
                        displayColors: true,
                        usePointStyle: true,
                    }
                }
            }
        });

        // 4. Горизонтальный столбчатый график: Нагрузка менеджеров (Manager Workload)
        const dirCtx = document.getElementById('directionsChart').getContext('2d');

        const dirGradient = dirCtx.createLinearGradient(0, 0, 400, 0);
        dirGradient.addColorStop(0, '#3b82f6');
        dirGradient.addColorStop(1, '#8b5cf6');

        const managerLabels = data.manager_workload.map(m => m.manager_name || (window.I18N_ANALYTICS?.unassigned || 'Не назначен'));
        const managerData = data.manager_workload.map(m => m.count);

        directionsChartInstance = new Chart(dirCtx, {
            type: 'bar',
            data: {
                labels: managerLabels,
                datasets: [{
                    label: window.I18N_ANALYTICS?.students || 'Студенты',
                    data: managerData,
                    backgroundColor: dirGradient,
                    borderRadius: 8,
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { family: "'Inter', sans-serif", size: 13, weight: '700' },
                        bodyFont: { family: "'Inter', sans-serif", size: 13 }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 11 },
                            color: '#64748b',
                            stepSize: 1
                        }
                    },
                    y: {
                        grid: { display: false, drawBorder: false },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 12, weight: '600' },
                            color: '#0f172a'
                        }
                    }
                }
            }
        });

        // 5. Заполнение таблицы последних регистраций студентов
        const tbody = document.getElementById('visitorsTableBody');
        tbody.innerHTML = '';
        
        if (data.recent_registrations && data.recent_registrations.length > 0) {
            data.recent_registrations.forEach(r => {
                const tr = document.createElement('tr');
                tr.style.borderBottom = '1px solid #f1f5f9';

                const date = new Date(r.created_at).toLocaleString(document.documentElement.lang === 'kk' ? 'kk-KZ' : 'ru-RU', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const normalizedStatus = strtolowerTrim(r.lead_status);
                const st = statusColors[normalizedStatus] || { bg: '#f3f4f6', text: '#374151' };
                const label = statusLabels[normalizedStatus] || r.lead_status;
                const statusBadge = `<span class="sbadge" style="background:${st.bg}; color:${st.text}; font-weight:700; padding:4px 10px; border-radius:20px;">${label}</span>`;

                tr.innerHTML = `
                    <td>
                        <div style="font-weight:700; color:#0f172a;">${r.full_name}</div>
                        <div style="font-size:0.75rem; color:#64748b; margin-top:2px;">${r.email || (window.I18N_ANALYTICS?.no_email || 'Нет email')}</div>
                    </td>
                    <td style="color:#334155; font-weight:500;">${r.phone || (window.I18N_ANALYTICS?.no_phone || 'Нет телефона')}</td>
                    <td style="color:#0f172a; font-weight:600;">👤 ${r.manager_name || (window.I18N_ANALYTICS?.unassigned || 'Не назначен')}</td>
                    <td>${statusBadge}</td>
                    <td style="text-align:right; color:#64748b; font-weight:500; font-size:0.85rem;">${date}</td>
                `;
                tbody.appendChild(tr);
            });
        } else {
            tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; padding:3rem; color:#94a3b8;">${window.I18N_ANALYTICS?.no_students || 'Нет зарегистрированных студентов за последнее время'}</td></tr>`;
        }

        // 6. Карточки для мобильных устройств
        const mobileList = document.getElementById('visitorsCards');
        if (mobileList) {
            mobileList.innerHTML = '';
            if (data.recent_registrations && data.recent_registrations.length > 0) {
                data.recent_registrations.forEach(r => {
                    const dt = new Date(r.created_at).toLocaleString(document.documentElement.lang === 'kk' ? 'kk-KZ' : 'ru-RU', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    });

                    const normalizedStatus = strtolowerTrim(r.lead_status);
                    const st = statusColors[normalizedStatus] || { bg: '#f3f4f6', text: '#374151' };
                    const label = statusLabels[normalizedStatus] || r.lead_status;
                    const statusBadge = `<span class="sbadge" style="background:${st.bg}; color:${st.text}; font-weight:700; padding:3px 8px; border-radius:20px; font-size:0.7rem;">${label}</span>`;

                    const card = document.createElement('div');
                    card.className = 'activity-card';
                    card.innerHTML = `
                        <div class="activity-card-top">
                            <span class="activity-card-name">${r.full_name}</span>
                            <span class="activity-card-time">${dt}</span>
                        </div>
                        <div style="font-size:0.75rem; color:#64748b; margin-top:-4px;">${r.email || (window.I18N_ANALYTICS?.no_email || 'Нет email')}</div>
                        <div style="font-size:0.85rem; color:#334155; margin-top:2px;">📞 ${r.phone || (window.I18N_ANALYTICS?.no_phone || 'Нет телефона')}</div>
                        <div class="activity-card-row" style="margin-top:6px;">
                            👤 <span style="font-size:0.8rem; font-weight:600; color:#0f172a;">${r.manager_name || (window.I18N_ANALYTICS?.unassigned || 'Не назначен')}</span>
                            <span style="margin-left:auto;">${statusBadge}</span>
                        </div>
                    `;
                    mobileList.appendChild(card);
                });
            } else {
                mobileList.innerHTML = `<div style="padding:30px; text-align:center; color:#94a3b8; font-size:0.875rem;">${window.I18N_ANALYTICS?.no_students || 'Нет данных'}</div>`;
            }
        }

    } catch (error) {
        console.error('Failed to load analytics:', error);
    } finally {
        isLoading = false;
    }
}

// Помощник для безопасной очистки и приведения к нижнему регистру
function strtolowerTrim(str) {
    if (typeof str !== 'string') return '';
    return str.toLowerCase().trim();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadAnalytics);
} else {
    loadAnalytics();
}
