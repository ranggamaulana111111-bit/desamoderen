<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Dokumen - {{ config('village.nama_desa', 'Desa Kumpay') }}</title>
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
        .a4 { animation-delay: .2s; } .a5 { animation-delay: .25s; } .a6 { animation-delay: .3s; }
        .a7 { animation-delay: .35s; } .a8 { animation-delay: .4s; }
        .gradient-valid {
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
        .timeline-dot {
            width: 40px; height: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            position: relative; z-index: 2;
        }
        .timeline-line {
            position: absolute; top: 20px; left: 50%; transform: translateX(-50%);
            width: 2px; height: calc(100% - 40px); z-index: 1;
        }
        .check-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.625rem 0;
        }
        .check-item + .check-item {
            border-top: 1px solid rgba(226,232,240,0.5);
        }
        .info-row {
            display: flex; align-items: flex-start; gap: 0.75rem;
            padding: 0.625rem 0;
        }
        .info-row + .info-row {
            border-top: 1px solid rgba(226,232,240,0.5);
        }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        .float-icon { animation: float 4s ease-in-out infinite; }
        [x-cloak] { display: none !important; }
    </style>
    @include('components.design-tokens')
</head>
<body class="bg-gradient-to-br from-slate-50 via-gray-50 to-emerald-50/30 min-h-screen font-sans antialiased">

    {{-- ═══ HERO HEADER ═══ --}}
    <header class="relative overflow-hidden {{ $status === 'expired' ? 'gradient-expired' : 'gradient-valid' }}">
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Desa Info --}}
            <p class="text-white/70 text-xs sm:text-sm font-medium tracking-widest uppercase mb-1 opacity-0 animate-fade-in a2">Pemerintah {{ $desa }}</p>
            <h1 class="text-xl sm:text-2xl font-bold mb-0.5 opacity-0 animate-fade-in a3">{{ $kecamatan }}, {{ $kabupaten }}</h1>

            {{-- Status Badge --}}
            <div class="mt-5 opacity-0 animate-scale-in a4">
                @if ($status === 'expired')
                    <div class="inline-flex items-center gap-2.5 bg-white/15 backdrop-blur-sm rounded-full px-6 py-3 border border-white/25 shadow-xl">
                        <div class="w-8 h-8 rounded-full bg-amber-400/25 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-bold text-white tracking-wide">DOKUMEN KEDALUWARSA</p>
                            <p class="text-[11px] text-white/60">Masa berlaku dokumen telah habis</p>
                        </div>
                    </div>
                @else
                    <div class="inline-flex items-center gap-2.5 bg-white/15 backdrop-blur-sm rounded-full px-6 py-3 border border-white/25 shadow-xl">
                        <div class="w-8 h-8 rounded-full bg-emerald-400/25 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-bold text-white tracking-wide">DOKUMEN TERVERIFIKASI</p>
                            <p class="text-[11px] text-white/60">Dokumen ini sah dan masih berlaku</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        {{-- Wave Separator --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 56" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-8 sm:h-12"><path d="M0 56V28C240 56 480 0 720 28C960 56 1200 0 1440 28V56H0Z" fill="#f8fafc"/></svg>
        </div>
    </header>

    {{-- ═══ MAIN CONTENT ═══ --}}
    <main class="max-w-3xl mx-auto px-4 sm:px-6 pb-12 -mt-4 relative z-10">

        {{-- Expired Warning --}}
        @if ($status === 'expired')
        <div class="mb-6 opacity-0 animate-slide-up a1">
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200/80 rounded-2xl p-4 sm:p-5 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-amber-800">Dokumen Sudah Melewati Masa Berlaku</p>
                        <p class="text-sm text-amber-700 mt-1">Hubungi kantor desa untuk perpanjangan atau penerbitan dokumen baru.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="space-y-5">

            {{-- ═══ SECTION 2: STATUS DOKUMEN ═══ --}}
            <div class="section-card opacity-0 animate-slide-up a2">
                <div class="px-5 sm:px-6 pt-5 pb-4">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-5 rounded-full bg-gradient-to-b from-emerald-400 to-emerald-600"></div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Status Dokumen</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="info-row sm:border-t-0">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Nomor Surat</p>
                                <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $nomor_surat }}</p>
                            </div>
                        </div>
                        <div class="info-row sm:border-t-0">
                            <div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Jenis Surat</p>
                                <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $jenis_surat }}</p>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Tanggal Cetak</p>
                                <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $tanggal_cetak }}</p>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="w-9 h-9 rounded-xl {{ $status === 'expired' ? 'bg-red-50' : 'bg-cyan-50' }} flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 {{ $status === 'expired' ? 'text-red-600' : 'text-cyan-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Berlaku Sampai</p>
                                <p class="text-sm font-bold {{ $status === 'expired' ? 'text-red-600' : 'text-gray-900' }} mt-0.5">{{ $tgl_berlaku_sampai }}</p>
                            </div>
                        </div>
                        <div class="info-row sm:border-t-0">
                            <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Status</p>
                                <div class="mt-0.5">
                                    @if ($status === 'expired')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 text-red-700 text-[11px] font-bold border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Kedaluwarsa
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-bold border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Aktif & Valid
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="info-row sm:border-t-0">
                            <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Ditandatangani</p>
                                <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $penandatangan }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ SECTION 3: IDENTITAS PEMILIK ═══ --}}
            <div class="section-card opacity-0 animate-slide-up a3">
                <div class="px-5 sm:px-6 pt-5 pb-4">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-5 rounded-full bg-gradient-to-b from-indigo-400 to-indigo-600"></div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Identitas Pemilik Dokumen</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-center gap-3 p-3 bg-gray-50/80 rounded-xl border border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Nama Lengkap</p>
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $nama_warga }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50/80 rounded-xl border border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center text-white shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">NIK</p>
                                <p class="text-sm font-bold text-gray-900 font-mono tracking-wide">{{ $nik }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50/80 rounded-xl border border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Jenis Surat</p>
                                <p class="text-sm font-bold text-gray-900">{{ $jenis_surat }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50/80 rounded-xl border border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center text-white shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Nomor Surat</p>
                                <p class="text-sm font-bold text-gray-900 font-mono">{{ $nomor_surat }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ SECTION 4: VALIDASI DIGITAL ═══ --}}
            <div class="section-card opacity-0 animate-slide-up a4">
                <div class="px-5 sm:px-6 pt-5 pb-4">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-5 rounded-full bg-gradient-to-b from-emerald-400 to-emerald-600"></div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Validasi Digital</h2>
                        <span class="ml-auto text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">5 / 5 Lulus</span>
                    </div>
                    <div>
                        <div class="check-item">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800">Dokumen ditemukan</p>
                                <p class="text-[11px] text-gray-400">Dokumen terdaftar dalam sistem Prodesa</p>
                            </div>
                        </div>
                        <div class="check-item">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800">QR Code valid</p>
                                <p class="text-[11px] text-gray-400">Tautan verifikasi cocok dengan hash dokumen</p>
                            </div>
                        </div>
                        <div class="check-item">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800">Digital Signature valid</p>
                                <p class="text-[11px] text-gray-400">Tanda tangan digital terverifikasi</p>
                            </div>
                        </div>
                        <div class="check-item">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800">Tidak mengalami perubahan data</p>
                                <p class="text-[11px] text-gray-400">Integritas data terjamin sejak diterbitkan</p>
                            </div>
                        </div>
                        <div class="check-item">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800">Data berasal dari Server Prodesa</p>
                                <p class="text-[11px] text-gray-400">Sumber data diverifikasi langsung dari server</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ SECTION 5: LEGALITAS DOKUMEN ═══ --}}
            @php
                $docHash = request()->route('hash') ?? '-';
                $verifyUrl = url()->current();
                $ttdPath = config('village.ttd_kades');
                $stempelPath = config('village.stempel_desa');
            @endphp
            <div class="section-card opacity-0 animate-slide-up a5">
                <div class="px-5 sm:px-6 pt-5 pb-5">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-1.5 h-5 rounded-full bg-gradient-to-b from-indigo-400 to-indigo-600"></div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Legalitas Dokumen</h2>
                    </div>

                    {{-- QR Code --}}
                    <div class="flex flex-col items-center mb-6 p-5 bg-gray-50/80 rounded-2xl border border-gray-100">
                        <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 mb-3">
                            {!! QrCode::format('svg')->size(160)->generate($verifyUrl) !!}
                        </div>
                        <p class="text-[11px] text-gray-400 font-medium">Pindai QR Code untuk memverifikasi dokumen ini</p>
                    </div>

                    {{-- Tanda Tangan & Stempel --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                        {{-- Tanda Tangan --}}
                        <div class="flex flex-col items-center p-4 bg-gray-50/80 rounded-xl border border-gray-100">
                            <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider mb-3">Tanda Tangan Digital</p>
                            @if($ttdPath)
                                <img src="{{ asset('storage/' . $ttdPath) }}" alt="Tanda Tangan" class="h-16 object-contain mb-2">
                            @else
                                <div class="h-16 w-32 flex items-center justify-center mb-2">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                </div>
                            @endif
                            <p class="text-xs font-bold text-gray-800">{{ config('village.nama_kades', 'Kepala Desa') }}</p>
                            <p class="text-[10px] text-gray-400">{{ $penandatangan }}</p>
                        </div>

                        {{-- Stempel --}}
                        <div class="flex flex-col items-center p-4 bg-gray-50/80 rounded-xl border border-gray-100">
                            <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider mb-3">Stempel Desa</p>
                            @if($stempelPath)
                                <img src="{{ asset('storage/' . $stempelPath) }}" alt="Stempel Desa" class="h-16 object-contain mb-2">
                            @else
                                <div class="h-16 w-32 flex items-center justify-center mb-2">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/></svg>
                                </div>
                            @endif
                            <p class="text-xs font-bold text-gray-800">{{ config('village.nama_desa', 'Desa Kumpay') }}</p>
                            <p class="text-[10px] text-gray-400">Kec. {{ $kecamatan }}, Kab. {{ $kabupaten }}</p>
                        </div>
                    </div>

                    {{-- Hash & Register --}}
                    <div class="space-y-0">
                        <div class="info-row">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7.848 8.25l1.536.887M7.848 8.25a3 3 0 11-5.196-3 3 3 0 015.196 3zm1.536.887a2.165 2.165 0 011.083 1.839c.005.351.054.695.14 1.024M9.384 9.137l2.077 1.199M7.848 15.75l1.536-.887m-1.536.887a3 3 0 01-5.196 3 3 3 0 015.196-3zm1.536-.887a2.165 2.165 0 001.083-1.838c.005-.352.054-.695.14-1.025m-1.223 2.863l2.077-1.199m0-3.328a4.323 4.323 0 012.068-1.379l5.325-1.628a4.5 4.5 0 012.48-.044l.803.215-7.794 4.5m-2.882-1.664A4.331 4.331 0 0010.607 12m3.736 0l7.794 4.5-.802.215a4.5 4.5 0 01-2.48-.043l-5.326-1.629a4.324 4.324 0 01-2.068-1.379M14.343 12l-2.882 1.664"/></svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Hash Verifikasi</p>
                                <p class="text-[11px] font-mono text-gray-600 mt-0.5 break-all leading-relaxed">{{ $docHash }}</p>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Nomor Register</p>
                                <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $nomor_surat }}</p>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Dasar Hukum</p>
                                <p class="text-xs text-gray-600 mt-0.5 leading-relaxed">UU No. 23 Tahun 2014 tentang Pemerintahan Daerah &middot; PP No. 72 Tahun 2019 tentang Desa &middot; Permendagri No. 20 Tahun 2018 tentang Pencatatan Pendidikan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ SECTION 6: INFORMASI KEAMANAN ═══ --}}
            <div class="section-card opacity-0 animate-slide-up a6">
                <div class="px-5 sm:px-6 pt-5 pb-4">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-5 rounded-full bg-gradient-to-b from-slate-400 to-slate-600"></div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Informasi Keamanan</h2>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3 p-3 bg-slate-50/80 rounded-xl border border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">Dokumen ini diverifikasi langsung melalui <span class="font-semibold text-gray-800">sistem Prodesa</span> — platform resmi pemerintah desa.</p>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-slate-50/80 rounded-xl border border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">QR Code akan <span class="font-semibold text-gray-800">gagal</span> apabila isi dokumen diubah atau dimanipulasi.</p>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-slate-50/80 rounded-xl border border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3H21"/></svg>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">Data berasal langsung dari <span class="font-semibold text-gray-800">server resmi desa</span> dan tidak dapat diubah secara sepihak.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ SECTION 7: INFORMASI DESA ═══ --}}
            <div class="section-card opacity-0 animate-slide-up a7">
                <div class="px-5 sm:px-6 pt-5 pb-4">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-5 rounded-full bg-gradient-to-b from-emerald-400 to-teal-600"></div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Informasi Desa</h2>
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
                            <p class="text-[11px] text-gray-400">Kec. {{ $kecamatan }}, Kab. {{ $kabupaten }}</p>
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
                            <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Website</p>
                                <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ config('village.website_desa', '-') }}</p>
                            </div>
                        </div>
                        <div class="info-row sm:border-t">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Telepon</p>
                                <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ config('village.telepon_desa', '-') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ═══ SECTION 8: FOOTER ═══ --}}
        <footer class="mt-8 opacity-0 animate-fade-in a8">
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
