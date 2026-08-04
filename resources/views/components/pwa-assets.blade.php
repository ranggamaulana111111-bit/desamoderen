{{-- Aset PWA: manifest, theme-color, apple touch icon, dan registrasi service worker. --}}
<link rel="manifest" href="/pwa/manifest.json">
<meta name="theme-color" content="#065f46">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Prodesa">
<link rel="apple-touch-icon" href="/pwa/icon-192.png">
<style>
    @media (display-mode: standalone) {
        html, body { -webkit-tap-highlight-color: transparent; }
        body { overscroll-behavior-y: none; }
    }
</style>
<script>
    if ('serviceWorker' in navigator && (location.protocol === 'https:' || ['localhost', '127.0.0.1'].includes(location.hostname))) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/pwa/sw.js').catch(function () {});
        });
    }
</script>
