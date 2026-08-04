/* Prodesa Service Worker */
const VERSION = 'prodesa-v1';

const PRECACHE = [
  '/',
  '/pwa/manifest.webmanifest',
  '/pwa/icon-192.png',
  '/pwa/icon-512.png',
  '/pwa/icon-maskable-512.png',
  '/favicon.ico',
];

const CDN = [
  'https://cdn.tailwindcss.com',
  'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js',
  'https://api.fontshare.com/v2/css?f[]=general-sans@400,500,600,700&display=swap',
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    (async () => {
      const cache = await caches.open(VERSION);
      for (const url of PRECACHE) {
        try {
          const res = await fetch(url, { credentials: 'same-origin' });
          if (res.ok) await cache.put(url, res);
        } catch (e) {
          /* abaikan aset yang gagal saat install */
        }
      }
      for (const url of CDN) {
        try {
          await cache.add(url);
        } catch (e) {
          /* CDN boleh gagal; tidak menghalangi install */
        }
      }
      await self.skipWaiting();
    })(),
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    (async () => {
      const keys = await caches.keys();
      await Promise.all(keys.filter((k) => k !== VERSION).map((k) => caches.delete(k)));
      await self.clients.claim();
    })(),
  );
});

self.addEventListener('fetch', (event) => {
  const { request } = event;

  if (request.method !== 'GET') return;

  const url = new URL(request.url);

  if (request.mode === 'navigate') {
    event.respondWith(
      (async () => {
        try {
          const res = await fetch(request);
          const cache = await caches.open(VERSION);
          cache.put(request, res.clone());
          return res;
        } catch (e) {
          const cached = await caches.match(request);
          return cached || (await caches.match('/')) || Response.error();
        }
      })(),
    );
    return;
  }

  if (url.origin === location.origin || CDN.includes(url.href)) {
    event.respondWith(
      (async () => {
        const cache = await caches.open(VERSION);
        const cached = await cache.match(request);
        const network = fetch(request)
          .then((res) => {
            if (res.ok) cache.put(request, res.clone());
            return res;
          })
          .catch(() => cached || Response.error());
        return cached || network;
      })(),
    );
  }
});
