<!DOCTYPE html>
<html lang="id" class="overflow-x-clip">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Prodesa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',
                            400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',
                            800:'#065f46',900:'#064e3b',950:'#022c22'
                        },
                        navy: { 800:'#1e293b',900:'#0f172a',950:'#020617' }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @include('components.favicon')
    @include('components.fonts')
    <style>
        :root {
            --brand-50:#ecfdf5;--brand-100:#d1fae5;--brand-200:#a7f3d0;--brand-300:#6ee7b7;
            --brand-400:#34d399;--brand-500:#10b981;--brand-600:#059669;--brand-700:#047857;
            --brand-800:#065f46;--brand-900:#064e3b;
            --teal-500:#14b8a6;--teal-600:#0d9488;
            --cyan-500:#06b6d4;--cyan-600:#0891b2;
            --navy-800:#1e293b;--navy-900:#0f172a;
            --shadow-soft:0 4px 24px -4px rgba(0,0,0,.08);
            --shadow-elevated:0 20px 60px rgba(0,0,0,.12),0 4px 12px rgba(0,0,0,.06);
            --shadow-card:0 1px 3px rgba(0,0,0,.04),0 8px 24px rgba(0,0,0,.06);
            --shadow-hover:0 12px 40px rgba(0,0,0,.1),0 4px 12px rgba(0,0,0,.05);
            --gradient-brand:linear-gradient(135deg,#059669,#0891b2);
            --gradient-hero:linear-gradient(160deg,#0a1a12 0%,#0d2818 20%,#0f3423 40%,#0a3040 65%,#0c2d48 85%,#0f172a 100%);
            --gradient-dark-card:linear-gradient(145deg,#0f172a,#1e293b);
            --ease-out-expo:cubic-bezier(.16,1,.3,1);
        }
        [x-cloak]{display:none!important}
        *,*::before,*::after{box-sizing:border-box}

        @keyframes fadeInUp{from{opacity:0;transform:translateY(28px)}to{opacity:1;transform:translateY(0)}}
        @keyframes fadeIn{from{opacity:0}to{opacity:1}}
        @keyframes slideUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
        @keyframes scaleIn{from{opacity:0;transform:scale(.92)}to{opacity:1;transform:scale(1)}}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
        @keyframes typing{0%,60%{opacity:1}30%{opacity:0}}
        @keyframes orbFloat1{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(30px,-20px) scale(1.05)}50%{transform:translate(-10px,15px) scale(.95)}75%{transform:translate(-25px,-10px) scale(1.02)}}
        @keyframes orbFloat2{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(-20px,25px) scale(.97)}50%{transform:translate(15px,-15px) scale(1.03)}75%{transform:translate(20px,10px) scale(.98)}}
        @keyframes pulseGlow{0%,100%{box-shadow:0 0 20px rgba(16,185,129,.15)}50%{box-shadow:0 0 40px rgba(16,185,129,.25)}}
        @keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
        @keyframes ringDraw{from{stroke-dashoffset:150.8}to{stroke-dashoffset:var(--ring-target)}}
        @keyframes successPop{0%{transform:scale(.9);opacity:0}50%{transform:scale(1.02)}100%{transform:scale(1);opacity:1}}
        @keyframes gentleBounce{0%,100%{transform:translateY(0)}50%{transform:translateY(-3px)}}
        @keyframes floatSlow{0%,100%{transform:translateY(0) rotate(0deg)}50%{transform:translateY(-6px) rotate(1deg)}}

        .a-fade-up{opacity:0;transform:translateY(28px);transition:all .7s var(--ease-out-expo)}.a-fade-up.v{opacity:1;transform:none}
        .a-fade-in{opacity:0;transition:opacity .7s ease}.a-fade-in.v{opacity:1}
        .a-scale{opacity:0;transform:scale(.92);transition:all .6s var(--ease-out-expo)}.a-scale.v{opacity:1;transform:none}
        .a-slide-l{opacity:0;transform:translateX(-20px);transition:all .6s var(--ease-out-expo)}.a-slide-l.v{opacity:1;transform:none}
        .a-slide-r{opacity:0;transform:translateX(20px);transition:all .6s var(--ease-out-expo)}.a-slide-r.v{opacity:1;transform:none}
        .d1{transition-delay:.05s}.d2{transition-delay:.1s}.d3{transition-delay:.15s}.d4{transition-delay:.2s}.d5{transition-delay:.25s}.d6{transition-delay:.3s}.d7{transition-delay:.35s}.d8{transition-delay:.4s}.d9{transition-delay:.45s}.d10{transition-delay:.5s}

        .glass{background:rgba(255,255,255,.06);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.1)}
        .glass-strong{background:rgba(255,255,255,.1);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.15)}
        .glass-dark{background:rgba(0,0,0,.2);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.08)}
        .glass-light{background:rgba(255,255,255,.82);backdrop-filter:blur(32px) saturate(200%);-webkit-backdrop-filter:blur(32px) saturate(200%);border:1px solid rgba(255,255,255,.5)}

        .bento-card{border-radius:20px;background:white;box-shadow:var(--shadow-card);transition:all .4s var(--ease-out-expo);overflow:hidden}
        .bento-card:hover{box-shadow:var(--shadow-hover);transform:translateY(-3px)}

        .interact{transition:all .3s var(--ease-out-expo);cursor:pointer}
        .interact:hover{transform:translateY(-2px)}
        .interact:active{transform:scale(.97);transition-duration:.1s}

        .btn-primary{position:relative;display:inline-flex;align-items:center;justify-content:center;gap:8px;background:var(--gradient-brand);color:white;font-weight:600;font-size:14px;padding:12px 24px;border-radius:16px;box-shadow:0 8px 24px rgba(5,150,105,.25);transition:all .3s var(--ease-out-expo);overflow:hidden}
        .btn-primary:hover{box-shadow:0 12px 32px rgba(5,150,105,.35);transform:translateY(-2px)}
        .btn-primary:active{transform:scale(.97);transition-duration:.1s}
        .btn-primary::after{content:'';position:absolute;inset:0;background:linear-gradient(rgba(255,255,255,.2),transparent);opacity:0;transition:opacity .3s}
        .btn-primary:hover::after{opacity:1}

        .btn-ghost{display:inline-flex;align-items:center;justify-content:center;gap:6px;background:rgba(0,0,0,.04);color:#475569;font-weight:600;font-size:13px;padding:10px 18px;border-radius:14px;transition:all .25s ease;border:1px solid transparent}
        .btn-ghost:hover{background:rgba(0,0,0,.07);color:#1e293b;transform:translateY(-1px)}
        .btn-ghost:active{transform:scale(.97);transition-duration:.1s}

        .stat-ring{position:relative;width:52px;height:52px;flex-shrink:0}
        .stat-ring svg{transform:rotate(-90deg)}
        .stat-ring .ring-bg{fill:none;stroke:rgba(255,255,255,.08);stroke-width:3}
        .stat-ring .ring-fill{fill:none;stroke-width:3;stroke-linecap:round;stroke-dasharray:125.6;stroke-dashoffset:125.6;transition:stroke-dashoffset 1.5s var(--ease-out-expo)}
        .stat-ring .ring-icon{position:absolute;inset:0;display:flex;align-items:center;justify-content:center}

        .action-pill{display:flex;flex-direction:column;align-items:center;gap:8px;padding:16px 12px;border-radius:18px;background:white;box-shadow:0 1px 3px rgba(0,0,0,.04),0 4px 12px rgba(0,0,0,.02);transition:all .3s var(--ease-out-expo);cursor:pointer;border:1px solid rgba(0,0,0,.04)}
        .action-pill:hover{transform:translateY(-4px);box-shadow:0 8px 24px rgba(0,0,0,.08);border-color:rgba(0,0,0,.06)}
        .action-pill:active{transform:scale(.95);transition-duration:.1s}

        .queue-strip{position:relative;border-radius:24px;overflow:hidden;transition:all .4s var(--ease-out-expo)}
        .queue-strip:hover{transform:translateY(-2px);box-shadow:0 16px 48px rgba(0,0,0,.12)}

        .event-row{display:flex;border-radius:16px;background:white;box-shadow:0 1px 3px rgba(0,0,0,.03);transition:all .3s var(--ease-out-expo);overflow:hidden;border:1px solid rgba(0,0,0,.04)}
        .event-row:hover{box-shadow:0 8px 24px rgba(0,0,0,.06);transform:translateY(-2px)}

        .timeline-card{position:relative;padding-left:28px;padding-bottom:20px}
        .timeline-card::before{content:'';position:absolute;left:6px;top:22px;bottom:0;width:2px;background:linear-gradient(to bottom,#e2e8f0,transparent)}
        .timeline-card:last-child::before{display:none}
        .timeline-card::after{content:'';position:absolute;left:0;top:5px;width:14px;height:14px;border-radius:50%;border:2.5px solid;background:white}
        .timeline-card.t-submitted::after{border-color:#3b82f6}
        .timeline-card.t-verified::after{border-color:#6366f1}
        .timeline-card.t-approved_operator::after{border-color:#06b6d4}
        .timeline-card.t-approved_sekdes::after{border-color:#8b5cf6}
        .timeline-card.t-approved_kades::after{border-color:var(--brand-500)}
        .timeline-card.t-completed::after{border-color:var(--brand-500);background:var(--brand-500)}
        .timeline-card.t-rejected::after{border-color:#f43f5e}
        .timeline-card.t-revision::after{border-color:#f59e0b}

        .chat-bubble{max-width:82%;padding:12px 16px;border-radius:18px;font-size:14px;line-height:1.5;animation:slideUp .3s ease}
        .chat-user{background:var(--gradient-brand);color:white;border-bottom-right-radius:4px}
        .chat-bot{background:white;border:1px solid #e2e8f0;color:#334155;border-bottom-left-radius:4px}
        .typing-dot{width:6px;height:6px;border-radius:50%;background:#94a3b8;animation:typing 1.4s infinite}.typing-dot:nth-child(2){animation-delay:.2s}.typing-dot:nth-child(3){animation-delay:.4s}

        .hero-orb{position:absolute;border-radius:50%;filter:blur(80px);pointer-events:none}
        .id-card-shine{position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.06),transparent);transition:left .8s ease;pointer-events:none}
        .bento-card:hover .id-card-shine{left:100%}

        .progress-track{height:6px;border-radius:9999px;background:rgba(0,0,0,.06);overflow:hidden}
        .progress-fill{height:100%;border-radius:9999px;background:var(--gradient-brand);transition:width 1.5s var(--ease-out-expo)}

        .bottom-nav{padding-bottom:env(safe-area-inset-bottom)}
        ::-webkit-scrollbar{width:4px;height:4px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:9999px}
        .scroll-x-fade{mask-image:linear-gradient(to right,transparent 0,#000 12px,#000 calc(100% - 12px),transparent 100%);-webkit-mask-image:linear-gradient(to right,transparent 0,#000 12px,#000 calc(100% - 12px),transparent 100%)}
    </style>
    @include('components.design-tokens')
</head>
<body class="bg-[#f5f5f0] font-sans antialiased text-slate-700 overflow-x-clip" x-data="dashboard()" @open-letter-picker.window="showLetterPicker = true" @keydown.escape.window="showLetterPicker = false">

    @php
        $lm = [
            'sktm'=>['i'=>'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z','f'=>'#f43f5e','t'=>'#e11d48'],
            'ktp_sementara'=>['i'=>'M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0','f'=>'#3b82f6','t'=>'#2563eb'],
            'akta'=>['i'=>'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z','f'=>'#f59e0b','t'=>'#d97706'],
            'sku'=>['i'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4','f'=>'#10b981','t'=>'#059669'],
            'domisili'=>['i'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6','f'=>'#06b6d4','t'=>'#0891b2'],
            'skkb'=>['i'=>'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z','f'=>'#8b5cf6','t'=>'#7c3aed'],
            'belum_menikah'=>['i'=>'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z','f'=>'#ec4899','t'=>'#db2777'],
            'izin_keramaian'=>['i'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','f'=>'#14b8a6','t'=>'#0d9488'],
            'ahli_waris'=>['i'=>'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3','f'=>'#64748b','t'=>'#475569'],
            'kepemilikan_tanah'=>['i'=>'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7','f'=>'#eab308','t'=>'#ca8a04'],
            'pengantar_skck'=>['i'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','f'=>'#6366f1','t'=>'#4f46e5'],
            'penghasilan'=>['i'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z','f'=>'#22c55e','t'=>'#16a34a'],
            'janda_duda'=>['i'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z','f'=>'#a855f7','t'=>'#9333ea'],
            'pindah'=>['i'=>'M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2m4-10l3-3m0 0l3 3m-3-3v12','f'=>'#f97316','t'=>'#ea580c'],
        ];
        $df=['i'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z','f'=>'#64748b','t'=>'#475569'];
    @endphp

    {{-- Scroll Progress --}}
    <div class="fixed top-0 left-0 right-0 z-[60] h-[3px] bg-transparent">
        <div id="scrollProgress" class="h-full bg-gradient-to-r from-brand-400 via-teal-400 to-cyan-400 rounded-r-full transition-all duration-150" style="width:0%"></div>
    </div>

    <nav class="fixed top-0 left-0 right-0 z-50 px-4 sm:px-6 transition-all duration-500">
        <div class="max-w-6xl mx-auto py-3">
            <div class="flex items-center justify-between rounded-2xl px-4 md:px-5 transition-all duration-300" :class="scrolled ? 'bg-white/80 backdrop-blur-2xl shadow-[0_1px_3px_rgba(0,0,0,.04),0_8px_24px_rgba(0,0,0,.06)] py-3 border border-white/60' : 'py-3'">
                <a href="{{ route('warga.dashboard') }}" @click.prevent="window.scrollTo({top:0,behavior:'smooth'})" class="flex items-center gap-2.5 group">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center shadow-lg shadow-brand-500/25 group-hover:shadow-brand-500/40 transition-all duration-300 group-hover:scale-105">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <span class="text-base font-bold" :class="scrolled ? 'text-slate-800' : 'text-white'">Pro<span class="text-brand-300">desa</span></span>
                </a>
                <div class="flex items-center gap-1.5">
                    <a href="{{ route('warga.surat.index') }}" class="hidden sm:flex items-center gap-1.5 text-sm font-medium px-3 py-2 rounded-xl transition-all duration-200" :class="scrolled ? 'text-slate-600 hover:text-brand-600 hover:bg-brand-50' : 'text-white/80 hover:text-white hover:bg-white/10'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Riwayat
                    </a>
                    <button class="relative w-9 h-9 flex items-center justify-center rounded-xl transition-all duration-200" :class="scrolled ? 'text-slate-500 hover:bg-slate-100' : 'text-white/70 hover:bg-white/10'">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                        @if($revisi > 0)<span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 rounded-full text-[8px] text-white font-bold flex items-center justify-center animate-pulse">{{ $revisi }}</span>@endif
                    </button>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="w-8 h-8 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white text-[11px] font-bold shadow-md ring-2 ring-white/30 cursor-pointer hover:ring-white/50 transition-all">{{ auth()->user()->avatar_initials }}</button>
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 -translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-[0_20px_60px_rgba(0,0,0,.15)] border border-slate-100 z-50 overflow-hidden">
                            <div class="p-4 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white text-xs font-bold shadow-md">{{ auth()->user()->avatar_initials }}</div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                                        <p class="text-[11px] text-slate-400 font-mono">NIK {{ substr(auth()->user()->nik, 0, 4) }}****{{ substr(auth()->user()->nik, -4) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <a href="{{ route('warga.dashboard') }}" @click="open = false; window.scrollTo({top:0,behavior:'smooth'})" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-brand-50 transition group text-sm font-medium text-slate-600 hover:text-brand-700">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-brand-600 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    Dashboard
                                </a>
                                <a href="{{ route('warga.surat.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-brand-50 transition group text-sm font-medium text-slate-600 hover:text-brand-700">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-brand-600 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    Riwayat Pengajuan
                                </a>
                                <button type="button" @click="$dispatch('open-letter-picker')" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-brand-50 transition group text-sm font-medium text-slate-600 hover:text-brand-700 text-left">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-brand-600 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Ajukan Surat
                                </button>
                                <a href="{{ route('home') }}#faq" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-brand-50 transition group text-sm font-medium text-slate-600 hover:text-brand-700">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-brand-600 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    FAQ
                                </a>
                            </div>
                            <div class="p-2 border-t border-slate-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-red-50 transition group text-sm font-medium text-slate-600 hover:text-red-600">
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-red-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="relative overflow-hidden" style="background:var(--gradient-hero)">
        <div class="hero-orb w-[500px] h-[500px] bg-brand-500/20 top-[-200px] left-[-100px]" style="animation:orbFloat1 20s ease-in-out infinite"></div>
        <div class="hero-orb w-[400px] h-[400px] bg-teal-500/15 top-[-100px] right-[-150px]" style="animation:orbFloat2 25s ease-in-out infinite"></div>
        <div class="hero-orb w-[300px] h-[300px] bg-cyan-500/10 bottom-[-100px] left-[30%]" style="animation:orbFloat1 18s ease-in-out infinite 3s"></div>
        <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(255,255,255,.06) 1px,transparent 1px);background-size:24px 24px"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 pt-24 md:pt-28 pb-12 md:pb-16">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-5">
                <div class="a-fade-up">
                    <div class="inline-flex items-center gap-2 glass-dark rounded-full px-3.5 py-1.5 mb-3">
                        <span class="w-2 h-2 rounded-full bg-brand-400 animate-pulse"></span>
                        <span class="text-[11px] font-semibold text-brand-200/80" x-text="greeting"></span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-[40px] font-bold text-white leading-[1.1] tracking-tight">{{ auth()->user()->name }}</h1>
                    <p class="text-brand-100/40 text-sm mt-2 max-w-md leading-relaxed">{{ config('village.nama_desa', 'Desa') }} &middot; {{ config('village.nama_kecamatan', '') }}, {{ config('village.nama_kabupaten', '') }}</p>
                    <div class="flex items-center gap-2 mt-4">
                        <span class="glass-dark rounded-full px-3 py-1 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-400 animate-pulse"></span>
                            <span class="text-[10px] font-semibold text-brand-200/80">{{ $letterConfigs->count() }} Layanan Tersedia</span>
                        </span>
                        <span class="glass-dark rounded-full px-3 py-1 flex items-center gap-1.5">
                            <svg class="w-3 h-3 text-cyan-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-[10px] font-semibold text-brand-200/80">Online 24/7</span>
                        </span>
                    </div>
                </div>
                <div class="a-fade-up d2 flex gap-2.5">
                    <div class="glass-dark rounded-2xl px-4 py-2.5 text-center min-w-[68px]">
                        <div class="text-[9px] text-brand-300/50 uppercase tracking-[.15em] font-semibold">Jam</div>
                        <div class="text-lg font-bold text-white mt-0.5 tabular-nums" x-text="currentTime"></div>
                    </div>
                    <div class="glass-dark rounded-2xl px-4 py-2.5 text-center min-w-[68px]">
                        <div class="text-[9px] text-brand-300/50 uppercase tracking-[.15em] font-semibold">Tanggal</div>
                        <div class="text-sm font-bold text-white mt-1 leading-tight" x-text="currentDate"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 -mt-8 relative z-10 pb-24 md:pb-12">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 md:gap-5">

            {{-- ROW 1: ID CARD --}}
            <div class="md:col-span-7 a-fade-up" x-data="{ showQr: false }">
                <div class="bento-card p-5 md:p-6 h-full" style="animation:successPop .5s var(--ease-out-expo)">
                    <div class="id-card-shine"></div>
                    <div class="flex items-start gap-4">
                        <div @click="showQr = true" class="relative flex-shrink-0 cursor-pointer group">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-brand-400 via-brand-500 to-teal-500 flex items-center justify-center text-white text-lg font-bold shadow-lg shadow-brand-500/20 group-hover:shadow-brand-500/40 transition-all duration-300 group-hover:scale-105">{{ auth()->user()->avatar_initials }}</div>
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-brand-500 rounded-full border-2 border-white flex items-center justify-center">
                                <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h2 class="text-lg font-bold text-slate-900">{{ auth()->user()->name }}</h2>
                                <span class="inline-flex items-center gap-1 bg-brand-50 text-brand-700 text-[10px] font-bold px-2 py-0.5 rounded-full border border-brand-200/60">
                                    <span class="w-1 h-1 rounded-full bg-brand-500"></span> Aktif
                                </span>
                            </div>
                            <p class="text-sm text-slate-500 font-mono tracking-wide mt-0.5">NIK {{ substr(auth()->user()->nik, 0, 4) }}****{{ substr(auth()->user()->nik, -4) }}</p>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-xs text-slate-400">
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>RT {{ auth()->user()->rt ?? '-' }} / RW {{ auth()->user()->rw ?? '-' }}</span>
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>{{ \Carbon\Carbon::parse(auth()->user()->created_at)->locale('id')->translatedFormat('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @php
                        $fields = [auth()->user()->name, auth()->user()->nik, auth()->user()->rt, auth()->user()->rw, auth()->user()->no_hp, auth()->user()->email];
                        $filled = count(array_filter($fields, fn($f) => !empty($f)));
                        $pct = round(($filled / count($fields)) * 100);
                    @endphp
                    <div class="mt-4">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[11px] font-semibold text-slate-500">Kelengkapan Data</span>
                            <span class="text-[11px] font-bold text-brand-600">{{ $pct }}%</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill" style="width:{{ $pct }}%"></div>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button type="button" @click="$dispatch('open-letter-picker')" class="btn-primary flex-1 text-sm !py-2.5 !px-4 !rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Ajukan Surat
                        </button>
                        <a href="{{ route('warga.surat.index') }}" class="btn-ghost !px-3 !py-2.5 !rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </a>
                    </div>
                    <template x-teleport="body">
                        <div x-show="showQr" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showQr=false"></div>
                            <div class="relative bg-white rounded-3xl shadow-2xl p-6 w-80 text-center" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center mx-auto mb-3 shadow-lg shadow-brand-500/20"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                                <h3 class="font-bold text-slate-900">Identitas Digital</h3>
                                <p class="text-xs text-slate-400 mt-1">Tunjukkan ke petugas jika diperlukan</p>
                                <div class="mt-4 p-4 bg-slate-50 rounded-2xl"><p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p><p class="text-xs text-slate-500 font-mono mt-1">{{ auth()->user()->nik }}</p><p class="text-xs text-slate-400 mt-1">RT {{ auth()->user()->rt ?? '-' }} / RW {{ auth()->user()->rw ?? '-' }}</p></div>
                                <button @click="showQr=false" class="mt-4 w-full text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 px-4 py-2.5 rounded-2xl transition">Tutup</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            {{-- STATS --}}
            <div class="md:col-span-5 a-fade-up d1">
                <div class="rounded-3xl p-5 h-full" style="background:var(--gradient-dark-card);box-shadow:var(--shadow-elevated)">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1 h-4 rounded-full bg-gradient-to-b from-brand-400 to-brand-500"></div>
                        <h3 class="text-xs font-bold text-white/80 tracking-wide uppercase">Ringkasan</h3>
                    </div>
                    @php
                        $stats = [
                            ['label'=>'Total','value'=>$total,'color'=>'#94a3b8','icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            ['label'=>'Diproses','value'=>$pending,'color'=>'#fbbf24','icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ['label'=>'Selesai','value'=>$selesai,'color'=>'#34d399','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ['label'=>'Ditolak','value'=>$ditolak,'color'=>'#fb7185','icon'=>'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ];
                    @endphp
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($stats as $i => $s)
                        <div class="a-scale d{{ $i+2 }} rounded-2xl p-3 transition-all duration-300 hover:bg-white/[.06]" style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.05)">
                            <div class="stat-ring mb-2">
                                <svg width="52" height="52" viewBox="0 0 52 52">
                                    <circle class="ring-bg" cx="26" cy="26" r="20"/>
                                    <circle class="ring-fill" cx="26" cy="26" r="20" stroke="{{ $s['color'] }}" style="--ring-target:{{ $s['value'] > 0 ? max(125.6 - ($s['value'] / max($total, 1) * 125.6), 15) : 125.6 }}"/>
                                </svg>
                                <div class="ring-icon"><svg class="w-4 h-4" style="color:{{ $s['color'] }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/></svg></div>
                            </div>
                            <div class="text-xl font-bold counter text-white" data-target="{{ $s['value'] }}">0</div>
                            <div class="text-[10px] text-white/35 font-medium mt-0.5">{{ $s['label'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- ALERTS --}}
            @if (session('success'))
            <div class="md:col-span-12 a-fade-up">
                <div class="bg-brand-50 border border-brand-200 text-brand-700 px-5 py-3.5 rounded-2xl flex items-center gap-3 text-sm font-medium" style="animation:successPop .4s var(--ease-out-expo)" x-data="{show:true}" x-show="show" x-transition>
                    <svg class="w-5 h-5 text-brand-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="flex-1">{{ session('success') }}</span>
                    <button @click="show=false" class="text-brand-400 hover:text-brand-600 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
            </div>
            @endif

            @php $revisiList = $terbaru->filter(fn($item) => $item->status === 'revision'); @endphp
            @if ($revisiList->isNotEmpty())
            <div class="md:col-span-12 a-fade-up">
                <div class="relative overflow-hidden rounded-2xl p-4 md:p-5" style="background:linear-gradient(135deg,#fef3c7,#fde68a 40%,#fcd34d)">
                    <div class="absolute top-0 right-0 w-28 h-28 bg-amber-400/30 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="relative flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-white/60 backdrop-blur flex items-center justify-center flex-shrink-0 shadow-sm"><svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg></div>
                        <div class="flex-1">
                            <p class="font-bold text-amber-900 text-sm">{{ $revisiList->count() }} Pengajuan Perlu Diperbaiki</p>
                            <div class="mt-2 space-y-1.5">
                                @foreach ($revisiList as $item)
                                <div class="flex items-center justify-between bg-white/50 backdrop-blur-sm rounded-xl px-3 py-2 border border-amber-200/50">
                                    <div><p class="text-sm font-semibold text-amber-900 capitalize">{{ str_replace('_', ' ', $item->jenis_surat) }}</p><p class="text-[11px] text-amber-700/60">{{ $item->created_at->format('d M Y') }}</p></div>
                                    <a href="{{ route('warga.surat.edit', $item) }}" class="text-xs font-bold text-amber-800 bg-white/70 hover:bg-white px-3 py-1.5 rounded-lg transition interact">Perbaiki</a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            {{-- ROW 2: QUICK ACTIONS --}}
            <div class="md:col-span-12 a-fade-up d2">
                <div class="flex items-center gap-2 mb-3 px-1">
                    <div class="w-1 h-4 rounded-full bg-gradient-to-b from-brand-400 to-teal-400"></div>
                    <h3 class="text-xs font-bold text-slate-800 tracking-wide uppercase">Layanan Cepat</h3>
                </div>
                @php
                    $actions = [
                        ['label'=>'Ajukan Surat','picker'=>true,'icon'=>'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z','from'=>'#059669','to'=>'#10b981'],
                        ['label'=>'Riwayat','route'=>route('warga.surat.index'),'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','from'=>'#0891b2','to'=>'#06b6d4'],
                        ['label'=>'Undangan','route'=>'#undangan','icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','from'=>'#7c3aed','to'=>'#8b5cf6','badge'=>$undanganAktif->count()>0?$undanganAktif->count():null],
                        ['label'=>'FAQ','route'=>route('home').'#faq','icon'=>'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z','from'=>'#0d9488','to'=>'#14b8a6'],
                    ];
                @endphp
                <div class="grid grid-cols-4 gap-3">
                    @foreach($actions as $i => $a)
                    @if(isset($a['picker']))
                    <button type="button" @click="$dispatch('open-letter-picker')" class="action-pill a-scale d{{ $i+2 }}">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg transition-all duration-300" style="background:linear-gradient(135deg,{{ $a['from'] }},{{ $a['to'] }});box-shadow:0 6px 16px {{ $a['from'] }}30">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $a['icon'] }}"/></svg>
                            </div>
                            @if(isset($a['badge']))
                            <span class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 rounded-full text-[9px] text-white font-bold flex items-center justify-center shadow-sm animate-pulse">{{ $a['badge'] }}</span>
                            @endif
                        </div>
                        <span class="text-[11px] font-semibold text-slate-600 leading-tight text-center">{{ $a['label'] }}</span>
                    </button>
                    @else
                    <a href="{{ $a['route'] }}" class="action-pill a-scale d{{ $i+2 }}">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg transition-all duration-300" style="background:linear-gradient(135deg,{{ $a['from'] }},{{ $a['to'] }});box-shadow:0 6px 16px {{ $a['from'] }}30">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $a['icon'] }}"/></svg>
                            </div>
                            @if(isset($a['badge']))
                            <span class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 rounded-full text-[9px] text-white font-bold flex items-center justify-center shadow-sm animate-pulse">{{ $a['badge'] }}</span>
                            @endif
                        </div>
                        <span class="text-[11px] font-semibold text-slate-600 leading-tight text-center">{{ $a['label'] }}</span>
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>
            {{-- ROW 3: ANTREAN --}}
            @if ($antreanAktif->isNotEmpty())
            <div class="{{ $undanganAktif->isNotEmpty() ? 'md:col-span-7' : 'md:col-span-12' }} a-fade-up d3" x-data="{ showQrA:false, qrA:'' }">
                <div class="flex items-center gap-2 mb-3 px-1">
                    <div class="w-1 h-4 rounded-full bg-gradient-to-b from-brand-400 to-brand-500"></div>
                    <h3 class="text-xs font-bold text-slate-800 tracking-wide uppercase">Antrean Aktif</h3>
                    <span class="ml-auto inline-flex items-center gap-1 text-[10px] font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-full border border-brand-100"><span class="w-1.5 h-1.5 rounded-full bg-brand-500 animate-pulse"></span> Aktif</span>
                </div>
                @foreach ($antreanAktif as $item)
                @php $antrean = $item->antrean; @endphp
                <div class="queue-strip shadow-[0_12px_40px_rgba(0,0,0,.1)] mb-3" style="background:linear-gradient(145deg,#064e3b 0%,#047857 40%,#059669 100%)">
                    <div class="p-5 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-36 h-36 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                        <div class="absolute bottom-0 left-0 w-20 h-20 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                        <div class="flex items-center justify-between relative">
                            <div>
                                <p class="text-[10px] text-brand-200/60 uppercase tracking-[.15em] font-semibold">{{ str_replace('_', ' ', $item->jenis_surat) }}</p>
                                <div class="text-5xl font-black mt-1 tracking-tight" style="text-shadow:0 4px 20px rgba(0,0,0,.2)">{{ $antrean->nomor_antrean }}</div>
                            </div>
                            <button @click="qrA='{{ base64_encode($antrean->qr_svg) }}';showQrA=true" class="bg-white/15 hover:bg-white/25 backdrop-blur-sm rounded-2xl px-4 py-3 text-sm font-semibold transition-all flex items-center gap-2 border border-white/10 interact">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                QR
                            </button>
                        </div>
                        <div class="flex items-center gap-4 mt-4 pt-4 border-t border-white/10">
                            <div><div class="text-[9px] text-brand-200/50 uppercase tracking-wider font-semibold">Tanggal</div><div class="text-sm font-bold text-white mt-0.5">{{ \Carbon\Carbon::parse($antrean->tanggal_ambil)->locale('id')->translatedFormat('d M Y') }}</div></div>
                            <div class="w-px h-8 bg-white/10"></div>
                            <div><div class="text-[9px] text-brand-200/50 uppercase tracking-wider font-semibold">Jam</div><div class="text-sm font-bold text-white mt-0.5">{{ \Carbon\Carbon::parse($antrean->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($antrean->jam_selesai)->format('H:i') }}</div></div>
                        </div>
                    </div>
                </div>
                @endforeach
                <template x-teleport="body">
                    <div x-show="showQrA" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showQrA=false"></div>
                        <div class="relative bg-white rounded-3xl shadow-2xl p-6 w-80 text-center" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center mx-auto mb-3 shadow-lg shadow-brand-500/20"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg></div>
                            <h3 class="font-bold text-slate-900">QR Antrean</h3><p class="text-xs text-slate-400 mt-1">Tunjukkan ke petugas saat pengambilan</p>
                            <div class="mt-4 flex justify-center"><img :src="'data:image/svg+xml;base64,'+qrA" alt="QR" class="w-40 h-40"></div>
                            <button @click="showQrA=false" class="mt-4 w-full text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 px-4 py-2.5 rounded-2xl transition">Tutup</button>
                        </div>
                    </div>
                </template>
            </div>
            @endif
            {{-- ROW 3: UNDANGAN --}}
            @if ($undanganAktif->isNotEmpty())
            <div class="{{ $antreanAktif->isNotEmpty() ? 'md:col-span-5' : 'md:col-span-12' }} a-fade-up d4">
                <div class="flex items-center gap-2 mb-3 px-1">
                    <div class="w-1 h-4 rounded-full bg-gradient-to-b from-purple-400 to-purple-500"></div>
                    <h3 class="text-xs font-bold text-slate-800 tracking-wide uppercase">Undangan Kegiatan</h3>
                    <span class="ml-auto text-[10px] font-bold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full border border-purple-200/60">{{ $undanganAktif->count() }}</span>
                </div>
                <div id="undangan" class="space-y-2.5">
                    @foreach ($undanganAktif as $undangan)
                    @php $event = $undangan->event; $eventDate = \Carbon\Carbon::parse($event->tanggal); $daysLeft = max(0, (int)\Carbon\Carbon::now()->diffInDays($eventDate, false)); @endphp
                    <div class="event-row">
                        <div class="w-16 sm:w-20 flex-shrink-0 flex flex-col items-center justify-center text-white p-2 relative overflow-hidden" style="background:linear-gradient(160deg,#5b21b6,#7c3aed 40%,#a78bfa)">
                            <div class="text-[9px] font-semibold uppercase tracking-[.15em] opacity-70 relative">{{ $eventDate->locale('id')->translatedFormat('M') }}</div>
                            <div class="text-2xl font-black leading-none mt-0.5 relative" style="text-shadow:0 2px 8px rgba(0,0,0,.2)">{{ $eventDate->format('d') }}</div>
                            @if($daysLeft > 0)<div class="mt-1.5 bg-white/20 backdrop-blur-sm rounded-full px-2 py-0.5 text-[8px] font-bold relative">{{ $daysLeft }}h lagi</div>
                            @else<div class="mt-1.5 bg-white/20 backdrop-blur-sm rounded-full px-2 py-0.5 text-[8px] font-bold relative">Hari Ini</div>@endif
                        </div>
                        <div class="flex-1 p-3">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <h4 class="font-bold text-slate-900 text-sm truncate">{{ $event->judul }}</h4>
                                    <div class="flex flex-col gap-0.5 mt-1 text-xs text-slate-500">
                                        <span class="flex items-center gap-1"><svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }} WIB</span>
                                        @if ($event->tempat)<span class="flex items-center gap-1"><svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>{{ $event->tempat }}</span>@endif
                                    </div>
                                </div>
                                @if (is_null($undangan->konfirmasi))
                                <form method="POST" action="{{ route('warga.events.konfirmasi', $undangan) }}" class="flex gap-1 shrink-0">
                                    @csrf
                                    <button name="konfirmasi" value="hadir" class="w-8 h-8 rounded-lg bg-brand-500 hover:bg-brand-600 text-white flex items-center justify-center shadow-sm shadow-brand-500/20 transition-all interact" title="Hadir"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></button>
                                    <button name="konfirmasi" value="izin" class="w-8 h-8 rounded-lg bg-amber-500 hover:bg-amber-600 text-white flex items-center justify-center shadow-sm shadow-amber-500/20 transition-all interact" title="Izin"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg></button>
                                    <button name="konfirmasi" value="absen" class="w-8 h-8 rounded-lg bg-rose-500 hover:bg-rose-600 text-white flex items-center justify-center shadow-sm shadow-rose-500/20 transition-all interact" title="Absen"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
                                </form>
                                @else
                                <span class="shrink-0 inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-lg
                                    @if($undangan->konfirmasi==='hadir') bg-brand-50 text-brand-700 border border-brand-200/60
                                    @elseif($undangan->konfirmasi==='izin') bg-amber-50 text-amber-700 border border-amber-200/60
                                    @else bg-rose-50 text-rose-700 border border-rose-200/60 @endif">{{ ucfirst($undangan->konfirmasi) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            {{-- ROW 4: LAYANAN SURAT --}}
            <div class="md:col-span-12 a-fade-up d5">
                <div class="flex items-center gap-2 mb-3 px-1">
                    <div class="w-1 h-4 rounded-full bg-gradient-to-b from-brand-400 to-brand-500"></div>
                    <h3 class="text-xs font-bold text-slate-800 tracking-wide uppercase">Layanan Surat</h3>
                    <span class="ml-auto text-[10px] font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-full border border-brand-100">{{ $letterConfigs->count() }}</span>
                </div>
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-7 gap-2.5">
                    @foreach ($letterConfigs as $i => $lc)
                    @php $m = $lm[$lc->jenis_surat] ?? $df; @endphp
                    <a href="{{ route('warga.surat.create', $lc->jenis_surat) }}" class="a-scale d{{ ($i%8)+1 }} group relative overflow-hidden rounded-2xl p-3 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-xl border border-slate-100 bg-white" style="box-shadow:0 1px 3px rgba(0,0,0,.03)">
                        <div class="absolute top-0 right-0 w-14 h-14 rounded-full opacity-[0.07] -translate-y-1/3 translate-x-1/3 transition-opacity group-hover:opacity-[0.12]" style="background:linear-gradient(135deg,{{ $m['f'] }},{{ $m['t'] }})"></div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mx-auto mb-2 shadow-md transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg" style="background:linear-gradient(135deg,{{ $m['f'] }},{{ $m['t'] }});box-shadow:0 4px 12px {{ $m['f'] }}25">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $m['i'] }}"/></svg>
                        </div>
                        <span class="text-[10px] font-semibold text-slate-600 group-hover:text-slate-900 transition leading-tight block">{{ $lc->label }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            {{-- ROW 5: RIWAYAT --}}
            <div class="md:col-span-12 a-fade-up d6" x-data="{ qrS:'', showQrS:false }">
                <div class="flex items-center gap-2 mb-3 px-1">
                    <div class="w-1 h-4 rounded-full bg-gradient-to-b from-brand-400 to-brand-500"></div>
                    <h3 class="text-xs font-bold text-slate-800 tracking-wide uppercase">Riwayat Pengajuan</h3>
                    @if($terbaru->isNotEmpty())<a href="{{ route('warga.surat.index') }}" class="ml-auto text-[11px] font-semibold text-brand-600 hover:text-brand-700 transition">Lihat Semua &rarr;</a>@endif
                </div>
                @if ($terbaru->isNotEmpty())
                <div class="flex gap-3 overflow-x-auto pb-2 scroll-x-fade" style="-webkit-overflow-scrolling:touch">
                    @foreach ($terbaru as $i => $item)
                    @php
                        $tc = match($item->status) {
                            'submitted' => 't-submitted','verified' => 't-verified','approved_operator' => 't-approved_operator',
                            'approved_sekdes' => 't-approved_sekdes','approved_kades' => 't-approved_kades',
                            'completed' => 't-completed','rejected' => 't-rejected','revision' => 't-revision', default => 't-submitted',
                        };
                        $statusBadge = match($item->status) {
                            'submitted' => 'bg-blue-50 text-blue-700 border-blue-200/60',
                            'verified' => 'bg-indigo-50 text-indigo-700 border-indigo-200/60',
                            'approved_operator' => 'bg-cyan-50 text-cyan-700 border-cyan-200/60',
                            'approved_sekdes' => 'bg-violet-50 text-violet-700 border-violet-200/60',
                            'approved_kades' => 'bg-brand-50 text-brand-700 border-brand-200/60',
                            'completed' => 'bg-green-50 text-green-700 border-green-200/60',
                            'rejected' => 'bg-red-50 text-red-700 border-red-200/60',
                            'revision' => 'bg-amber-50 text-amber-700 border-amber-200/60',
                            default => 'bg-slate-50 text-slate-700 border-slate-200',
                        };
                    @endphp
                    <div class="flex-shrink-0 w-[280px] sm:w-[300px]">
                        <div class="bg-white rounded-2xl p-4 shadow-[0_1px_3px_rgba(0,0,0,.04)] border border-slate-100 hover:shadow-[0_6px_20px_rgba(0,0,0,.06)] transition-all duration-300 h-full flex flex-col">
                            <div class="flex items-center gap-2 flex-wrap mb-2">
                                <a href="{{ route('warga.surat.show', $item) }}" class="text-sm font-bold text-slate-900 hover:text-brand-600 transition capitalize">{{ str_replace('_', ' ', $item->jenis_surat) }}</a>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full border {{ $statusBadge }}">{{ $item->status_label }}</span>
                            </div>
                            <p class="text-[11px] text-slate-400 mb-3">{{ $item->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</p>
                            @if($item->catatan_admin)<p class="text-xs text-slate-500 mb-3 bg-slate-50 rounded-xl px-3 py-2 border border-slate-100 line-clamp-2">{{ $item->catatan_admin }}</p>@endif
                            <div class="flex items-center gap-1.5 mt-auto">
                                @if ($item->status === 'completed')
                                    <a href="{{ route('warga.surat.cetak', $item) }}" target="_blank" class="inline-flex items-center gap-1 bg-green-50 hover:bg-green-100 text-green-700 text-[11px] font-bold px-2.5 py-1.5 rounded-lg transition border border-green-200/60 interact"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg> Unduh</a>
                                    @if (!empty($item->qr_verifikasi_svg))
                                    <button @click="qrS='{{ base64_encode($item->qr_verifikasi_svg) }}';showQrS=true" class="inline-flex items-center gap-1 bg-brand-50 hover:bg-brand-100 text-brand-700 text-[11px] font-bold px-2.5 py-1.5 rounded-lg transition border border-brand-200/60 interact"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg> QR</button>
                                    @endif
                                @elseif ($item->status === 'submitted')
                                    <form method="POST" action="{{ route('warga.surat.destroy', $item) }}" onsubmit="return confirm('Batalkan?')">@csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 text-red-600 text-[11px] font-bold px-2.5 py-1.5 rounded-lg transition border border-red-200/60 interact"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg> Batal</button>
                                    </form>
                                @elseif ($item->status === 'revision')
                                    <a href="{{ route('warga.surat.edit', $item) }}" class="inline-flex items-center gap-1 bg-amber-50 hover:bg-amber-100 text-amber-700 text-[11px] font-bold px-2.5 py-1.5 rounded-lg transition border border-amber-200/60 interact"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> Perbaiki</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <template x-teleport="body">
                    <div x-show="showQrS" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showQrS=false"></div>
                        <div class="relative bg-white rounded-3xl shadow-2xl p-6 w-80 text-center" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center mx-auto mb-3 shadow-lg shadow-brand-500/20"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></div>
                            <h3 class="font-bold text-slate-900">QR Verifikasi</h3><p class="text-xs text-slate-400 mt-1">Scan untuk verifikasi keaslian surat</p>
                            <div class="mt-4 flex justify-center"><img :src="'data:image/svg+xml;base64,'+qrS" alt="QR" class="w-40 h-40"></div>
                            <button @click="showQrS=false" class="mt-4 w-full text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 px-4 py-2.5 rounded-2xl transition">Tutup</button>
                        </div>
                    </div>
                </template>
                @else
                <div class="rounded-3xl p-10 text-center border-2 border-dashed border-slate-200 bg-white/50">
                    <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4"><svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg></div>
                    <p class="text-sm font-semibold text-slate-600">Belum Ada Pengajuan</p>
                    <p class="text-xs text-slate-400 mt-1">Mulai ajukan surat dari layanan di atas</p>
                </div>
                @endif
            </div>
            {{-- ROW 6: INFO DESA --}}
            <div class="md:col-span-12 a-fade-up d7">
                <div class="rounded-2xl p-4 md:p-5" style="background:linear-gradient(135deg,var(--brand-50),#ecfdf5 50%,#f0f9ff)">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="a-slide-l flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white shadow-sm flex items-center justify-center flex-shrink-0 border border-brand-100"><svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                            <div><p class="text-xs font-bold text-slate-800">Jam Pelayanan</p><p class="text-[11px] text-slate-500 mt-0.5">Senin - Jumat, 08:00 - 15:00 WIB</p></div>
                        </div>
                        <div class="a-slide-r flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white shadow-sm flex items-center justify-center flex-shrink-0 border border-blue-100"><svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
                            <div><p class="text-xs font-bold text-slate-800">Kontak Desa</p><p class="text-[11px] text-slate-500 mt-0.5">{{ config('village.email_desa', '-') }}</p></div>
                        </div>
                        <div class="a-slide-r d2 flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white shadow-sm flex items-center justify-center flex-shrink-0 border border-purple-100"><svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                            <div><p class="text-xs font-bold text-slate-800">Kepala Desa</p><p class="text-[11px] text-slate-500 mt-0.5">{{ config('village.nama_kades', '-') }}</p></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- LETTER PICKER MODAL --}}
    <template x-teleport="body">
        <div x-show="showLetterPicker" x-cloak class="fixed inset-0 z-[70] flex items-center justify-center p-4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showLetterPicker = false"></div>
            <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                <div class="p-5 text-white relative overflow-hidden" style="background:var(--gradient-dark-card)">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-brand-500/20 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="flex items-start justify-between relative">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/25">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-white">Pilih Jenis Surat</h3>
                                <p class="text-xs text-white/50 mt-0.5">Pilih jenis surat yang ingin Anda ajukan</p>
                            </div>
                        </div>
                        <button @click="showLetterPicker = false" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                <div class="p-5 max-h-[60vh] overflow-y-auto">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach ($letterConfigs as $lc)
                        @php $m = $lm[$lc->jenis_surat] ?? $df; @endphp
                        <a href="{{ route('warga.surat.create', $lc->jenis_surat) }}" class="group relative overflow-hidden rounded-2xl p-4 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-xl border border-slate-100 bg-white" style="box-shadow:0 1px 3px rgba(0,0,0,.03)">
                            <div class="absolute top-0 right-0 w-14 h-14 rounded-full opacity-[0.07] -translate-y-1/3 translate-x-1/3 transition-opacity group-hover:opacity-[0.12]" style="background:linear-gradient(135deg,{{ $m['f'] }},{{ $m['t'] }})"></div>
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center mx-auto mb-2.5 shadow-md transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg" style="background:linear-gradient(135deg,{{ $m['f'] }},{{ $m['t'] }});box-shadow:0 4px 12px {{ $m['f'] }}25">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $m['i'] }}"/></svg>
                            </div>
                            <span class="text-[11px] font-semibold text-slate-700 group-hover:text-slate-900 transition leading-tight block">{{ $lc->label }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </template>
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
    <div class="md:hidden fixed bottom-0 left-0 right-0 z-50 bottom-nav">
        <div class="mx-3 mb-3 rounded-2xl bg-white/90 backdrop-blur-2xl shadow-[0_-2px_12px_rgba(0,0,0,.06),0_4px_24px_rgba(0,0,0,.08)] border border-white/60 px-2 py-2">
            <div class="grid grid-cols-5 gap-1">
                <a href="{{ route('warga.dashboard') }}" @click.prevent="window.scrollTo({top:0,behavior:'smooth'})" class="flex flex-col items-center gap-0.5 py-2 rounded-xl text-brand-600 bg-brand-50/80">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-[10px] font-bold">Beranda</span>
                </a>
                <button type="button" @click="$dispatch('open-letter-picker')" class="flex flex-col items-center gap-0.5 py-2 rounded-xl text-slate-400 hover:text-brand-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span class="text-[10px] font-semibold">Surat</span>
                </button>
                <a href="{{ route('warga.surat.index') }}" class="flex flex-col items-center gap-0.5 py-2 rounded-xl text-slate-400 hover:text-brand-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span class="text-[10px] font-semibold">Riwayat</span>
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
        function dashboard(){return{
            scrolled:false,greeting:'',currentTime:'',currentDate:'',currentDay:'',showLetterPicker:false,
            init(){this.updateTime();setInterval(()=>this.updateTime(),1000);window.addEventListener('scroll',()=>{this.scrolled=window.scrollY>20;const b=document.getElementById('scrollProgress');if(b){const h=document.documentElement.scrollHeight-window.innerHeight;b.style.width=(window.scrollY/h*100)+'%'}});this.initReveal();this.initCounters();this.initRings()},
            updateTime(){const n=new Date(),h=n.getHours();this.greeting=h<11?'Selamat Pagi':h<15?'Selamat Siang':h<18?'Selamat Sore':'Selamat Malam';this.currentTime=n.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'});this.currentDate=n.toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'});this.currentDay=n.toLocaleDateString('id-ID',{weekday:'long'})},
            initReveal(){const o=new IntersectionObserver(e=>{e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('v');o.unobserve(x.target)}})},{threshold:.08,rootMargin:'0px 0px -30px 0px'});document.querySelectorAll('.a-fade-up,.a-fade-in,.a-slide-l,.a-slide-r,.a-scale').forEach(e=>o.observe(e))},
            initCounters(){const o=new IntersectionObserver(e=>{e.forEach(x=>{if(x.isIntersecting){const el=x.target,t=+el.dataset.target;if(!t)return;let c=0;const s=t/75;const ti=setInterval(()=>{c+=s;if(c>=t){c=t;clearInterval(ti)}el.textContent=Math.floor(c)},16);o.unobserve(el)}})},{threshold:.5});document.querySelectorAll('.counter').forEach(e=>o.observe(e))},
            initRings(){const o=new IntersectionObserver(e=>{e.forEach(x=>{if(x.isIntersecting){const c=x.target;const t=c.style.getPropertyValue('--ring-target')||'125.6';c.style.strokeDashoffset=t;o.unobserve(c)}})},{threshold:.5});document.querySelectorAll('[style*="--ring-target"]').forEach(e=>{e.style.strokeDashoffset='125.6';o.observe(e)})}
        }}
        function aiChat(){return{
            open:false,input:'',sending:false,messages:[{text:'Halo! Saya Asisten Prodesa. Ada yang bisa saya bantu?',isUser:false}],prompts:['Cara ajukan surat','Syarat SKTM','Jam pelayanan','Cetak surat'],
            async send(t){const q=t||this.input.trim();if(!q)return;this.input='';this.messages.push({text:q,isUser:true});this.sending=true;this.$nextTick(()=>{this.$refs.chatBox.scrollTop=this.$refs.chatBox.scrollHeight});try{const r=await fetch('{{route("faq.ask")}}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{csrf_token()}}'},body:JSON.stringify({question:q})});const d=await r.json();this.messages.push({text:d.answer||'Maaf, saya tidak bisa menjawab.',isUser:false})}catch{this.messages.push({text:'Terjadi kesalahan. Coba lagi.',isUser:false})}this.sending=false;this.$nextTick(()=>{this.$refs.chatBox.scrollTop=this.$refs.chatBox.scrollHeight})}
        }}
    </script>
</body>
</html>
