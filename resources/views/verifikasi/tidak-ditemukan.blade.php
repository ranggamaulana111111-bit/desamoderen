<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen Tidak Ditemukan - {{ config('village.nama_desa', 'Desa Kumpay') }}</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b' },
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out forwards',
                        'slide-up': 'slideUp 0.5s ease-out forwards',
                        'scale-in': 'scaleIn 0.4s ease-out forwards',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { opacity: '0', transform: 'translateY(24px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        scaleIn: { '0%': { opacity: '0', transform: 'scale(0.9)' }, '100%': { opacity: '1', transform: 'scale(1)' } },
                    }
                }
            }
        }
    </script>
    @include('components.favicon')
    @include('components.fonts')
    <style>
        .font-sans { font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif !important; }
        .a1 { animation-delay: .05s; } .a2 { animation-delay: .1s; } .a3 { animation-delay: .15s; }
        .a4 { animation-delay: .2s; } .a5 { animation-delay: .25s; }
        .gradient-notfound {
            background: linear-gradient(160deg, #7f1d1d 0%, #b91c1c 30%, #c2410c 65%, #ea580c 100%);
        }
        .gradient-process {
            background: linear-gradient(160deg, #1e1b4b 0%, #312e81 30%, #1e40af 65%, #0ea5e9 100%);
        }
        .section-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid rgba(226,232,240,0.8);
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.06);
        }
        .info-row {
            display: flex; align-items: flex-start; gap: 0.75rem;
            padding: 0.625rem 0;
        }
        .info-row + .info-row {
            border-top: 1px solid rgba(226,232,240,0.5);
        }
    </style>
    @include('components.design-tokens')
