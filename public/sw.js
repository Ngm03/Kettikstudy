self.addEventListener('push', function (event) {
    const data = event.data ? event.data.json() : {};

    const title = data.title || 'Kettik Study';
    const options = {
        body: data.body || 'Новое уведомление',
        icon: '/assets/images/logo.png',
        badge: '/assets/images/badge.png',
        data: {
            url: data.url || '/admin/dashboard',
            timestamp: Date.now()
        },
        vibrate: [200, 100, 200],
        tag: data.tag || 'default',
        requireInteraction: true,
        actions: data.actions || [
            { action: 'open', title: 'Открыть' },
            { action: 'close', title: 'Закрыть' }
        ]
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    if (event.action === 'close') {
        return;
    }

    event.waitUntil(
        clients.openWindow(event.notification.data.url)
    );
});
