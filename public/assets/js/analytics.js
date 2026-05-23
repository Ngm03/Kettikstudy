let trafficChartInstance = null;
let directionsChartInstance = null;
let isLoading = false;


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


        document.getElementById('visitors-count').textContent = data.today.visitors;
        document.getElementById('leads-count').textContent = data.today.leads;
        document.getElementById('qualified-count').textContent = data.today.qualified;
        document.getElementById('conversion-rate').textContent = data.today.conversion + '%';


        const updateDiff = (current, yesterday, elementId, labelId) => {
            const diff = current - yesterday;
            const element = document.getElementById(elementId);
            const label = document.getElementById(labelId);

            if (!element || !label) return;

            document.getElementById(labelId).textContent = yesterday;

            let badgeClass = 'diff-neutral';
            let icon = '';
            let text = 'Вчера: ' + yesterday;

            if (diff > 0) {
                badgeClass = 'diff-success';
                icon = '▲ ';
                element.innerHTML = `<span class="diff-badge" style="background:#ecfdf5; color:#059669;">${icon}+${diff} (vs ${yesterday})</span>`;
            } else if (diff < 0) {
                badgeClass = 'diff-danger';
                icon = '▼ ';
                element.innerHTML = `<span class="diff-badge" style="background:#fef2f2; color:#dc2626;">${icon}${diff} (vs ${yesterday})</span>`;
            } else {
                element.innerHTML = `<span class="diff-badge diff-neutral">Вчера: ${yesterday}</span>`;
            }
        };

        updateDiff(data.today.visitors, data.yesterday.visitors, 'visitors-diff', 'visitors-yesterday');
        updateDiff(data.today.leads, data.yesterday.leads, 'leads-diff', 'leads-yesterday');
        updateDiff(data.today.qualified, data.yesterday.qualified, 'qualified-diff', 'qualified-yesterday');


        if (trafficChartInstance) {
            trafficChartInstance.destroy();
        }
        if (directionsChartInstance) {
            directionsChartInstance.destroy();
        }


        const trafficCtx = document.getElementById('trafficChart').getContext('2d');
        const trafficGradient = trafficCtx.createLinearGradient(0, 0, 0, 400);

        const trafficLabels = data.traffic_sources.map(s => {
            let label = s.source || 'Прямой заход';
            if (label === 'Direct') label = 'Прямой заход';
            return label;
        });
        const trafficData = data.traffic_sources.map(s => s.count);


        const palette = [
            '#6366f1',
            '#8b5cf6',
            '#ec4899',
            '#10b981',
            '#f59e0b',
            '#3b82f6',
        ];

        trafficChartInstance = new Chart(trafficCtx, {
            type: 'doughnut',
            data: {
                labels: trafficLabels,
                datasets: [{
                    data: trafficData,
                    backgroundColor: palette,
                    borderWidth: 0,
                    hoverOffset: 15,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { family: "'Inter', sans-serif", size: 12 },
                            color: '#64748b'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 41, 59, 0.9)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { family: "'Inter', sans-serif", size: 13 },
                        bodyFont: { family: "'Inter', sans-serif", size: 13 },
                        displayColors: true,
                        usePointStyle: true,
                    }
                }
            }
        });


        const dirCtx = document.getElementById('directionsChart').getContext('2d');

        const dirGradient = dirCtx.createLinearGradient(0, 0, 400, 0);
        dirGradient.addColorStop(0, '#6366f1');
        dirGradient.addColorStop(1, '#a855f7');

        const directionLabels = data.top_directions.map(d => d.direction || 'Не указано');
        const directionData = data.top_directions.map(d => d.count);

        directionsChartInstance = new Chart(dirCtx, {
            type: 'bar',
            data: {
                labels: directionLabels,
                datasets: [{
                    label: 'Лиды',
                    data: directionData,
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
                        backgroundColor: 'rgba(30, 41, 59, 0.9)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { family: "'Inter', sans-serif" },
                        bodyFont: { family: "'Inter', sans-serif" }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { display: false }
                    },
                    y: {
                        grid: { display: false, drawBorder: false },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 12, weight: '500' },
                            color: '#64748b'
                        }
                    }
                }
            }
        });

        const tbody = document.getElementById('visitorsTableBody');
        tbody.innerHTML = '';
        if (data.recent_visits && data.recent_visits.length > 0) {
            data.recent_visits.forEach(v => {
                const tr = document.createElement('tr');
                tr.style.borderBottom = '1px solid #e5e7eb';

                let deviceIcon = '💻';
                let deviceName = 'ПК';

                if (v.device_type === 'mobile') {
                    deviceIcon = '📱';
                    deviceName = 'Смартфон';
                } else if (v.device_type === 'tablet') {
                    deviceIcon = '📟';
                    deviceName = 'Планшет';
                }

                let sourceName = v.utm_source || 'Прямой заход';
                if (sourceName === 'Direct') sourceName = 'Прямой заход';

                const date = new Date(v.created_at).toLocaleString('ru-RU');

                tr.innerHTML = `
                    <td style="font-weight:600;color:#334155;">${v.ip_address || 'Скрыт'}</td>
                    <td><span class="source-badge">${sourceName}</span></td>
                    <td><span class="device-badge">${deviceIcon} ${deviceName}</span></td>
                    <td style="text-align:center;font-weight:bold;">${v.page_views}</td>
                    <td style="text-align:right;color:#94a3b8;font-size:0.85rem;">${date}</td>
                `;
                tbody.appendChild(tr);
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;padding:3rem;color:#94a3b8;">Нет данных за последнее время</td></tr>';
        }

        const mobileList = document.getElementById('visitorsCards');
        if (mobileList) {
            mobileList.innerHTML = '';
            if (data.recent_visits && data.recent_visits.length > 0) {
                data.recent_visits.forEach(v => {
                    let dIcon = '💻', dName = 'ПК';
                    if (v.device_type === 'mobile') { dIcon = '📱'; dName = 'Смартфон'; }
                    else if (v.device_type === 'tablet') { dIcon = '📟'; dName = 'Планшет'; }
                    let src = v.utm_source || 'Прямой заход';
                    if (src === 'Direct') src = 'Прямой заход';
                    const dt = new Date(v.created_at).toLocaleString('ru-RU');
                    const card = document.createElement('div');
                    card.className = 'activity-card';
                    card.innerHTML = `
                        <div class="activity-card-top">
                            <span class="activity-card-ip">${v.ip_address || 'Скрыт'}</span>
                            <span class="activity-card-time">${dt}</span>
                        </div>
                        <div class="activity-card-row">
                            <span class="source-badge">${src}</span>
                            <span class="device-badge">${dIcon} ${dName}</span>
                            <span style="font-size:0.75rem;color:#64748b;margin-left:auto;">👁 ${v.page_views}</span>
                        </div>
                    `;
                    mobileList.appendChild(card);
                });
            } else {
                mobileList.innerHTML = '<div style="padding:30px;text-align:center;color:#94a3b8;font-size:0.875rem;">Нет данных</div>';
            }
        }

    } catch (error) {
        console.error('Failed to load analytics:', error);
    } finally {
        isLoading = false;
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadAnalytics);
} else {
    loadAnalytics();
}