</head>
<body class="bg-gradient-to-br from-slate-50 via-gray-50 to-emerald-50/30 min-h-screen font-sans antialiased">

    {{-- ═══ HERO ═══ --}}
    <header class="relative overflow-hidden {{ $alasan === 'belum_selesai' ? 'gradient-process' : 'gradient-notfound' }}">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 800 400" fill="none"><circle cx="650" cy="80" r="200" fill="white"/><circle cx="100" cy="350" r="150" fill="white"/><circle cx="400" cy="200" r="100" fill="white"/></svg>
        </div>
        <div class="relative max-w-3xl mx-auto px-4 sm:px-6 py-10 sm:py-16 text-center text-white">
            <div class="mb-5 opacity-0 animate-scale-in a1">
                @if(config('village.logo_desa'))
                    <img src="{{ asset('storage/' . config('village.logo_desa')) }}" alt="Logo Desa" class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl mx-auto shadow-lg object-cover bg-white p-1">
                @else
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl mx-auto bg-white/15 backdrop-blur-sm flex items-center justify-center shadow-lg border border-white/20">
                        <svg class="w-9 h-9 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/></svg>
                    </div>
                @endif
            </div>
            <p class="text-white/70 text-xs sm:text-sm font-medium tracking-widest uppercase mb-1 opacity-0 animate-fade-in a2">Pemerintah {{ $desa }}</p>
            <h1 class="text-xl sm:text-2xl font-bold mb-0.5 opacity-0 animate-fade-in a3">{{ $kecamatan }}, {{ $kabupaten }}</h1>

            <div class="mt-5 opacity-0 animate-scale-in a4">
                <div class="inline-flex items-center gap-2.5 bg-white/15 backdrop-blur-sm rounded-full px-6 py-3 border border-white/25 shadow-xl">
                    <div class="w-8 h-8 rounded-full bg-white/25 flex items-center justify-center">
                        @if ($alasan === 'belum_selesai')
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        @endif
                    </div>
                    <div class="text-left">
                        <p class="text-sm font-bold text-white tracking-wide">{{ $alasan === 'belum_selesai' ? 'DOKUMEN BELUM DITERBITKAN' : 'DOKUMEN TIDAK DITEMUKAN' }}</p>
                        <p class="text-[11px] text-white/60">{{ $alasan === 'belum_selesai' ? 'Surat masih dalam proses penerbitan' : 'Kode verifikasi tidak terdaftar dalam sistem' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 56" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-8 sm:h-12"><path d="M0 56V28C240 56 480 0 720 28C960 56 1200 0 1440 28V56H0Z" fill="#f8fafc"/></svg>
        </div>
    </header>

    {{-- ═══ MAIN ═══ --}}
    <main class="max-w-3xl mx-auto px-4 sm:px-6 pb-12 -mt-4 relative z-10">
        <div class="space-y-5">

            <div class="section-card opacity-0 animate-slide-up a2">
                <div class="px-5 sm:px-6 pt-5 pb-4">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-5 rounded-full {{ $alasan === 'belum_selesai' ? 'bg-gradient-to-b from-indigo-400 to-blue-600' : 'bg-gradient-to-b from-red-400 to-orange-600' }}"></div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Apa Artinya Ini?</h2>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50/80 border border-gray-100">
                        <div class="w-10 h-10 rounded-xl {{ $alasan === 'belum_selesai' ? 'bg-indigo-50' : 'bg-red-50' }} flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 {{ $alasan === 'belum_selesai' ? 'text-indigo-500' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                        </div>
                        <div class="min-w-0">
                            @if ($alasan === 'belum_selesai')
                                <p class="text-sm font-semibold text-gray-800">Surat masih diproses</p>
                                <p class="text-sm text-gray-600 mt-1 leading-relaxed">Dokumen dengan kode verifikasi ini <span class="font-semibold text-gray-800">tercatat dalam sistem</span>, tetapi belum selesai diterbitkan / ditandatangani. Silakan cek kembali setelah proses selesai.</p>
                            @else
                                <p class="text-sm font-semibold text-gray-800">Dokumen tidak dapat diverifikasi</p>
                                <p class="text-sm text-gray-600 mt-1 leading-relaxed">Kode verifikasi ini <span class="font-semibold text-red-600">tidak terdaftar</span> dalam sistem <span class="font-semibold text-gray-800">Prodesa</span>. Hal ini bisa terjadi karena tautan/QR yang salah, atau dokumen yang Anda terima <span class="font-semibold">bukan dikeluarkan melalui sistem resmi desa</span>.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-card opacity-0 animate-slide-up a3">
                <div class="px-5 sm:px-6 pt-5 pb-4">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-5 rounded-full bg-gradient-to-b from-slate-400 to-slate-600"></div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Perlu Bantuan?</h2>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">Hubungi kantor desa untuk konfirmasi keabsahan dokumen Anda:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @php($wa = preg_replace('/\D/', '', (string) config('village.telepon_desa', '')))
                        @if ($wa)
                        <a href="https://wa.me/{{ str_starts_with($wa, '0') ? '62'.substr($wa, 1) : $wa }}" target="_blank" rel="noopener" class="flex items-center justify-center gap-2 p-3 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 hover:bg-emerald-100 transition font-semibold text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.297-.497.1-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            WhatsApp
                        </a>
                        @endif
                        @if (config('village.telepon_desa'))
                        <a href="tel:{{ config('village.telepon_desa') }}" class="flex items-center justify-center gap-2 p-3 rounded-xl bg-cyan-50 border border-cyan-100 text-cyan-700 hover:bg-cyan-100 transition font-semibold text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                            Telepon
                        </a>
                        @endif
                        @if (config('village.email_desa'))
                        <a href="mailto:{{ config('village.email_desa') }}" class="flex items-center justify-center gap-2 p-3 rounded-xl bg-violet-50 border border-violet-100 text-violet-700 hover:bg-violet-100 transition font-semibold text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            Email
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="section-card opacity-0 animate-slide-up a4">
                <div class="px-5 sm:px-6 pt-5 pb-4">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-5 rounded-full bg-gradient-to-b from-emerald-400 to-teal-600"></div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Lanjut Verifikasi</h2>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">Pastikan Anda memindai <span class="font-semibold">QR Code yang asli</span> dari surat yang diterbitkan oleh kantor desa. Tautan verifikasi resmi diawali domain pemerintah desa.</p>
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gray-900 hover:bg-gray-800 text-white font-semibold text-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                        Kembali ke Beranda Desa
                    </a>
                </div>
            </div>

        </div>

        <footer class="mt-8 opacity-0 animate-fade-in a5">
            <div class="text-center py-6 border-t border-gray-200/60">
                <div class="flex items-center justify-center gap-1.5 mb-2">
                    <div class="w-5 h-5 rounded bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-gray-500 tracking-wider">PRODESA</span>
                </div>
                <p class="text-[11px] text-gray-400">Digital Government Platform</p>
                <p class="text-[10px] text-gray-300 mt-1">Powered by Prodesa &middot; v{{ config('app.version', '1.0') }}</p>
            </div>
        </footer>

    </main>

</body>
</html>