@props(['title' => 'Prodesa', 'showNav' => true])

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

    @if($showNav)
    <nav class="bg-white shadow-sm border-b sticky top-0 z-40">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-lg font-bold text-[#0068BD]">Prodesa</a>
            <div class="flex items-center gap-4">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-[#0068BD] hover:text-[#005AA6] font-medium">Admin</a>
                    @elseif(auth()->user()->isLembaga())
                        <a href="{{ route('lembaga.dashboard') }}" class="text-sm text-[#0068BD] hover:text-[#005AA6] font-medium">Dashboard Lembaga</a>
                    @else
                        <a href="{{ route('warga.dashboard') }}" class="text-sm text-[#0068BD] hover:text-[#005AA6] font-medium">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-sm text-[#0068BD] hover:text-[#005AA6] font-medium">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>
    @endif

    <x-alert />
    {{ $slot }}

    @stack('scripts')
</body>
</html>
