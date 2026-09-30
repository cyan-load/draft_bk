// SIM-BK Service Worker for PWA & Push Notifications
const CACHE_NAME = 'simbk-v1';

// Install event - activate immediately
self.addEventListener('install', event => {
    self.skipWaiting();
});

// Activate event - claim clients immediately
self.addEventListener('activate', event => {
    event.waitUntil(self.clients.claim());
});

// Handle Push Notifications from Server / WebPush
self.addEventListener('push', event => {
    let data = {};
    if (event.data) {
        try {
            data = event.data.json();
        } catch (e) {
            data = { title: 'Notifikasi SIM-BK', message: event.data.text() };
        }
    }

    const title = data.title || 'Notifikasi SIM-BK';
    const options = {
        body: data.message || 'Anda memiliki pemberitahuan baru di SIM-BK.',
        icon: data.icon || '/icon-192.png',
        badge: '/icon-192.png',
        vibrate: [200, 100, 200],
        data: {
            url: data.url || '/'
        },
        tag: data.tag || 'simbk-notif-' + Date.now(),
        renotify: true
    };

    event.waitUntil(self.registration.showNotification(title, options));
});

// Handle notification tap / click from mobile status bar
self.addEventListener('notificationclick', event => {
    event.notification.close();

    const targetUrl = (event.notification.data && event.notification.data.url) 
        ? event.notification.data.url 
        : '/';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(clientList => {
            for (let i = 0; i < clientList.length; i++) {
                const client = clientList[i];
                if ('focus' in client) {
                    client.focus();
                    if (targetUrl && targetUrl !== '/') {
                        client.navigate(targetUrl);
                    }
                    return;
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});

// Handle message from client page to show background notification
self.addEventListener('message', event => {
    if (event.data && event.data.type === 'SHOW_NOTIFICATION') {
        const payload = event.data.payload || {};
        const title = payload.title || 'Notifikasi SIM-BK';
        const options = {
            body: payload.message || '',
            icon: payload.icon || '/icon-192.png',
            badge: '/icon-192.png',
            vibrate: [200, 100, 200],
            data: {
                url: payload.url || '/'
            },
            tag: payload.tag || ('simbk-' + Date.now()),
            renotify: true
        };
        self.registration.showNotification(title, options);
    }
});
