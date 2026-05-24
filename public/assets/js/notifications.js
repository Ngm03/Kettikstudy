window.toggleNotificationDropdown = function () {
    const dropdown = document.getElementById('notificationDropdown');
    if (dropdown) {
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    }
};

window.markAllAsRead = async function () {
    try {
        await fetch(`${window.BASE_URL}/api/notifications/mark-all-read`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        });
        if (window.notificationSystem) {
            window.notificationSystem.checkNotifications();
        }
    } catch (error) {
        console.error('Failed to mark all as read:', error);
    }
};

window.toggleSound = function () {
    const currentState = localStorage.getItem('notificationSound');
    const newState = currentState === 'muted' ? 'enabled' : 'muted';
    localStorage.setItem('notificationSound', newState);

    const btn = document.getElementById('soundToggle');
    if (btn) {
        btn.textContent = newState === 'muted' ? '🔕' : '🔔';
        btn.title = newState === 'muted' ? 'Включить звук' : 'Выключить звук';
    }
};

window.handleNotificationClick = async function (id, url) {
    try {
        await fetch(`${window.BASE_URL}/api/notifications/mark-read`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });
        if (window.notificationSystem) {
            window.notificationSystem.checkNotifications();
        }
    } catch (error) {
        console.error('Failed to mark notification as read:', error);
    }

    if (url) {
        window.location.href = url;
    }
    document.getElementById('notificationDropdown').style.display = 'none';
};

(function () {
    'use strict';

    let lastCheck = Date.now();
    let badgeElement = null;
    let notificationCount = 0;

    function init() {
        if (typeof Notification !== 'undefined' && Notification.permission === 'default') {
            Notification.requestPermission();
        }

        badgeElement = document.querySelector('.notification-badge');

        const soundBtn = document.getElementById('soundToggle');
        if (soundBtn) {
            const isMuted = localStorage.getItem('notificationSound') === 'muted';
            soundBtn.textContent = isMuted ? '🔕' : '🔔';
            soundBtn.title = isMuted ? 'Включить звук' : 'Выключить звук';
        }

        checkNotifications();
        setInterval(checkNotifications, 15000);

        document.addEventListener('click', function (e) {
            const bell = document.getElementById('notificationBell');
            const dropdown = document.getElementById('notificationDropdown');
            if (bell && dropdown && !bell.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    }

    async function checkNotifications() {
        try {
            const response = await fetch(`${window.BASE_URL}/api/notifications/unread`);
            if (!response.ok) return;

            const data = await response.json();
            const notifications = data.notifications || [];

            updateBadge(notifications.length);

            updateDropdownList(notifications);

            notifications.forEach(notification => {
                const createdAt = new Date(notification.created_at).getTime();
                if (createdAt > lastCheck) {
                    showBrowserNotification(notification);
                }
            });

            lastCheck = Date.now();
        } catch (error) {
            console.error('Notification check failed:', error);
        }
    }

    function updateBadge(count) {
        if (count === notificationCount) return;

        notificationCount = count;

        if (badgeElement) {
            badgeElement.textContent = count;
            badgeElement.style.display = count > 0 ? 'flex' : 'none';
        }
    }

    function updateDropdownList(notifications) {
        const listEl = document.getElementById('notificationList');
        if (!listEl) return;

        if (notifications.length === 0) {
            listEl.innerHTML = '<div style="padding: 40px 20px; text-align: center; color: #9ca3af;">Нет уведомлений</div>';
            return;
        }

        listEl.innerHTML = notifications.map(n => `
            <div class="notification-item" onclick="handleNotificationClick(${n.id}, '${n.url || ''}')" style="padding: 16px; border-bottom: 1px solid #f3f4f6; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
                <div style="font-weight: 600; font-size: 0.9rem; color: #111827; margin-bottom: 4px;">${escapeHtml(n.title)}</div>
                <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 6px;">${escapeHtml(n.body)}</div>
                <div style="font-size: 0.75rem; color: #9ca3af;">${formatTime(n.created_at)}</div>
            </div>
        `).join('');
    }

    function showBrowserNotification(notification) {
        if (typeof Notification === 'undefined' || Notification.permission !== 'granted') return;

        playNotificationSound();

        const n = new Notification(notification.title, {
            body: notification.body,
            icon: `${window.BASE_URL}/favicon.ico`,
            tag: 'notification-' + notification.id,
            requireInteraction: false
        });

        n.onclick = function () {
            window.focus();
            handleNotificationClick(notification.id, notification.url);
            n.close();
        };
    }

    function playNotificationSound() {
        if (localStorage.getItem('notificationSound') === 'muted') return;

        try {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);

            oscillator.frequency.value = 800;
            oscillator.type = 'sine';

            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.2);

            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.2);
        } catch (error) {
            console.error('Failed to play notification sound:', error);
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function formatTime(dateStr) {
        const date = new Date(dateStr);
        const now = new Date();
        const diff = Math.floor((now - date) / 1000);

        if (diff < 60) return 'только что';
        if (diff < 3600) return Math.floor(diff / 60) + ' мин назад';
        if (diff < 86400) return Math.floor(diff / 3600) + ' ч назад';
        return date.toLocaleDateString('ru-RU');
    }

    window.notificationSystem = {
        checkNotifications: checkNotifications
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
