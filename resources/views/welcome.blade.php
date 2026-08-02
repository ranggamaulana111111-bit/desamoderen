<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="0;url={{ url('/') }}">
    <title>Prodesa - Portal Desa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.favicon')
    @include('components.fonts')
    <style>
        .splash-loader { animation: pulse 1.5s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { opacity: 0.4; } 50% { opacity: 1; } }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased flex items-center justify-center min-h-screen">
    <div class="text-center">
        <div class="w-16 h-16 rounded-2xl bg-teal-600 flex items-center justify-center mx-auto mb-5 shadow-lg shadow-teal-600/25">
            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </div>
        <h1 class="text-xl font-bold text-gray-800 mb-2">Prodesa</h1>
        <p class="text-sm text-gray-400 mb-6">Portal Pelayanan Desa Digital</p>
        <div class="flex items-center justify-center gap-1.5 splash-loader">
            <span class="w-2 h-2 rounded-full bg-teal-500"></span>
            <span class="w-2 h-2 rounded-full bg-teal-500" style="animation-delay: 0.2s"></span>
            <span class="w-2 h-2 rounded-full bg-teal-500" style="animation-delay: 0.4s"></span>
        </div>
    </div>
    <script>window.location.href = '{{ url("/") }}';</script>
</body>
</html>
