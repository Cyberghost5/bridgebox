const CACHE_NAME = 'bridgebox-offline-v2';

const PRECACHE_URLS = [
    '/',
    '/login/admin',
    '/login/teacher',
    '/login/student',
    '/assets/css/auth.css',
    '/assets/js/auth.js',
    '/assets/js/landing.js',
    '/assets/js/offline.js',
    '/assets/fonts/dm-sans-400.ttf',
    '/assets/fonts/dm-sans-500.ttf',
    '/assets/fonts/dm-sans-700.ttf',
    '/assets/fonts/sora-400.ttf',
    '/assets/fonts/sora-500.ttf',
    '/assets/fonts/sora-600.ttf',
    '/assets/fonts/sora-700.ttf',
    '/favicon.ico'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => cache.addAll(PRECACHE_URLS))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(
                keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key))
            )
        ).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') {
        return;
    }

    event.respondWith(
        caches.match(event.request).then((cached) => {
            if (cached) {
                return cached;
            }

            return fetch(event.request)
                .then((response) => {
                    const copy = response.clone();
                    caches.open(CACHE_NAME).then((cache) => cache.put(event.request, copy));
                    return response;
                })
                .catch(() => caches.match('/'));
        })
    );
});
