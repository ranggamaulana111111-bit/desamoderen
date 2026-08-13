<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Sekretaris Desa - Prodesa</title>
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
        }
        [x-cloak]{display:none!important}
        *,*::before,*::after{box-sizing:border-box}

        @keyframes fadeInUp{from{opacity:0;transform:translateY(28px)}to{opacity:1;transform:translateY(0)}}
        @keyframes fadeIn{from{opacity:0}to{opacity:1}}
        @keyframes slideUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
        @keyframes scaleIn{from{opacity:0;transform:scale(.92)}to{opacity:1;transform:scale(1)}}
        @keyframes orbFloat1{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(30px,-20px) scale(1.05)}50%{transform:translate(-10px,15px) scale(.95)}75%{transform:translate(-25px,-10px) scale(1.02)}}
        @keyframes orbFloat2{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(-20px,25px) scale(.97)}50%{transform:translate(15px,-15px) scale(1.03)}75%{transform:translate(20px,10px) scale(.98)}}
        @keyframes pulse-ring{0%{box-shadow:0 0 0 0 rgba(16,185,129,.4)}70%{box-shadow:0 0 0 8px rgba(16,185,129,0)}100%{box-shadow:0 0 0 0 rgba(16,185,129,0)}}
        @keyframes pulse-dot{0%,100%{opacity:1}50%{opacity:.5}}
        @keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
        @keyframes successPop{0%{transform:scale(.9);opacity:0}50%{transform:scale(1.02)}100%{transform:scale(1);opacity:1}}

        .a-fade-up{opacity:0;transform:translateY(28px);transition:all .7s var(--ease-out-expo)}.a-fade-up.v{opacity:1;transform:none}
        .a-fade-in{opacity:0;transition:opacity .7s ease}.a-fade-in.v{opacity:1}
        .a-scale{opacity:0;transform:scale(.92);transition:all .6s var(--ease-out-expo)}.a-scale.v{opacity:1;transform:none}
        .d1{transition-delay:.05s}.d2{transition-delay:.1s}.d3{transition-delay:.15s}.d4{transition-delay:.2s}.d5{transition-delay:.25s}.d6{transition-delay:.3s}.d7{transition-delay:.35s}.d8{transition-delay:.4s}.d9{transition-delay:.45s}.d10{transition-delay:.5s}.d11{transition-delay:.55s}.d12{transition-delay:.6s}.d13{transition-delay:.65s}.d14{transition-delay:.7s}

        .glass{background:rgba(255,255,255,.06);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.1)}
        .glass-strong{background:rgba(255,255,255,.1);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.15)}
        .glass-light{background:rgba(255,255,255,.82);backdrop-filter:blur(32px) saturate(200%);border:1px solid rgba(255,255,255,.5)}

        .bento-card{border-radius:20px;background:white;box-shadow:var(--shadow-card);transition:all .4s var(--ease-out-expo);overflow:hidden}
        .bento-card:hover{box-shadow:var(--shadow-hover);transform:translateY(-3px)}

        .interact{transition:all .3s var(--ease-out-expo);cursor:pointer}
        .interact:hover{transform:translateY(-2px)}
        .interact:active{transform:scale(.97);transition-duration:.1s}

        .stat-micro{transition:all .3s var(--ease-out-expo);position:relative;overflow:hidden}
        .stat-micro:hover{transform:translateY(-2px);box-shadow:var(--shadow-hover)}

        .quick-action{transition:all .3s var(--ease-out-expo);position:relative;overflow:hidden}
        .quick-action:hover{transform:scale(1.04) translateY(-3px);box-shadow:var(--shadow-hover)}
        .quick-action:active{transform:scale(.97)}

        .timeline-dot{width:14px;height:14px;border-radius:50%;border:2.5px solid;background:white;position:absolute;left:0;top:5px}
        .timeline-item{position:relative;padding-left:28px;padding-bottom:20px}
        .timeline-item::before{content:'';position:absolute;left:6px;top:22px;bottom:0;width:2px;background:linear-gradient(to bottom,#e2e8f0,transparent)}
        .timeline-item:last-child::before{display:none}

        .progress-step{display:flex;align-items:center;gap:4px}
        .progress-step-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0}
        .progress-step-line{flex:1;height:2px;border-radius:9999px}

        .health-dot{width:8px;height:8px;border-radius:50%;display:inline-block;flex-shrink:0}
        .health-dot.ok{background:#10b981;box-shadow:0 0 8px rgba(16,185,129,.4)}

        .notification-dot{animation:pulse-dot 2s ease-in-out infinite}

        ::-webkit-scrollbar{width:4px;height:4px}
        ::-webkit-scrollbar-track{background:transparent}
        ::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:9999px}

        .section-header{display:flex;align-items:center;gap:8px;margin-bottom:1rem;padding:0 2px}
        .section-header::before{content:'';width:3px;height:18px;border-radius:9999px;background:linear-gradient(180deg,var(--brand-400),var(--brand-600))}
        .section-header h3{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#475569}
        .section-header .shimmer-line{flex:1;height:1px;background:linear-gradient(90deg,rgba(0,0,0,.06),transparent)}
    </style>
    @include('components.design-tokens')
</head>
<body class="bg-[#f5f5f0] font-sans antialiased text-slate-700 overflow-x-clip">

    @include('admin.components.sidebar')

    <main class="flex-1 overflow-y-auto pt-16 md:pt-0 min-h-screen">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="max-w-[1440px] mx-auto" x-data="sekdesDashboard()" x-init="init()">

                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                         x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
                         class="mb-6 flex items-center gap-3 px-5 py-4 rounded-2xl bg-emerald-50 border border-emerald-200/60 shadow-sm shadow-emerald-500/5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-500/10 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-sm font-medium text-emerald-700 flex-1">{{ session('success') }}</p>
                        <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif

                @php
                    $ratePersetujuan = $totalSurat > 0 ? round(($selesai / max($selesai + $ditolak, 1)) * 100) : 0;
                    $quotaPercent = $dailyQuotaLimit > 0 ? round(($dailyQuotaUsed / $dailyQuotaLimit) * 100) : 0;
                @endphp

                {{-- ═══════════════════════════════════════════════════════════ --}}
                {{-- SECTION 1: KPI EXECUTIVE (8 cards)                        --}}
                {{-- ═══════════════════════════════════════════════════════════ --}}
                @php
                    $kpis = [
                        ['label' => 'Total Warga', 'value' => $totalWarga, 'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z', 'color' => 'teal', 'subtitle' => 'Penduduk terdaftar', 'growth' => $wargaGrowth],
                        ['label' => 'Total Surat', 'value' => $totalSurat, 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z', 'color' => 'cyan', 'subtitle' => 'Sepanjang masa', 'growth' => $suratGrowth],
                        ['label' => 'Menunggu', 'value' => $pendingCount, 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'amber', 'subtitle' => 'Perlu diverifikasi', 'pulse' => $pendingCount > 0],
                        ['label' => 'Selesai', 'value' => $selesai, 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'emerald', 'subtitle' => 'Total selesai'],
                        ['label' => 'Bulan Ini', 'value' => $selesaiBulanIni, 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5', 'color' => 'teal', 'subtitle' => 'Selesai bulan ini'],
                        ['label' => 'Ditolak', 'value' => $ditolak, 'icon' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'red', 'subtitle' => 'Total ditolak'],
                        ['label' => 'Verifikasi', 'value' => $todayVerified, 'icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z', 'color' => 'cyan', 'subtitle' => 'Diverifikasi hari ini'],
                        ['label' => 'Surat Masuk', 'value' => $totalSuratMasuk, 'icon' => 'M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51', 'color' => 'cyan', 'subtitle' => 'Total masuk'],
                    ];
                @endphp
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3">
                    @foreach($kpis as $i => $kpi)
                        <div class="bento-card stat-micro p-4 lg:p-3 xl:p-4 a-fade-up d{{ $i + 1 }}" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 rounded-xl bg-{{ $kpi['color'] }}-50 text-{{ $kpi['color'] }}-600 flex items-center justify-center border border-{{ $kpi['color'] }}-100/50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $kpi['icon'] }}"/></svg>
                                </div>
                                @if($kpi['pulse'] ?? false)
                                    <span class="relative flex h-3 w-3">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-{{ $kpi['color'] }}-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-{{ $kpi['color'] }}-500"></span>
                                    </span>
                                @endif
                            </div>
                            <p class="text-2xl lg:text-xl xl:text-2xl font-extrabold text-gray-900 tabular-nums">{{ number_format($kpi['value']) }}</p>
                            <p class="text-[10px] xl:text-xs font-semibold text-gray-500 mt-1 uppercase tracking-wider">{{ $kpi['label'] }}</p>
                            <div class="flex items-center gap-1.5 mt-1">
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
                {{-- SECTION 2: HERO HEADER                                    --}}
                {{-- ═══════════════════════════════════════════════════════════ --}}
                <div class="a-fade-up d1 mt-6">
                    <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-[#052e22] via-[#065f46] to-[#0e7490] p-6 sm:p-8 lg:p-10 text-white shadow-2xl shadow-teal-900/20">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3" style="animation:orbFloat1 12s ease-in-out infinite"></div>
                        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/4" style="animation:orbFloat2 14s ease-in-out infinite"></div>
                        <div class="absolute top-1/2 right-1/4 w-32 h-32 bg-teal-400/5 rounded-full" style="animation:orbFloat1 10s ease-in-out infinite reverse"></div>

                        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                            <div class="flex items-start gap-5">
                                <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-sm flex items-center justify-center shrink-0 border border-white/10 shadow-lg">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                </div>
                                <div>
                                    <p class="text-teal-200/80 text-sm font-medium" x-text="greeting"></p>
                                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mt-1 tracking-tight">
                                        Selamat Datang, <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-300 to-cyan-200">Sekretaris Desa</span>
                                    </h1>
                                    <div class="flex flex-wrap items-center gap-2.5 mt-3">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 backdrop-blur-sm text-xs font-semibold border border-white/10">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21"/></svg>
                                            {{ config('village.nama_desa', 'Desa') }}
                                        </span>
                                        @if($pendingCount > 0)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-400/20 backdrop-blur-sm text-amber-200 text-xs font-semibold border border-amber-400/20">
                                                <span class="w-2 h-2 rounded-full bg-amber-400 notification-dot"></span>
                                                {{ $pendingCount }} menunggu verifikasi
                                            </span>
                                        @endif
                                        @if($slaBreached > 0)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-400/20 backdrop-blur-sm text-red-200 text-xs font-semibold border border-red-400/20">
                                                <span class="w-2 h-2 rounded-full bg-red-400 notification-dot"></span>
                                                {{ $slaBreached }} melewati SLA
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row lg:flex-col xl:flex-row items-start sm:items-center gap-4 lg:gap-5">
                                <div class="text-left sm:text-right lg:text-left xl:text-right">
                                    <p class="text-2xl sm:text-3xl font-extrabold tracking-tight tabular-nums" x-text="currentTime">--:--</p>
                                    <p class="text-sm text-teal-200/70 mt-0.5" x-text="currentDate">--</p>
                                </div>
                                @if($pendingCount > 0)
                                    <a href="{{ route('admin.pengajuan.index', ['status' => 'approved_operator']) }}"
                                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white/15 backdrop-blur-sm text-sm font-semibold hover:bg-white/25 transition-all border border-white/10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                                        Lihat Semua
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════════ --}}
                {{-- SECTION 3: MAIN 2-COLUMN GRID (8:4)                      --}}
                {{-- ═══════════════════════════════════════════════════════════ --}}
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6">

                    {{-- ── LEFT COLUMN (8 cols) ── --}}
                    <div class="lg:col-span-8 space-y-6">

                        {{-- VERIFICATION PRIORITY --}}
                        <div class="bento-card a-fade-up d3" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="flex items-center justify-between px-5 sm:px-6 py-4 border-b border-gray-100">
                                <div class="section-header mb-0">
                                    <h3 class="text-gray-800">Verifikasi Prioritas</h3>
                                </div>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-bold border border-amber-100">
                                    {{ $pendingCount }} menunggu verifikasi
                                </span>
                            </div>

                            @if($pendingVerification->count())
                                <div class="p-4 sm:p-5 space-y-4">
                                    @foreach($pendingVerification as $item)
                                        @php
                                            $hoursWaiting = $item->created_at->diffInHours(now());
                                            if($hoursWaiting >= 48) { $priority = 'Mendesak'; $priorityBg = 'bg-red-50 text-red-600 border-red-100'; $priorityDot = 'bg-red-500'; }
                                            elseif($hoursWaiting >= 24) { $priority = 'Perhatian'; $priorityBg = 'bg-amber-50 text-amber-600 border-amber-100'; $priorityDot = 'bg-amber-500'; }
                                            else { $priority = 'Normal'; $priorityBg = 'bg-emerald-50 text-emerald-600 border-emerald-100'; $priorityDot = 'bg-emerald-500'; }
                                            $initials = collect(explode(' ', $item->user->name ?? 'U'))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
                                            $timeAgo = $item->created_at->diffForHumans();
                                        @endphp
                                        <div class="rounded-2xl border border-gray-100 p-4 sm:p-5 hover:border-teal-200/60 hover:shadow-md transition-all duration-300" style="animation:slideUp .5s var(--ease-out-expo)">
                                            <div class="flex items-start justify-between mb-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-11 h-11 rounded-full bg-gradient-to-br from-brand-400 to-cyan-500 flex items-center justify-center text-white text-sm font-bold shrink-0 shadow-lg shadow-brand-500/20">
                                                        {{ $initials }}
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-bold text-gray-900">{{ $item->user->name ?? '-' }}</p>
                                                        <p class="text-xs text-gray-500 capitalize">{{ str_replace('_', ' ', $item->jenis_surat) }}</p>
                                                    </div>
                                                </div>
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $priorityBg }}">
                                                    <span class="w-1.5 h-1.5 rounded-full {{ $priorityDot }}"></span>
                                                    {{ $priority }}
                                                </span>
                                            </div>

                                            <div class="flex items-center gap-2 text-[11px] text-gray-400 mb-4">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                <span>{{ $item->created_at->format('d M Y, H:i') }}</span>
                                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                                <span class="font-medium">{{ $timeAgo }}</span>
                                            </div>

                                            {{-- Progress Timeline: submitted → operator → SEKADES (active) → kades --}}
                                            <div class="flex items-center gap-1 mb-4 px-1">
                                                @php $steps = ['Diajukan', 'Operator', 'Sekdes', 'Kades']; @endphp
                                                @foreach($steps as $si => $step)
                                                    <div class="flex items-center gap-1 flex-1">
                                                        <div class="progress-step w-full">
                                                            @if($si <= 1)
                                                                <div class="progress-step-dot bg-emerald-500 shrink-0"></div>
                                                            @elseif($si == 2)
                                                                <div class="progress-step-dot bg-amber-500 shrink-0" style="animation:pulse-dot 2s ease-in-out infinite"></div>
                                                            @else
                                                                <div class="progress-step-dot bg-gray-300 shrink-0"></div>
                                                            @endif
                                                            @if($si < 3)<div class="progress-step-line {{ $si < 2 ? 'bg-emerald-400' : 'bg-gray-200' }}"></div>@endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="flex justify-between px-1 mb-4">
                                                @foreach($steps as $si => $step)
                                                    <span class="text-[9px] font-semibold {{ $si == 2 ? 'text-amber-600' : ($si < 2 ? 'text-emerald-600' : 'text-gray-400') }}">{{ $step }}</span>
                                                @endforeach
                                            </div>

                                            <div class="flex items-center gap-2 flex-wrap">
                                                <a href="{{ route('admin.pengajuan.show', $item) }}"
                                                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-cyan-50 text-cyan-600 text-xs font-semibold hover:bg-cyan-100 transition border border-cyan-100/50">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                    Detail
                                                </a>
                                                <form action="{{ route('admin.pengajuan.approve', $item) }}" method="POST"
                                                      onsubmit="return confirm('Verifikasi pengajuan ini? Surat akan dikirim ke Kepala Desa untuk persetujuan akhir.')">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gradient-to-r from-brand-500 to-cyan-500 text-white text-xs font-semibold shadow-lg shadow-brand-500/25 hover:shadow-xl hover:shadow-brand-500/30 hover:-translate-y-0.5 transition-all">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                        Verifikasi
                                                    </button>
                                                </form>
                                                <button @click="openReject({{ $item->id }})"
                                                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-red-50 text-red-600 text-xs font-semibold hover:bg-red-100 transition border border-red-100/50">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    Tolak
                                                </button>
                                            </div>

                                            <div x-show="rejectingId === {{ $item->id }}" x-cloak
                                                 x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                                                 x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                 class="mt-3 rounded-xl border border-red-200 bg-red-50/50 p-3">
                                                <form action="{{ route('admin.pengajuan.reject', $item) }}" method="POST" class="flex gap-2">
                                                    @csrf
                                                    <input type="text" name="catatan" required placeholder="Alasan penolakan..."
                                                           class="flex-1 text-xs border border-red-200 rounded-xl px-3 py-2 outline-none focus:ring-2 focus:ring-red-400 bg-white">
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1 px-3 py-2 rounded-xl bg-red-500 text-white text-xs font-semibold hover:bg-red-600 transition shrink-0">
                                                        Kirim
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach

                                    @if($pendingVerification->hasPages())
                                        <div class="pt-2">{{ $pendingVerification->links() }}</div>
                                    @endif
                                </div>
                            @else
                                <div class="p-10 text-center">
                                    <div class="w-20 h-20 rounded-3xl bg-teal-50 flex items-center justify-center mx-auto mb-4 border border-teal-100/50">
                                        <svg class="w-10 h-10 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Semua pengajuan sudah diverifikasi</p>
                                    <p class="text-xs text-gray-400">Tidak ada pengajuan yang menunggu verifikasi Anda.</p>
                                </div>
                            @endif
                        </div>

                        {{-- SURAT MANDEK DI OPERATOR --}}
                        @if($stuckSurat->count())
                        <div class="bento-card a-fade-up d5" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="px-5 sm:px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                                <div class="section-header mb-0">
                                    <h3 class="text-gray-800">Surat Mandek di Operator</h3>
                                </div>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 text-red-600 text-xs font-bold border border-red-100">
                                    {{ $stuckSurat->count() }} surat
                                </span>
                            </div>
                            <div class="p-4 sm:p-5">
                                <div class="space-y-2">
                                    @foreach($stuckSurat as $stuck)
                                        @php
                                            $daysStuck = $stuck->updated_at->diffInDays(now());
                                        @endphp
                                        <div class="flex items-center gap-3 p-3 rounded-xl bg-red-50/40 border border-red-100/30">
                                            <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-[10px] font-bold shrink-0">
                                                {{ $daysStuck }}h
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-semibold text-gray-700 truncate">{{ $stuck->user->name ?? '-' }} — {{ str_replace('_', ' ', $stuck->jenis_surat) }}</p>
                                                <p class="text-[10px] text-gray-400">{{ $stuck->updated_at->diffForHumans() }} &middot; Status: verified</p>
                                            </div>
                                            <a href="{{ route('admin.pengajuan.show', $stuck) }}" class="text-[10px] font-semibold text-teal-600 hover:text-teal-700">Lihat</a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- STATISTIK OPERATOR --}}
                        @if($operatorStats->count())
                        <div class="bento-card a-fade-up d6" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="px-5 sm:px-6 py-4 border-b border-gray-100">
                                <div class="section-header mb-0">
                                    <h3 class="text-gray-800">Statistik Operator</h3>
                                </div>
                            </div>
                            <div class="p-4 sm:p-5">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-xs">
                                        <thead>
                                            <tr class="border-b border-gray-100">
                                                <th class="text-left py-2 px-2 font-bold text-gray-500 uppercase tracking-wider">Operator</th>
                                                <th class="text-center py-2 px-2 font-bold text-gray-500 uppercase tracking-wider">Review</th>
                                                <th class="text-center py-2 px-2 font-bold text-gray-500 uppercase tracking-wider">Approve</th>
                                                <th class="text-center py-2 px-2 font-bold text-gray-500 uppercase tracking-wider">Tolak</th>
                                                <th class="text-center py-2 px-2 font-bold text-gray-500 uppercase tracking-wider">Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($operatorStats as $op)
                                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                                                    <td class="py-2.5 px-2 font-semibold text-gray-700">{{ $op->name }}</td>
                                                    <td class="py-2.5 px-2 text-center font-medium text-gray-600">{{ $op->total_reviewed }}</td>
                                                    <td class="py-2.5 px-2 text-center font-medium text-emerald-600">{{ $op->total_approved }}</td>
                                                    <td class="py-2.5 px-2 text-center font-medium text-red-600">{{ $op->total_rejected }}</td>
                                                    <td class="py-2.5 px-2 text-center">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $op->approval_rate >= 80 ? 'bg-emerald-50 text-emerald-600' : ($op->approval_rate >= 50 ? 'bg-amber-50 text-amber-600' : 'bg-red-50 text-red-600') }}">
                                                            {{ $op->approval_rate }}%
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- RIWAYAT VERIFIKASI --}}
                        @if($verificationHistory->count())
                        <div class="bento-card a-fade-up d7" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="px-5 sm:px-6 py-4 border-b border-gray-100">
                                <div class="section-header mb-0">
                                    <h3 class="text-gray-800">Riwayat Verifikasi Saya</h3>
                                </div>
                            </div>
                            <div class="p-4 sm:p-5">
                                <div class="space-y-0">
                                    @foreach($verificationHistory as $hist)
                                        @php
                                            $isApproved = $hist->status === 'approved_sekdes';
                                            $actColor = $isApproved ? 'emerald' : 'red';
                                        @endphp
                                        <div class="timeline-item">
                                            <div class="timeline-dot border-{{ $actColor }}-500" style="{{ $isApproved ? 'background:#10b981' : '' }}"></div>
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="min-w-0">
                                                    <p class="text-sm font-semibold text-gray-900">{{ $hist->pengajuan->user->name ?? '-' }}</p>
                                                    <p class="text-xs text-gray-500 mt-0.5">
                                                        {{ str_replace('_', ' ', $hist->pengajuan->jenis_surat ?? '') }} &middot;
                                                        <span class="{{ $isApproved ? 'text-emerald-600' : 'text-red-600' }}">{{ $isApproved ? 'Diverifikasi' : 'Ditolak' }}</span>
                                                    </p>
                                                    @if($hist->catatan)
                                                        <p class="text-[11px] text-gray-400 mt-0.5 italic">"{{ $hist->catatan }}"</p>
                                                    @endif
                                                </div>
                                                <span class="text-[10px] text-gray-400 shrink-0">{{ $hist->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- SURAT MASUK / KELUAR --}}
                        <div class="bento-card a-fade-up d8" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="px-5 sm:px-6 py-4 border-b border-gray-100">
                                <div class="section-header mb-0">
                                    <h3 class="text-gray-800">Surat Masuk & Keluar</h3>
                                </div>
                            </div>
                            <div class="p-4 sm:p-5">
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div class="p-4 rounded-xl bg-cyan-50/80 border border-cyan-100/50">
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="w-8 h-8 rounded-lg bg-cyan-100 text-cyan-600 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51"/></svg>
                                            </div>
                                            <span class="text-xs font-bold text-cyan-700">Masuk</span>
                                        </div>
                                        <p class="text-xl font-extrabold text-gray-900">{{ $totalSuratMasuk }}</p>
                                        <div class="flex items-center gap-2 mt-1 text-[10px] text-gray-500">
                                            <span>Hari ini: <strong class="text-cyan-600">{{ $suratMasukHariIni }}</strong></span>
                                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                            <span>Minggu ini: <strong class="text-cyan-600">{{ $suratMasukMingguIni }}</strong></span>
                                        </div>
                                    </div>
                                    <div class="p-4 rounded-xl bg-violet-50/80 border border-violet-100/50">
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="w-8 h-8 rounded-lg bg-violet-100 text-violet-600 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                                            </div>
                                            <span class="text-xs font-bold text-violet-700">Keluar</span>
                                        </div>
                                        <p class="text-xl font-extrabold text-gray-900">{{ $totalSuratKeluar }}</p>
                                        <div class="flex items-center gap-2 mt-1 text-[10px] text-gray-500">
                                            <span>Hari ini: <strong class="text-violet-600">{{ $suratKeluarHariIni }}</strong></span>
                                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                            <span>Minggu ini: <strong class="text-violet-600">{{ $suratKeluarMingguIni }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                @if($suratMasukTerbaru->count())
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Terbaru Diterima</p>
                                        <div class="space-y-2">
                                            @foreach($suratMasukTerbaru as $sm)
                                                <div class="flex items-center gap-3 p-2 rounded-lg bg-gray-50/60">
                                                    <div class="w-2 h-2 rounded-full bg-cyan-400 shrink-0"></div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-xs font-semibold text-gray-700 truncate">{{ $sm->perihal }}</p>
                                                        <p class="text-[10px] text-gray-400">{{ $sm->pengirim }} &middot; {{ $sm->tanggal_terima?->format('d M Y') }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ── RIGHT COLUMN (4 cols) ── --}}
                    <div class="lg:col-span-4 space-y-6">

                        {{-- QUICK ACTIONS --}}
                        <div class="bento-card p-5 sm:p-6 a-fade-up d4" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="section-header">
                                <h3 class="text-gray-800">Aksi Cepat</h3>
                                <div class="shimmer-line"></div>
                            </div>
                            <div class="grid grid-cols-3 gap-2.5">
                                <a href="{{ route('admin.pengajuan.index', ['status' => 'approved_operator']) }}" class="quick-action flex flex-col items-center gap-2 p-3.5 rounded-2xl bg-amber-50/80 border border-amber-100/50 hover:border-amber-200">
                                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-gray-700 text-center leading-tight">Verifikasi</span>
                                </a>
                                <a href="{{ route('admin.pengajuan.index') }}" class="quick-action flex flex-col items-center gap-2 p-3.5 rounded-2xl bg-cyan-50/80 border border-cyan-100/50 hover:border-cyan-200">
                                    <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-gray-700 text-center leading-tight">Riwayat</span>
                                </a>
                                <a href="{{ route('admin.analytics.index') }}" class="quick-action flex flex-col items-center gap-2 p-3.5 rounded-2xl bg-purple-50/80 border border-purple-100/50 hover:border-purple-200">
                                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-gray-700 text-center leading-tight">Analitik</span>
                                </a>
                                <a href="{{ route('admin.setting.index') }}" class="quick-action flex flex-col items-center gap-2 p-3.5 rounded-2xl bg-gray-50/80 border border-gray-100/50 hover:border-gray-200">
                                    <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-gray-700 text-center leading-tight">Pengaturan</span>
                                </a>
                                <a href="{{ route('home') }}" class="quick-action flex flex-col items-center gap-2 p-3.5 rounded-2xl bg-cyan-50/80 border border-cyan-100/50 hover:border-cyan-200">
                                    <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-gray-700 text-center leading-tight">Beranda</span>
                                </a>
                                <a href="{{ route('admin.pengajuan.index', ['status' => 'completed']) }}" class="quick-action flex flex-col items-center gap-2 p-3.5 rounded-2xl bg-emerald-50/80 border border-emerald-100/50 hover:border-emerald-200">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-gray-700 text-center leading-tight">Selesai</span>
                                </a>
                            </div>
                        </div>

                        {{-- RINGKASAN EKSEKUTIF --}}
                        <div class="bento-card p-5 sm:p-6 a-fade-up d5" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="section-header">
                                <h3 class="text-gray-800">Ringkasan Eksekutif</h3>
                                <div class="shimmer-line"></div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50/80 border border-gray-100/50">
                                    <div class="w-9 h-9 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-[11px] text-gray-500 font-medium">Surat Hari Ini</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $totalSuratBulanIni }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50/80 border border-gray-100/50">
                                    <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-[11px] text-gray-500 font-medium">Selesai Bulan Ini</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $selesaiBulanIni }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50/80 border border-gray-100/50">
                                    <div class="w-9 h-9 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-[11px] text-gray-500 font-medium">Rate Persetujuan</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $ratePersetujuan }}%</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- KUOTA VERIFIKASI HARIAN --}}
                        <div class="bento-card p-5 sm:p-6 a-fade-up d6" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="section-header">
                                <h3 class="text-gray-800">Kuota Verifikasi Harian</h3>
                                <div class="shimmer-line"></div>
                            </div>
                            <div class="text-center mb-3">
                                <div class="relative w-24 h-24 mx-auto">
                                    <svg class="w-24 h-24 -rotate-90" viewBox="0 0 36 36">
                                        <path d="M18 2.0845a15.9155 15.9155 0 010 31.831 15.9155 15.9155 0 010-31.831" fill="none" stroke="#e5e7eb" stroke-width="3"/>
                                        <path d="M18 2.0845a15.9155 15.9155 0 010 31.831 15.9155 15.9155 0 010-31.831" fill="none" stroke="{{ $quotaPercent >= 80 ? '#10b981' : ($quotaPercent >= 50 ? '#f59e0b' : '#14b8a6') }}" stroke-width="3" stroke-dasharray="{{ $quotaPercent }}, 100" stroke-linecap="round"/>
                                    </svg>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <span class="text-lg font-extrabold text-gray-900">{{ $dailyQuotaUsed }}/{{ $dailyQuotaLimit }}</span>
                                        <span class="text-[8px] font-semibold text-gray-400 uppercase">Hari Ini</span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-[10px] text-gray-400 text-center">Sisa kuota: {{ max(0, $dailyQuotaLimit - $dailyQuotaUsed) }} verifikasi</p>
                        </div>

                        {{-- RATA-RATA WAKTU VERIFIKASI --}}
                        <div class="bento-card p-5 sm:p-6 a-fade-up d7" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="section-header">
                                <h3 class="text-gray-800">Waktu Proses Verifikasi</h3>
                                <div class="shimmer-line"></div>
                            </div>
                            @php
                                $avgDays = floor($avgProcessHours / 24);
                                $avgRemainHours = round($avgProcessHours % 24);
                                $avgLabel = $avgDays > 0 ? "{$avgDays} hari {$avgRemainHours} jam" : "{$avgRemainHours} jam";
                                $avgBarWidth = min(($avgProcessHours / 48) * 100, 100);
                                $avgBarColor = $avgProcessHours <= 12 ? 'from-emerald-400 to-teal-400' : ($avgProcessHours <= 24 ? 'from-amber-400 to-orange-400' : 'from-red-400 to-rose-400');
                            @endphp
                            <div class="text-center mb-3">
                                <p class="text-2xl font-extrabold text-gray-900">{{ $avgLabel }}</p>
                                <p class="text-[10px] text-gray-400 mt-1">Rata-rata dari operator approve ke verifikasi Anda</p>
                            </div>
                            <div class="h-2.5 rounded-full bg-gray-100 overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r {{ $avgBarColor }} transition-all duration-1000" style="width:{{ $avgBarWidth }}%"></div>
                            </div>
                        </div>

                        {{-- PETA SEBARAN RT/RW --}}
                        @if($rtStats->count())
                        <div class="bento-card p-5 sm:p-6 a-fade-up d8" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="section-header">
                                <h3 class="text-gray-800">Sebaran RT / RW</h3>
                                <div class="shimmer-line"></div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Per RT</p>
                                    <div class="h-32">
                                        <canvas id="rtChart"></canvas>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Per RW</p>
                                    <div class="h-32">
                                        <canvas id="rwChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- ANTREAN PENGAMBILAN --}}
                        @if($antreanMenunggu > 0 || $antreanLewat > 0)
                        <div class="bento-card p-5 sm:p-6 a-fade-up d9" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="section-header">
                                <h3 class="text-gray-800">Antrean Pengambilan</h3>
                                <div class="shimmer-line"></div>
                            </div>
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                <div class="p-2.5 rounded-xl bg-amber-50/80 border border-amber-100/50 text-center">
                                    <p class="text-lg font-extrabold text-amber-600">{{ $antreanMenunggu }}</p>
                                    <p class="text-[9px] font-bold text-amber-500 uppercase">Menunggu</p>
                                </div>
                                <div class="p-2.5 rounded-xl bg-red-50/80 border border-red-100/50 text-center">
                                    <p class="text-lg font-extrabold text-red-600">{{ $antreanLewat }}</p>
                                    <p class="text-[9px] font-bold text-red-500 uppercase">Lewat</p>
                                </div>
                                <div class="p-2.5 rounded-xl bg-emerald-50/80 border border-emerald-100/50 text-center">
                                    <p class="text-lg font-extrabold text-emerald-600">{{ $antreanDiambil }}</p>
                                    <p class="text-[9px] font-bold text-emerald-500 uppercase">Hari Ini</p>
                                </div>
                            </div>
                            @if($antreanTerbaru->count())
                                <div class="space-y-2">
                                    @foreach($antreanTerbaru as $aq)
                                        <div class="flex items-center gap-3 p-2.5 rounded-lg {{ $aq->tanggal_ambil->isPast() ? 'bg-red-50/60 border border-red-100/30' : 'bg-gray-50/60' }}">
                                            <div class="w-8 h-8 rounded-lg {{ $aq->tanggal_ambil->isPast() ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600' }} flex items-center justify-center text-[10px] font-bold shrink-0">
                                                {{ $aq->nomor_antrean ? substr($aq->nomor_antrean, -3) : '-' }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-semibold text-gray-700 truncate">{{ $aq->pengajuan->user->name ?? '-' }}</p>
                                                <p class="text-[10px] text-gray-400 capitalize">{{ str_replace('_', ' ', $aq->pengajuan->jenis_surat ?? '') }} &middot; {{ $aq->tanggal_ambil->format('d M') }}</p>
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

                        {{-- BERITA TERBARU --}}
                        @if($beritaTerbaru->count())
                        <div class="bento-card p-5 sm:p-6 a-fade-up d10" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="section-header">
                                <h3 class="text-gray-800">Berita Terbaru</h3>
                                <div class="shimmer-line"></div>
                            </div>
                            <div class="space-y-3">
                                @foreach($beritaTerbaru as $berita)
                                    <a href="{{ route('berita.show', $berita->slug) }}" target="_blank" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-gray-50/80 transition group">
                                        @if($berita->foto)
                                            <img src="{{ asset('storage/' . $berita->foto) }}" alt="{{ $berita->judul }}" class="w-14 h-14 rounded-lg object-cover shrink-0 border border-gray-100">
                                        @else
                                            <div class="w-14 h-14 rounded-lg bg-gradient-to-br from-teal-100 to-cyan-100 flex items-center justify-center shrink-0">
                                                <svg class="w-6 h-6 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5"/></svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 group-hover:text-teal-700 transition truncate">{{ $berita->judul }}</p>
                                            <p class="text-[11px] text-gray-400 mt-0.5">{{ $berita->created_at->diffForHumans() }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- TREN PENGAJUAN --}}
                        <div class="bento-card p-5 sm:p-6 a-fade-up d11" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="section-header">
                                <h3 class="text-gray-800">Tren Pengajuan</h3>
                                <div class="shimmer-line"></div>
                            </div>
                            <div class="h-48">
                                <canvas id="trenChart"></canvas>
                            </div>
                        </div>

                        {{-- DISTRIBUSI JENIS SURAT --}}
                        @if($distribusiJenis->count())
                        <div class="bento-card p-5 sm:p-6 a-fade-up d12" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="section-header">
                                <h3 class="text-gray-800">Distribusi Jenis Surat</h3>
                                <div class="shimmer-line"></div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-32 h-32 shrink-0">
                                    <canvas id="jenisChart"></canvas>
                                </div>
                                <div class="flex-1 space-y-1.5">
                                    @php
                                        $colors = ['#10b981','#14b8a6','#f59e0b','#ef4444','#8b5cf6','#06b6d4'];
                                        $totalJenis = $distribusiJenis->sum('total');
                                    @endphp
                                    @foreach($distribusiJenis as $i => $dj)
                                        <div class="flex items-center gap-2">
                                            <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background:{{ $colors[$i % 6] }}"></span>
                                            <span class="text-[10px] font-medium text-gray-600 capitalize truncate flex-1">{{ str_replace('_', ' ', $dj->jenis_surat) }}</span>
                                            <span class="text-[10px] font-bold text-gray-700">{{ $dj->total }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- PERTUMBUHAN WARGA --}}
                        <div class="bento-card p-5 sm:p-6 a-fade-up d13" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="section-header">
                                <h3 class="text-gray-800">Pertumbuhan Warga</h3>
                                <div class="shimmer-line"></div>
                            </div>
                            <div class="h-40">
                                <canvas id="wargaChart"></canvas>
                            </div>
                        </div>

                        {{-- MONITORING SLA --}}
                        <div class="bento-card p-5 sm:p-6 a-fade-up d14" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="section-header">
                                <h3 class="text-gray-800">Monitoring SLA</h3>
                                <div class="shimmer-line"></div>
                            </div>
                            @php
                                $slaPercent = $inProgress > 0 ? round((($inProgress - $slaBreached) / $inProgress) * 100) : 100;
                            @endphp
                            <div class="text-center mb-4">
                                <div class="relative w-24 h-24 mx-auto">
                                    <svg class="w-24 h-24 -rotate-90" viewBox="0 0 36 36">
                                        <path d="M18 2.0845a15.9155 15.9155 0 010 31.831 15.9155 15.9155 0 010-31.831" fill="none" stroke="#e5e7eb" stroke-width="3"/>
                                        <path d="M18 2.0845a15.9155 15.9155 0 010 31.831 15.9155 15.9155 0 010-31.831" fill="none" stroke="{{ $slaPercent >= 80 ? '#10b981' : ($slaPercent >= 50 ? '#f59e0b' : '#ef4444') }}" stroke-width="3" stroke-dasharray="{{ $slaPercent }}, 100" stroke-linecap="round"/>
                                    </svg>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <span class="text-lg font-extrabold text-gray-900">{{ $slaPercent }}%</span>
                                        <span class="text-[8px] font-semibold text-gray-400 uppercase">On Time</span>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="p-2.5 rounded-xl bg-emerald-50/80 border border-emerald-100/50 text-center">
                                    <p class="text-sm font-extrabold text-emerald-600">{{ $inProgress - $slaBreached }}</p>
                                    <p class="text-[9px] font-bold text-emerald-500 uppercase">Sesuai SLA</p>
                                </div>
                                <div class="p-2.5 rounded-xl bg-red-50/80 border border-red-100/50 text-center">
                                    <p class="text-sm font-extrabold text-red-600">{{ $slaBreached }}</p>
                                    <p class="text-[9px] font-bold text-red-500 uppercase">Melewati SLA</p>
                                </div>
                            </div>
                            <p class="text-[10px] text-gray-400 text-center mt-2">Batas SLA: {{ $slaHours }} jam</p>
                        </div>

                        {{-- INFORMASI DESA --}}
                        <div class="bento-card p-5 sm:p-6 a-fade-up d14" style="animation:successPop .5s var(--ease-out-expo)">
                            <div class="section-header">
                                <h3 class="text-gray-800">Informasi Desa</h3>
                                <div class="shimmer-line"></div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama Desa</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ config('village.nama_desa') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kepala Desa</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ config('village.nama_kades') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Sekretaris Desa</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ config('village.nama_sekdes') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kontak</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ config('village.email_desa') }}</p>
                                        <p class="text-xs text-gray-500">{{ config('village.telepon_desa') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                                    <span class="health-dot ok"></span>
                                    <span class="text-[11px] font-medium text-gray-500">Server Aktif</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════════ --}}
                {{-- SECTION 4: INSIGHT BAR                                   --}}
                {{-- ═══════════════════════════════════════════════════════════ --}}
                <div class="mt-6 a-fade-up d12" style="animation:successPop .5s var(--ease-out-expo)">
                    <div class="rounded-2xl bg-gradient-to-r from-gray-50 to-white border border-gray-100 p-4 sm:p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-6 h-6 rounded-lg bg-teal-100 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-600 uppercase tracking-wider">Insight Cepat</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @if($pendingCount > 0)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-50 text-amber-700 text-[11px] font-semibold border border-amber-100/50">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $pendingCount }} surat menunggu verifikasi
                                </span>
                            @endif
                            @if($selesaiBulanIni > 0)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-semibold border border-emerald-100/50">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $selesaiBulanIni }} surat selesai bulan ini
                                </span>
                            @endif
                            @if($antreanLewat > 0)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-50 text-red-700 text-[11px] font-semibold border border-red-100/50">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
                                    {{ $antreanLewat }} antrean lewat jadwal
                                </span>
                            @endif
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-cyan-50 text-cyan-700 text-[11px] font-semibold border border-cyan-100/50">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/></svg>
                                Rate persetujuan {{ $ratePersetujuan }}%
                            </span>
                            @if($eventMendatang->count())
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-cyan-50 text-cyan-700 text-[11px] font-semibold border border-cyan-100/50">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                    {{ $eventMendatang->count() }} event mendatang
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════════ --}}
                {{-- SECTION 5: FOOTER                                        --}}
                {{-- ═══════════════════════════════════════════════════════════ --}}
                <div class="border-t border-gray-200/60 pt-5 pb-2 mt-8 a-fade-in d14">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-[11px] text-gray-400">
                        <div class="flex items-center gap-3">
                            <span class="font-semibold text-gray-500">Prodesa v1.0</span>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <span class="px-2 py-0.5 rounded-full {{ config('app.env') === 'production' ? 'bg-emerald-50 text-emerald-600 font-semibold border border-emerald-100' : 'bg-amber-50 text-amber-600 font-semibold border border-amber-100' }}">{{ ucfirst(config('app.env')) }}</span>
                        </div>
                        <span>&copy; {{ date('Y') }} {{ config('village.nama_desa', 'Desa') }} &middot; IG <a href="https://instagram.com/rangga.mrw" target="_blank" class="text-gray-500 hover:text-brand-600 transition font-medium">@rangga.mrw</a></span>
                    </div>
                </div>

            </div>
        </div>
    </main>
    </div>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- SCRIPTS                                                   --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <script>
        function sekdesDashboard() {
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
                    }, { threshold: 0.1 });
                    document.querySelectorAll('.a-fade-up, .a-fade-in, .a-scale').forEach(el => obs.observe(el));
                },

                initCharts() {
                    const font = { family: 'Montserrat' };
                    const tooltipStyle = { backgroundColor: '#0f172a', padding: 12, cornerRadius: 10, titleFont: { ...font, weight: '600', size: 12 }, bodyFont: { ...font, size: 11 } };

                    // ── Tren Pengajuan (Bar) ──
                    const trenLabels = @json($trenLabels);
                    const trenSelesai = @json($trenSelesai);
                    const trenDitolak = @json($trenDitolak);
                    const trenCtx = document.getElementById('trenChart');
                    if (trenCtx) {
                        new Chart(trenCtx, {
                            type: 'bar',
                            data: {
                                labels: trenLabels,
                                datasets: [
                                    { label: 'Selesai', data: trenSelesai, backgroundColor: 'rgba(16,185,129,0.7)', borderRadius: 4, borderSkipped: false },
                                    { label: 'Ditolak', data: trenDitolak, backgroundColor: 'rgba(239,68,68,0.5)', borderRadius: 4, borderSkipped: false },
                                ]
                            },
                            options: {
                                responsive: true, maintainAspectRatio: false,
                                animation: { duration: 1000, easing: 'easeOutQuart' },
                                plugins: { legend: { display: true, position: 'top', labels: { ...font, size: 10, usePointStyle: true, pointStyle: 'circle', padding: 12 } }, tooltip: tooltipStyle },
                                scales: {
                                    y: { beginAtZero: true, stacked: true, ticks: { stepSize: 1, font: { size: 10, ...font }, color: '#94a3b8' }, grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false } },
                                    x: { stacked: true, ticks: { font: { size: 10, ...font }, color: '#94a3b8' }, grid: { display: false } }
                                }
                            }
                        });
                    }

                    // ── Distribusi Jenis Surat (Doughnut) ──
                    const jenisLabels = @json($jenisLabels);
                    const jenisValues = @json($jenisValues);
                    const jenisCtx = document.getElementById('jenisChart');
                    if (jenisCtx) {
                        new Chart(jenisCtx, {
                            type: 'doughnut',
                            data: {
                                labels: jenisLabels,
                                datasets: [{ data: jenisValues, backgroundColor: ['#10b981','#14b8a6','#f59e0b','#ef4444','#8b5cf6','#06b6d4'], borderWidth: 0, hoverOffset: 4 }]
                            },
                            options: {
                                responsive: true, maintainAspectRatio: false, cutout: '65%',
                                animation: { animateRotate: true, duration: 1200 },
                                plugins: { legend: { display: false }, tooltip: tooltipStyle }
                            }
                        });
                    }

                    // ── Pertumbuhan Warga (Line) ──
                    const wargaLabels = @json($wargaLabels);
                    const wargaValues = @json($wargaValues);
                    const wargaCtx = document.getElementById('wargaChart');
                    if (wargaCtx) {
                        const wargaGradient = wargaCtx.getContext('2d').createLinearGradient(0, 0, 0, 160);
                        wargaGradient.addColorStop(0, 'rgba(20,184,166,0.2)');
                        wargaGradient.addColorStop(1, 'rgba(20,184,166,0.01)');
                        new Chart(wargaCtx, {
                            type: 'line',
                            data: {
                                labels: wargaLabels,
                                datasets: [{
                                    label: 'Warga Baru', data: wargaValues,
                                    borderColor: '#14b8a6', borderWidth: 2, pointRadius: 3, pointBackgroundColor: '#14b8a6',
                                    backgroundColor: wargaGradient, fill: true, tension: 0.4
                                }]
                            },
                            options: {
                                responsive: true, maintainAspectRatio: false,
                                animation: { duration: 1200, easing: 'easeOutQuart' },
                                plugins: { legend: { display: false }, tooltip: tooltipStyle },
                                scales: {
                                    y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 10, ...font }, color: '#94a3b8' }, grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false } },
                                    x: { ticks: { font: { size: 10, ...font }, color: '#94a3b8' }, grid: { display: false } }
                                }
                            }
                        });
                    }

                    // ── RT Distribution (Horizontal Bar) ──
                    const rtLabels = @json($rtLabels);
                    const rtValues = @json($rtValues);
                    const rtCtx = document.getElementById('rtChart');
                    if (rtCtx) {
                        new Chart(rtCtx, {
                            type: 'bar',
                            data: {
                                labels: rtLabels,
                                datasets: [{ data: rtValues, backgroundColor: 'rgba(20,184,166,0.6)', borderRadius: 4, borderSkipped: false }]
                            },
                            options: {
                                responsive: true, maintainAspectRatio: false, indexAxis: 'y',
                                animation: { duration: 1000, easing: 'easeOutQuart' },
                                plugins: { legend: { display: false }, tooltip: tooltipStyle },
                                scales: {
                                    x: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 9, ...font }, color: '#94a3b8' }, grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false } },
                                    y: { ticks: { font: { size: 9, ...font }, color: '#64748b' }, grid: { display: false } }
                                }
                            }
                        });
                    }

                    // ── RW Distribution (Horizontal Bar) ──
                    const rwLabels = @json($rwLabels);
                    const rwValues = @json($rwValues);
                    const rwCtx = document.getElementById('rwChart');
                    if (rwCtx) {
                        new Chart(rwCtx, {
                            type: 'bar',
                            data: {
                                labels: rwLabels,
                                datasets: [{ data: rwValues, backgroundColor: 'rgba(16,185,129,0.6)', borderRadius: 4, borderSkipped: false }]
                            },
                            options: {
                                responsive: true, maintainAspectRatio: false, indexAxis: 'y',
                                animation: { duration: 1000, easing: 'easeOutQuart' },
                                plugins: { legend: { display: false }, tooltip: tooltipStyle },
                                scales: {
                                    x: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 9, ...font }, color: '#94a3b8' }, grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false } },
                                    y: { ticks: { font: { size: 9, ...font }, color: '#64748b' }, grid: { display: false } }
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
