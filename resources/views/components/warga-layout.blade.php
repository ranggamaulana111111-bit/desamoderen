@props(['title' => 'Dashboard Warga'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - Prodesa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @include('components.favicon')
    @include('components.fonts')
    <x-pwa-assets />
    @include('components.design-tokens')
</head>
<body class="bg-gray-50 font-sans antialiased">

    <nav class="bg-white shadow-sm border-b sticky top-0 z-40">
        <div class="max-w-4xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('warga.dashboard') }}" class="text-lg font-bold text-emerald-700">Prodesa</a>
            <div class="flex items-center gap-3">
                <a href="{{ route('warga.surat.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">Riwayat</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-6">
        <x-alert />
        {{ $slot }}
    </div>

    @stack('scripts')
</body>
</html>
