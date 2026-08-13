<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug QR Code - Prodesa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.design-tokens')
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-lg w-full">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-2">Debug QR Code</h1>
        <p class="text-center text-gray-500 text-sm mb-6">Halaman uji coba QR Code Verifikasi Dokumen</p>

        <div class="flex justify-center mb-6">
            <img src="data:image/svg+xml;base64,{{ $qrBase64 }}"
                 alt="QR Code Verifikasi" class="w-48 h-48 border-2 border-dashed border-gray-300 rounded-xl p-2">
        </div>

        <div class="bg-gray-50 rounded-lg p-4 mb-4 space-y-2 text-sm">
            <p class="font-semibold text-gray-700">URL Verifikasi:</p>
            <p class="text-teal-600 break-all bg-white p-2 rounded border text-xs font-mono">{{ $verifyUrl }}</p>
        </div>

        <div class="border-t pt-4 space-y-3">
            <h2 class="font-semibold text-gray-700">Data Warga Simulasi</h2>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Nama</span>
                <span class="font-semibold">{{ $pengajuan->user->name }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">NIK</span>
                <span class="font-semibold">{{ $pengajuan->user->nik }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Jenis Surat</span>
                <span class="font-semibold capitalize">{{ str_replace('_', ' ', $pengajuan->jenis_surat) }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Nomor Surat</span>
                <span class="font-semibold">{{ $pengajuan->nomor_surat ?? '-' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Hash Verifikasi</span>
                <span class="font-mono text-xs text-gray-600 truncate max-w-[200px]">{{ $pengajuan->hash_verifikasi }}</span>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t text-xs text-gray-400 space-y-1">
            <p><strong>Cara uji:</strong> Scan QR di atas atau buka URL verifikasi di browser.</p>
            <p>Halaman ini bersifat sementara dan hanya untuk debugging.</p>
            <p class="mt-2"><a href="{{ route('home') }}" class="text-teal-500 hover:underline">&larr; Kembali ke Beranda</a></p>
        </div>
    </div>
</body>
</html>
