<!DOCTYPE html>
<html lang="id" class="scroll-smooth overflow-x-clip">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Portal pelayanan desa digital - Cepat, mudah, dan transparan.">
    <title>{{ config('village.nama_desa', 'Prodesa') }} — Portal Desa Digital</title>
    <x-pwa-assets />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://api.fontshare.com">
    <link href="https://api.fontshare.com/v2/css?f[]=inter@300,400,500,600,700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
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
    <style>
        :root {
            --brand-50:#ecfdf5; --brand-100:#d1fae5; --brand-200:#a7f3d0; --brand-300:#6ee7b7;
            --brand-400:#34d399; --brand-500:#10b981; --brand-600:#059669; --brand-700:#047857;
            --brand-800:#065f46; --brand-900:#064e3b;
            --teal-500:#14b8a6; --teal-600:#0d9488;
            --cyan-500:#06b6d4; --cyan-600:#0891b2;
            --navy-800:#1e293b; --navy-900:#0f172a;
            --shadow-soft:0 4px 24px -4px rgba(0,0,0,.08);
            --shadow-elevated:0 20px 60px rgba(0,0,0,.15),0 4px 12px rgba(0,0,0,.08);
            --shadow-card:0 1px 3px rgba(0,0,0,.04),0 8px 24px rgba(0,0,0,.06);
            --gradient-brand:linear-gradient(135deg,#059669,#0891b2);
            --gradient-hero:linear-gradient(135deg,#052e22 0%,#065f46 25%,#047857 50%,#0e7490 75%,#0369a1 100%);
        }

        *{scroll-behavior:smooth}
        body{font-family:'Inter',system-ui,sans-serif}

        @keyframes gradientShift{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
        @keyframes floatSlow{0%,100%{transform:translateY(0) rotate(0deg)}50%{transform:translateY(-8px) rotate(3deg)}}
        @keyframes floatReverse{0%,100%{transform:translateY(0)}50%{transform:translateY(10px)}}
        @keyframes fadeInUp{from{opacity:0;transform:translateY(32px)}to{opacity:1;transform:translateY(0)}}
        @keyframes pulseGlow{0%,100%{box-shadow:0 0 0 0 rgba(16,185,129,0.3)}50%{box-shadow:0 0 20px 6px rgba(16,185,129,0.12)}}
        @keyframes typingDot{0%,60%,100%{opacity:.3;transform:translateY(0)}30%{opacity:1;transform:translateY(-4px)}}
        @keyframes marquee{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}

        .anim-fade-up{opacity:0;transform:translateY(32px);transition:opacity .6s cubic-bezier(.22,1,.36,1),transform .6s cubic-bezier(.22,1,.36,1)}
        .anim-fade-up.visible{opacity:1;transform:translateY(0)}
        .anim-fade-scale{opacity:0;transform:scale(.92);transition:opacity .6s ease,transform .6s ease}
        .anim-fade-scale.visible{opacity:1;transform:scale(1)}
        .anim-slide-left{opacity:0;transform:translateX(-40px);transition:opacity .6s ease,transform .6s ease}
        .anim-slide-left.visible{opacity:1;transform:translateX(0)}
        .anim-slide-right{opacity:0;transform:translateX(40px);transition:opacity .6s ease,transform .6s ease}
        .anim-slide-right.visible{opacity:1;transform:translateX(0)}

        .stagger-1{transition-delay:.08s}.stagger-2{transition-delay:.16s}.stagger-3{transition-delay:.24s}
        .stagger-4{transition-delay:.32s}.stagger-5{transition-delay:.4s}.stagger-6{transition-delay:.48s}
        .stagger-7{transition-delay:.56s}.stagger-8{transition-delay:.64s}

        .hero-gradient{background:var(--gradient-hero);background-size:300% 300%;animation:gradientShift 12s ease infinite}
        .hero-mesh{background:radial-gradient(ellipse at 20% 50%,rgba(16,185,129,.10) 0%,transparent 50%),radial-gradient(ellipse at 80% 20%,rgba(8,145,178,.08) 0%,transparent 50%),radial-gradient(ellipse at 50% 80%,rgba(2,132,199,.07) 0%,transparent 50%)}

        .glass{background:rgba(255,255,255,.06);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.1)}
        .glass-strong{background:rgba(255,255,255,.1);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.15)}

        .card-premium{background:#fff;border:1px solid #f1f5f9;border-radius:16px;transition:all .35s cubic-bezier(.22,1,.36,1);position:relative;overflow:hidden}
        .card-premium::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:var(--gradient-brand);opacity:0;transition:opacity .35s ease}
        .card-premium:hover{transform:translateY(-4px);box-shadow:0 20px 40px -12px rgba(0,0,0,.08);border-color:#e2e8f0}
        .card-premium:hover::before{opacity:1}

        .card-feature{background:#fff;border:1px solid #f1f5f9;border-radius:20px;padding:2rem;transition:all .35s cubic-bezier(.22,1,.36,1);position:relative;overflow:hidden}
        .card-feature:hover{transform:translateY(-6px);box-shadow:0 24px 48px -12px rgba(0,0,0,.1)}

        .card-institution{background:#fff;border:1px solid #f1f5f9;border-radius:16px;padding:1.5rem;transition:all .3s ease;text-align:center}
        .card-institution:hover{transform:translateY(-4px);box-shadow:0 12px 32px -8px rgba(0,0,0,.08);border-color:#d1fae5}

        .nav-scrolled{background:rgba(255,255,255,.95)!important;backdrop-filter:blur(20px)!important;box-shadow:0 1px 20px rgba(0,0,0,.06)!important;border-color:rgba(0,0,0,.04)!important}
        .nav-scrolled .nav-link{color:#475569}
        .nav-scrolled .nav-link:hover{color:#059669}
        .nav-scrolled .nav-link::after{background:var(--accent-500,#0068bd)}
        .nav-scrolled .logo-text{color:#1e293b!important}
        .nav-scrolled .logo-text .gradient-text{-webkit-text-fill-color:var(--brand-600)}
        .nav-scrolled .nav-btn-masuk{color:#475569}
        .nav-scrolled .nav-btn-masuk:hover{color:var(--brand-600)}
        .nav-scrolled .nav-btn-daftar{background:#0068bd;color:#fff}
        .nav-scrolled .nav-btn-daftar:hover{background:#0070cc}
        .nav-scrolled .nav-btn-keluar{color:#64748b}
        .nav-scrolled .nav-btn-keluar:hover{color:#ef4444}
        .nav-scrolled .mobile-toggle{color:#334155}
        .nav-scrolled .mobile-toggle:hover{background:#f1f5f9}

        /* Link aktif saat navbar sudah scroll: harus tetap kontras (bukan putih di atas background putih) */
        .nav-scrolled .nav-link.active{color:#059669}
        .nav-scrolled .nav-link.active::after{background:var(--brand-600);width:100%}

        .nav-link{position:relative;color:rgba(255,255,255,.7);font-weight:500;font-size:.875rem;transition:color .25s ease}
        .nav-link::after{content:'';position:absolute;bottom:-4px;left:50%;width:0;height:2px;background:var(--accent-500,#0068bd);border-radius:9999px;transition:all .3s ease;transform:translateX(-50%)}
        .nav-link:hover{color:#fff}
        .nav-link:hover::after{width:100%}
        .nav-link.active{color:#fff}
        .nav-link.active::after{width:100%}

        .shape{position:absolute;border-radius:50%;filter:blur(1px);pointer-events:none}
        .shape-1{width:300px;height:300px;background:rgba(16,185,129,.08);top:-80px;right:-60px;animation:float 8s ease-in-out infinite}
        .shape-2{width:200px;height:200px;background:rgba(8,145,178,.06);bottom:-40px;left:-40px;animation:floatSlow 10s ease-in-out infinite}
        .shape-3{width:120px;height:120px;background:rgba(2,132,199,.05);top:30%;left:10%;animation:floatReverse 7s ease-in-out infinite}
        .shape-4{width:80px;height:80px;background:rgba(16,185,129,.06);bottom:20%;right:15%;animation:float 6s ease-in-out infinite 1s}

        .gradient-text{background:var(--gradient-brand);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}

        .faq-item{border:1px solid #f1f5f9;border-radius:12px;transition:all .3s ease;overflow:hidden}
        .faq-item:hover{border-color:#d1fae5}
        .faq-chevron{transition:transform .3s ease}

        .chat-bubble-user{background:var(--gradient-brand);border-radius:16px 16px 4px 16px}
        .chat-bubble-bot{background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px 16px 16px 4px}
        .typing-dot{animation:typingDot 1.2s ease infinite}
        .typing-dot:nth-child(2){animation-delay:.2s}
        .typing-dot:nth-child(3){animation-delay:.4s}

        #scrollProgress{position:fixed;top:0;left:0;height:3px;background:var(--gradient-brand);z-index:9999;transition:width .1s linear}

        .btt{position:fixed;bottom:28px;right:28px;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;opacity:0;visibility:hidden;transition:all .3s ease;z-index:50;background:linear-gradient(135deg,var(--brand-600),var(--brand-700));color:#fff;box-shadow:0 8px 24px -4px rgba(5,150,105,.4)}
        .btt.show{opacity:1;visibility:visible}
        .btt:hover{transform:translateY(-3px) scale(1.05);box-shadow:0 12px 32px -4px rgba(5,150,105,.5)}

        .marquee-track{display:flex;animation:marquee 30s linear infinite;width:max-content}
        .marquee-track:hover{animation-play-state:paused}

        .dev-card{background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(8,145,178,.06));border:1px solid rgba(16,185,129,.12);border-radius:20px;padding:1.5rem 2rem;position:relative;overflow:hidden;transition:all .4s cubic-bezier(.22,1,.36,1)}
        .dev-card::before{content:'';position:absolute;top:-50%;left:-50%;width:200%;height:200%;background:conic-gradient(from 0deg,transparent,rgba(16,185,129,.06),transparent,rgba(8,145,178,.06),transparent);animation:devSpin 8s linear infinite;pointer-events:none}
        .dev-card:hover{border-color:rgba(16,185,129,.25);box-shadow:0 8px 32px -8px rgba(16,185,129,.15);transform:translateY(-2px)}
        @keyframes devSpin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
        .dev-badge{background:var(--gradient-brand);padding:2px;border-radius:9999px;display:inline-flex;align-items:center;justify-content:center}
        .dev-badge-inner{background:#0f172a;border-radius:9999px;padding:2px 10px;display:flex;align-items:center;gap:5px}
        .social-ig{background:linear-gradient(135deg,#833ab4,#fd1d1d,#fcb045);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;transition:all .3s ease}
        .social-ig:hover{filter:brightness(1.2)}
        .social-wa{color:#25d366;transition:all .3s ease}
        .social-wa:hover{color:#128c7e;filter:drop-shadow(0 0 6px rgba(37,211,102,.4))}

        ::-webkit-scrollbar{width:6px}
        ::-webkit-scrollbar-track{background:#f8fafc}
        ::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:9999px}
        ::-webkit-scrollbar-thumb:hover{background:#94a3b8}
    </style>
    @include('components.favicon')
    @include('components.design-tokens')
</head>
<body class="bg-white font-sans antialiased text-slate-700 overflow-x-clip" x-data="{ mobileOpen:false }">

    <div id="scrollProgress" style="width:0%"></div>

    {{-- NAVBAR --}}
    <nav id="mainNav" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b border-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-18">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center shadow-lg shadow-brand-500/20 group-hover:shadow-brand-500/30 transition-shadow">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <span class="text-lg font-bold text-white logo-text">Pro<span class="gradient-text" style="-webkit-text-fill-color:transparent">desa</span></span>
                </a>
                <div class="hidden lg:flex items-center gap-8">
                    <a href="#profil" class="nav-link">Profil</a>
                    <a href="#layanan" class="nav-link">Layanan</a>
                    <a href="#keunggulan" class="nav-link">Keunggulan</a>
                    <a href="#statistik" class="nav-link">Statistik</a>
                    <a href="#struktur" class="nav-link">Struktur</a>
                    <a href="#kelembagaan" class="nav-link">Kelembagaan</a>
                    <a href="#berita" class="nav-link">Berita</a>
                    <a href="#faq" class="nav-link">FAQ</a>
                </div>
                <div class="hidden lg:flex items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-medium text-white/80 hover:text-white px-4 py-2 rounded-xl transition-colors nav-btn-masuk">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-[#0068BD] px-5 py-2.5 rounded-full hover:bg-[#0070CC] transition-all shadow-lg shadow-blue-500/30 nav-btn-daftar min-h-12 inline-flex items-center">Daftar Gratis</a>
                    @endguest
                    @auth
                        <a href="{{ auth()->user()->dashboardRoute() }}" class="text-sm font-medium text-white/80 hover:text-white px-4 py-2 rounded-xl transition-colors nav-btn-masuk">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">@csrf
                            <button type="submit" class="text-sm font-medium text-white/60 hover:text-white px-3 py-2 rounded-xl transition-colors nav-btn-keluar">Keluar</button>
                        </form>
                    @endauth
                </div>
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl hover:bg-white/10 transition mobile-toggle text-white">
                    <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-2" x-cloak class="lg:hidden bg-white/95 backdrop-blur-xl border-b border-slate-100 shadow-xl">
            <div class="max-w-7xl mx-auto px-4 py-4 space-y-1">
                @foreach(['profil'=>'Profil','layanan'=>'Layanan','keunggulan'=>'Keunggulan','statistik'=>'Statistik','struktur'=>'Struktur','kelembagaan'=>'Kelembagaan','berita'=>'Berita','faq'=>'FAQ'] as $id=>$label)
                    <a href="#{{ $id }}" @click="mobileOpen=false" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-brand-50 hover:text-brand-600 transition">{{ $label }}</a>
                @endforeach
                <div class="border-t border-slate-100 mt-3 pt-3 flex flex-col gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="block text-center px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="block text-center px-4 py-3 rounded-full text-sm font-semibold text-white bg-[#0068BD] shadow-lg shadow-blue-500/25 hover:bg-[#0070CC] transition">Daftar Gratis</a>
                    @endguest
                    @auth
                        <a href="{{ auth()->user()->dashboardRoute() }}" class="block text-center px-4 py-2.5 rounded-xl text-sm font-medium text-brand-600 bg-brand-50 transition">Dashboard</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    <script>
        // Setel status navbar secepatnya (sebelum paint) agar background konsisten saat reload di posisi scroll.
        (function(){var n=document.getElementById('navbar');if(n){n.classList.toggle('nav-scrolled',(window.scrollY||window.pageYOffset||0)>40);}})();
    </script>
    {{-- HERO --}}
    <section class="hero-gradient relative min-h-[92vh] flex items-center overflow-hidden">
        <div class="hero-mesh absolute inset-0"></div>
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
        <div class="absolute inset-0" style="background-image:radial-gradient(rgba(255,255,255,.07) 1px,transparent 1px);background-size:24px 24px"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-28 md:py-32">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 glass rounded-full px-4 py-2 mb-6 anim-fade-up">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-xs font-medium text-white/85 tracking-wide uppercase">Sistem Pelayanan Digital {{ config('village.nama_desa', 'Desa') }}</span>
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-[1.1] mb-6 anim-fade-up stagger-1">
                        Pelayanan Desa<br>
                        <span class="relative inline-block">
                            <span class="relative z-10 text-transparent bg-clip-text bg-gradient-to-r from-emerald-200 to-cyan-200">Digital & Modern</span>
                            <span class="absolute bottom-1 left-0 right-0 h-3 bg-white/10 rounded-full -skew-x-3"></span>
                        </span>
                    </h1>
                    <p class="text-lg text-white/75 max-w-lg mb-8 leading-relaxed anim-fade-up stagger-2">
                        Urus surat desa kapan saja, di mana saja. Tanpa antre, tanpa ribet — transparan dan cepat untuk seluruh warga {{ config('village.nama_desa', 'Desa') }}.
                    </p>
                    <div class="flex flex-wrap gap-3 mb-10 anim-fade-up stagger-3">
                        <a href="{{ route('register') }}" class="group inline-flex items-center gap-2.5 bg-[#0068BD] text-white px-7 py-3.5 rounded-full font-semibold hover:bg-[#0070CC] transition-all shadow-xl shadow-blue-500/30 hover:shadow-2xl hover:-translate-y-0.5">
                            <span>Daftar Sekarang</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 glass text-white px-7 py-3.5 rounded-full font-semibold hover:bg-white/15 transition-all border border-white/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            <span>Masuk</span>
                        </a>
                    </div>
                    <div class="flex flex-wrap gap-6 anim-fade-up stagger-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl glass flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <div class="text-white font-bold text-lg leading-tight counter-hero" data-target="{{ $totalWarga }}">0</div>
                                <div class="text-white/50 text-xs">Warga Aktif</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl glass flex items-center justify-center">
                                <svg class="w-5 h-5 text-cyan-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <div class="text-white font-bold text-lg leading-tight counter-hero" data-target="{{ $suratSelesai }}">0</div>
                                <div class="text-white/50 text-xs">Surat Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Informasi Desa Slider: Berita Terbaru (pelihat terbanyak + filter lembaga) --}}
                <div class="relative anim-fade-scale stagger-3 hidden lg:block" x-data="infoSlider({{ Illuminate\Support\Js::from($sliderBerita) }})" @mouseenter="pause()" @mouseleave="play()">
                    <div class="glass-strong rounded-3xl p-6 shadow-2xl">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-3 h-3 rounded-full bg-red-400/80"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-400/80"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400/80"></div>
                            <span class="ml-2 text-xs text-white/40 font-medium">Informasi Desa</span>
                            <div class="ml-auto flex items-center gap-1">
                                <button type="button" @click="prev()" class="w-6 h-6 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition" title="Sebelumnya">
                                    <svg class="w-3 h-3 text-white/60" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                </button>
                                <button type="button" @click="next()" class="w-6 h-6 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition" title="Berikutnya">
                                    <svg class="w-3 h-3 text-white/60" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-1.5 mb-4">
                            <button type="button" @click="Alpine.store('berita').setLembaga('all')" class="text-[10px] font-semibold px-2.5 py-1 rounded-full transition" :class="Alpine.store('berita').lembaga === 'all' ? 'bg-emerald-400 text-emerald-950' : 'bg-white/10 text-white/60 hover:bg-white/20'">Semua</button>
                            @if ($pemdesCount > 0)
                            <button type="button" @click="Alpine.store('berita').setLembaga('pemdes')" class="text-[10px] font-semibold px-2.5 py-1 rounded-full transition" :class="Alpine.store('berita').lembaga === 'pemdes' ? 'bg-emerald-400 text-emerald-950' : 'bg-white/10 text-white/60 hover:bg-white/20'">Pemerintah Desa</button>
                            @endif
                            @foreach ($lembagas as $lg)
                            <button type="button" @click="Alpine.store('berita').setLembaga('{{ $lg->id }}')" class="text-[10px] font-semibold px-2.5 py-1 rounded-full transition" :class="Alpine.store('berita').lembaga === '{{ (string) $lg->id }}' ? 'bg-emerald-400 text-emerald-950' : 'bg-white/10 text-white/60 hover:bg-white/20'">{{ $lg->nama }}</button>
                            @endforeach
                        </div>
                        <div class="relative overflow-hidden rounded-2xl">
                            <div class="flex transition-transform duration-700 ease-out" :style="`transform: translateX(-${slide*100}%)`">
                                <template x-for="(b, i) in visibleSlides" :key="b.id">
                                    <div class="w-full flex-shrink-0 rounded-2xl relative overflow-hidden">
                                        <div class="absolute inset-0 bg-cover bg-center" :style="b.bg"></div>
                                        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/95 via-emerald-950/70 to-emerald-950/20"></div>
                                        <div class="absolute inset-0 bg-gradient-to-tr from-emerald-900/40 via-transparent to-transparent"></div>
                                        <div class="relative p-5 min-h-[17rem] flex flex-col justify-end">
                                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-lg bg-emerald-500/90 text-white text-[10px] font-bold uppercase tracking-wider">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                                    Berita
                                                </span>
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-white/10 text-white/80 text-[10px] font-semibold">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l7-4 7 4v14m-9 0v-6h4v6"/></svg>
                                                    <span x-text="b.lembaga"></span>
                                                </span>
                                                <span class="text-white/60 text-[10px] font-medium"><span x-text="i + 1"></span> / <span x-text="visibleSlides.length"></span> &middot; <span x-text="b.tanggal"></span></span>
                                            </div>
                                            <a :href="b.url" class="group block">
                                                <h3 class="text-white font-bold text-base leading-snug line-clamp-2 group-hover:text-emerald-300 transition" x-text="b.judul"></h3>
                                                <p class="text-white/70 text-xs leading-relaxed line-clamp-3 mt-2" x-text="b.excerpt"></p>
                                                <div class="flex items-center justify-between mt-3">
                                                    <span class="inline-flex items-center gap-1.5 text-[10px] text-white/50">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                        <span x-text="b.dilihat"></span>x dilihat
                                                    </span>
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-300 group-hover:text-emerald-200 transition">Baca Selengkapnya
                                                        <svg class="w-3 h-3 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </template>
                                <div x-show="visibleSlides.length === 0" class="w-full flex-shrink-0 bg-white/5 rounded-2xl p-8 text-center">
                                    <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-white/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                    </div>
                                    <div class="text-white/60 text-sm font-medium">Belum Ada Berita</div>
                                    <div class="text-white/30 text-xs mt-1">Berita dari kategori ini belum tersedia.</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center gap-1.5 mt-4">
                            <template x-for="(s, i) in visibleSlides" :key="s.id">
                                <button type="button" @click="go(i)" class="h-1.5 rounded-full transition-all duration-300" :class="slide === i ? 'w-6 bg-emerald-400' : 'w-1.5 bg-white/25 hover:bg-white/40'"></button>
                            </template>
                        </div>
                    </div>
                    <div class="absolute -top-4 -right-4 glass rounded-2xl px-4 py-3 shadow-xl" style="animation:float 5s ease-in-out infinite">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-emerald-400/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                            <div>
                                <div class="text-white text-xs font-bold">+{{ number_format($suratSelesai, 0, ',', '.') }}</div>
                                <div class="text-white/50 text-xs">Surat selesai</div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -bottom-4 -left-4 glass rounded-2xl px-4 py-3 shadow-xl" style="animation:floatSlow 6s ease-in-out infinite 1s">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-cyan-400/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-cyan-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            </div>
                            <div>
                                <div class="text-white text-xs font-bold">Notifikasi</div>
                                <div class="text-white/50 text-xs">Surat baru diterbitkan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden md:flex justify-center mt-12">
                <a href="#layanan" class="flex flex-col items-center gap-2 text-white/40 hover:text-white/70 transition group">
                    <span class="text-xs font-medium tracking-wider uppercase">Scroll</span>
                    <div class="w-6 h-10 border-2 border-white/20 rounded-full flex items-start justify-center pt-2 group-hover:border-white/40 transition">
                        <div class="w-1 h-2.5 bg-white/40 rounded-full animate-bounce"></div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- MARQUEE TRUST BAR --}}
    <div class="bg-white border-b border-slate-100 py-4 overflow-hidden">
        <div class="marquee-track">
            @foreach(array_merge(['Pelayanan Cepat & Mudah','100% Gratis untuk Warga','Data Aman & Terenkripsi','Proses Transparan','14+ Jenis Surat Tersedia','24/7 Online','Didukung AI Assistant','Terverifikasi Resmi'], ['Pelayanan Cepat & Mudah','100% Gratis untuk Warga','Data Aman & Terenkripsi','Proses Transparan','14+ Jenis Surat Tersedia','24/7 Online','Didukung AI Assistant','Terverifikasi Resmi']) as $item)
                <div class="flex items-center gap-3 px-8 whitespace-nowrap">
                    <svg class="w-4 h-4 text-brand-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-sm font-medium text-slate-500">{{ $item }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- PROFIL DESA --}}
    <section id="profil" class="py-20 md:py-28 bg-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-50 rounded-full opacity-50 -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-2xl mx-auto mb-16 anim-fade-up">
                <div class="inline-flex items-center gap-2 bg-brand-50 rounded-full px-4 py-1.5 mb-4">
                    <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/></svg>
                    <span class="text-xs font-semibold text-brand-700 uppercase tracking-wider">Profil {{ config('village.nama_desa', 'Desa') }}</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Selamat Datang di <span class="gradient-text">{{ config('village.nama_desa', 'Desa') }}</span></h2>
                @if(config('village.motto_desa'))
                <p class="text-brand-600 font-semibold text-lg">"{{ config('village.motto_desa') }}"</p>
                @endif
            </div>

            <div class="grid lg:grid-cols-2 gap-10 items-stretch">
                <div class="card-premium p-8 anim-slide-left">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-brand-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                        </div>
                        <h3 class="font-bold text-slate-900 text-lg">Tentang Desa</h3>
                    </div>
                    <p class="text-sm text-slate-500 leading-relaxed mb-6">
                        {{ config('village.deskripsi_desa', 'Desa yang terus berkembang dengan pelayanan publik yang transparan, cepat, dan berbasis digital.') }}
                    </p>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-slate-50 rounded-xl px-4 py-3">
                            <div class="text-2xl font-bold text-brand-600">{{ config('village.kode_pos', '-') }}</div>
                            <div class="text-xs text-slate-400 mt-0.5">Kode Pos</div>
                        </div>
                        <div class="bg-slate-50 rounded-xl px-4 py-3">
                            <div class="text-2xl font-bold text-brand-600">{{ config('village.kode_desa', '-') }}</div>
                            <div class="text-xs text-slate-400 mt-0.5">Kode Desa</div>
                        </div>
                    </div>
                </div>

                <div class="card-premium p-8 anim-slide-right">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-cyan-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        </div>
                        <h3 class="font-bold text-slate-900 text-lg">Informasi Kontak</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            <div>
                                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Alamat Kantor</div>
                                <p class="text-sm text-slate-700 mt-0.5">{{ config('village.alamat_kantor', 'Alamat Kantor Desa') }}</p>
                            </div>
                        </div>
                        @if(config('village.telepon_desa'))
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                            <div>
                                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Telepon</div>
                                <p class="text-sm text-slate-700 mt-0.5">{{ config('village.telepon_desa') }}</p>
                            </div>
                        </div>
                        @endif
                        @if(config('village.email_desa'))
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            <div>
                                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email</div>
                                <p class="text-sm text-slate-700 mt-0.5">{{ config('village.email_desa') }}</p>
                            </div>
                        </div>
                        @endif
                        @if(config('village.website_desa'))
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                            <div>
                                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Website</div>
                                <p class="text-sm text-slate-700 mt-0.5">{{ config('village.website_desa') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- BERITA --}}
    <section id="berita" class="py-20 md:py-28 bg-slate-50 relative" x-data="{ init() { Alpine.effect(() => applyBeritaFilter()); } }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-12 anim-fade-up">
                <div>
                    <div class="inline-flex items-center gap-2 bg-sky-50 rounded-full px-4 py-1.5 mb-4">
                        <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <span class="text-xs font-semibold text-sky-700 uppercase tracking-wider">Berita Terbaru</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-2">Informasi Desa</h2>
                    <p class="text-slate-500">Kabar terbaru dari {{ config('village.nama_desa', 'Desa') }} untuk seluruh warga.</p>
                </div>
                <div class="relative w-full md:w-80">
                    <input type="text" id="searchBerita" placeholder="Cari berita..." class="w-full text-sm border border-slate-200 rounded-2xl pl-11 pr-4 py-3 bg-white focus:ring-2 focus:ring-brand-400 focus:border-brand-400 outline-none transition text-slate-700 placeholder-slate-400">
                    <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2 mb-8 anim-fade-up">
                <button type="button" @click="Alpine.store('berita').setLembaga('all')" class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold transition" :class="Alpine.store('berita').lembaga === 'all' ? 'bg-brand-600 text-white shadow-lg shadow-brand-500/25' : 'bg-white text-slate-600 border border-slate-200 hover:border-brand-300'">
                    Semua
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full" :class="Alpine.store('berita').lembaga === 'all' ? 'bg-white/20' : 'bg-slate-100 text-slate-500'">{{ $totalBerita }}</span>
                </button>
                @if ($pemdesCount > 0)
                <button type="button" @click="Alpine.store('berita').setLembaga('pemdes')" class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold transition" :class="Alpine.store('berita').lembaga === 'pemdes' ? 'bg-brand-600 text-white shadow-lg shadow-brand-500/25' : 'bg-white text-slate-600 border border-slate-200 hover:border-brand-300'">
                    Pemerintah Desa
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full" :class="Alpine.store('berita').lembaga === 'pemdes' ? 'bg-white/20' : 'bg-slate-100 text-slate-500'">{{ $pemdesCount }}</span>
                </button>
                @endif
                @foreach ($lembagas as $lg)
                <button type="button" @click="Alpine.store('berita').setLembaga('{{ $lg->id }}')" class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold transition" :class="Alpine.store('berita').lembaga === '{{ (string) $lg->id }}' ? 'bg-brand-600 text-white shadow-lg shadow-brand-500/25' : 'bg-white text-slate-600 border border-slate-200 hover:border-brand-300'">
                    {{ $lg->nama }}
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full" :class="Alpine.store('berita').lembaga === '{{ (string) $lg->id }}' ? 'bg-white/20' : 'bg-slate-100 text-slate-500'">{{ $lg->berita_count }}</span>
                </button>
                @endforeach
            </div>

            @if (isset($berita) && $berita->isNotEmpty())
            @php
                $first = $berita->shift();
                $relTime = function($date) {
                    $diff = now()->diffInHours($date);
                    if ($diff < 1) return now()->diffInMinutes($date).' menit lalu';
                    if ($diff < 24) return $diff.' jam lalu';
                    if ($diff < 168) return now()->diffInDays($date).' hari lalu';
                    return $date->format('d M Y');
                };
                $category = ['Pembangunan', 'Kesehatan', 'Pendidikan', 'Budaya', 'Pemerintahan', 'Lingkungan'];
            @endphp

            <div class="berita-item anim-fade-up mb-8" data-judul="{{ strtolower($first->judul) }}" data-lembaga="{{ $first->lembaga_id ? (string) $first->lembaga_id : 'pemdes' }}">
                <a href="{{ route('berita.show', $first->slug) }}" class="group block md:grid md:grid-cols-5 bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-xl transition-all duration-300">
                    <div class="md:col-span-3 relative overflow-hidden">
                        @if ($first->foto)
                        <img src="{{ asset('storage/' . $first->foto) }}" alt="{{ $first->judul }}" loading="lazy" class="w-full h-56 md:h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        @else
                        <div class="w-full h-56 md:h-full bg-gradient-to-br from-brand-100 via-emerald-50 to-cyan-50 flex items-center justify-center">
                            <svg class="w-16 h-16 text-brand-200" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                        @endif
                        <div class="absolute top-4 left-4"><span class="text-xs font-bold text-white bg-gradient-to-r from-brand-500 to-brand-600 px-3 py-1.5 rounded-lg shadow-lg shadow-brand-500/25">Terbaru</span></div>
                    </div>
                    <div class="md:col-span-2 p-6 md:p-8 flex flex-col justify-center">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-xs font-semibold text-brand-600 bg-brand-50 px-2.5 py-1 rounded-lg">{{ $category[$first->id % 6] }}</span>
                            <span class="text-slate-300">|</span>
                            <span class="text-xs text-slate-400">{{ $relTime($first->created_at) }}</span>
                            <span class="text-slate-300">|</span>
                            <span class="text-xs text-slate-400">{{ ceil(str_word_count(strip_tags($first->konten)) / 200) ?: 1 }} menit baca</span>
                            @if ($first->lembaga)
                            <span class="text-xs text-slate-300">|</span>
                            <span class="inline-flex items-center gap-1 text-xs text-slate-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l7-4 7 4v14m-9 0v-6h4v6"/></svg>
                                {{ $first->lembaga->nama }}
                            </span>
                            @endif
                        </div>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-900 group-hover:text-brand-600 transition-colors leading-snug mb-3">{{ $first->judul }}</h3>
                        <p class="text-sm text-slate-500 leading-relaxed mb-5 line-clamp-3">{{ strip_tags($first->konten) }}</p>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white text-xs font-bold">{{ substr($first->user?->name ?? 'A', 0, 1) }}</div>
                            <div><div class="text-sm font-semibold text-slate-700">{{ $first->user?->name ?? 'Admin' }}</div><div class="text-xs text-slate-400">Penulis</div></div>
                        </div>
                    </div>
                </a>
            </div>

            @if ($berita->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="beritaGrid">
                @foreach ($berita as $item)
                <div class="berita-item anim-fade-up stagger-{{ ($loop->index % 3) + 1 }}" data-judul="{{ strtolower($item->judul) }}" data-lembaga="{{ $item->lembaga_id ? (string) $item->lembaga_id : 'pemdes' }}">
                    <a href="{{ route('berita.show', $item->slug) }}" class="group block bg-white rounded-2xl overflow-hidden border border-slate-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="relative overflow-hidden">
                            @if ($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}" loading="lazy" class="w-full h-48 object-cover transition-transform duration-700 group-hover:scale-105">
                            @else
                            <div class="w-full h-48 bg-gradient-to-br from-slate-100 to-slate-50 flex items-center justify-center">
                                <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                            @endif
                            <span class="absolute top-3 left-3 text-xs font-bold text-white bg-gradient-to-r from-brand-500/90 to-brand-600/90 px-2.5 py-1 rounded-lg backdrop-blur-sm">{{ $category[$item->id % 6] }}</span>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
                                <span>{{ $relTime($item->created_at) }}</span><span>&middot;</span><span>{{ ceil(str_word_count(strip_tags($item->konten)) / 200) ?: 1 }} menit baca</span>
                                <span>&middot;</span>
                                <span class="inline-flex items-center gap-1 font-medium" title="{{ $item->lembaga?->nama ?? 'Diterbitkan oleh Pemerintah Desa' }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l7-4 7 4v14m-9 0v-6h4v6"/></svg>
                                    {{ $item->lembaga?->nama ?? 'Pemerintah Desa' }}
                                </span>
                            </div>
                            <h3 class="font-bold text-slate-900 group-hover:text-brand-600 transition-colors leading-snug mb-2 line-clamp-2">{{ $item->judul }}</h3>
                            <p class="text-xs text-slate-400 line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($item->konten), 120) }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @endif
            @else
            <div class="text-center py-20 bg-white rounded-3xl border border-slate-100 anim-fade-up">
                <div class="w-20 h-20 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center mb-5">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <p class="text-slate-500 font-semibold mb-1">Belum Ada Berita</p>
                <p class="text-slate-400 text-sm">{{ config('village.deskripsi_desa', 'Kabar terbaru desa akan segera hadir.') }}</p>
            </div>
            @endif
        </div>
    </section>

    {{-- LAYANAN --}}
    <section id="layanan" class="py-20 md:py-28 bg-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-50 rounded-full opacity-50 -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-cyan-50 rounded-full opacity-40 translate-y-1/3 -translate-x-1/4 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-2xl mx-auto mb-16 anim-fade-up">
                <div class="inline-flex items-center gap-2 bg-brand-50 rounded-full px-4 py-1.5 mb-4">
                    <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span class="text-xs font-semibold text-brand-700 uppercase tracking-wider">Layanan Kami</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Kebutuhan Surat Desa<br><span class="gradient-text">di Ujung Jari Anda</span></h2>
                <p class="text-slate-500 leading-relaxed">Ajukan berbagai jenis surat desa secara online. Cepat, mudah, dan tanpa perlu datang ke kantor.</p>
            </div>
            @php
                $services = [
                    ['jenis' => 'sktm', 'badge' => 'SKTM', 'title' => 'Surat Keterangan Tidak Mampu', 'tag' => 'Proses 1-3 hari kerja', 'desc' => 'Ajukan SKTM untuk berobat gratis, keringanan biaya, atau keperluan lainnya — semuanya dari rumah.', 'cta' => 'Ajukan Sekarang', 'gradient' => 'from-emerald-500 to-teal-700', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                    ['jenis' => 'ktp_sementara', 'badge' => 'KTP Sementara', 'title' => 'KTP Sementara', 'tag' => 'KTP sementara', 'desc' => 'Surat keterangan pengganti KTP sementara dalam proses penerbitan.', 'cta' => 'Ajukan Sekarang', 'gradient' => 'from-cyan-400 to-sky-600', 'icon' => 'M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2'],
                    ['jenis' => 'akta', 'badge' => 'Akta', 'title' => 'Akta Kelahiran / Kematian', 'tag' => 'Surat pengantar', 'desc' => 'Surat pengantar pembuatan akta kelahiran atau kematian resmi.', 'cta' => 'Ajukan Sekarang', 'gradient' => 'from-amber-400 to-orange-500', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    ['jenis' => 'domisili', 'badge' => 'Domisili', 'title' => 'Surat Domisili', 'tag' => 'Domisili resmi', 'desc' => 'Keterangan resmi tentang alamat dan tempat tinggal warga desa.', 'cta' => 'Ajukan Sekarang', 'gradient' => 'from-violet-400 to-purple-600', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['jenis' => 'belum_menikah', 'badge' => 'Belum Menikah', 'title' => 'Belum Menikah / Janda Duda', 'tag' => 'Status pernikahan', 'desc' => 'Surat keterangan status pernikahan untuk berbagai keperluan resmi.', 'cta' => 'Ajukan Sekarang', 'gradient' => 'from-rose-400 to-pink-600', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                    ['jenis' => null, 'badge' => 'Lainnya', 'title' => '14+ Jenis Surat Lainnya', 'tag' => 'SKU, SKKB, dan banyak lagi', 'desc' => 'SKU, SKKB, Ahli Waris, Kepemilikan Tanah, Penghasilan, dan banyak lagi — semuanya tersedia online.', 'cta' => 'Lihat semua layanan', 'gradient' => 'from-sky-400 to-blue-600', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                ];
                $services = array_map(function ($s) {
                    $s['href'] = $s['jenis'] ? route('warga.surat.create', ['jenis' => $s['jenis']]) : route('login');
                    return $s;
                }, $services);
            @endphp

            <div class="anim-fade-up" x-data="serviceCarousel({{ count($services) }})" @mouseenter="pause()" @mouseleave="play()">
                {{-- Hero Stage --}}
                <div class="relative rounded-[2rem] overflow-hidden bg-slate-900 shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-900 to-emerald-950/60"></div>
                    <div class="absolute -top-20 -left-20 w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-24 -right-10 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl"></div>
                    @foreach($services as $i => $s)
                    <div x-show="active === {{ $i }}" {{ $i > 0 ? 'style="display:none"' : '' }} x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="grid lg:grid-cols-2 min-h-[26rem] relative">
                        <div class="relative z-10 p-8 md:p-12 flex flex-col justify-center">
                            <div class="flex flex-wrap items-center gap-2 mb-5">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gradient-to-r {{ $s['gradient'] }} text-white text-[11px] font-bold uppercase tracking-wider shadow-lg">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/></svg>
                                    {{ $s['badge'] }}
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 text-white/80 text-[11px] font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $s['tag'] }}
                                </span>
                            </div>
                            <h3 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-4">{{ $s['title'] }}</h3>
                            <p class="text-white/70 leading-relaxed mb-8 max-w-lg">{{ $s['desc'] }}</p>
                            <div class="flex flex-wrap items-center gap-3">
                                <a href="{{ $s['href'] }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-slate-900 text-sm font-bold hover:bg-brand-50 transition shadow-lg group">
                                    {{ $s['cta'] }}
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </a>
                                <span class="inline-flex items-center gap-1.5 text-xs text-white/50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    100% Gratis
                                </span>
                            </div>
                        </div>
                        <div class="relative hidden lg:block min-h-[26rem]">
                            <div class="absolute inset-0 bg-gradient-to-br {{ $s['gradient'] }} opacity-90"></div>
                            <div class="absolute -bottom-16 -right-16 w-64 h-64 rounded-full bg-white/10"></div>
                            <div class="absolute top-12 left-12 w-24 h-24 rounded-full bg-white/10"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-44 h-44 rounded-[2rem] bg-white/15 backdrop-blur-md flex items-center justify-center rotate-3 shadow-2xl border border-white/20">
                                    <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Thumbnail Carousel --}}
                <div class="relative mt-6">
                    <button type="button" @click="prev()" class="absolute -left-3 md:-left-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-white shadow-lg border border-slate-100 flex items-center justify-center text-slate-600 hover:bg-brand-600 hover:text-white transition" title="Sebelumnya" aria-label="Sebelumnya">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <div x-ref="thumb" class="flex gap-3 overflow-x-auto snap-x snap-mandatory scroll-smooth py-1 px-1" style="scrollbar-width:none;-ms-overflow-style:none">
                        @foreach($services as $i => $s)
                        <button type="button" @click="select({{ $i }})" class="snap-start shrink-0 w-40 md:w-44 rounded-2xl p-3 text-left border-2 transition-all duration-300 group" :class="active === {{ $i }} ? 'border-brand-500 bg-white shadow-lg shadow-brand-500/10 -translate-y-0.5' : 'border-transparent bg-white hover:border-brand-200 hover:shadow-md'">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $s['gradient'] }} flex items-center justify-center mb-2.5 shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/></svg>
                            </div>
                            <div class="text-[13px] font-bold text-slate-800 leading-tight group-hover:text-brand-700 transition">{{ $s['title'] }}</div>
                        </button>
                        @endforeach
                    </div>
                    <button type="button" @click="next()" class="absolute -right-3 md:-right-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-white shadow-lg border border-slate-100 flex items-center justify-center text-slate-600 hover:bg-brand-600 hover:text-white transition" title="Berikutnya" aria-label="Berikutnya">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>

                {{-- Dots --}}
                <div class="flex items-center justify-center gap-1.5 mt-5">
                    @foreach($services as $i => $s)
                    <button type="button" @click="select({{ $i }})" class="h-1.5 rounded-full transition-all duration-300" :class="active === {{ $i }} ? 'w-6 bg-brand-600' : 'w-1.5 bg-slate-300 hover:bg-slate-400'"></button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ALUR PELAYANAN --}}
    <section class="py-20 md:py-28 bg-gradient-to-b from-slate-50 to-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 anim-fade-up">
                <div class="inline-flex items-center gap-2 bg-cyan-50 rounded-full px-4 py-1.5 mb-4">
                    <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span class="text-xs font-semibold text-cyan-700 uppercase tracking-wider">Cara Kerja</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Mudah dalam <span class="gradient-text">4 Langkah</span></h2>
                <p class="text-slate-500">Tidak perlu antre lama. Urus surat desa cukup dari ponsel Anda.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 relative">
                <div class="hidden lg:block absolute top-16 left-[12%] right-[12%] h-0.5 bg-gradient-to-r from-brand-200 via-teal-200 to-cyan-200"></div>
                @php
                    $steps = [
                        ['num'=>'01','title'=>'Daftar Akun','desc'=>'Buat akun warga dengan NIK dan data diri Anda. Gratis dan cepat.','icon'=>'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z','color'=>'from-brand-400 to-brand-600','shadow'=>'shadow-brand-500/20'],
                        ['num'=>'02','title'=>'Pilih Surat','desc'=>'Pilih jenis surat yang dibutuhkan dari 14+ layanan tersedia.','icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','color'=>'from-cyan-400 to-cyan-600','shadow'=>'shadow-cyan-500/20'],
                        ['num'=>'03','title'=>'Isi Formulir','desc'=>'Lengkapi data dan unggah dokumen yang diperlukan secara online.','icon'=>'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z','color'=>'from-violet-400 to-purple-600','shadow'=>'shadow-violet-500/20'],
                        ['num'=>'04','title'=>'Terima Surat','desc'=>'Pantau status dan cetak surat langsung dari dashboard Anda.','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'from-amber-400 to-orange-500','shadow'=>'shadow-amber-500/20'],
                    ];
                @endphp
                @foreach($steps as $i=>$step)
                <div class="relative text-center anim-fade-up stagger-{{ $i+1 }}">
                    <div class="relative z-10 mx-auto w-16 h-16 rounded-2xl bg-gradient-to-br {{ $step['color'] }} flex items-center justify-center mb-5 shadow-xl {{ $step['shadow'] }}">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}"/></svg>
                    </div>
                    <div class="text-xs font-bold text-brand-500 mb-2 tracking-widest">STEP {{ $step['num'] }}</div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $step['title'] }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- KEUNGGULAN (Zig-zag) --}}
    <section id="keunggulan" class="py-20 md:py-28 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 anim-fade-up">
                <div class="inline-flex items-center gap-2 bg-violet-50 rounded-full px-4 py-1.5 mb-4">
                    <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    <span class="text-xs font-semibold text-violet-700 uppercase tracking-wider">Keunggulan</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Mengapa Memilih <span class="gradient-text">Prodesa</span>?</h2>
                <p class="text-slate-500">Dirancang khusus untuk pelayanan desa yang modern, efisien, dan terpercaya.</p>
            </div>

            <div class="space-y-20">
                {{-- Feature 1: Cepat & Gratis --}}
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="anim-slide-left">
                        <div class="bg-gradient-to-br from-brand-50 to-emerald-50 rounded-3xl p-8 md:p-10 relative overflow-hidden">
                            <div class="absolute top-4 right-4 w-32 h-32 bg-brand-100 rounded-full opacity-40"></div>
                            <div class="relative">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-white rounded-2xl p-5 shadow-sm">
                                        <div class="w-10 h-10 rounded-xl bg-brand-100 flex items-center justify-center mb-3"><svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
                                        <div class="text-2xl font-bold text-slate-900 counter" data-target="3">0</div>
                                        <div class="text-xs text-slate-500 mt-1">Menit Proses</div>
                                    </div>
                                    <div class="bg-white rounded-2xl p-5 shadow-sm">
                                        <div class="w-10 h-10 rounded-xl bg-cyan-100 flex items-center justify-center mb-3"><svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                                        <div class="text-2xl font-bold text-slate-900">24/7</div>
                                        <div class="text-xs text-slate-500 mt-1">Online</div>
                                    </div>
                                    <div class="bg-white rounded-2xl p-5 shadow-sm col-span-2">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center"><svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                                            <div><div class="text-sm font-bold text-slate-900">100% Gratis</div><div class="text-xs text-slate-500">Tanpa biaya apapun untuk warga</div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="anim-slide-right">
                        <div class="text-sm font-bold text-brand-600 mb-3 tracking-wider">CEPAT & GRATIS</div>
                        <h3 class="text-2xl md:text-3xl font-bold text-slate-900 mb-4">Proses Super Cepat,<br>Tanpa Biaya Sepeser Pun</h3>
                        <p class="text-slate-500 leading-relaxed mb-6">Semua layanan surat desa di Prodesa tersedia secara gratis. Cukup daftar, pilih jenis surat, isi formulir, dan tunggu prosesnya — selesai dalam hitungan hari, bukan minggu.</p>
                        <ul class="space-y-3">
                            @foreach(['Tanpa biaya pendaftaran','Tanpa biaya pengajuan surat','Tanpa biaya cetak PDF','Proses verifikasi 1-3 hari kerja'] as $item)
                            <li class="flex items-center gap-3 text-sm text-slate-600">
                                <svg class="w-5 h-5 text-brand-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                {{ $item }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Feature 2: Aman & Transparan --}}
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="anim-slide-left order-2 lg:order-1">
                        <div class="text-sm font-bold text-cyan-600 mb-3 tracking-wider">AMAN & TRANSPARAN</div>
                        <h3 class="text-2xl md:text-3xl font-bold text-slate-900 mb-4">Data Terenkripsi,<br>Proses Sepenuhnya Transparan</h3>
                        <p class="text-slate-500 leading-relaxed mb-6">Setiap pengajuan dilacak secara real-time. Anda bisa melihat status, riwayat, dan versi dokumen kapan saja. Data pribadi dijaga ketat sesuai standar keamanan.</p>
                        <ul class="space-y-3">
                            @foreach(['Enkripsi data end-to-end','Tracking status real-time','Riwayat versi dokumen','Log aktivitas lengkap'] as $item)
                            <li class="flex items-center gap-3 text-sm text-slate-600">
                                <svg class="w-5 h-5 text-cyan-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                {{ $item }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="anim-slide-right order-1 lg:order-2">
                        <div class="bg-gradient-to-br from-cyan-50 to-sky-50 rounded-3xl p-8 md:p-10 relative overflow-hidden">
                            <div class="absolute bottom-4 left-4 w-24 h-24 bg-cyan-100 rounded-full opacity-40"></div>
                            <div class="relative space-y-4">
                                @php $timeline = [['status'=>'Dikirim','time'=>'Hari ini, 08:30','color'=>'bg-brand-500'],['status'=>'Diverifikasi','time'=>'Hari ini, 10:15','color'=>'bg-cyan-500'],['status'=>'Disetujui Operator','time'=>'Hari ini, 14:00','color'=>'bg-violet-500'],['status'=>'Selesai','time'=>'Besok, 09:00','color'=>'bg-emerald-500']]; @endphp
                                @foreach($timeline as $t)
                                <div class="bg-white rounded-xl p-4 flex items-center gap-4 shadow-sm">
                                    <div class="w-3 h-3 rounded-full {{ $t['color'] }} flex-shrink-0 ring-4 ring-white"></div>
                                    <div class="flex-1">
                                        <div class="text-sm font-semibold text-slate-800">{{ $t['status'] }}</div>
                                        <div class="text-xs text-slate-400">{{ $t['time'] }}</div>
                                    </div>
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Feature 3: AI Assistant --}}
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="anim-slide-left">
                        <div class="bg-gradient-to-br from-violet-50 to-purple-50 rounded-3xl p-8 md:p-10 relative overflow-hidden">
                            <div class="absolute top-6 right-6 w-28 h-28 bg-violet-100 rounded-full opacity-40"></div>
                            <div class="relative">
                                <div class="bg-white rounded-2xl p-6 shadow-sm">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg></div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-800">AI Assistant</div>
                                            <div class="text-xs text-emerald-500 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Online</div>
                                        </div>
                                    </div>
                                    <div class="space-y-3">
                                        <div class="chat-bubble-bot px-4 py-2.5 max-w-[85%]"><p class="text-xs text-slate-600">Halo! Saya AI Prodesa. Ada yang bisa saya bantu?</p></div>
                                        <div class="chat-bubble-user px-4 py-2.5 ml-auto max-w-[85%]"><p class="text-xs text-white">Cara daftar SKTM?</p></div>
                                        <div class="chat-bubble-bot px-4 py-2.5 max-w-[85%]"><p class="text-xs text-slate-600">Klik "Daftar Gratis" lalu isi formulir dengan NIK Anda. Mudah!</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="anim-slide-right">
                        <div class="text-sm font-bold text-violet-600 mb-3 tracking-wider">AI-POWERED</div>
                        <h3 class="text-2xl md:text-3xl font-bold text-slate-900 mb-4">Asisten AI Siap<br>Membantu Kapan Saja</h3>
                        <p class="text-slate-500 leading-relaxed mb-6">Tidak perlu bingung. AI Assistant Prodesa siap menjawab pertanyaan Anda seputar layanan desa, cara pengajuan, dan informasi lainnya — 24 jam non-stop.</p>
                        <ul class="space-y-3">
                            @foreach(['Jawaban instan 24/7','Panduan langkah demi langkah','Info status pengajuan','Tips pengisian formulir'] as $item)
                            <li class="flex items-center gap-3 text-sm text-slate-600">
                                <svg class="w-5 h-5 text-violet-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                {{ $item }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATISTIK --}}
    <section id="statistik" class="py-20 md:py-28 relative overflow-hidden" style="background:var(--gradient-hero)">
        <div class="absolute inset-0" style="background-image:radial-gradient(rgba(255,255,255,.05) 1px,transparent 1px);background-size:20px 20px"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-white/5 rounded-full translate-y-1/3 -translate-x-1/4"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-2xl mx-auto mb-16 anim-fade-up">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Pencapaian Kami</h2>
                <p class="text-emerald-100/70">Data real-time pelayanan digital {{ config('village.nama_desa', 'Desa') }}.</p>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $stats = [
                        ['label'=>'Warga Terdaftar','target'=>$totalWarga,'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                        ['label'=>'Total Pengajuan','target'=>$totalSurat,'icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['label'=>'Surat Selesai','target'=>$suratSelesai,'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['label'=>'Berita Terbit','target'=>$totalBerita,'icon'=>'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
                    ];
                @endphp
                @foreach($stats as $i=>$s)
                <div class="text-center anim-fade-up stagger-{{ $i+1 }}">
                    <div class="glass rounded-2xl p-6 md:p-8 hover:bg-white/10 transition-all group">
                        <div class="w-14 h-14 mx-auto rounded-2xl glass flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-white/80" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/></svg>
                        </div>
                        <div class="text-3xl md:text-4xl font-bold text-[#F6BD23] mb-1 counter" data-target="{{ $s['target'] }}">0</div>
                        <div class="text-sm text-white/50">{{ $s['label'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- STRUKTUR ORGANISASI --}}
    <section id="struktur" class="py-20 md:py-28 bg-gradient-to-b from-white to-slate-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 anim-fade-up">
                <div class="inline-flex items-center gap-2 bg-amber-50 rounded-full px-4 py-1.5 mb-4">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span class="text-xs font-semibold text-amber-700 uppercase tracking-wider">Pemerintahan Desa</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Struktur Organisasi</h2>
                <p class="text-slate-500">Perangkat Pemerintah {{ config('village.nama_desa', 'Desa') }} — Berdasarkan Permendagri No. 84 Tahun 2015</p>
            </div>
            <div class="max-w-5xl mx-auto">
                {{-- Top Row: Kepala Desa + BPD side by side --}}
                <div class="grid md:grid-cols-2 gap-8 md:gap-12">
                    {{-- Kepala Desa --}}
                    <div class="flex flex-col items-center anim-fade-up">
                        <div class="card-premium px-8 py-6 text-center hover:shadow-xl w-full">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center mx-auto mb-3 shadow-lg shadow-brand-500/20">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <h3 class="font-bold text-slate-900 text-lg">Kepala Desa</h3>
                            <p class="text-sm text-slate-500">{{ config('village.nama_kades', 'Kepala Desa') }}</p>
                            <div class="mt-3 inline-flex items-center gap-1.5 bg-brand-50 text-brand-700 text-xs font-semibold px-3 py-1 rounded-full">
                                <div class="w-1.5 h-1.5 rounded-full bg-brand-500"></div>
                                Pimpinan Utama
                            </div>
                        </div>
                    </div>
                    {{-- BPD --}}
                    <div class="flex flex-col items-center anim-fade-up">
                        <div class="card-premium px-8 py-6 text-center hover:shadow-xl w-full">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-sky-400 to-sky-600 flex items-center justify-center mx-auto mb-3 shadow-lg shadow-sky-500/20">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <h3 class="font-bold text-slate-900 text-lg">BPD</h3>
                            <p class="text-sm text-slate-500">Badan Permusyawaratan Desa</p>
                            <div class="mt-3 inline-flex items-center gap-1.5 bg-sky-50 text-sky-700 text-xs font-semibold px-3 py-1 rounded-full">
                                <div class="w-1.5 h-1.5 rounded-full bg-sky-500"></div>
                                Lembaga Legislatif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SVG Connector Lines from Kepala Desa to Kaur & Kasi --}}
                <div class="hidden md:block h-12 relative my-2">
                    <svg width="100%" height="48" preserveAspectRatio="none">
                        <line x1="25%" y1="0" x2="25%" y2="24" stroke="#cbd5e1" stroke-width="2"/>
                        <line x1="25%" y1="24" x2="75%" y2="24" stroke="#cbd5e1" stroke-width="2"/>
                        <line x1="25%" y1="24" x2="25%" y2="48" stroke="#cbd5e1" stroke-width="2"/>
                        <line x1="75%" y1="24" x2="75%" y2="48" stroke="#cbd5e1" stroke-width="2"/>
                        <circle cx="25%" cy="24" r="4" fill="#f59e0b" stroke="white" stroke-width="2"/>
                        <circle cx="75%" cy="24" r="4" fill="#8b5cf6" stroke="white" stroke-width="2"/>
                    </svg>
                </div>

                {{-- Bottom Row: Perangkat Desa --}}
                <div class="grid md:grid-cols-2 gap-8 md:gap-12">
                    {{-- Sekretariat: Kaur --}}
                    <div class="card-premium p-6 anim-slide-left">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Sekretariat Desa</h4>
                                <p class="text-xs text-slate-400">Dipimpin: {{ config('village.nama_sekdes', 'Sekretaris Desa') }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            @php $kaur = [
                                ['key' => 'kaur_tu', 'title' => 'Kaur Tata Usaha & Umum', 'color' => 'amber'],
                                ['key' => 'kaur_keuangan', 'title' => 'Kaur Keuangan', 'color' => 'amber'],
                                ['key' => 'kaur_perencanaan', 'title' => 'Kaur Perencanaan', 'color' => 'amber'],
                            ]; @endphp
                            @foreach($kaur as $k)
                            @php $nama = $officials[$k['key'].'_nama'] ?? ''; @endphp
                            <div class="bg-slate-50 rounded-xl px-4 py-3 flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-semibold text-slate-700">{{ $k['title'] }}</div>
                                    @if($nama)
                                    <div class="text-xs text-slate-500 mt-0.5">{{ $nama }}</div>
                                    @else
                                    <div class="text-xs text-slate-300 italic mt-0.5">Belum diatur</div>
                                    @endif
                                </div>
                                @if($nama)
                                <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-bold text-amber-600">{{ strtoupper(substr($nama, 0, 1)) }}</span>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Pelaksana Teknis: Kasi --}}
                    <div class="card-premium p-6 anim-slide-right">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Pelaksana Teknis</h4>
                                <p class="text-xs text-slate-400">Kepala Seksi (Kasi)</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            @php $kasi = [
                                ['key' => 'kasi_pemerintahan', 'title' => 'Kasi Pemerintahan', 'color' => 'violet'],
                                ['key' => 'kasi_kesra', 'title' => 'Kasi Kesejahteraan', 'color' => 'violet'],
                                ['key' => 'kasi_pelayanan', 'title' => 'Kasi Pelayanan', 'color' => 'violet'],
                            ]; @endphp
                            @foreach($kasi as $k)
                            @php $nama = $officials[$k['key'].'_nama'] ?? ''; @endphp
                            <div class="bg-slate-50 rounded-xl px-4 py-3 flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-semibold text-slate-700">{{ $k['title'] }}</div>
                                    @if($nama)
                                    <div class="text-xs text-slate-500 mt-0.5">{{ $nama }}</div>
                                    @else
                                    <div class="text-xs text-slate-300 italic mt-0.5">Belum diatur</div>
                                    @endif
                                </div>
                                @if($nama)
                                <div class="w-8 h-8 rounded-full bg-violet-100 flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-bold text-violet-600">{{ strtoupper(substr($nama, 0, 1)) }}</span>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- KELEMBAGAAN DESA --}}
    <section id="kelembagaan" class="py-20 md:py-28 bg-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-80 h-80 bg-brand-50 rounded-full opacity-30 -translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-2xl mx-auto mb-16 anim-fade-up">
                <div class="inline-flex items-center gap-2 bg-rose-50 rounded-full px-4 py-1.5 mb-4">
                    <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-xs font-semibold text-rose-700 uppercase tracking-wider">Kelembagaan Desa</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Lembaga & Organisasi <span class="gradient-text">Masyarakat Desa</span></h2>
                <p class="text-slate-500">Berbagai lembaga yang mendukung pembangunan dan pemberdayaan masyarakat di {{ config('village.nama_desa', 'Desa') }}.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @php
                    $institutions = [
                        ['name'=>'Karang Taruna','icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','desc'=>'Organisasi kepemudaan yang aktif dalam kegiatan sosial, olahraga, dan pemberdayaan pemuda desa.','color'=>'from-rose-400 to-pink-600','border'=>'hover:border-rose-200'],
                        ['name'=>'BUMDes','icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4','desc'=>'Badan Usaha Milik Desa untuk pengelolaan potensi ekonomi desa guna kesejahteraan masyarakat.','color'=>'from-amber-400 to-orange-500','border'=>'hover:border-amber-200'],
                        ['name'=>'PKK','icon'=>'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z','desc'=>'Pemberdayaan Kesejahteraan Keluarga — fokus pada kesehatan, pendidikan, dan ekonomi keluarga.','color'=>'from-brand-400 to-emerald-600','border'=>'hover:border-brand-200'],
                        ['name'=>'LPM','icon'=>'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z','desc'=>'Lembaga Pemberdayaan Masyarakat — mengadvokasi dan memberdayakan masyarakat desa.','color'=>'from-violet-400 to-purple-600','border'=>'hover:border-violet-200'],
                        ['name'=>'Linmas','icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','desc'=>'Perlindungan Masyarakat — menjaga keamanan dan ketertiban serta membantu situasi darurat.','color'=>'from-sky-400 to-blue-600','border'=>'hover:border-sky-200'],
                        ['name'=>'KWT','icon'=>'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z','desc'=>'Kelompok Wanita Tani — pemberdayaan perempuan di sektor pertanian dan ketahanan pangan.','color'=>'from-emerald-400 to-green-600','border'=>'hover:border-emerald-200'],
                        ['name'=>'BKM','icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z','desc'=>'Badan Keswadayaan Masyarakat — mengelola program pengentasan kemiskinan desa.','color'=>'from-teal-400 to-cyan-600','border'=>'hover:border-teal-200'],
                        ['name'=>'Toga','icon'=>'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z','desc'=>'Tanaman Obat Keluarga — pengembangan tanaman obat tradisional untuk kesehatan warga.','color'=>'from-lime-400 to-green-600','border'=>'hover:border-lime-200'],
                    ];
                @endphp
                @foreach($institutions as $i=>$inst)
                <div class="card-institution {{ $inst['border'] }} anim-fade-up stagger-{{ ($i % 8) + 1 }} group cursor-default">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $inst['color'] }} flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $inst['icon'] }}"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm mb-2">{{ $inst['name'] }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ $inst['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FAQ + AI CHAT --}}
    <section id="faq" class="py-20 md:py-28 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 anim-fade-up">
                <div class="inline-flex items-center gap-2 bg-emerald-50 rounded-full px-4 py-1.5 mb-4">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-xs font-semibold text-emerald-700 uppercase tracking-wider">FAQ & Asisten</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Pertanyaan & Bantuan</h2>
                <p class="text-slate-500">Temukan jawaban atas pertanyaan umum atau tanyakan langsung ke AI kami.</p>
            </div>

            <div class="grid lg:grid-cols-5 gap-8">
                <div class="lg:col-span-3 space-y-3" x-data="{ openFaq: null }">
                    @php
                        $faqs = [
                            ['q' => 'Bagaimana cara mendaftar di Prodesa?', 'a' => 'Klik tombol "Daftar Gratis" di halaman utama, isi formulir dengan NIK dan data diri Anda, lalu login menggunakan NIK dan password yang telah didaftarkan. Prosesnya hanya butuh 1 menit!'],
                            ['q' => 'Apa saja dokumen yang diperlukan?', 'a' => 'Dokumen yang diperlukan tergantung jenis surat. Untuk SKTM: KTP dan KK. Untuk KTP sementara: KTP yang sedang dalam proses. Untuk akta: surat keterangan dari rumah sakit/kelurahan.'],
                            ['q' => 'Berapa lama proses pengajuan surat?', 'a' => 'Proses pengajuan biasanya selesai dalam 1-3 hari kerja setelah data diverifikasi oleh perangkat desa. Anda akan mendapat notifikasi setiap ada perubahan status.'],
                            ['q' => 'Apakah ada biaya untuk pengajuan surat?', 'a' => 'Tidak ada biaya sama sekali. Seluruh layanan surat menyurat di '.config('village.nama_desa', 'Desa').' gratis untuk seluruh warga.'],
                            ['q' => 'Bagaimana cara mengambil surat yang sudah selesai?', 'a' => 'Setelah status pengajuan "Selesai", Anda bisa mencetak sendiri surat dalam format PDF langsung dari dashboard warga. Tidak perlu datang ke kantor desa.'],
                            ['q' => 'Bagaimana jika data yang saya masukkan salah?', 'a' => 'Jika surat belum diproses, Anda bisa membatalkan pengajuan dan membuat baru. Jika sudah dalam proses, silakan ajukan permintaan revisi melalui dashboard.'],
                            ['q' => 'Apakah data pribadi saya aman?', 'a' => 'Ya, seluruh data Anda dienkripsi dan hanya diakses oleh perangkat desa yang berwenang. Kami menggunakan standar keamanan data setara enterprise.'],
                        ];
                    @endphp
                    @foreach ($faqs as $i => $faq)
                    <div class="faq-item {{ $i === 0 ? '' : '' }} anim-fade-up stagger-{{ ($i % 7) + 1 }}" @click="openFaq === {{ $i }} ? openFaq = null : openFaq = {{ $i }}">
                        <button class="w-full flex items-center justify-between px-5 py-4 text-left">
                            <span class="text-sm font-semibold text-slate-800 pr-4">{{ $faq['q'] }}</span>
                            <svg class="w-5 h-5 text-slate-400 flex-shrink-0 faq-chevron transition-transform duration-300" :class="{ 'rotate-180': openFaq === {{ $i }} }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="faq-body px-5" :class="{ 'max-h-[300px] pb-4': openFaq === {{ $i }} }">
                            <p class="text-sm text-slate-500 leading-relaxed">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- AI Chatbot --}}
                <div class="lg:col-span-2 anim-fade-up stagger-3">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden sticky top-24" x-data="chatWidget()">
                        <div class="bg-gradient-to-r from-brand-600 to-brand-700 px-5 py-4 flex items-center gap-3">
                            <div class="relative">
                                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                </div>
                                <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-brand-600"></span>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-white">AI Assistant</h3>
                                <p class="text-xs text-brand-100">Selalu online &bull; Siap membantu</p>
                            </div>
                        </div>
                        <div class="h-72 overflow-y-auto p-4 space-y-3 scroll-smooth" id="chatMessages" x-ref="chatBox">
                            <template x-for="(msg, i) in messages" :key="i">
                                <div :class="msg.isUser ? 'flex justify-end' : 'flex items-start gap-2.5'">
                                    <template x-if="!msg.isUser">
                                        <div class="w-7 h-7 rounded-lg bg-brand-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg class="w-3.5 h-3.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                        </div>
                                    </template>
                                    <div :class="msg.isUser ? 'chat-bubble-user px-4 py-2.5 max-w-[80%]' : 'chat-bubble-bot px-4 py-2.5 max-w-[80%]'">
                                        <p :class="msg.isUser ? 'text-sm text-white' : 'text-sm text-slate-600'" x-html="msg.text"></p>
                                    </div>
                                </div>
                            </template>
                            <div x-show="typing" class="flex items-start gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-brand-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                </div>
                                <div class="chat-bubble-bot px-4 py-3">
                                    <div class="flex gap-1">
                                        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full typing-dot"></span>
                                        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full typing-dot"></span>
                                        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full typing-dot"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-t border-slate-100 p-3">
                            <form @submit.prevent="sendMessage()" class="flex gap-2">
                                <input type="text" x-model="question" placeholder="Ketik pertanyaan Anda..." class="flex-1 text-sm border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 outline-none bg-slate-50 text-slate-700 placeholder-slate-400 transition">
                                <button type="submit" :disabled="!question.trim() || sending" class="w-10 h-10 rounded-full bg-[#0068BD] text-white flex items-center justify-center hover:bg-[#0070CC] transition-all shadow-lg shadow-blue-500/25 disabled:opacity-50 disabled:cursor-not-allowed flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 0l-7 7m7-7l7 7"/></svg>
                                </button>
                            </form>
                            <div class="flex gap-1.5 mt-2.5 flex-wrap">
                                @foreach(['Cara daftar', 'Biaya', 'Cetak surat', 'Jam kerja'] as $suggestion)
                                <button @click="question = '{{ $suggestion }}'; sendMessage()" class="text-xs bg-slate-50 hover:bg-brand-50 text-slate-500 hover:text-brand-600 px-3 py-1.5 rounded-full border border-slate-100 hover:border-brand-200 transition-all">{{ $suggestion }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-20 md:py-28 relative overflow-hidden" style="background:linear-gradient(135deg,var(--brand-900) 0%,var(--brand-600) 50%,var(--cyan-600) 100%)">
        <div class="absolute inset-0" style="background-image:radial-gradient(rgba(255,255,255,.06) 1px,transparent 1px);background-size:20px 20px"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-white/5 rounded-full -translate-y-1/2"></div>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative anim-fade-up">
            <div class="inline-flex items-center gap-2 glass rounded-full px-4 py-2 mb-6">
                <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span class="text-xs font-medium text-white/80">Mulai Sekarang — Gratis!</span>
            </div>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">Siap Merasakan<br>Kemudahan Prodesa?</h2>
            <p class="text-lg text-white/70 mb-10 max-w-xl mx-auto leading-relaxed">Bergabung dengan ribuan warga {{ config('village.nama_desa', 'Desa') }} yang sudah merasakan kemudahan pelayanan desa digital.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="group inline-flex items-center gap-2.5 bg-[#0068BD] text-white px-8 py-4 rounded-full font-bold hover:bg-[#0070CC] transition-all shadow-xl shadow-blue-500/30 hover:shadow-2xl hover:-translate-y-0.5 text-lg">
                    <span>Daftar Gratis Sekarang</span>
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 glass text-white px-8 py-4 rounded-full font-bold hover:bg-white/15 transition-all text-lg border border-white/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    <span>Masuk</span>
                </a>
            </div>
            <p class="text-xs text-white/40 mt-6">Tidak perlu kartu kredit. Tidak ada biaya tersembunyi. 100% gratis untuk warga {{ config('village.nama_desa', 'Desa') }}.</p>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-slate-900 text-slate-400 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-slate-700 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <div class="lg:col-span-1">
                    <a href="/" class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center shadow-lg shadow-brand-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="text-lg font-bold text-white">Pro<span class="text-brand-400">desa</span></span>
                    </a>
                    <p class="text-sm text-slate-500 leading-relaxed mb-4">Portal desa digital untuk pelayanan administrasi yang cepat, mudah, dan transparan.</p>
                    <div class="text-xs text-slate-600">
                        <p>{{ config('village.alamat_kantor', 'Alamat Desa') }}</p>
                        <p class="mt-1">{{ config('village.email_desa', 'email@desa.id') }}</p>
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white mb-4 tracking-wide">Navigasi</h4>
                    <ul class="space-y-2.5">
                        @foreach(['profil'=>'Profil','layanan'=>'Layanan','statistik'=>'Statistik','struktur'=>'Struktur','kelembagaan'=>'Kelembagaan','berita'=>'Berita'] as $id=>$label)
                        <li><a href="#{{ $id }}" class="text-sm hover:text-brand-400 transition">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white mb-4 tracking-wide">Layanan</h4>
                    <ul class="space-y-2.5">
                        @foreach(['SKTM','KTP Sementara','Akta Kelahiran','Domisili','SKU','SKKB'] as $svc)
                        <li><a href="#layanan" class="text-sm hover:text-brand-400 transition">{{ $svc }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white mb-4 tracking-wide">Kontak</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-sm">
                            <svg class="w-4 h-4 text-brand-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ config('village.alamat_kantor', 'Alamat Kantor Desa') }}</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm">
                            <svg class="w-4 h-4 text-brand-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ config('village.email_desa', 'email@desa.id') }}</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm">
                            <svg class="w-4 h-4 text-brand-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Senin - Jumat, 08.00 - 15.00 WIB</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }} {{ config('village.nama_desa', 'Desa') }} &middot; Prodesa Digital</p>
                <div class="flex items-center gap-4 text-xs text-slate-600">
                    <span>Kec. {{ config('village.nama_kecamatan', 'Kecamatan') }}</span>
                    <span>&middot;</span>
                    <span>Kab. {{ config('village.nama_kabupaten', 'Kabupaten') }}</span>
                    <span>&middot;</span>
                    <span>Prov. Jawa Barat</span>
                </div>
            </div>
        </div>
        {{-- Developer Credit --}}
        <div class="mt-10 pt-8 pb-2">
            <div class="dev-card max-w-2xl mx-auto text-center relative z-10">
                <div class="relative z-10">
                    <div class="dev-badge mx-auto mb-4 w-fit">
                        <div class="dev-badge-inner">
                            <svg class="w-3.5 h-3.5 text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                            <span class="text-xs font-bold text-brand-400 tracking-wide">DEVELOPED WITH</span>
                            <svg class="w-3 h-3 text-red-400" fill="currentColor" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                        </div>
                    </div>

                    <h4 class="text-base font-bold text-white mb-1">Rangga Dev</h4>
                    <p class="text-xs text-slate-400 mb-5">Fullstack Developer & UI/UX Designer</p>

                    <div class="flex items-center justify-center gap-3">
                        <a href="https://instagram.com/rangga.mrw" target="_blank" rel="noopener"
                            class="group flex items-center gap-2.5 bg-white/5 hover:bg-white/10 border border-white/5 hover:border-pink-500/30 rounded-2xl px-5 py-3 transition-all duration-300 hover:shadow-lg hover:shadow-pink-500/10">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-purple-500 via-pink-500 to-orange-400 flex items-center justify-center shadow-lg shadow-pink-500/20 group-hover:shadow-pink-500/30 group-hover:scale-110 transition-all">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </div>
                            <div class="text-left">
                                <div class="text-xs font-bold text-white/80 group-hover:text-pink-300 transition-colors">Instagram</div>
                                <div class="text-xs text-slate-400 group-hover:text-pink-400/60 transition-colors">@rangga.mrw</div>
                            </div>
                        </a>

                        <a href="https://wa.me/6285176922584" target="_blank" rel="noopener"
                            class="group flex items-center gap-2.5 bg-white/5 hover:bg-white/10 border border-white/5 hover:border-emerald-500/30 rounded-2xl px-5 py-3 transition-all duration-300 hover:shadow-lg hover:shadow-emerald-500/10">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-400 to-green-600 flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:shadow-emerald-500/30 group-hover:scale-110 transition-all">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </div>
                            <div class="text-left">
                                <div class="text-xs font-bold text-white/80 group-hover:text-emerald-300 transition-colors">WhatsApp</div>
                                <div class="text-xs text-slate-400 group-hover:text-emerald-400/60 transition-colors">0851 7692 2584</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-6 text-xs text-slate-600">
                &copy; {{ date('Y') }} {{ config('village.nama_desa', 'Desa') }} &middot; Prodesa Digital &middot; RanggaDev ACCESS
            </div>
        </div>
    </footer>

    {{-- BACK TO TOP --}}
    <div class="btt" id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
    </div>

    {{-- SCRIPTS --}}
    <script>
        // ─── Scroll Reveal ───
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); } });
        }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
        document.querySelectorAll('.anim-fade-up, .anim-fade-scale, .anim-slide-left, .anim-slide-right').forEach(el => observer.observe(el));

        // ─── Counter Animation ───
        function animateCounter(el) {
            const target = parseInt(el.dataset.target);
            if (isNaN(target) || target === 0) { el.textContent = '0'; return; }
            const duration = 1800;
            const startTime = performance.now();
            const ease = t => t < .5 ? 4*t*t*t : 1 - Math.pow(-2*t+2,3)/2;
            function update(now) {
                const elapsed = now - startTime;
                const progress = Math.min(elapsed / duration, 1);
                el.textContent = Math.round(ease(progress) * target).toLocaleString('id-ID');
                if (progress < 1) requestAnimationFrame(update);
            }
            requestAnimationFrame(update);
        }
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    animateCounter(e.target);
                    counterObserver.unobserve(e.target);
                }
            });
        }, { threshold: 0.5 });
        document.querySelectorAll('.counter, .counter-hero').forEach(el => counterObserver.observe(el));

        // ─── Navbar Scroll ───
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('nav-scrolled', window.scrollY > 40);
            document.getElementById('backToTop').classList.toggle('show', window.scrollY > 500);
            // Scroll progress
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
            document.getElementById('scrollProgress').style.width = progress + '%';
        });
        // Trigger on load
        window.dispatchEvent(new Event('scroll'));

        // ─── Active Nav Link ───
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const top = section.offsetTop - 100;
                if (window.scrollY >= top) current = section.getAttribute('id');
            });
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) link.classList.add('active');
            });
        });

        // ─── Berita: filter lembaga + search ───
        document.addEventListener('alpine:init', () => {
            Alpine.store('berita', {
                lembaga: 'all',
                setLembaga(f) { this.lembaga = f; },
            });
        });

        function applyBeritaFilter() {
            const q = (document.getElementById('searchBerita')?.value || '').toLowerCase().trim();
            const f = Alpine.store('berita').lembaga;
            document.querySelectorAll('.berita-item').forEach(el => {
                const matchL = f === 'all' || el.dataset.lembaga === f;
                const matchQ = q === '' || (el.dataset.judul || '').includes(q);
                el.style.display = (matchL && matchQ) ? '' : 'none';
            });
        }
        document.getElementById('searchBerita')?.addEventListener('input', applyBeritaFilter);

        // ─── Informasi Desa Slider (Alpine) ───
        function infoSlider(slides = []) {
            return {
                slides,
                slide: 0,
                timer: null,
                get visibleSlides() {
                    const f = Alpine.store('berita').lembaga;
                    return f === 'all' ? this.slides : this.slides.filter(s => s.lembagaKey === f);
                },
                init() {
                    this.play();
                    Alpine.effect(() => {
                        const n = this.visibleSlides.length;
                        if (n === 0) this.slide = 0;
                        else if (this.slide >= n) this.slide = n - 1;
                    });
                },
                play() {
                    this.stop();
                    this.timer = setInterval(() => this.next(), 6000);
                },
                stop() {
                    if (this.timer) { clearInterval(this.timer); this.timer = null; }
                },
                pause() { this.stop(); },
                next() { const n = this.visibleSlides.length; if (!n) return; this.slide = (this.slide + 1) % n; },
                prev() { const n = this.visibleSlides.length; if (!n) return; this.slide = (this.slide - 1 + n) % n; },
                go(i) { this.slide = i; },
            };
        }

        // ─── Layanan: Product Selector Carousel ───
        function serviceCarousel(count) {
            return {
                active: 0,
                timer: null,
                count,
                go(i) {
                    this.active = i;
                    this.scrollIntoView();
                },
                select(i) {
                    this.go(i);
                    this.pause();
                },
                next() {
                    this.go((this.active + 1) % this.count);
                    if (!this.timer) this.play();
                },
                prev() {
                    this.go((this.active - 1 + this.count) % this.count);
                    if (!this.timer) this.play();
                },
                play() {
                    this.stop();
                    this.timer = setInterval(() => this.next(), 6000);
                },
                stop() {
                    if (this.timer) { clearInterval(this.timer); this.timer = null; }
                },
                pause() { this.stop(); },
                scrollIntoView() {
                    this.$nextTick(() => {
                        const c = this.$refs.thumb;
                        const el = c && c.children[this.active];
                        if (!el) return;
                        const max = c.scrollWidth - c.clientWidth;
                        if (max <= 0) return;
                        const target = c.scrollLeft + (el.getBoundingClientRect().left - c.getBoundingClientRect().left) - (c.clientWidth - el.clientWidth) / 2;
                        c.scrollTo({ left: Math.max(0, Math.min(target, max)), behavior: 'smooth' });
                    });
                },
                init() { this.play(); },
            };
        }

        // ─── Chat Widget (Alpine) ───
        function chatWidget() {
            return {
                messages: [{ text: 'Halo! Ada yang bisa saya bantu? Tanyakan seputar layanan desa.', isUser: false }],
                question: '',
                typing: false,
                sending: false,
                async sendMessage() {
                    const q = this.question.trim();
                    if (!q || this.sending) return;
                    this.messages.push({ text: this.escapeHtml(q), isUser: true });
                    this.question = '';
                    this.sending = true;
                    this.typing = true;
                    this.$nextTick(() => { this.$refs.chatBox.scrollTop = this.$refs.chatBox.scrollHeight; });
                    try {
                        const res = await fetch('{{ route("faq.ask") }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ question: q }),
                        });
                        const data = await res.json();
                        this.typing = false;
                        this.messages.push({ text: this.escapeHtml(data.answer), isUser: false });
                    } catch {
                        this.typing = false;
                        this.messages.push({ text: 'Maaf, terjadi masalah koneksi. Silakan coba lagi.', isUser: false });
                    } finally {
                        this.sending = false;
                        this.$nextTick(() => { this.$refs.chatBox.scrollTop = this.$refs.chatBox.scrollHeight; });
                    }
                },
                escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                }
            }
        }
    </script>
</body>
</html>
