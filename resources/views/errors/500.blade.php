<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Server Error | Prodesa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.favicon')
    @include('components.fonts')
    @include('components.design-tokens')
</head>
<body class="bg-gray-50 font-sans antialiased min-h-screen flex items-center justify-center">
    <div class="text-center px-6 max-w-lg">
        <div class="text-8xl font-bold text-red-500 mb-4">500</div>
        <h1 class="text-2xl font-semibold text-gray-800 mb-2">Terjadi Kesalahan Server</h1>
        <p class="text-gray-500 mb-8">Maaf, terjadi gangguan pada server. Silakan coba beberapa saat lagi atau hubungi perangkat desa.</p>
        <div class="flex gap-4 justify-center">
            <a href="/" class="inline-block px-6 py-3 bg-[#10b981] text-white rounded-full hover:bg-[#059669] transition font-medium">&larr; Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
