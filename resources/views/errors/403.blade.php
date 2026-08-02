<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak | Prodesa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.favicon')
    @include('components.fonts')
</head>
<body class="bg-gray-50 font-sans antialiased min-h-screen flex items-center justify-center">
    <div class="text-center px-6 max-w-lg">
        <div class="text-8xl font-bold text-teal-600 mb-4">403</div>
        <h1 class="text-2xl font-semibold text-gray-800 mb-2">Akses Ditolak</h1>
        <p class="text-gray-500 mb-8">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi perangkat desa jika Anda memerlukan bantuan.</p>
        <div class="flex gap-4 justify-center">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : '/' }}" class="inline-block px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition font-medium">&larr; Kembali</a>
            <a href="/" class="inline-block px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition font-medium">Beranda</a>
        </div>
    </div>
</body>
</html>
