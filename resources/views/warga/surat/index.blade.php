<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pengajuan - {{ config('village.nama_desa', 'Prodesa') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config={theme:{extend:{colors:{brand:{50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b',950:'#022c22'},navy:{800:'#1e293b',900:'#0f172a',950:'#020617'}}}}}
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @include('components.favicon')
    @include('components.fonts')
    <style>
        :root{--brand-50:#ecfdf5;--brand-100:#d1fae5;--brand-200:#a7f3d0;--brand-300:#6ee7b7;--brand-400:#34d399;--brand-500:#10b981;--brand-600:#059669;--brand-700:#047857;--brand-800:#065f46;--brand-900:#064e3b;--teal-500:#14b8a6;--teal-600:#0d9488;--cyan-500:#06b6d4;--cyan-600:#0891b2;--navy-800:#1e293b;--navy-900:#0f172a;--shadow-soft:0 4px 24px -4px rgba(0,0,0,.08);--shadow-elevated:0 20px 60px rgba(0,0,0,.12),0 4px 12px rgba(0,0,0,.06);--shadow-card:0 1px 3px rgba(0,0,0,.04),0 8px 24px rgba(0,0,0,.06);--shadow-hover:0 12px 40px rgba(0,0,0,.1),0 4px 12px rgba(0,0,0,.05);--gradient-brand:linear-gradient(135deg,#059669,#0891b2);--gradient-hero:linear-gradient(160deg,#0a1a12 0%,#0d2818 20%,#0f3423 40%,#0a3040 65%,#0c2d48 85%,#0f172a 100%);--gradient-dark-card:linear-gradient(145deg,#0f172a,#1e293b);--ease-out-expo:cubic-bezier(.16,1,.3,1)}
        [x-cloak]{display:none!important}*,*::before,*::after{box-sizing:border-box}
        @keyframes fadeInUp{from{opacity:0;transform:translateY(28px)}to{opacity:1;transform:translateY(0)}}
        @keyframes fadeIn{from{opacity:0}to{opacity:1}}
        @keyframes slideUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
        @keyframes scaleIn{from{opacity:0;transform:scale(.92)}to{opacity:1;transform:scale(1)}}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
        @keyframes orbFloat1{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(30px,-20px) scale(1.05)}50%{transform:translate(-10px,15px) scale(.95)}75%{transform:translate(-25px,-10px) scale(1.02)}}
        @keyframes orbFloat2{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(-20px,25px) scale(.97)}50%{transform:translate(15px,-15px) scale(1.03)}75%{transform:translate(20px,10px) scale(.98)}}
        @keyframes pulse{0%,100%{opacity:1}50%{opacity:.5}}
        @keyframes ringDraw{from{stroke-dashoffset:150.8}to{stroke-dashoffset:var(--ring-target)}}
        @keyframes successPop{0%{transform:scale(.9);opacity:0}50%{transform:scale(1.02)}100%{transform:scale(1);opacity:1}}
        @keyframes gentleBounce{0%,100%{transform:translateY(0)}50%{transform:translateY(-3px)}}
        @keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
        @keyframes dotPulse{0%,100%{opacity:.4}50%{opacity:1}}
        @keyframes progressPulse{0%,100%{box-shadow:0 0 0 0 rgba(16,185,129,.4)}50%{box-shadow:0 0 0 6px rgba(16,185,129,0)}}

        .a-fade-up{opacity:0;transform:translateY(28px);transition:all .7s var(--ease-out-expo)}.a-fade-up.v{opacity:1;transform:none}
        .a-fade-in{opacity:0;transition:opacity .7s ease}.a-fade-in.v{opacity:1}
        .a-scale{opacity:0;transform:scale(.92);transition:all .6s var(--ease-out-expo)}.a-scale.v{opacity:1;transform:none}
        .a-slide-l{opacity:0;transform:translateX(-20px);transition:all .6s var(--ease-out-expo)}.a-slide-l.v{opacity:1;transform:none}
        .a-slide-r{opacity:0;transform:translateX(20px);transition:all .6s var(--ease-out-expo)}.a-slide-r.v{opacity:1;transform:none}
        .d1{transition-delay:.05s}.d2{transition-delay:.1s}.d3{transition-delay:.15s}.d4{transition-delay:.2s}.d5{transition-delay:.25s}.d6{transition-delay:.3s}.d7{transition-delay:.35s}.d8{transition-delay:.4s}

        .glass{background:rgba(255,255,255,.06);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.1)}
        .glass-strong{background:rgba(255,255,255,.1);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.15)}
        .glass-dark{background:rgba(0,0,0,.2);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.08)}
        .glass-light{background:rgba(255,255,255,.82);backdrop-filter:blur(32px) saturate(200%);-webkit-backdrop-filter:blur(32px) saturate(200%);border:1px solid rgba(255,255,255,.5)}

        .interact{transition:all .3s var(--ease-out-expo);cursor:pointer}.interact:hover{transform:translateY(-2px)}.interact:active{transform:scale(.97);transition-duration:.1s}
        .btn-primary{position:relative;display:inline-flex;align-items:center;justify-content:center;gap:8px;background:var(--gradient-brand);color:white;font-weight:600;font-size:14px;padding:12px 24px;border-radius:16px;box-shadow:0 8px 24px rgba(5,150,105,.25);transition:all .3s var(--ease-out-expo);overflow:hidden}.btn-primary:hover{box-shadow:0 12px 32px rgba(5,150,105,.35);transform:translateY(-2px)}.btn-primary:active{transform:scale(.97);transition-duration:.1s}.btn-primary::after{content:'';position:absolute;inset:0;background:linear-gradient(rgba(255,255,255,.2),transparent);opacity:0;transition:opacity .3s}.btn-primary:hover::after{opacity:1}
        .btn-ghost{display:inline-flex;align-items:center;justify-content:center;gap:6px;background:rgba(0,0,0,.04);color:#475569;font-weight:600;font-size:13px;padding:10px 18px;border-radius:14px;transition:all .25s ease;border:1px solid transparent}.btn-ghost:hover{background:rgba(0,0,0,.07);color:#1e293b;transform:translateY(-1px)}.btn-ghost:active{transform:scale(.97);transition-duration:.1s}
        .btn-danger{display:inline-flex;align-items:center;justify-content:center;gap:6px;background:#fef2f2;color:#dc2626;font-weight:600;font-size:13px;padding:10px 18px;border-radius:14px;transition:all .25s ease;border:1px solid #fecaca}.btn-danger:hover{background:#fee2e2;transform:translateY(-1px)}.btn-danger:active{transform:scale(.97);transition-duration:.1s}
        .btn-amber{display:inline-flex;align-items:center;justify-content:center;gap:6px;background:#fffbeb;color:#d97706;font-weight:600;font-size:13px;padding:10px 18px;border-radius:14px;transition:all .25s ease;border:1px solid #fde68a}.btn-amber:hover{background:#fef3c7;transform:translateY(-1px)}.btn-amber:active{transform:scale(.97);transition-duration:.1s}

        .bento-card{border-radius:20px;background:white;box-shadow:var(--shadow-card);transition:all .4s var(--ease-out-expo);overflow:hidden}.bento-card:hover{box-shadow:var(--shadow-hover);transform:translateY(-3px)}

        .filter-chip{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:12px;font-size:13px;font-weight:600;transition:all .3s var(--ease-out-expo);cursor:pointer;border:1.5px solid transparent;background:rgba(0,0,0,.03);color:#64748b;white-space:nowrap}.filter-chip:hover{background:rgba(0,0,0,.06);color:#334155}.filter-chip.active{background:var(--brand-500);color:white;border-color:var(--brand-500);box-shadow:0 4px 12px rgba(16,185,129,.25)}

        .step-dot{width:12px;height:12px;border-radius:50%;border:2px solid #d1d5db;background:white;transition:all .4s var(--ease-out-expo);position:relative;z-index:1;flex-shrink:0}
        .step-dot.done{border-color:var(--brand-500);background:var(--brand-500)}
        .step-dot.active{border-color:var(--brand-500);background:white;animation:progressPulse 2s ease-in-out infinite}
        .step-dot.rejected{border-color:#ef4444;background:#ef4444}
        .step-dot.revision{border-color:#f59e0b;background:#f59e0b}
        .step-line{height:2px;flex:1;border-radius:1px;background:#e5e7eb;transition:background .6s var(--ease-out-expo)}
        .step-line.done{background:var(--brand-500)}
        .step-line.partial{background:linear-gradient(90deg,var(--brand-500),#e5e7eb)}

        .activity-card{border-radius:20px;background:white;box-shadow:var(--shadow-card);transition:all .4s var(--ease-out-expo);overflow:hidden;border:1px solid rgba(0,0,0,.04)}.activity-card:hover{box-shadow:var(--shadow-hover);transform:translateY(-2px)}

        .timeline-item{position:relative;padding-left:28px;padding-bottom:20px}.timeline-item::before{content:'';position:absolute;left:5px;top:22px;bottom:0;width:2px;background:linear-gradient(to bottom,#e2e8f0,transparent)}.timeline-item:last-child::before{display:none}.timeline-item::after{content:'';position:absolute;left:0;top:5px;width:12px;height:12px;border-radius:50%;border:2.5px solid;background:white}.timeline-item.t-submitted::after{border-color:#3b82f6}.timeline-item.t-verified::after{border-color:#6366f1}.timeline-item.t-approved_operator::after{border-color:#06b6d4}.timeline-item.t-approved_sekdes::after{border-color:#8b5cf6}.timeline-item.t-approved_kades::after{border-color:var(--brand-500)}.timeline-item.t-completed::after{border-color:var(--brand-500);background:var(--brand-500)}.timeline-item.t-rejected::after{border-color:#ef4444}.timeline-item.t-revision::after{border-color:#f59e0b}

        .chat-bubble{max-width:82%;padding:12px 16px;border-radius:18px;font-size:14px;line-height:1.5;animation:slideUp .3s ease}.chat-user{background:var(--gradient-brand);color:white;border-bottom-right-radius:4px}.chat-bot{background:#f1f5f9;color:#334155;border-bottom-left-radius:4px}.typing-dot{width:6px;height:6px;border-radius:50%;background:#94a3b8;animation:dotPulse 1.4s ease-in-out infinite}.typing-dot:nth-child(2){animation-delay:.2s}.typing-dot:nth-child(3){animation-delay:.4s}

        .scroll-progress{position:fixed;top:0;left:0;height:3px;background:var(--gradient-brand);z-index:9999;transition:width .1s linear}

        ::-webkit-scrollbar{width:6px;height:6px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:3px}::-webkit-scrollbar-thumb:hover{background:#94a3b8}

        @media(max-width:768px){
            .hero-stats{grid-template-columns:repeat(2,1fr);gap:10px}
            .filter-scroll{overflow-x:auto;flex-wrap:nowrap;-webkit-overflow-scrolling:touch;scrollbar-width:none}
            .filter-scroll::-webkit-scrollbar{display:none}
        }
    </style>
    @include('components.design-tokens')
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="riwayat()">
    <div class="scroll-progress" id="scrollProgress" style="width:0%"></div>

    {{-- FLOATING NAV --}}
    <nav class="fixed top-3 left-1/2 -translate-x-1/2 z-40 a-fade-up" x-data="{ scrolled:false }" x-init="window.addEventListener('scroll',()=>{scrolled=window.scrollY>20})">
        <div :class="scrolled ? 'glass-light shadow-lg' : 'bg-white/70 backdrop-blur-md'" class="rounded-2xl px-3 py-2 flex items-center gap-2.5 transition-all duration-500 border border-white/40">
            <a href="{{ route('warga.dashboard') }}" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-brand-50 flex items-center justify-center transition-colors group">
                <svg class="w-4 h-4 text-slate-400 group-hover:text-brand-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div class="w-px h-5 bg-slate-200"></div>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <span class="text-sm font-bold text-slate-800 hidden sm:block">Riwayat Pengajuan</span>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <div class="relative overflow-hidden" style="background:var(--gradient-hero)">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-brand-500/8 rounded-full blur-3xl" style="animation:orbFloat1 20s ease-in-out infinite"></div>
            <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-cyan-500/8 rounded-full blur-3xl" style="animation:orbFloat2 25s ease-in-out infinite"></div>
            <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(255,255,255,.03) 1px,transparent 1px);background-size:24px 24px"></div>
        </div>
        <div class="relative max-w-5xl mx-auto px-4 pt-24 pb-8 md:pt-28 md:pb-10">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                <div class="a-fade-up">
                    <p class="text-brand-300/80 text-sm font-medium mb-1" x-text="greeting"></p>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Riwayat Pengajuan <span class="text-brand-400">Surat</span></h1>
                    <div class="flex items-center gap-3 mt-2">
                        <div class="flex items-center gap-1.5 text-white/50 text-xs">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span x-text="currentDate"></span>
                        </div>
                        <div class="w-1 h-1 rounded-full bg-white/30"></div>
                        <div class="flex items-center gap-1.5 text-white/50 text-xs">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span x-text="currentTime"></span>
                        </div>
                    </div>
                </div>
                <div class="a-fade-up d2">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="btn-primary text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Ajukan Surat Baru
                        </button>
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 -translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-[0_20px_60px_rgba(0,0,0,.15)] border border-slate-100 z-20 max-h-80 overflow-y-auto">
                            <div class="p-2">
                                @foreach ($letterConfigs as $lc)
                                    <a href="{{ route('warga.surat.create', $lc->jenis_surat) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-brand-50 transition group">
                                        <div class="w-8 h-8 rounded-lg bg-brand-50 group-hover:bg-brand-100 flex items-center justify-center transition">
                                            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <span class="text-sm font-semibold text-slate-700 group-hover:text-brand-700 transition">{{ $lc->label }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- HERO STATS --}}
            @php
                $total = $pengajuan->count();
                $aktif = $pengajuan->filter(fn($p) => in_array($p->status, ['submitted','verified','approved_operator','approved_sekdes','approved_kades']))->count();
                $selesai = $pengajuan->filter(fn($p) => $p->status === 'completed')->count();
                $revisi = $pengajuan->filter(fn($p) => $p->status === 'revision')->count();
            @endphp
            <div class="hero-stats grid grid-cols-4 gap-3 mt-6 a-fade-up d3">
                <div class="glass rounded-2xl p-3 md:p-4 text-center">
                    <div class="text-xl md:text-2xl font-extrabold text-white counter" data-target="{{ $total }}">0</div>
                    <div class="text-[10px] md:text-xs text-white/50 font-medium mt-0.5">Total</div>
                </div>
                <div class="glass rounded-2xl p-3 md:p-4 text-center">
                    <div class="text-xl md:text-2xl font-extrabold text-brand-400 counter" data-target="{{ $aktif }}">0</div>
                    <div class="text-[10px] md:text-xs text-white/50 font-medium mt-0.5">Aktif</div>
                </div>
                <div class="glass rounded-2xl p-3 md:p-4 text-center">
                    <div class="text-xl md:text-2xl font-extrabold text-emerald-300 counter" data-target="{{ $selesai }}">0</div>
                    <div class="text-[10px] md:text-xs text-white/50 font-medium mt-0.5">Selesai</div>
                </div>
                <div class="glass rounded-2xl p-3 md:p-4 text-center">
                    <div class="text-xl md:text-2xl font-extrabold text-amber-300 counter" data-target="{{ $revisi }}">0</div>
                    <div class="text-[10px] md:text-xs text-white/50 font-medium mt-0.5">Revisi</div>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <main class="max-w-5xl mx-auto px-4 -mt-4 relative z-10 pb-28 md:pb-16">

        {{-- FLASH MESSAGE --}}
        @if (session('success'))
            <div class="rounded-2xl p-4 mb-5 flex items-center gap-3 border border-green-200/60 bg-green-50/80 backdrop-blur-sm a-scale" style="animation:successPop .5s var(--ease-out-expo)">
                <div class="w-9 h-9 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-sm font-semibold text-green-800">{{ session('success') }}</span>
            </div>
        @endif

        {{-- FILTER BAR --}}
        <div class="glass-light rounded-2xl p-3 mb-6 shadow-lg a-fade-up d4 sticky top-16 z-30">
            <div class="flex flex-col md:flex-row md:items-center gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input x-model="search" type="text" placeholder="Cari surat..." class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 outline-none transition">
                </div>
                <div class="filter-scroll flex items-center gap-2">
                    <template x-for="f in filters" :key="f.key">
                        <button @click="activeFilter = f.key" :class="activeFilter === f.key ? 'active' : ''" class="filter-chip">
                            <span x-text="f.label"></span>
                            <span x-show="f.key !== 'all'" class="text-[10px] px-1.5 py-0.5 rounded-full" :class="activeFilter === f.key ? 'bg-white/20' : 'bg-slate-100'" x-text="getCount(f.key)"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        @if ($pengajuan->isEmpty())
            {{-- EMPTY STATE --}}
            <div class="rounded-3xl p-12 text-center border-2 border-dashed border-slate-200 bg-white/50 a-fade-up d5">
                <div class="w-20 h-20 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-5">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-700">Belum Ada Pengajuan</h3>
                <p class="text-sm text-slate-400 mt-1 max-w-xs mx-auto">Mulai ajukan surat pertama Anda dari tombol di atas</p>
                <a href="{{ route('warga.surat.create', $letterConfigs->first()->jenis_surat ?? 'sktm') }}" class="btn-primary mt-6 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Ajukan Sekarang
                </a>
            </div>
        @else
            {{-- REVISION ALERTS --}}
            @php $revisiItems = $pengajuan->filter(fn($p) => $p->status === 'revision'); @endphp
            @if ($revisiItems->isNotEmpty())
                <div class="rounded-2xl p-4 mb-5 border border-amber-200/60 bg-gradient-to-r from-amber-50/80 to-orange-50/60 backdrop-blur-sm a-fade-up d5" style="animation:successPop .5s var(--ease-out-expo)">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-amber-800">Perlu Perbaikan</h3>
                            <p class="text-xs text-amber-600">{{ $revisiItems->count() }} pengajuan perlu diperbaiki</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        @foreach ($revisiItems as $rev)
                            <div class="flex items-center justify-between bg-white/70 rounded-xl px-4 py-3 border border-amber-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ str_replace('_', ' ', $rev->jenis_surat) }}</p>
                                        @if ($rev->catatan_admin)
                                            <p class="text-xs text-amber-600 mt-0.5 line-clamp-1">{{ $rev->catatan_admin }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('warga.surat.edit', $rev) }}" class="btn-amber text-xs px-3 py-1.5 rounded-xl interact">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Perbaiki
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- FILTER RESULTS INFO --}}
            <div x-show="search || activeFilter !== 'all'" x-cloak class="flex items-center justify-between mb-4 px-1">
                <p class="text-sm text-slate-500">
                    Menampilkan <span class="font-bold text-slate-800" x-text="filteredItems().length"></span> dari {{ $pengajuan->count() }} pengajuan
                </p>
                <button @click="search='';activeFilter='all'" class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition">Reset Filter</button>
            </div>

            {{-- ALL SUBMISSIONS --}}
            <div class="space-y-4 a-fade-up d5">
                @foreach ($pengajuan as $item)
                    @php
                        $statusSteps = ['submitted'=>1,'verified'=>2,'approved_operator'=>3,'approved_sekdes'=>4,'approved_kades'=>5,'completed'=>6];
                        $currentStep = $statusSteps[$item->status] ?? 0;
                        $isRevision = $item->status === 'revision';
                        $isRejected = $item->status === 'rejected';
                        $isCompleted = $item->status === 'completed';
                        $progress = $currentStep > 0 ? round(($currentStep / 6) * 100) : 0;
                    @endphp
                    <div class="activity-card"
                         x-show="matchesFilter('{{ $item->status }}', '{{ $item->jenis_surat }}', '{{ addslashes($item->status_label ?? '') }}')"
                         x-data="{ expanded: false }"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">

                        {{-- CARD HEADER --}}
                        <div class="p-4 md:p-5 cursor-pointer" @click="expanded = !expanded">
                            <div class="flex items-start gap-3.5">
                                <div class="w-11 h-11 rounded-2xl flex items-center justify-center flex-shrink-0
                                    {{ ($isCompleted ? 'bg-gradient-to-br from-brand-400 to-brand-600 shadow-lg shadow-brand-500/20' : ($isRevision ? 'bg-gradient-to-br from-amber-400 to-orange-500 shadow-lg shadow-amber-500/20' : ($isRejected ? 'bg-gradient-to-br from-red-400 to-red-600 shadow-lg shadow-red-500/20' : 'bg-gradient-to-br from-slate-100 to-slate-200'))) }}">
                                    <svg class="w-5 h-5 {{ ($isCompleted || $isRevision || $isRejected) ? 'text-white' : 'text-slate-500' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        @if ($isCompleted)
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        @elseif ($isRevision)
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        @elseif ($isRejected)
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        @endif
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <h3 class="text-sm font-bold text-slate-800 capitalize">{{ str_replace('_', ' ', $item->jenis_surat) }}</h3>
                                            <p class="text-xs text-slate-400 mt-0.5">{{ $item->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</p>
                                        </div>
                                        <div class="flex items-center gap-2 flex-shrink-0">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold
                                                {{ match($item->status) {
                                                    'submitted' => 'bg-blue-50 text-blue-700 border border-blue-200/60',
                                                    'verified' => 'bg-indigo-50 text-indigo-700 border border-indigo-200/60',
                                                    'approved_operator' => 'bg-cyan-50 text-cyan-700 border border-cyan-200/60',
                                                    'approved_sekdes' => 'bg-purple-50 text-purple-700 border border-purple-200/60',
                                                    'approved_kades' => 'bg-brand-50 text-brand-700 border border-brand-200/60',
                                                    'completed' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/60',
                                                    'revision' => 'bg-amber-50 text-amber-700 border border-amber-200/60',
                                                    'rejected' => 'bg-red-50 text-red-600 border border-red-200/60',
                                                    default => 'bg-slate-50 text-slate-600 border border-slate-200/60',
                                                } }}">
                                                {{ $item->status_label }}
                                            </span>
                                            <svg class="w-4 h-4 text-slate-400 transition-transform duration-300" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </div>

                                    {{-- PROGRESS STEPPER --}}
                                    @if (!$isRejected)
                                        <div class="mt-3 flex items-center gap-0">
                                            @php $stepLabels = ['Diajukan','Verifikasi','Operator','Sekdes','Kades','Selesai']; @endphp
                                            @foreach ($stepLabels as $si => $sl)
                                                @php
                                                    $stepNum = $si + 1;
                                                    $isDone = $currentStep >= $stepNum && !$isRevision;
                                                    $isActive = $isRevision && $stepNum === 3;
                                                    $isCurrent = !$isRevision && !$isRejected && $currentStep === $stepNum;
                                                @endphp
                                                <div class="step-dot {{ $isDone ? 'done' : '' }} {{ $isActive ? 'revision' : '' }} {{ $isCurrent ? 'active' : '' }}" title="{{ $sl }}"></div>
                                                @if (!$loop->last)
                                                    <div class="step-line {{ $isDone ? 'done' : '' }} {{ $isActive ? 'partial' : '' }}"></div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="hidden md:flex items-center justify-between mt-1 px-0">
                                            @foreach ($stepLabels as $si => $sl)
                                                <span class="text-[9px] {{ ($si + 1) <= $currentStep && !$isRevision ? 'text-brand-600 font-bold' : 'text-slate-400' }} text-center" style="width:{{ 100/6 }}%">{{ $sl }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="mt-3 flex items-center gap-2">
                                            <div class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </div>
                                            <span class="text-xs text-red-600 font-semibold">Ditolak</span>
                                        </div>
                                    @endif

                                    {{-- CATATAN ADMIN --}}
                                    @if ($item->catatan_admin && !$isCompleted)
                                        <div class="mt-2.5 rounded-xl px-3 py-2 border text-xs
                                            {{ $isRevision ? 'bg-amber-50/60 border-amber-200/40 text-amber-700' : 'bg-slate-50 border-slate-100 text-slate-600' }}">
                                            <span class="font-bold">Catatan:</span> {{ $item->catatan_admin }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- EXPANDED DETAIL --}}
                        <div x-show="expanded" x-collapse x-cloak class="border-t border-slate-100">
                            <div class="p-4 md:p-5 space-y-4">
                                {{-- APPROVAL TIMELINE --}}
                                @if ($item->approvalHistories->isNotEmpty())
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Riwayat Approval
                                        </h4>
                                        <div class="space-y-0">
                                            @foreach ($item->approvalHistories->sortByDesc('created_at') as $history)
                                                <div class="timeline-item t-{{ $history->status }}">
                                                    <div class="text-xs font-bold text-slate-700 capitalize">{{ str_replace('_', ' ', $history->status) }}</div>
                                                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $history->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</div>
                                                    @if ($history->user)
                                                        <div class="text-[11px] text-slate-500 mt-0.5">oleh {{ $history->user->name }}</div>
                                                    @endif
                                                    @if ($history->catatan)
                                                        <div class="text-[11px] text-slate-600 mt-1 bg-slate-50 rounded-lg px-2.5 py-1.5 border border-slate-100">{{ $history->catatan }}</div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- ACTIONS --}}
                                <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-slate-100">
                                    <a href="{{ route('warga.surat.show', $item) }}" class="btn-ghost text-xs interact">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat Detail
                                    </a>
                                    @if ($item->status === 'revision')
                                        <a href="{{ route('warga.surat.edit', $item) }}" class="btn-amber text-xs interact">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Perbaiki
                                        </a>
                                    @endif
                                    @if ($item->status === 'completed')
                                        <a href="{{ route('warga.surat.cetak', $item) }}" target="_blank" class="btn-primary text-xs interact" style="padding:8px 14px;border-radius:12px;font-size:12px">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            Unduh PDF
                                        </a>
                                        @if (!empty($item->qr_verifikasi_svg))
                                            <button @click="$dispatch('show-qr', {svg: '{{ base64_encode($item->qr_verifikasi_svg) }}'})" class="btn-ghost text-xs interact">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                                QR
                                            </button>
                                        @endif
                                    @endif
                                    @if ($item->status === 'submitted')
                                        <form method="POST" action="{{ route('warga.surat.destroy', $item) }}" onsubmit="return confirm('Batalkan pengajuan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-danger text-xs interact">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- NO RESULTS --}}
            <div x-show="filteredItems().length === 0 && (search || activeFilter !== 'all')" x-cloak class="rounded-3xl p-10 text-center border-2 border-dashed border-slate-200 bg-white/50 mt-4">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <p class="text-sm font-semibold text-slate-600">Tidak Ditemukan</p>
                <p class="text-xs text-slate-400 mt-1">Coba kata kunci atau filter lain</p>
                <button @click="search='';activeFilter='all'" class="mt-4 text-xs font-semibold text-brand-600 hover:text-brand-700 transition">Reset Filter</button>
            </div>
        @endif
    </main>

    {{-- QR MODAL --}}
    <div x-data="{ showQr:false, qrSvg:'' }" @show-qr.window="qrSvg=$event.detail.svg;showQr=true">
        <template x-teleport="body">
            <div x-show="showQr" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showQr=false"></div>
                <div class="relative bg-white rounded-3xl shadow-2xl p-6 w-80 text-center" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center mx-auto mb-3 shadow-lg shadow-brand-500/20"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></div>
                    <h3 class="font-bold text-slate-900">QR Verifikasi</h3><p class="text-xs text-slate-400 mt-1">Scan untuk verifikasi keaslian surat</p>
                    <div class="mt-4 flex justify-center"><img :src="'data:image/svg+xml;base64,'+qrSvg" alt="QR" class="w-40 h-40"></div>
                    <button @click="showQr=false" class="mt-4 w-full text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 px-4 py-2.5 rounded-2xl transition">Tutup</button>
                </div>
            </div>
        </template>
    </div>

    {{-- AI ASSISTANT --}}
    <div class="fixed bottom-20 md:bottom-6 right-4 md:right-6 z-40" x-data="aiChat()" x-cloak>
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90 translate-y-4" class="absolute bottom-16 right-0 w-[340px] sm:w-[360px] bg-white rounded-3xl shadow-[0_20px_60px_rgba(0,0,0,.15),0_4px_12px_rgba(0,0,0,.05)] border border-slate-200/60 overflow-hidden mb-2">
            <div class="p-4 text-white relative overflow-hidden" style="background:linear-gradient(135deg,#059669,#10b981,#0891b2)">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="flex items-center gap-3 relative">
                    <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg></div>
                    <div class="flex-1"><h4 class="text-sm font-bold">Asisten Prodesa</h4><p class="text-[10px] text-brand-100/70">AI-powered &middot; Selalu online</p></div>
                    <button @click="open=false" class="w-7 h-7 rounded-lg bg-white/20 hover:bg-white/30 flex items-center justify-center transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
            </div>
            <div class="h-72 overflow-y-auto p-4 space-y-3" x-ref="chatBox">
                <template x-for="(msg,i) in messages" :key="i"><div :class="msg.isUser?'flex justify-end':'flex justify-start'"><div :class="msg.isUser?'chat-bubble chat-user':'chat-bubble chat-bot'" x-html="msg.text"></div></div></template>
                <div x-show="typing" class="flex justify-start"><div class="chat-bubble chat-bot flex items-center gap-1.5 py-3"><div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div></div></div>
            </div>
            <div class="px-4 pb-2 flex gap-1.5 overflow-x-auto" x-show="messages.length<=1"><template x-for="p in prompts" :key="p"><button @click="send(p)" class="shrink-0 text-[11px] font-medium text-brand-600 bg-brand-50 hover:bg-brand-100 px-3 py-1.5 rounded-full transition border border-brand-100" x-text="p"></button></template></div>
            <div class="p-3 border-t border-slate-100">
                <form @submit.prevent="send(input)" class="flex items-center gap-2">
                    <input x-model="input" type="text" placeholder="Ketik pertanyaan..." class="flex-1 text-sm border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 outline-none transition">
                    <button type="submit" class="w-10 h-10 rounded-full bg-[#0068BD] text-white flex items-center justify-center shadow-md shadow-blue-500/20 hover:bg-[#0070CC] transition-all disabled:opacity-50" :disabled="!input.trim()||sending"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg></button>
                </form>
            </div>
        </div>
        <button @click="open=!open" class="w-14 h-14 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 text-white shadow-lg shadow-brand-500/30 hover:shadow-brand-500/40 flex items-center justify-center transition-all duration-300" style="animation:float 3s ease-in-out infinite">
            <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- MOBILE BOTTOM NAV --}}
    <div class="md:hidden fixed bottom-0 left-0 right-0 z-50">
        <div class="mx-3 mb-3 rounded-2xl bg-white/90 backdrop-blur-2xl shadow-[0_-2px_12px_rgba(0,0,0,.06),0_4px_24px_rgba(0,0,0,.08)] border border-white/60 px-2 py-2">
            <div class="grid grid-cols-5 gap-1">
                <a href="{{ route('warga.dashboard') }}" class="flex flex-col items-center gap-0.5 py-2 rounded-xl text-slate-400 hover:text-brand-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-[10px] font-semibold">Beranda</span>
                </a>
                <a href="{{ route('warga.surat.create', $letterConfigs->first()->jenis_surat ?? 'sktm') }}" class="flex flex-col items-center gap-0.5 py-2 rounded-xl text-slate-400 hover:text-brand-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span class="text-[10px] font-semibold">Surat</span>
                </a>
                <a href="{{ route('warga.surat.index') }}" class="flex flex-col items-center gap-0.5 py-2 rounded-xl text-brand-600 bg-brand-50/80">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span class="text-[10px] font-bold">Riwayat</span>
                </a>
                <a href="{{ route('home') }}#faq" class="flex flex-col items-center gap-0.5 py-2 rounded-xl text-slate-400 hover:text-brand-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-[10px] font-semibold">FAQ</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="flex flex-col items-center gap-0.5 py-2 rounded-xl text-slate-400 hover:text-red-500 transition">
                    @csrf<button type="submit" class="flex flex-col items-center gap-0.5"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg><span class="text-[10px] font-semibold">Keluar</span></button>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        function riwayat(){return{
            search:'',activeFilter:'all',
            greeting:'',currentTime:'',currentDate:'',
            filters:[
                {key:'all',label:'Semua'},
                {key:'active',label:'Aktif'},
                {key:'revision',label:'Perlu Perbaikan'},
                {key:'completed',label:'Selesai'},
                {key:'rejected',label:'Ditolak'}
            ],
            init(){
                this.updateTime();setInterval(()=>this.updateTime(),1000);
                window.addEventListener('scroll',()=>{const b=document.getElementById('scrollProgress');if(b){const h=document.documentElement.scrollHeight-window.innerHeight;b.style.width=(window.scrollY/h*100)+'%'}});
                this.initReveal();this.initCounters();
            },
            updateTime(){const n=new Date(),h=n.getHours();this.greeting=h<11?'Selamat Pagi ☀️':h<15?'Selamat Siang 🌤️':h<18?'Selamat Sore':'Selamat Malam 🌙';this.currentTime=n.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'});this.currentDate=n.toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'})},
            initReveal(){const o=new IntersectionObserver(e=>{e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('v');o.unobserve(x.target)}})},{threshold:.08,rootMargin:'0px 0px -30px 0px'});document.querySelectorAll('.a-fade-up,.a-fade-in,.a-slide-l,.a-slide-r,.a-scale').forEach(e=>o.observe(e))},
            initCounters(){const o=new IntersectionObserver(e=>{e.forEach(x=>{if(x.isIntersecting){const el=x.target,t=+el.dataset.target;if(!t)return;let c=0;const s=t/75;const ti=setInterval(()=>{c+=s;if(c>=t){c=t;clearInterval(ti)}el.textContent=Math.floor(c)},16);o.unobserve(el)}})},{threshold:.5});document.querySelectorAll('.counter').forEach(e=>o.observe(e))},
            matchesFilter(status,jenis,label){
                const q=this.search.toLowerCase();
                const jenisClean=jenis.replace(/_/g,' ');
                if(q&&!jenisClean.toLowerCase().includes(q)&&!label.toLowerCase().includes(q))return false;
                if(this.activeFilter==='active')return['submitted','verified','approved_operator','approved_sekdes','approved_kades'].includes(status);
                if(this.activeFilter!=='all'&&status!==this.activeFilter)return false;
                return true;
            },
            _items:@json($pengajuan->map(fn($p)=>['status'=>$p->status,'jenis'=>$p->jenis_surat,'label'=>$p->status_label ?? ''])),
            filteredItems(){return this._items.filter(i=>this.matchesFilter(i.status,i.jenis,i.label))},
            _allStatuses:@json($pengajuan->pluck('status')->toArray()),
            getCount(f){if(f==='active')return this._allStatuses.filter(s=>['submitted','verified','approved_operator','approved_sekdes','approved_kades'].includes(s)).length;return this._allStatuses.filter(s=>s===f).length}
        }}
        function aiChat(){return{
            open:false,input:'',sending:false,messages:[{text:'Halo! Saya Asisten Prodesa. Ada yang bisa saya bantu?',isUser:false}],prompts:['Cara ajukan surat','Syarat SKTM','Jam pelayanan','Cetak surat'],
            async send(t){const q=t||this.input.trim();if(!q)return;this.input='';this.messages.push({text:q,isUser:true});this.sending=true;this.$nextTick(()=>{this.$refs.chatBox.scrollTop=this.$refs.chatBox.scrollHeight});try{const r=await fetch('{{route("faq.ask")}}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{csrf_token()}}'},body:JSON.stringify({question:q})});const d=await r.json();this.messages.push({text:d.answer||'Maaf, saya tidak bisa menjawab.',isUser:false})}catch{this.messages.push({text:'Terjadi kesalahan. Coba lagi.',isUser:false})}this.sending=false;this.$nextTick(()=>{this.$refs.chatBox.scrollTop=this.$refs.chatBox.scrollHeight})}
        }}
    </script>
</body>
</html>