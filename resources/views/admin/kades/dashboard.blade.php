<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Kepala Desa — {{ config('village.nama_desa', 'Prodesa') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b' },
                        navy: { 800:'#1e293b',900:'#0f172a',950:'#020617' },
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    @include('components.favicon')
    @include('components.fonts')
    <style>
        :root {
            --brand-50:#ecfdf5;--brand-100:#d1fae5;--brand-200:#a7f3d0;--brand-300:#6ee7b7;
            --brand-400:#34d399;--brand-500:#10b981;--brand-600:#059669;--brand-700:#047857;
            --brand-800:#065f46;--brand-900:#064e3b;
            --teal-500:#14b8a6;--teal-600:#0d9488;
            --shadow-card:0 1px 3px rgba(0,0,0,.04),0 8px 24px rgba(0,0,0,.06);
            --shadow-hover:0 12px 40px rgba(0,0,0,.1),0 4px 12px rgba(0,0,0,.05);
            --gradient-brand:linear-gradient(135deg,#059669,#0891b2);
            --ease-out-expo:cubic-bezier(.16,1,.3,1);
            --ease-spring:cubic-bezier(.34,1.56,.64,1);
        }
        [x-cloak]{display:none!important}
        *,*::before,*::after{box-sizing:border-box}

        @keyframes orbFloat1{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(30px,-20px) scale(1.05)}50%{transform:translate(-10px,15px) scale(.95)}75%{transform:translate(-25px,-10px) scale(1.02)}}
        @keyframes orbFloat2{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(-20px,25px) scale(.97)}50%{transform:translate(15px,-15px) scale(1.03)}75%{transform:translate(20px,10px) scale(.98)}}
        @keyframes orbFloat3{0%,100%{transform:translate(0,0) rotate(0deg)}50%{transform:translate(-15px,-20px) rotate(180deg)}}
        @keyframes pulse-dot{0%,100%{opacity:1}50%{opacity:.5}}
        @keyframes glowPulse{0%,100%{box-shadow:0 0 20px rgba(16,185,129,.08)}50%{box-shadow:0 0 30px rgba(16,185,129,.18)}}
        @keyframes slideRight{from{transform:scaleX(0)}to{transform:scaleX(1)}}
        @keyframes countUp{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:none}}
        @keyframes shimmerSlide{0%{background-position:-200% 0}100%{background-position:200% 0}}
        @keyframes ringPulse{0%,100%{box-shadow:0 0 0 0 rgba(255,255,255,.3)}70%{box-shadow:0 0 0 6px rgba(255,255,255,0)}100%{box-shadow:0 0 0 0 rgba(255,255,255,0)}}

        .reveal{opacity:0;transform:translateY(20px);transition:all .6s var(--ease-out-expo)}.reveal.v{opacity:1;transform:none}
        .reveal-delay-1{transition-delay:.08s}.reveal-delay-2{transition-delay:.16s}.reveal-delay-3{transition-delay:.24s}
        .reveal-delay-4{transition-delay:.32s}.reveal-delay-5{transition-delay:.4s}.reveal-delay-6{transition-delay:.48s}
        .reveal-delay-7{transition-delay:.56s}.reveal-delay-8{transition-delay:.64s}

        .card{border-radius:16px;background:#fff;box-shadow:var(--shadow-card);transition:all .25s var(--ease-out-expo);position:relative}
        .card:hover{box-shadow:var(--shadow-hover);transform:translateY(-2px)}

        .glass{background:rgba(255,255,255,.06);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.1)}
        .glass-strong{background:rgba(255,255,255,.1);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.15)}

        .section-label{display:flex;align-items:center;gap:8px;margin-bottom:14px;padding:0 2px}
        .section-label::before{content:'';width:3px;height:16px;border-radius:9999px;background:linear-gradient(180deg,var(--brand-400),var(--brand-600))}
        .section-label h3{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b}
        .section-label::after{content:'';flex:1;height:1px;background:linear-gradient(90deg,rgba(0,0,0,.06),transparent)}

        .progress-step-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0}
        .progress-step-line{flex:1;height:2px;border-radius:9999px}

        ::-webkit-scrollbar{width:4px;height:4px}
        ::-webkit-scrollbar-track{background:transparent}
        ::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:9999px}

        .notification-dot{animation:pulse-dot 2s ease-in-out infinite}

        body{background:#f0f0eb;
            background-image:
                radial-gradient(ellipse 80% 50% at 20% 0%,rgba(16,185,129,.04),transparent),
                radial-gradient(ellipse 60% 40% at 80% 100%,rgba(99,102,241,.03),transparent);
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-700 overflow-x-hidden">

    @include('admin.components.sidebar')

    <main class="flex-1 overflow-y-auto pt-16 md:pt-0 min-h-screen">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="max-w-[1600px] mx-auto" x-data="kadesDashboard()" x-init="init()">

                {{-- ═══════════════════════════════════════════════════════════ --}}
                {{-- FLASH SUCCESS                                            --}}
                {{-- ═══════════════════════════════════════════════════════════ --}}
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                         x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
                         class="mb-6 flex items-center gap-3 px-5 py-4 rounded-2xl bg-emerald-50/80 backdrop-blur border border-emerald-200/60 shadow-sm shadow-emerald-500/5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-500/10 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-sm font-medium text-emerald-700 flex-1">{{ session('success') }}</p>
                        <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                @endif

                {{-- ═══════════════════════════════════════════════════════════ --}}
                {{-- COMPUTED VARIABLES                                       --}}
                {{-- ═══════════════════════════════════════════════════════════ --}}
                @php
                    $pendingTotal = $menungguSaya->total();
                    $ratePersetujuan = $totalSurat > 0 ? round(($selesai / max($selesai + $ditolak, 1)) * 100) : 0;
                    $topJenis = $riwayatTertandaTangan->groupBy('jenis_surat')->map->count()->sortDesc()->take(3);
                    $now = now();
                    $kpis = [
                        ['label' => 'Total Warga', 'value' => $totalWarga, 'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z', 'color' => 'blue', 'subtitle' => 'Penduduk terdaftar', 'growth' => $wargaGrowth],
                        ['label' => 'Total Surat', 'value' => $totalSurat, 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z', 'color' => 'indigo', 'subtitle' => 'Sepanjang masa', 'growth' => $suratGrowth],
                        ['label' => 'Menunggu', 'value' => $pendingTotal, 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'amber', 'subtitle' => 'Perlu ditindak', 'pulse' => $pendingTotal > 0],
                        ['label' => 'Selesai', 'value' => $selesai, 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'emerald', 'subtitle' => 'Total selesai'],
                        ['label' => 'Bulan Ini', 'value' => $selesaiBulanIni, 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5', 'color' => 'teal', 'subtitle' => 'Selesai bulan ini'],
                        ['label' => 'Ditolak', 'value' => $ditolak, 'icon' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'red', 'subtitle' => 'Total ditolak'],
                        ['label' => 'Antrean', 'value' => $antreanMenunggu, 'icon' => 'M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z', 'color' => 'orange', 'subtitle' => 'Menunggu diambil', 'pulse' => $antreanMenunggu > 0],
                        ['label' => 'Surat Masuk', 'value' => $totalSuratMasuk, 'icon' => 'M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51', 'color' => 'cyan', 'subtitle' => 'Total masuk'],
                    ];
                @endphp

                {{-- ═══════════════════════════════════════════════════════════ --}}
                {{-- SECTION 1: EXECUTIVE HERO HEADER                           --}}
                {{-- ═══════════════════════════════════════════════════════════ --}}
                <div class="reveal">
                    <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-[#061a10] via-[#0c3521] to-[#0a7e6a] text-white" style="box-shadow:0 25px 60px -12px rgba(6,78,59,.35)">

                        {{-- Animated orbs --}}
                        <div class="absolute inset-0 overflow-hidden pointer-events-none">
                            <div class="absolute -top-20 -right-20 w-80 h-80 bg-white/[.03] rounded-full" style="animation:orbFloat1 14s ease-in-out infinite"></div>
                            <div class="absolute -bottom-16 -left-16 w-60 h-60 bg-emerald-400/[.04] rounded-full" style="animation:orbFloat2 16s ease-in-out infinite"></div>
                            <div class="absolute top-1/3 right-1/4 w-40 h-40 bg-teal-300/[.03] rounded-full" style="animation:orbFloat3 12s ease-in-out infinite"></div>
                            <div class="absolute bottom-1/3 left-1/3 w-28 h-28 bg-cyan-300/[.02] rounded-full" style="animation:orbFloat1 18s ease-in-out infinite reverse"></div>
                            {{-- Dot pattern --}}
                            <div class="absolute inset-0" style="background-image:radial-gradient(rgba(255,255,255,.04) 1px,transparent 1px);background-size:24px 24px"></div>
                        </div>

                        <div class="relative px-6 sm:px-8 lg:px-10 py-7 sm:py-8 lg:py-9">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                                {{-- Left: Avatar + Greeting --}}
                                <div class="flex items-start gap-5">
                                    <div class="relative shrink-0">
                                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-br from-emerald-400/30 to-teal-300/20 backdrop-blur-sm flex items-center justify-center border border-white/15 shadow-lg" style="animation:ringPulse 3s ease-in-out infinite">
                                            @if(config('village.logo_desa'))
                                                <img src="{{ asset('storage/' . config('village.logo_desa')) }}" alt="Logo" class="w-9 h-9 sm:w-10 sm:h-10 object-contain">
                                            @else
                                                <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                                            @endif
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-emerald-400 border-2 border-[#0c3521] flex items-center justify-center">
                                            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-emerald-200/70 text-xs sm:text-sm font-medium" x-text="greeting"></p>
                                        <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold mt-0.5 tracking-tight leading-tight">
                                            Selamat Datang, <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 via-teal-200 to-cyan-300">{{ config('village.nama_kades', 'Kepala Desa') }}</span>
                                        </h1>
                                        <div class="flex flex-wrap items-center gap-2 mt-2.5">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full glass-strong text-[11px] font-semibold">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21"/></svg>
                                                {{ config('village.nama_desa', 'Desa') }}
                                            </span>
                                            @if($pendingTotal > 0)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-400/20 text-amber-200 text-[11px] font-semibold border border-amber-400/20">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 notification-dot"></span>
                                                    {{ $pendingTotal }} menunggu
                                                </span>
                                            @endif
                                            @if($slaBreached > 0)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-red-400/20 text-red-200 text-[11px] font-semibold border border-red-400/20">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400 notification-dot"></span>
                                                    {{ $slaBreached }} melewati SLA
                                                </span>
                                            @endif
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-400/15 text-emerald-200 text-[11px] font-semibold border border-emerald-400/15">
                                                {{ $selesaiBulanIni }} selesai bulan ini
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Right: Clock + Action --}}
                                <div class="flex flex-row lg:flex-col items-center lg:items-end gap-4 lg:gap-3">
                                    <div class="text-right">
                                        <p class="text-2xl sm:text-3xl font-extrabold tracking-tight tabular-nums leading-none" x-text="currentTime">--:--</p>
                                        <p class="text-[11px] text-emerald-200/60 mt-1 font-medium" x-text="currentDate">--</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if($pendingTotal > 0)
                                            <a href="{{ route('admin.pengajuan.index', ['status' => 'approved_sekdes']) }}"
                                               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white/15 backdrop-blur-sm text-xs font-semibold hover:bg-white/25 transition-all border border-white/10">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                                                Lihat Semua
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════════ --}}
                {{-- SECTION 2: KPI EXECUTIVE (8 cards)                        --}}
                {{-- ═══════════════════════════════════════════════════════════ --}}
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3 mt-6">
                    @foreach($kpis as $i => $kpi)
                        @php
                            $colorMap = ['blue'=>['from-blue-500','to-blue-600','bg-blue-50','text-blue-600','border-blue-100'],
                                'indigo'=>['from-indigo-500','to-indigo-600','bg-indigo-50','text-indigo-600','border-indigo-100'],
                                'amber'=>['from-amber-500','to-amber-600','bg-amber-50','text-amber-600','border-amber-100'],
                                'emerald'=>['from-emerald-500','to-emerald-600','bg-emerald-50','text-emerald-600','border-emerald-100'],
                                'teal'=>['from-teal-500','to-teal-600','bg-teal-50','text-teal-600','border-teal-100'],
                                'red'=>['from-red-500','to-red-600','bg-red-50','text-red-600','border-red-100'],
                                'orange'=>['from-orange-500','to-orange-600','bg-orange-50','text-orange-600','border-orange-100'],
                                'cyan'=>['from-cyan-500','to-cyan-600','bg-cyan-50','text-cyan-600','border-cyan-100'],
                            ];
                            $c = $colorMap[$kpi['color']] ?? $colorMap['blue'];
                        @endphp
                        <div class="card p-4 lg:p-3 xl:p-4 reveal reveal-delay-{{ min($i + 1, 8) }} group" style="overflow:hidden">
                            {{-- Top gradient accent --}}
                            <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r {{ $c[0] }} {{ $c[1] }} opacity-0 group-hover:opacity-100 transition-opacity duration-250"></div>
                            <div class="flex items-center justify-between mb-2.5">
                                <div class="w-9 h-9 rounded-xl {{ $c[2] }} {{ $c[3] }} flex items-center justify-center border {{ $c[4] }}/50 transition-transform duration-250 group-hover:scale-110 group-hover:-rotate-3">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $kpi['icon'] }}"/></svg>
                                </div>
                                @if($kpi['pulse'] ?? false)
                                    <span class="relative flex h-2.5 w-2.5">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $c[3] }} opacity-60"></span>
                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 {{ $c[3] }}"></span>
                                    </span>
                                @endif
                            </div>
                            <p class="text-[22px] lg:text-xl xl:text-[22px] font-extrabold text-gray-900 tabular-nums leading-none count-up" style="animation-delay:{{ $i * 50 }}ms">{{ number_format($kpi['value']) }}</p>
                            <p class="text-[9px] xl:text-[10px] font-bold text-gray-400 mt-1.5 uppercase tracking-widest">{{ $kpi['label'] }}</p>
                            <div class="flex items-center gap-1 mt-0.5">
                                <p class="text-[10px] text-gray-400">{{ $kpi['subtitle'] }}</p>
                                @if(isset($kpi['growth']))
                                    <span class="text-[9px] font-bold {{ $kpi['growth'] >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                                        {{ $kpi['growth'] >= 0 ? '+' : '' }}{{ $kpi['growth'] }}%
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- ═══════════════════════════════════════════════════════════ --}}
                {{-- SECTION 3: MAIN 2-COLUMN GRID (8:4)                      --}}
                {{-- ═══════════════════════════════════════════════════════════ --}}
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 mt-5">

                    {{-- ── LEFT COLUMN (8 cols) ── --}}
                    <div class="lg:col-span-8 space-y-5">

                        {{-- ═══ PRIORITY APPROVAL LIST ═══ --}}
                        <div class="card reveal reveal-delay-2" style="overflow:visible">
                            <div class="flex items-center justify-between px-5 sm:px-6 py-4 border-b border-gray-100/80">
                                <div class="section-label mb-0">
                                    <h3 class="text-gray-700">Persetujuan Prioritas</h3>
                                </div>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold border border-amber-100/80">
                                    {{ $pendingTotal }} perlu ditindak
                                </span>
                            </div>

                            @if($menungguSaya->count())
                                <div class="p-4 sm:p-5 space-y-3">
                                    @foreach($menungguSaya as $item)
                                        @php
                                            $hoursWaiting = $item->created_at->diffInHours(now());
                                            if($hoursWaiting >= 48) { $priority = 'Mendesak'; $pColor = 'red'; $priorityBg = 'bg-red-50 text-red-600 border-red-100/80'; $leftBar = 'from-red-400 to-red-500'; }
                                            elseif($hoursWaiting >= 24) { $priority = 'Perhatian'; $pColor = 'amber'; $priorityBg = 'bg-amber-50 text-amber-600 border-amber-100/80'; $leftBar = 'from-amber-400 to-amber-500'; }
                                            else { $priority = 'Normal'; $pColor = 'emerald'; $priorityBg = 'bg-emerald-50 text-emerald-600 border-emerald-100/80'; $leftBar = 'from-emerald-400 to-emerald-500'; }
                                            $initials = collect(explode(' ', $item->user->name ?? 'U'))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
                                            $timeAgo = $item->created_at->diffForHumans();
                                            $hoursLeft = max(0, $slaHours - $hoursWaiting);
                                            $isOverSla = $hoursWaiting > $slaHours;
                                        @endphp
                                        <div class="relative rounded-xl border border-gray-100 hover:border-{{ $pColor }}-200/60 hover:shadow-md transition-all duration-250 bg-white overflow-hidden group" x-data="{ open: false }">
                                            {{-- Left accent bar --}}
                                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b {{ $leftBar }}"></div>

                                            <div class="pl-4 pr-4 py-3.5">
                                                {{-- Top row: Avatar + Name + Priority --}}
                                                <div class="flex items-center justify-between mb-2.5">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-{{ $pColor }}-400 to-{{ $pColor }}-500 flex items-center justify-center text-white text-xs font-bold shrink-0 shadow-md shadow-{{ $pColor }}-500/15 transition-transform duration-250 group-hover:scale-105">
                                                            {{ $initials }}
                                                        </div>
                                                        <div class="min-w-0">
                                                            <p class="text-sm font-bold text-gray-900 leading-tight">{{ $item->user->name ?? '-' }}</p>
                                                            <p class="text-[11px] text-gray-500 capitalize">{{ str_replace('_', ' ', $item->jenis_surat) }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold border {{ $priorityBg }}">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-{{ $pColor }}-500"></span>
                                                            {{ $priority }}
                                                        </span>
                                                    </div>
                                                </div>

                                                {{-- SLA + Time info --}}
                                                <div class="flex items-center gap-3 text-[11px] text-gray-400 mb-3">
                                                    <span class="inline-flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        {{ $item->created_at->format('d M, H:i') }}
                                                    </span>
                                                    <span class="w-1 h-1 rounded-full bg-gray-200"></span>
                                                    <span class="font-medium">{{ $timeAgo }}</span>
                                                    <span class="w-1 h-1 rounded-full bg-gray-200"></span>
                                                    @if($isOverSla)
                                                        <span class="text-red-500 font-semibold">Terlambat {{ $hoursWaiting - $slaHours }} jam</span>
                                                    @else
                                                        <span class="text-emerald-500 font-semibold">{{ $hoursLeft }} jam tersisa</span>
                                                    @endif
                                                </div>

                                                {{-- Workflow progress --}}
                                                <div class="mb-3">
                                                    <div class="flex items-center gap-1 px-0.5">
                                                        @php $steps = ['Diajukan', 'Operator', 'Sekdes', 'Kades']; @endphp
                                                        @foreach($steps as $si => $step)
                                                            <div class="flex items-center gap-1 flex-1">
                                                                <div class="flex items-center gap-1 w-full">
                                                                    <div class="progress-step-dot bg-emerald-500 shrink-0"></div>
                                                                    @if($si < 3)
                                                                        <div class="progress-step-line bg-emerald-300" style="animation:slideRight .6s var(--ease-out-expo) both;animation-delay:{{ $si * 120 }}ms"></div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="flex justify-between px-0.5 mt-1">
                                                        @foreach($steps as $si => $step)
                                                            <span class="text-[8px] font-bold {{ $si === 3 ? 'text-amber-600' : 'text-emerald-500' }} uppercase tracking-wide">{{ $step }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                {{-- Action buttons --}}
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <a href="{{ route('admin.pengajuan.show', $item) }}"
                                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gray-50 text-gray-600 text-[11px] font-semibold hover:bg-gray-100 transition-colors border border-gray-100">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                        Detail
                                                    </a>
                                                    <form action="{{ route('admin.pengajuan.approve', $item) }}" method="POST"
                                                          onsubmit="return confirm('Setujui pengajuan ini? Surat akan langsung selesai dan warga bisa mengambil.')">
                                                        @csrf
                                                        <button type="submit"
                                                                class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-lg bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-[11px] font-semibold shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-px active:scale-[.97] transition-all duration-200">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                            Setujui
                                                        </button>
                                                    </form>
                                                    <button @click="openReject({{ $item->id }})"
                                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-[11px] font-semibold hover:bg-red-100 transition-colors border border-red-100/80">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                        Tolak
                                                    </button>
                                                    <button @click="open = !open" class="inline-flex items-center gap-1 px-2 py-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-50 transition-colors ml-auto">
                                                        <svg class="w-3.5 h-3.5" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                                                    </button>
                                                </div>

                                                {{-- Expandable detail --}}
                                                <div x-show="open" x-cloak
                                                     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                                                     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                     class="mt-3 pt-3 border-t border-gray-100 text-[11px] text-gray-500 space-y-1">
                                                    <div class="flex justify-between"><span class="font-medium">ID Pengajuan</span><span class="text-gray-700 font-mono">#{{ $item->id }}</span></div>
                                                    <div class="flex justify-between"><span class="font-medium">Diajukan</span><span class="text-gray-700">{{ $item->created_at->format('d M Y, H:i') }}</span></div>
                                                    <div class="flex justify-between"><span class="font-medium">Jenis Surat</span><span class="text-gray-700 capitalize">{{ str_replace('_', ' ', $item->jenis_surat) }}</span></div>
                                                </div>

                                                {{-- Reject form --}}
                                                <div x-show="rejectingId === {{ $item->id }}" x-cloak
                                                     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                                                     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                     class="mt-3 rounded-xl border border-red-200 bg-red-50/50 p-3">
                                                    <form action="{{ route('admin.pengajuan.reject', $item) }}" method="POST" class="flex gap-2">
                                                        @csrf
                                                        <input type="text" name="catatan" required placeholder="Alasan penolakan..."
                                                               class="flex-1 text-xs border border-red-200 rounded-lg px-3 py-1.5 outline-none focus:ring-2 focus:ring-red-400 bg-white">
                                                        <button type="submit"
                                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-500 text-white text-[11px] font-semibold hover:bg-red-600 transition-colors shrink-0">
                                                            Kirim
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    @if($menungguSaya->hasPages())
                                        <div class="pt-2">{{ $menungguSaya->links() }}</div>
                                    @endif
                                </div>
                            @else
                                <div class="p-12 text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center mx-auto mb-3 border border-emerald-100/50">
                                        <svg class="w-8 h-8 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-700">Semua pengajuan sudah diproses</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Tidak ada yang menunggu persetujuan Anda.</p>
                                </div>
                            @endif
                        </div>

                        {{-- ═══ EVENT MENDATANG ═══ --}}
                        @if($eventMendatang->count())
                        <div class="card reveal reveal-delay-3" style="overflow:visible">
                            <div class="px-5 sm:px-6 py-4 border-b border-gray-100/80 flex items-center justify-between">
                                <div class="section-label mb-0"><h3 class="text-gray-700">Event Mendatang</h3></div>
                                @can('event.manage')
                                <a href="{{ route('admin.events.index') }}" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700 transition-colors uppercase tracking-wide">Lihat Semua</a>
                                @endcan
                            </div>
                            <div class="p-4 sm:p-5">
                                <div class="space-y-2.5">
                                    @foreach($eventMendatang as $event)
                                        @php
                                            $jenisColor = match($event->jenis) { 'musrenbangdes' => 'indigo', 'rapat' => 'blue', 'sosialisasi' => 'amber', 'kegiatan' => 'emerald', default => 'gray' };
                                            $daysUntil = now()->diffInDays($event->tanggal, false);
                                            $dateLabel = $daysUntil == 0 ? 'Hari ini' : ($daysUntil == 1 ? 'Besok' : 'Dalam '.ceil($daysUntil).' hr');
                                        @endphp
                                        <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-gray-50/80 border border-transparent hover:border-gray-100 transition-all duration-200">
                                            <div class="w-11 h-11 rounded-xl bg-{{ $jenisColor }}-50 border border-{{ $jenisColor }}-100/60 flex flex-col items-center justify-center shrink-0">
                                                <span class="text-[10px] font-bold text-{{ $jenisColor }}-600 leading-none">{{ $event->tanggal->format('d') }}</span>
                                                <span class="text-[8px] font-bold text-{{ $jenisColor }}-400 uppercase leading-none mt-0.5">{{ $event->tanggal->format('M') }}</span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-[13px] font-bold text-gray-900 truncate">{{ $event->judul }}</p>
                                                <div class="flex items-center gap-1.5 text-[10px] text-gray-400 mt-0.5">
                                                    <span class="capitalize">{{ $event->jenis }}</span>
                                                    <span class="w-0.5 h-0.5 rounded-full bg-gray-300"></span>
                                                    <span>{{ $event->tempat }}</span>
                                                    <span class="w-0.5 h-0.5 rounded-full bg-gray-300"></span>
                                                    <span>{{ $event->peserta_count }} peserta</span>
                                                </div>
                                            </div>
                                            <span class="text-[9px] font-bold text-{{ $jenisColor }}-600 bg-{{ $jenisColor }}-50 px-2 py-0.5 rounded-full border border-{{ $jenisColor }}-100 shrink-0">{{ $dateLabel }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- ═══ SURAT MASUK / KELUAR ═══ --}}
                        <div class="card reveal reveal-delay-4" style="overflow:visible">
                            <div class="px-5 sm:px-6 py-4 border-b border-gray-100/80">
                                <div class="section-label mb-0"><h3 class="text-gray-700">Surat Masuk & Keluar</h3></div>
                            </div>
                            <div class="p-4 sm:p-5">
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div class="p-3.5 rounded-xl bg-gradient-to-br from-cyan-50 to-cyan-50/30 border border-cyan-100/50 hover:shadow-sm transition-all duration-200">
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <div class="w-7 h-7 rounded-lg bg-cyan-100 text-cyan-600 flex items-center justify-center">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51"/></svg>
                                            </div>
                                            <span class="text-[11px] font-bold text-cyan-700">Masuk</span>
                                        </div>
                                        <p class="text-xl font-extrabold text-gray-900 leading-none">{{ $totalSuratMasuk }}</p>
                                        <div class="flex items-center gap-1.5 mt-1 text-[9px] text-gray-400">
                                            <span>Hari: <strong class="text-cyan-600">{{ $suratMasukHariIni }}</strong></span>
                                            <span class="w-0.5 h-0.5 rounded-full bg-gray-300"></span>
                                            <span>Minggu: <strong class="text-cyan-600">{{ $suratMasukMingguIni }}</strong></span>
                                        </div>
                                    </div>
                                    <div class="p-3.5 rounded-xl bg-gradient-to-br from-violet-50 to-violet-50/30 border border-violet-100/50 hover:shadow-sm transition-all duration-200">
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <div class="w-7 h-7 rounded-lg bg-violet-100 text-violet-600 flex items-center justify-center">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                                            </div>
                                            <span class="text-[11px] font-bold text-violet-700">Keluar</span>
                                        </div>
                                        <p class="text-xl font-extrabold text-gray-900 leading-none">{{ $totalSuratKeluar }}</p>
                                        <div class="flex items-center gap-1.5 mt-1 text-[9px] text-gray-400">
                                            <span>Hari: <strong class="text-violet-600">{{ $suratKeluarHariIni }}</strong></span>
                                            <span class="w-0.5 h-0.5 rounded-full bg-gray-300"></span>
                                            <span>Minggu: <strong class="text-violet-600">{{ $suratKeluarMingguIni }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                @if($suratMasukTerbaru->count())
                                    <div>
                                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-2">Terbaru Diterima</p>
                                        <div class="space-y-1.5">
                                            @foreach($suratMasukTerbaru as $sm)
                                                <div class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-cyan-400 shrink-0"></div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-[12px] font-semibold text-gray-700 truncate">{{ $sm->perihal }}</p>
                                                        <p class="text-[10px] text-gray-400">{{ $sm->pengirim }} &middot; {{ $sm->tanggal_terima?->format('d M Y') }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- ═══ ACTIVITY TIMELINE ═══ --}}
                        <div class="card reveal reveal-delay-5" style="overflow:visible">
                            <div class="px-5 sm:px-6 py-4 border-b border-gray-100/80 flex items-center justify-between">
                                <div class="section-label mb-0"><h3 class="text-gray-700">Log Aktivitas Terbaru</h3></div>
                                @can('audit.view')
                                <a href="{{ route('admin.activity-log.index') }}" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700 transition-colors uppercase tracking-wide">Semua Log</a>
                                @endcan
                            </div>
                            @if($recentActivities->count())
                                <div class="p-4 sm:p-5">
                                    @foreach($recentActivities as $act)
                                        @php
                                            $actColor = match(true) {
                                                str_contains($act->aksi, 'create') => 'emerald',
                                                str_contains($act->aksi, 'update') || str_contains($act->aksi, 'approve') => 'blue',
                                                str_contains($act->aksi, 'delete') || str_contains($act->aksi, 'reject') => 'red',
                                                default => 'gray',
                                            };
                                            $actInitials = collect(explode(' ', $act->user->name ?? 'S'))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
                                        @endphp
                                        <div class="flex items-start gap-3 relative pb-4 last:pb-0">
                                            {{-- Timeline line --}}
                                            @if(!$loop->last)<div class="absolute left-4 top-8 bottom-0 w-px bg-gradient-to-b from-gray-200 to-transparent"></div>@endif
                                            {{-- Avatar --}}
                                            <div class="w-8 h-8 rounded-full bg-{{ $actColor }}-50 text-{{ $actColor }}-600 flex items-center justify-center text-[9px] font-bold shrink-0 border border-{{ $actColor }}-100 relative z-10">
                                                {{ $actInitials }}
                                            </div>
                                            <div class="flex-1 min-w-0 pt-0.5">
                                                <p class="text-[13px] font-semibold text-gray-900 leading-tight">{{ $act->user->name ?? 'System' }}</p>
                                                <p class="text-[11px] text-gray-500 mt-0.5">{{ $act->deskripsi }}</p>
                                            </div>
                                            <span class="text-[10px] text-gray-400 shrink-0 pt-0.5">{{ $act->created_at->diffForHumans() }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-10 text-center">
                                    <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="text-[13px] font-semibold text-gray-500">Belum ada aktivitas</p>
                                </div>
                            @endif
                        </div>

                        {{-- ═══ TREND CHART (12 bulan) ═══ --}}
                        <div class="card reveal reveal-delay-6" style="overflow:visible">
                            <div class="px-5 sm:px-6 py-4 border-b border-gray-100/80">
                                <div class="section-label mb-0"><h3 class="text-gray-700">Tren Pengajuan</h3></div>
                            </div>
                            <div class="p-4 sm:p-5">
                                <div class="h-48"><canvas id="kadesChart"></canvas></div>
                            </div>
                        </div>
                    </div>

                    {{-- ── RIGHT COLUMN (4 cols) ── --}}
                    <div class="lg:col-span-4 space-y-5">

                        {{-- ═══ QUICK ACTIONS ═══ --}}
                        <div class="card p-5 reveal reveal-delay-3" style="overflow:visible">
                            <div class="section-label"><h3 class="text-gray-700">Aksi Cepat</h3></div>
                            <div class="grid grid-cols-3 gap-2.5">
                                @php
                                    $actions = [
                                        ['route' => route('admin.pengajuan.index', ['status' => 'approved_sekdes']), 'label' => 'Persetujuan', 'color' => 'amber', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        ['route' => route('admin.pengajuan.index'), 'label' => 'Riwayat', 'color' => 'indigo', 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        ['route' => route('admin.analytics.index'), 'label' => 'Analitik', 'color' => 'purple', 'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z'],
                                        ['route' => route('admin.pengajuan.index', ['status' => 'completed']), 'label' => 'Selesai', 'color' => 'emerald', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        ['route' => route('admin.setting.index'), 'label' => 'Pengaturan', 'color' => 'gray', 'icon' => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z', 'icon2' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                                        ['route' => route('home'), 'label' => 'Beranda', 'color' => 'cyan', 'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25'],
                                    ];
                                @endphp
                                @foreach($actions as $a)
                                    <a href="{{ $a['route'] }}" class="flex flex-col items-center gap-1.5 p-3 rounded-xl bg-gradient-to-b from-{{ $a['color'] }}-50/80 to-{{ $a['color'] }}-50/20 border border-{{ $a['color'] }}-100/40 hover:border-{{ $a['color'] }}-200 hover:shadow-md hover:-translate-y-0.5 active:scale-[.97] transition-all duration-200">
                                        <div class="w-9 h-9 rounded-lg bg-{{ $a['color'] }}-100 text-{{ $a['color'] }}-600 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ isset($a['icon2']) ? $a['icon2'] : $a['icon'] }}"/></svg>
                                        </div>
                                        <span class="text-[10px] font-bold text-gray-600 text-center leading-tight">{{ $a['label'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- ═══ EXECUTIVE SUMMARY ═══ --}}
                        <div class="card p-5 reveal reveal-delay-4" style="overflow:visible">
                            <div class="section-label"><h3 class="text-gray-700">Ringkasan Eksekutif</h3></div>
                            <div class="space-y-2.5">
                                @php
                                    $execSummary = [
                                        ['label' => 'Surat Hari Ini', 'value' => \App\Models\PengajuanSurat::whereDate('created_at', now()->toDateString())->count(), 'color' => 'teal', 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        ['label' => 'Selesai Bulan Ini', 'value' => $selesaiBulanIni, 'color' => 'emerald', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        ['label' => 'Rate Persetujuan', 'value' => $ratePersetujuan . '%', 'color' => 'indigo', 'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z'],
                                    ];
                                @endphp
                                @foreach($execSummary as $es)
                                    <div class="flex items-center gap-3 p-2.5 rounded-xl bg-gray-50/60 hover:bg-white border border-transparent hover:border-gray-100 transition-all duration-200">
                                        <div class="w-8 h-8 rounded-lg bg-{{ $es['color'] }}-50 text-{{ $es['color'] }}-600 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $es['icon'] }}"/></svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wide">{{ $es['label'] }}</p>
                                            <p class="text-lg font-bold text-gray-900 leading-tight">{{ $es['value'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if($topJenis->count())
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-2">Jenis Surat Terbanyak</p>
                                    <div class="space-y-1.5">
                                        @foreach($topJenis as $jenis => $count)
                                            @php $maxCount = $topJenis->first(); @endphp
                                            <div class="flex items-center gap-2">
                                                <span class="text-[11px] font-medium text-gray-600 capitalize min-w-0 flex-1 truncate">{{ str_replace('_', ' ', $jenis) }}</span>
                                                <span class="text-[10px] font-bold text-emerald-600">{{ $count }}</span>
                                                <div class="w-14 h-1 rounded-full bg-gray-100 overflow-hidden shrink-0">
                                                    <div class="h-full rounded-full bg-gradient-to-r from-emerald-400 to-teal-400" style="width:{{ $maxCount > 0 ? ($count / $maxCount) * 100 : 0 }}%"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- ═══ ANTREAN PENGAMBILAN ═══ --}}
                        @if($antreanMenunggu > 0 || $antreanLewat > 0)
                        <div class="card p-5 reveal reveal-delay-5" style="overflow:visible">
                            <div class="section-label"><h3 class="text-gray-700">Antrean Pengambilan</h3></div>
                            <div class="grid grid-cols-3 gap-2 mb-3">
                                <div class="p-2 rounded-lg bg-amber-50/80 border border-amber-100/50 text-center">
                                    <p class="text-base font-extrabold text-amber-600 leading-none">{{ $antreanMenunggu }}</p>
                                    <p class="text-[8px] font-bold text-amber-500 uppercase mt-0.5">Menunggu</p>
                                </div>
                                <div class="p-2 rounded-lg bg-red-50/80 border border-red-100/50 text-center">
                                    <p class="text-base font-extrabold text-red-600 leading-none">{{ $antreanLewat }}</p>
                                    <p class="text-[8px] font-bold text-red-500 uppercase mt-0.5">Lewat</p>
                                </div>
                                <div class="p-2 rounded-lg bg-emerald-50/80 border border-emerald-100/50 text-center">
                                    <p class="text-base font-extrabold text-emerald-600 leading-none">{{ $antreanDiambil }}</p>
                                    <p class="text-[8px] font-bold text-emerald-500 uppercase mt-0.5">Hari Ini</p>
                                </div>
                            </div>
                            @if($antreanTerbaru->count())
                                <div class="space-y-1.5">
                                    @foreach($antreanTerbaru as $aq)
                                        <div class="flex items-center gap-2.5 p-2 rounded-lg {{ $aq->tanggal_ambil->isPast() ? 'bg-red-50/50 border border-red-100/30' : 'bg-gray-50/60' }} transition">
                                            <div class="w-7 h-7 rounded-lg {{ $aq->tanggal_ambil->isPast() ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600' }} flex items-center justify-center text-[9px] font-bold shrink-0">
                                                {{ $aq->nomor_antrean ? substr($aq->nomor_antrean, -3) : '-' }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-[11px] font-semibold text-gray-700 truncate">{{ $aq->pengajuan->user->name ?? '-' }}</p>
                                                <p class="text-[9px] text-gray-400 capitalize">{{ str_replace('_', ' ', $aq->pengajuan->jenis_surat ?? '') }} &middot; {{ $aq->tanggal_ambil->format('d M') }}</p>
                                            </div>
                                            <span class="text-[9px] font-bold {{ $aq->tanggal_ambil->isPast() ? 'text-red-500' : 'text-amber-500' }}">
                                                {{ $aq->tanggal_ambil->isPast() ? 'LEWAT' : $aq->tanggal_ambil->diffForHumans() }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        @endif

                        {{-- ═══ BERITA TERBARU ═══ --}}
                        @if($beritaTerbaru->count())
                        <div class="card p-5 reveal reveal-delay-5" style="overflow:visible">
                            <div class="section-label"><h3 class="text-gray-700">Berita Terbaru</h3></div>
                            <div class="space-y-2">
                                @foreach($beritaTerbaru as $berita)
                                    <a href="{{ route('berita.show', $berita->slug) }}" target="_blank" class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-gray-50/80 transition group">
                                        @if($berita->foto)
                                            <img src="{{ asset('storage/' . $berita->foto) }}" alt="{{ $berita->judul }}" class="w-12 h-12 rounded-lg object-cover shrink-0 border border-gray-100">
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5"/></svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[12px] font-semibold text-gray-900 group-hover:text-emerald-700 transition truncate">{{ $berita->judul }}</p>
                                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $berita->created_at->diffForHumans() }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- ═══ DISTRIBUTION CHART (Donut) ═══ --}}
                        @if($distribusiJenis->count())
                        <div class="card p-5 reveal reveal-delay-6" style="overflow:visible">
                            <div class="section-label"><h3 class="text-gray-700">Distribusi Jenis Surat</h3></div>
                            <div class="flex items-center gap-4">
                                <div class="w-28 h-28 shrink-0"><canvas id="jenisChart"></canvas></div>
                                <div class="flex-1 space-y-1">
                                    @php $colors = ['#10b981','#3b82f6','#f59e0b','#ef4444','#8b5cf6','#06b6d4']; @endphp
                                    @foreach($distribusiJenis as $i => $dj)
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full shrink-0" style="background:{{ $colors[$i % 6] }}"></span>
                                            <span class="text-[10px] font-medium text-gray-500 capitalize truncate flex-1">{{ str_replace('_', ' ', $dj->jenis_surat) }}</span>
                                            <span class="text-[10px] font-bold text-gray-600">{{ $dj->total }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- ═══ WARGA GROWTH CHART ═══ --}}
                        <div class="card p-5 reveal reveal-delay-6" style="overflow:visible">
                            <div class="section-label"><h3 class="text-gray-700">Pertumbuhan Warga</h3></div>
                            <div class="h-36"><canvas id="wargaChart"></canvas></div>
                        </div>

                        {{-- ═══ AVG PROCESSING TIME ═══ --}}
                        @if($avgProcessingTime->count())
                        <div class="card p-5 reveal reveal-delay-7" style="overflow:visible">
                            <div class="section-label"><h3 class="text-gray-700">Waktu Proses Rata-rata</h3></div>
                            <div class="space-y-2">
                                @foreach($avgProcessingTime as $apt)
                                    @php
                                        $hours = (float) $apt->avg_hours;
                                        $days = floor($hours / 24);
                                        $remainHours = $hours % 24;
                                        $timeLabel = $days > 0 ? "{$days}h {$remainHours}j" : "{$remainHours} jam";
                                        $barWidth = min(($hours / 168) * 100, 100);
                                        $barColor = $hours <= 24 ? 'from-emerald-400 to-teal-400' : ($hours <= 72 ? 'from-amber-400 to-orange-400' : 'from-red-400 to-rose-400');
                                    @endphp
                                    <div>
                                        <div class="flex items-center justify-between mb-0.5">
                                            <span class="text-[11px] font-medium text-gray-600 capitalize">{{ str_replace('_', ' ', $apt->jenis_surat) }}</span>
                                            <span class="text-[9px] font-bold text-gray-400">{{ $timeLabel }}</span>
                                        </div>
                                        <div class="h-1.5 rounded-full bg-gray-100 overflow-hidden">
                                            <div class="h-full rounded-full bg-gradient-to-r {{ $barColor }}" style="width:{{ $barWidth }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- ═══ SLA MONITORING ═══ --}}
                        <div class="card p-5 reveal reveal-delay-7" style="overflow:visible">
                            <div class="section-label"><h3 class="text-gray-700">Monitoring SLA</h3></div>
                            @php $slaPercent = $inProgress > 0 ? round((($inProgress - $slaBreached) / $inProgress) * 100) : 100; @endphp
                            <div class="text-center mb-3">
                                <div class="relative w-20 h-20 mx-auto">
                                    <svg class="w-20 h-20 -rotate-90" viewBox="0 0 36 36">
                                        <path d="M18 2.0845a15.9155 15.9155 0 010 31.831 15.9155 15.9155 0 010-31.831" fill="none" stroke="#f1f5f9" stroke-width="3"/>
                                        <path d="M18 2.0845a15.9155 15.9155 0 010 31.831 15.9155 15.9155 0 010-31.831" fill="none" stroke="{{ $slaPercent >= 80 ? '#10b981' : ($slaPercent >= 50 ? '#f59e0b' : '#ef4444') }}" stroke-width="3" stroke-dasharray="{{ $slaPercent }}, 100" stroke-linecap="round" style="filter:drop-shadow(0 0 4px {{ $slaPercent >= 80 ? 'rgba(16,185,129,.25)' : ($slaPercent >= 50 ? 'rgba(245,158,11,.25)' : 'rgba(239,68,68,.25)') }})"/>
                                    </svg>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <span class="text-base font-extrabold text-gray-900 leading-none">{{ $slaPercent }}%</span>
                                        <span class="text-[7px] font-bold text-gray-400 uppercase mt-0.5">On Time</span>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="p-2 rounded-lg bg-emerald-50/80 border border-emerald-100/50 text-center">
                                    <p class="text-sm font-extrabold text-emerald-600 leading-none">{{ $inProgress - $slaBreached }}</p>
                                    <p class="text-[8px] font-bold text-emerald-500 uppercase mt-0.5">Sesuai SLA</p>
                                </div>
                                <div class="p-2 rounded-lg bg-red-50/80 border border-red-100/50 text-center">
                                    <p class="text-sm font-extrabold text-red-600 leading-none">{{ $slaBreached }}</p>
                                    <p class="text-[8px] font-bold text-red-500 uppercase mt-0.5">Melewati SLA</p>
                                </div>
                            </div>
                            <p class="text-[9px] text-gray-400 text-center mt-2">Batas SLA: {{ $slaHours }} jam</p>
                        </div>

                        {{-- ═══ INFORMASI DESA ═══ --}}
                        <div class="card p-5 reveal reveal-delay-8" style="overflow:visible">
                            <div class="section-label"><h3 class="text-gray-700">Informasi Desa</h3></div>
                            <div class="space-y-2.5">
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21"/></svg>
                                    </div>
                                    <div><p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Nama Desa</p><p class="text-[12px] font-semibold text-gray-800">{{ config('village.nama_desa') }}</p></div>
                                </div>
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                    </div>
                                    <div><p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Kepala Desa</p><p class="text-[12px] font-semibold text-gray-800">{{ config('village.nama_kades') }}</p></div>
                                </div>
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                    </div>
                                    <div><p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Sekretaris Desa</p><p class="text-[12px] font-semibold text-gray-800">{{ config('village.nama_sekdes') }}</p></div>
                                </div>
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                    </div>
                                    <div><p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Kontak</p><p class="text-[12px] font-semibold text-gray-800">{{ config('village.email_desa') }}</p><p class="text-[11px] text-gray-500">{{ config('village.telepon_desa') }}</p></div>
                                </div>
                                <div class="flex items-center gap-2 pt-2 border-t border-gray-100">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0" style="box-shadow:0 0 6px rgba(16,185,129,.4)"></span>
                                    <span class="text-[10px] font-medium text-gray-500">Server Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════════ --}}
                {{-- SECTION 4: INSIGHT BAR                                   --}}
                {{-- ═══════════════════════════════════════════════════════════ --}}
                <div class="mt-5 reveal reveal-delay-8">
                    <div class="rounded-2xl bg-gradient-to-r from-gray-50 via-white to-gray-50 border border-gray-100/80 p-4 sm:p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-5 h-5 rounded-md bg-emerald-100 flex items-center justify-center">
                                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>
                            </div>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Insight Cepat</p>
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            @if($pendingTotal > 0)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-[10px] font-semibold border border-amber-100/50">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $pendingTotal }} menunggu persetujuan
                                </span>
                            @endif
                            @if($selesaiBulanIni > 0)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-semibold border border-emerald-100/50">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $selesaiBulanIni }} selesai bulan ini
                                </span>
                            @endif
                            @if($antreanLewat > 0)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-50 text-red-700 text-[10px] font-semibold border border-red-100/50">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
                                    {{ $antreanLewat }} antrean lewat jadwal
                                </span>
                            @endif
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 text-[10px] font-semibold border border-indigo-100/50">
                                Rate {{ $ratePersetujuan }}%
                            </span>
                            @if($topJenis->count())
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-purple-50 text-purple-700 text-[10px] font-semibold border border-purple-100/50">
                                    Teratas: {{ str_replace('_', ' ', $topJenis->keys()->first()) }}
                                </span>
                            @endif
                            @if($eventMendatang->count())
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-cyan-50 text-cyan-700 text-[10px] font-semibold border border-cyan-100/50">
                                    {{ $eventMendatang->count() }} event mendatang
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════════ --}}
                {{-- SECTION 5: FOOTER                                        --}}
                {{-- ═══════════════════════════════════════════════════════════ --}}
                <div class="border-t border-gray-200/50 pt-4 pb-2 mt-6 reveal">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-[10px] text-gray-400">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-500">Prodesa v1.0</span>
                            <span class="w-0.5 h-0.5 rounded-full bg-gray-300"></span>
                            <span class="px-1.5 py-0.5 rounded-full {{ config('app.env') === 'production' ? 'bg-emerald-50 text-emerald-600 font-bold border border-emerald-100' : 'bg-amber-50 text-amber-600 font-bold border border-amber-100' }}">{{ ucfirst(config('app.env')) }}</span>
                        </div>
                        <span>&copy; {{ date('Y') }} {{ config('village.nama_desa', 'Desa') }} &middot; IG <a href="https://instagram.com/rangga.mrw" target="_blank" class="text-gray-500 hover:text-brand-600 transition-colors font-medium">@rangga.mrw</a></span>
                    </div>
                </div>

            </div>
        </div>
    </main>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- SCRIPTS                                                   --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <script>
        function kadesDashboard() {
            return {
                greeting: '',
                currentTime: '',
                currentDate: '',
                rejectingId: null,

                init() {
                    this.updateClock();
                    setInterval(() => this.updateClock(), 1000);
                    this.updateGreeting();
                    this.initReveal();
                    this.initCharts();
                },

                updateClock() {
                    const now = new Date();
                    this.currentTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    this.currentDate = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                },

                updateGreeting() {
                    const h = new Date().getHours();
                    if (h < 11) this.greeting = 'Selamat Pagi';
                    else if (h < 15) this.greeting = 'Selamat Siang';
                    else if (h < 18) this.greeting = 'Selamat Sore';
                    else this.greeting = 'Selamat Malam';
                },

                openReject(id) {
                    this.rejectingId = this.rejectingId === id ? null : id;
                },

                initReveal() {
                    const obs = new IntersectionObserver((entries) => {
                        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('v'); obs.unobserve(e.target); } });
                    }, { threshold: 0.08 });
                    document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
                },

                initCharts() {
                    const font = { family: 'Montserrat' };
                    const tooltip = {
                        backgroundColor: '#0f172a', titleColor: '#e2e8f0', bodyColor: '#cbd5e1',
                        padding: 10, cornerRadius: 8, titleFont: { ...font, weight: '600', size: 11 },
                        bodyFont: { ...font, size: 10 }, borderColor: 'rgba(255,255,255,.06)', borderWidth: 1
                    };

                    const trenLabels = @json($trenLabels);
                    const trenSelesai = @json($trenSelesai);
                    const trenDitolak = @json($trenDitolak);
                    const trenCtx = document.getElementById('kadesChart');
                    if (trenCtx) {
                        new Chart(trenCtx, {
                            type: 'bar',
                            data: {
                                labels: trenLabels,
                                datasets: [
                                    { label: 'Selesai', data: trenSelesai, backgroundColor: 'rgba(16,185,129,.7)', borderRadius: 4, borderSkipped: false },
                                    { label: 'Ditolak', data: trenDitolak, backgroundColor: 'rgba(239,68,68,.45)', borderRadius: 4, borderSkipped: false },
                                ]
                            },
                            options: {
                                responsive: true, maintainAspectRatio: false,
                                animation: { duration: 1000, easing: 'easeOutQuart' },
                                plugins: { legend: { display: true, position: 'top', labels: { ...font, size: 9, usePointStyle: true, pointStyle: 'circle', padding: 12 } }, tooltip },
                                scales: {
                                    y: { beginAtZero: true, stacked: true, ticks: { stepSize: 1, font: { size: 9, ...font }, color: '#94a3b8' }, grid: { color: 'rgba(0,0,0,.04)', drawBorder: false } },
                                    x: { stacked: true, ticks: { font: { size: 9, ...font }, color: '#94a3b8' }, grid: { display: false } }
                                }
                            }
                        });
                    }

                    const jenisLabels = @json($jenisLabels);
                    const jenisValues = @json($jenisValues);
                    const jenisCtx = document.getElementById('jenisChart');
                    if (jenisCtx) {
                        new Chart(jenisCtx, {
                            type: 'doughnut',
                            data: {
                                labels: jenisLabels,
                                datasets: [{ data: jenisValues, backgroundColor: ['#10b981','#3b82f6','#f59e0b','#ef4444','#8b5cf6','#06b6d4'], borderWidth: 0, hoverOffset: 4 }]
                            },
                            options: { responsive: true, maintainAspectRatio: false, cutout: '68%', animation: { animateRotate: true, duration: 1200, easing: 'easeOutQuart' }, plugins: { legend: { display: false }, tooltip } }
                        });
                    }

                    const wargaLabels = @json($wargaLabels);
                    const wargaValues = @json($wargaValues);
                    const wargaCtx = document.getElementById('wargaChart');
                    if (wargaCtx) {
                        const grad = wargaCtx.getContext('2d').createLinearGradient(0, 0, 0, 144);
                        grad.addColorStop(0, 'rgba(59,130,246,.18)'); grad.addColorStop(1, 'rgba(59,130,246,.01)');
                        new Chart(wargaCtx, {
                            type: 'line',
                            data: {
                                labels: wargaLabels,
                                datasets: [{
                                    label: 'Warga Baru', data: wargaValues, borderColor: '#3b82f6', borderWidth: 2,
                                    pointRadius: 3, pointBackgroundColor: '#3b82f6', pointBorderColor: '#fff', pointBorderWidth: 2,
                                    backgroundColor: grad, fill: true, tension: 0.4
                                }]
                            },
                            options: {
                                responsive: true, maintainAspectRatio: false, animation: { duration: 1200, easing: 'easeOutQuart' },
                                plugins: { legend: { display: false }, tooltip },
                                scales: {
                                    y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 9, ...font }, color: '#94a3b8' }, grid: { color: 'rgba(0,0,0,.04)', drawBorder: false } },
                                    x: { ticks: { font: { size: 9, ...font }, color: '#94a3b8' }, grid: { display: false } }
                                }
                            }
                        });
                    }
                }
            }
        }
    </script>
</body>
</html>