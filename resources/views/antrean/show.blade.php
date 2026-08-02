<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrean Pengambilan - {{ config('village.nama_desa', 'Desa Kumpay') }}</title>
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
        .a1{animation-delay:.05s} .a2{animation-delay:.1s} .a3{animation-delay:.15s} .a4{animation-delay:.2s} .a5{animation-delay:.25s}
        .a6{animation-delay:.3s} .a7{animation-delay:.35s} .a8{animation-delay:.4s} .a9{animation-delay:.45s} .a10{animation-delay:.5s}
        .gradient-waiting {
            background: linear-gradient(160deg, #1e3a5f 0%, #1e40af 30%, #3b82f6 60%, #06b6d4 100%);
        }
        .gradient-done {
            background: linear-gradient(160deg, #064e3b 0%, #065f46 25%, #047857 50%, #0d9488 75%, #0f766e 100%);
        }
        .gradient-expired {
            background: linear-gradient(160deg, #78350f 0%, #92400e 30%, #b45309 60%, #d97706 100%);
        }
        .glass-card {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255,255,255,0.6);
        }
        .section-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid rgba(226,232,240,0.8);
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.06);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .section-card:hover {
            box-shadow: 0 12px 40px rgba(0,0,0,0.1), 0 4px 12px rgba(0,0,0,0.05);
            border-color: rgba(16,185,129,0.2);
        }
        .queue-number {
            font-variant-numeric: tabular-nums;
            letter-spacing: 0.08em;
        }
        .info-row {
            display: flex; align-items: flex-start; gap: 0.75rem;
            padding: 0.625rem 0;
        }
        .info-row + .info-row {
            border-top: 1px solid rgba(226,232,240,0.5);
        }
        .check-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.625rem 0;
        }
        .check-item + .check-item {
            border-top: 1px solid rgba(226,232,240,0.5);
        }
        @keyframes countPulse { 0%,100% { opacity:1; } 50% { opacity:.5; } }
        .count-pulse { animation: countPulse 2s ease-in-out infinite; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-gray-50 to-blue-50/30 min-h-screen font-sans antialiased" x-data="antreanApp()" x-init="init()">

    @php
        $status = $antrean->status;
        $isWaiting = $status === 'menunggu';
        $isDone = $status === 'diambil';
        $isExpired = $status === 'lewat';
    @endphp

    {{-- ═══ SECTION 1: HERO HEADER ═══ --}}
    <header class="relative overflow-hidden {{ $isDone ? 'gradient-done' : ($isExpired ? 'gradient-expired' : 'gradient-waiting') }}">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 800 400" fill="none"><circle cx="650" cy="80" r="200" fill="white"/><circle cx="100" cy="350" r="150" fill="white"/><circle cx="400" cy="200" r="100" fill="white"/></svg>
        </div>
        <div class="relative max-w-3xl mx-auto px-4 sm:px-6 py-10 sm:py-16 text-center text-white">
            {{-- Logo --}}
            <div class="mb-5 opacity-0 animate-scale-in a1">
                @if(config('village.logo_desa'))
                    <img src="{{ asset('storage/' . config('village.logo_desa')) }}" alt="Logo Desa" class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl mx-auto shadow-lg object-cover bg-white p-1">
                @else
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl mx-auto bg-white/15 backdrop-blur-sm flex items-center justify-center shadow-lg border border-white/20">
                        <svg class="w-9 h-9 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Title --}}
            <p class="text-white/70 text-xs sm:text-sm font-medium tracking-widest uppercase mb-1 opacity-0 animate-fade-in a2">Pemerintah {{ config('village.nama_desa', 'Desa Kumpay') }}</p>
            <h1 class="text-xl sm:text-2xl font-bold mb-1 opacity-0 animate-fade-in a3">Antrean Pengambilan Dokumen</h1>
            <p class="text-white/60 text-sm mb-5 opacity-0 animate-fade-in a4">Silakan datang sesuai jadwal yang telah ditentukan.</p>

            {{-- Status Badge --}}
            <div class="mt-2 opacity-0 animate-scale-in a5">
                <div class="inline-flex items-center gap-2.5 bg-white/15 backdrop-blur-sm rounded-full px-6 py-3 border border-white/25 shadow-xl">
                    @if($isDone)
                        <div class="w-8 h-8 rounded-full bg-emerald-400/25 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-bold text-white tracking-wide">SELESAI DIAMBIL</p>
                            <p class="text-[11px] text-white/60">Dokumen telah diterima</p>
                        </div>
                    @elseif($isExpired)
                        <div class="w-8 h-8 rounded-full bg-red-400/25 flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-bold text-white tracking-wide">JADWAL TERLEWAT</p>
                            <p class="text-[11px] text-white/60">Silakan hubungi kantor desa</p>
                        </div>
                    @else
                        <div class="w-8 h-8 rounded-full bg-blue-400/25 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-bold text-white tracking-wide">MENUNGGU PENGAMBILAN</p>
                            <p class="text-[11px] text-white/60">Harap datang sesuai jadwal</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{-- Wave Separator --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 56" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-8 sm:h-12"><path d="M0 56V28C240 56 480 0 720 28C960 56 1200 0 1440 28V56H0Z" fill="#f8fafc"/></svg>
        </div>
    </header>

    {{-- ═══ MAIN CONTENT ═══ --}}
    <main class="max-w-3xl mx-auto px-4 sm:px-6 pb-12 -mt-4 relative z-10">

        @if($isExpired)
        <div class="mb-6 opacity-0 animate-slide-up a1">
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border border-red-200/80 rounded-2xl p-4 sm:p-5 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-red-800">Jadwal Pengambilan Telah Lewat</p>
                        <p class="text-sm text-red-700 mt-1">Hubungi kantor desa untuk informasi lebih lanjut mengenai pengambilan dokumen Anda.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="space-y-5">

            {{-- ═══ SECTION 2: NOMOR ANTREAN ═══ --}}
            <div class="section-card opacity-0 animate-slide-up a2 overflow-visible">
                <div class="px-5 sm:px-6 pt-6 pb-6 text-center">
                    <p class="text-[11px] text-gray-400 font-bold uppercase tracking-[0.2em] mb-3">Nomor Antrean Anda</p>
                    <div class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl px-6 sm:px-10 py-4 sm:py-5 border border-blue-100/80 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-sm flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                        </div>
                        <p class="text-2xl sm:text-3xl font-extrabold text-gray-900 queue-number">{{ $antrean->nomor_antrean }}</p>
                    </div>
                    @if($isWaiting)
                        <p class="text-xs text-blue-600 font-medium mt-3 count-pulse">Menunggu pemanggilan</p>
                    @endif
                </div>
            </div>

            {{-- ═══ SECTION 3: INFORMASI PEMOHON ═══ --}}
            <div class="section-card opacity-0 animate-slide-up a3">
                <div class="px-5 sm:px-6 pt-5 pb-4">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-5 rounded-full bg-gradient-to-b from-emerald-400 to-emerald-600"></div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Informasi Pemohon</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="flex items-center gap-3 p-3 bg-gray-50/80 rounded-xl border border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Nama</p>
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $antrean->pengajuan->user->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50/80 rounded-xl border border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center text-white shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">NIK</p>
                                <p class="text-sm font-bold text-gray-900 font-mono tracking-wide">{{ $antrean->pengajuan->user->nik }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50/80 rounded-xl border border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Jenis Surat</p>
                                <p class="text-sm font-bold text-gray-900 capitalize">{{ str_replace('_', ' ', $antrean->pengajuan->jenis_surat) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ SECTION 4: JADWAL PENGAMBILAN ═══ --}}
            @php
                $jamMulai = \Carbon\Carbon::parse($antrean->jam_mulai)->format('H:i');
                $jamSelesai = \Carbon\Carbon::parse($antrean->jam_selesai)->format('H:i');
                $tanggalFormatted = \Carbon\Carbon::parse($antrean->tanggal_ambil)->locale('id')->translatedFormat('l, d F Y');
                $estimasi = \Carbon\Carbon::parse($antrean->jam_mulai)->diffInMinutes(\Carbon\Carbon::parse($antrean->jam_selesai));
            @endphp
            <div class="section-card opacity-0 animate-slide-up a4">
                <div class="px-5 sm:px-6 pt-5 pb-4">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-5 rounded-full bg-gradient-to-b from-blue-400 to-indigo-600"></div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Jadwal Pengambilan</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="info-row sm:border-t-0">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4.5 h-4.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Tanggal</p>
                                <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $tanggalFormatted }}</p>
                            </div>
                        </div>
                        <div class="info-row sm:border-t-0">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4.5 h-4.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Jam</p>
                                <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $jamMulai }} - {{ $jamSelesai }} WIB</p>
                            </div>
                        </div>
                        <div class="info-row sm:border-t-0">
                            <div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4.5 h-4.5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Estimasi Pelayanan</p>
                                <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $estimasi }} menit</p>
                            </div>
                        </div>
                        <div class="info-row sm:border-t-0">
                            <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4.5 h-4.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Lokasi</p>
                                <p class="text-sm font-bold text-gray-900 mt-0.5">{{ config('village.nama_desa', 'Desa Kumpay') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Countdown for waiting --}}
                    @if($isWaiting)
                    <div class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100/80" x-data x-init="$nextTick(() => { countdownTarget = '{{ \Carbon\Carbon::parse($antrean->tanggal_ambil)->format('Y-m-d') }}T{{ $jamMulai }}:00'; startCountdown(); })">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-xs font-bold text-blue-700 uppercase tracking-wider">Hitung Mundur</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="text-center">
                                <p class="text-2xl font-extrabold text-blue-800" x-text="countdown.days">0</p>
                                <p class="text-[10px] text-blue-500 font-medium">Hari</p>
                            </div>
                            <p class="text-lg font-bold text-blue-300">:</p>
                            <div class="text-center">
                                <p class="text-2xl font-extrabold text-blue-800" x-text="countdown.hours">0</p>
                                <p class="text-[10px] text-blue-500 font-medium">Jam</p>
                            </div>
                            <p class="text-lg font-bold text-blue-300">:</p>
                            <div class="text-center">
                                <p class="text-2xl font-extrabold text-blue-800" x-text="countdown.minutes">0</p>
                                <p class="text-[10px] text-blue-500 font-medium">Menit</p>
                            </div>
                            <p class="text-lg font-bold text-blue-300">:</p>
                            <div class="text-center">
                                <p class="text-2xl font-extrabold text-blue-800" x-text="countdown.seconds">0</p>
                                <p class="text-[10px] text-blue-500 font-medium">Detik</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- ═══ SECTION 5: STATUS PROGRESS ═══ --}}
            <div class="section-card opacity-0 animate-slide-up a5">
                <div class="px-5 sm:px-6 pt-5 pb-5">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-1.5 h-5 rounded-full bg-gradient-to-b from-blue-400 to-indigo-600"></div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Status Pengajuan</h2>
                    </div>

                    @php
                        $activeIndex = $isDone ? 4 : ($isExpired ? 3 : ($isWaiting ? 3 : 4));
                        $progressSteps = [
                            ['label' => 'Diajukan', 'sub' => 'Warga'],
                            ['label' => 'Diverifikasi', 'sub' => 'Operator'],
                            ['label' => 'Disetujui', 'sub' => 'Pemerintah'],
                            ['label' => 'Siap Diambil', 'sub' => 'Antrean'],
                            ['label' => 'Selesai', 'sub' => 'Diterima'],
                        ];
                    @endphp

                    {{-- Desktop: Horizontal --}}
                    <div class="hidden sm:block">
                        <div class="flex items-start justify-between relative">
                            <div class="absolute top-5 left-[10%] right-[10%] h-0.5 bg-gray-200 rounded-full"></div>
                            <div class="absolute top-5 left-[10%] h-0.5 bg-gradient-to-r from-emerald-400 to-emerald-500 rounded-full transition-all duration-700" style="width: {{ $isDone ? '80%' : ($isExpired ? '60%' : '60%') }}; max-width: 80%;"></div>

                            @foreach($progressSteps as $i => $step)
                                @php
                                    $completed = $i < ($isDone ? 5 : ($isExpired ? 4 : 4));
                                    $active = $i === ($isDone ? 4 : ($isExpired ? 3 : 3));
                                @endphp
                                <div class="flex flex-col items-center relative z-10" style="flex:1; {{ $i === 0 ? 'max-width:20%;' : '' }}">
                                    @if($active && $isExpired)
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-lg shadow-amber-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                        </div>
                                    @elseif($completed || $active)
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        </div>
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                    @endif
                                    <p class="text-xs font-bold {{ $completed || $active ? 'text-gray-800' : 'text-gray-400' }} mt-2 text-center">{{ $step['label'] }}</p>
                                    <p class="text-[10px] {{ $completed || $active ? 'text-emerald-600' : 'text-gray-300' }} font-medium text-center">{{ $step['sub'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Mobile: Vertical --}}
                    <div class="sm:hidden space-y-0">
                        @foreach($progressSteps as $i => $step)
                            @php
                                $completed = $i < ($isDone ? 5 : ($isExpired ? 4 : 4));
                                $active = $i === ($isDone ? 4 : ($isExpired ? 3 : 3));
                            @endphp
                            <div class="flex items-start gap-3 relative {{ $i < 4 ? 'pb-4' : '' }}">
                                @if($i < 4)
                                    <div class="absolute top-10 left-4 w-0.5 h-full {{ $completed ? 'bg-emerald-200' : 'bg-gray-200' }}"></div>
                                @endif
                                @if($active && $isExpired)
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-md flex-shrink-0 relative z-10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                    </div>
                                @elseif($completed || $active)
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-md flex-shrink-0 relative z-10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    </div>
                                @else
                                    <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 flex-shrink-0 relative z-10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                @endif
                                <div class="pt-1.5">
                                    <p class="text-sm font-semibold {{ $completed || $active ? 'text-gray-800' : 'text-gray-400' }}">{{ $step['label'] }}</p>
                                    <p class="text-[10px] {{ $completed ? 'text-emerald-600 font-medium' : ($active && $isExpired ? 'text-amber-600 font-medium' : ($active ? 'text-blue-600 font-medium' : 'text-gray-300')) }}">{{ $completed ? 'Selesai' : ($active && $isExpired ? 'Terlewat' : ($active ? 'Saat Ini' : 'Menunggu')) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ═══ SECTION 6: QR CODE ═══ --}}
            @php
                $qrUrl = route('antrean.show', $antrean->kode_qr);
            @endphp
            <div class="section-card opacity-0 animate-slide-up a6">
                <div class="px-5 sm:px-6 pt-5 pb-5">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-5 rounded-full bg-gradient-to-b from-indigo-400 to-indigo-600"></div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">QR Code</h2>
                    </div>
                    <div class="flex flex-col items-center p-5 bg-gray-50/80 rounded-2xl border border-gray-100">
                        <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 mb-3">
                            {!! QrCode::format('svg')->size(160)->generate($qrUrl) !!}
                        </div>
                        <p class="text-[11px] text-gray-400 font-medium text-center">Scan saat datang ke kantor desa</p>
                        <p class="text-[10px] text-gray-300 mt-1 font-mono">{{ $antrean->kode_qr }}</p>
                    </div>
                </div>
            </div>

            {{-- ═══ SECTION 7: INFORMASI PENGAMBILAN ═══ --}}
            <div class="section-card opacity-0 animate-slide-up a7">
                <div class="px-5 sm:px-6 pt-5 pb-4">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-5 rounded-full bg-gradient-to-b from-amber-400 to-amber-600"></div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Informasi Pengambilan</h2>
                    </div>
                    <div class="space-y-0">
                        <div class="check-item">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4.5 h-4.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800">Datang 10 menit sebelum jadwal</p>
                                <p class="text-[11px] text-gray-400">Untuk proses verifikasi yang lebih lancar</p>
                            </div>
                        </div>
                        <div class="check-item">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4.5 h-4.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800">Membawa KTP asli</p>
                                <p class="text-[11px] text-gray-400">Sebagai bukti identitas resmi</p>
                            </div>
                        </div>
                        <div class="check-item">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4.5 h-4.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800">Membawa nomor antrean</p>
                                <p class="text-[11px] text-gray-400">Tunjukkan QR Code atau sebutkan nomor antrean</p>
                            </div>
                        </div>
                        <div class="check-item">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4.5 h-4.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800">Pengambilan dapat diwakilkan</p>
                                <p class="text-[11px] text-gray-400">Sesuai ketentuan, wajib membawa surat kuasa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ SECTION 8: KONTAK DESA ═══ --}}
            @php
                $lat = config('village.latitude');
                $lng = config('village.longitude');
                $hasCoords = $lat && $lng;
            @endphp
            <div class="section-card opacity-0 animate-slide-up a8">
                <div class="px-5 sm:px-6 pt-5 pb-4">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-5 rounded-full bg-gradient-to-b from-slate-400 to-slate-600"></div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Kontak Desa</h2>
                    </div>

                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100">
                        @if(config('village.logo_desa'))
                            <img src="{{ asset('storage/' . config('village.logo_desa')) }}" alt="Logo" class="w-12 h-12 rounded-xl object-cover shadow-sm bg-white border border-gray-100 p-0.5">
                        @else
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white shadow-sm flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/></svg>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ config('village.nama_desa', 'Desa Kumpay') }}</p>
                            <p class="text-[11px] text-gray-400">Kec. {{ config('village.nama_kecamatan', 'Ciasem') }}, Kab. {{ config('village.nama_kabupaten', 'Subang') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0">
                        <div class="info-row sm:border-r sm:pr-4">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Alamat</p>
                                <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ config('village.alamat_kantor', '-') }}</p>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Email</p>
                                <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ config('village.email_desa', '-') }}</p>
                            </div>
                        </div>
                        <div class="info-row sm:border-t sm:border-r sm:pr-4">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Telepon</p>
                                <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ config('village.telepon_desa', '-') }}</p>
                            </div>
                        </div>
                        <div class="info-row sm:border-t">
                            <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Website</p>
                                <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ config('village.website_desa', '-') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Google Maps --}}
                    @if($hasCoords)
                    <div class="mt-4 rounded-xl overflow-hidden border border-gray-100">
                        <a href="https://www.google.com/maps?q={{ $lat }},{{ $lng }}" target="_blank" rel="noopener" class="block relative group">
                            <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ $lat }},{{ $lng }}&zoom=15&size=600x200&markers=color:green%7C{{ $lat }},{{ $lng }}&style=feature:all|element:labels|visibility:on" alt="Peta Lokasi" class="w-full h-32 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent flex items-end p-3">
                                <div class="flex items-center gap-2 text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                    <span class="text-xs font-semibold">Buka di Google Maps</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- ═══ FOOTER ═══ --}}
        <footer class="mt-8 opacity-0 animate-fade-in a9">
            <div class="text-center py-6 border-t border-gray-200/60">
                <div class="flex items-center justify-center gap-1.5 mb-2">
                    <div class="w-5 h-5 rounded bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-gray-500 tracking-wider">PRODESA</span>
                </div>
                <p class="text-[11px] text-gray-400">Digital Government Platform</p>
                <p class="text-[10px] text-gray-300 mt-1">&copy; {{ date('Y') }} {{ config('village.nama_desa', 'Desa Kumpay') }} &middot; Powered by Prodesa</p>
            </div>
        </footer>

    </main>

    {{-- ═══ ALPINE.JS ═══ --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function antreanApp() {
            return {
                countdownTarget: '',
                countdown: { days: 0, hours: 0, minutes: 0, seconds: 0 },
                timer: null,

                init() {},

                startCountdown() {
                    if (!this.countdownTarget) return;
                    this.updateCountdown();
                    this.timer = setInterval(() => this.updateCountdown(), 1000);
                },

                updateCountdown() {
                    const target = new Date(this.countdownTarget).getTime();
                    const now = Date.now();
                    const diff = target - now;

                    if (diff <= 0) {
                        this.countdown = { days: 0, hours: 0, minutes: 0, seconds: 0 };
                        if (this.timer) clearInterval(this.timer);
                        return;
                    }

                    this.countdown = {
                        days: Math.floor(diff / (1000 * 60 * 60 * 24)),
                        hours: Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
                        minutes: Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)),
                        seconds: Math.floor((diff % (1000 * 60)) / 1000),
                    };
                },
            }
        }
    </script>
</body>
</html>
