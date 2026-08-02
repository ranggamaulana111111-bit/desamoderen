<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - {{ config('village.nama_desa', 'Prodesa') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config={theme:{extend:{colors:{brand:{50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b',950:'#022c22'},navy:{800:'#1e293b',900:'#0f172a',950:'#020617'}}}}}
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @include('components.favicon')
    @include('components.fonts')
    <style>
        :root{--brand-50:#ecfdf5;--brand-100:#d1fae5;--brand-200:#a7f3d0;--brand-300:#6ee7b7;--brand-400:#34d399;--brand-500:#10b981;--brand-600:#059669;--brand-700:#047857;--brand-800:#065f46;--brand-900:#064e3b;--teal-500:#14b8a6;--teal-600:#0d9488;--cyan-500:#06b6d4;--cyan-600:#0891b2;--navy-800:#1e293b;--navy-900:#0f172a;--gradient-brand:linear-gradient(135deg,#059669,#0891b2);--gradient-hero:linear-gradient(160deg,#0a1a12 0%,#0d2818 20%,#0f3423 40%,#0a3040 65%,#0c2d48 85%,#0f172a 100%);--ease-out-expo:cubic-bezier(.16,1,.3,1)}
        [x-cloak]{display:none!important}*,*::before,*::after{box-sizing:border-box}
        @keyframes fadeInUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
        @keyframes fadeIn{from{opacity:0}to{opacity:1}}
        @keyframes slideUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
        @keyframes scaleIn{from{opacity:0;transform:scale(.95)}to{opacity:1;transform:scale(1)}}
        @keyframes orbFloat1{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(20px,-15px) scale(1.05)}50%{transform:translate(-8px,12px) scale(.95)}75%{transform:translate(-18px,-8px) scale(1.02)}}
        @keyframes orbFloat2{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(-15px,18px) scale(.97)}50%{transform:translate(12px,-10px) scale(1.03)}75%{transform:translate(14px,8px) scale(.98)}}
        @keyframes orbFloat3{0%,100%{transform:translate(0,0)}33%{transform:translate(10px,-12px)}66%{transform:translate(-8px,6px)}}
        @keyframes ringFloat{0%,100%{transform:translateY(0) rotate(0deg)}50%{transform:translateY(-10px) rotate(3deg)}}
        @keyframes pulse{0%,100%{opacity:1}50%{opacity:.5}}
        @keyframes dotPulse{0%,100%{opacity:.3}50%{opacity:1}}
        @keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
        @keyframes spin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
        @keyframes ripple{to{transform:scale(4);opacity:0}}
        @keyframes meshMove{0%,100%{transform:translate(0,0) rotate(0deg)}25%{transform:translate(30px,-20px) rotate(2deg)}50%{transform:translate(-20px,30px) rotate(-1deg)}75%{transform:translate(15px,15px) rotate(1deg)}}
        @keyframes floatStat{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}

        .a-fade-up{opacity:0;transform:translateY(24px);transition:all .7s var(--ease-out-expo)}.a-fade-up.v{opacity:1;transform:none}
        .a-fade-in{opacity:0;transition:opacity .6s ease}.a-fade-in.v{opacity:1}
        .a-scale{opacity:0;transform:scale(.95);transition:all .6s var(--ease-out-expo)}.a-scale.v{opacity:1;transform:none}
        .d1{transition-delay:.05s}.d2{transition-delay:.1s}.d3{transition-delay:.15s}.d4{transition-delay:.2s}.d5{transition-delay:.25s}.d6{transition-delay:.3s}.d7{transition-delay:.35s}

        .glass{background:rgba(255,255,255,.06);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.1)}
        .glass-strong{background:rgba(255,255,255,.1);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.15)}
        .glass-dark{background:rgba(0,0,0,.2);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.08)}
        .glass-card{background:rgba(255,255,255,.08);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.12);border-radius:20px}
        .glass-input{background:rgba(255,255,255,.06);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border:1.5px solid rgba(255,255,255,.12);border-radius:14px;transition:all .3s var(--ease-out-expo)}
        .glass-input:focus{background:rgba(255,255,255,.1);border-color:rgba(16,185,129,.5);box-shadow:0 0 0 4px rgba(16,185,129,.1)}

        .input-group{position:relative}
        .input-group input{width:100%;padding:14px 16px 14px 48px;font-size:14px;color:white;background:rgba(255,255,255,.06);border:1.5px solid rgba(255,255,255,.12);border-radius:14px;outline:none;transition:all .3s var(--ease-out-expo);font-family:inherit}
        .input-group input::placeholder{color:rgba(255,255,255,.35)}
        .input-group input:focus{background:rgba(255,255,255,.1);border-color:rgba(16,185,129,.5);box-shadow:0 0 0 4px rgba(16,185,129,.1)}
        .input-group .input-icon{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);transition:color .3s;pointer-events:none}
        .input-group input:focus ~ .input-icon{color:rgba(16,185,129,.8)}
        .input-group .input-action{position:absolute;right:12px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);cursor:pointer;transition:color .2s;padding:4px}
        .input-group .input-action:hover{color:rgba(255,255,255,.7)}
        .input-group.has-error input{border-color:rgba(239,68,68,.5);box-shadow:0 0 0 4px rgba(239,68,68,.1)}
        .input-group.has-success input{border-color:rgba(16,185,129,.5)}

        .btn-login{position:relative;display:inline-flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:14px 24px;font-size:14px;font-weight:700;color:white;background:var(--gradient-brand);border:none;border-radius:14px;cursor:pointer;transition:all .3s var(--ease-out-expo);overflow:hidden;box-shadow:0 8px 24px rgba(5,150,105,.3)}
        .btn-login:hover{box-shadow:0 12px 32px rgba(5,150,105,.4);transform:translateY(-2px)}
        .btn-login:active{transform:scale(.98);transition-duration:.1s}
        .btn-login:disabled{opacity:.6;cursor:not-allowed;transform:none!important;box-shadow:0 4px 12px rgba(5,150,105,.15)!important}
        .btn-login::after{content:'';position:absolute;inset:0;background:linear-gradient(rgba(255,255,255,.15),transparent);opacity:0;transition:opacity .3s}
        .btn-login:hover::after{opacity:1}
        .btn-login .btn-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.3);transform:scale(0);animation:ripple .6s linear;pointer-events:none}

        .stat-pill{display:flex;align-items:center;gap:8px;padding:10px 14px;border-radius:14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.08);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);transition:all .3s var(--ease-out-expo)}
        .stat-pill:hover{background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.15);transform:translateY(-2px)}

        .brand-orb{position:absolute;border-radius:50%;filter:blur(80px);pointer-events:none}

        .mesh-bg{position:absolute;inset:0;overflow:hidden;pointer-events:none}
        .mesh-bg::before{content:'';position:absolute;width:140%;height:140%;top:-20%;left:-20%;background:conic-gradient(from 0deg at 50% 50%,#064e3b 0deg,#0a3040 60deg,#0c2d48 120deg,#064e3b 180deg,#0a1a12 240deg,#0f3423 300deg,#064e3b 360deg);animation:meshMove 30s ease-in-out infinite;opacity:.4}

        .noise-overlay{position:absolute;inset:0;opacity:.03;pointer-events:none;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");background-repeat:repeat;background-size:128px 128px}

        .dot-pattern{position:absolute;inset:0;background-image:radial-gradient(circle,rgba(255,255,255,.04) 1px,transparent 1px);background-size:20px 20px;pointer-events:none}

        ::-webkit-scrollbar{width:4px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:rgba(255,255,255,.15);border-radius:9999px}

        @media(max-width:1023px){
            .login-left{display:none}
        }
    </style>
</head>
<body class="min-h-screen font-sans antialiased overflow-x-hidden" x-data="loginPage()" x-init="init()">

    {{-- ═══════ DESKTOP: TWO-COLUMN LAYOUT ═══════ --}}
    <div class="hidden lg:flex min-h-screen">

        {{-- ═══ LEFT PANEL: BRANDING ═══ --}}
        <div class="relative w-[480px] xl:w-[520px] flex-shrink-0 flex flex-col justify-between p-10 xl:p-12 overflow-hidden" style="background:var(--gradient-hero)">
            {{-- Mesh Background --}}
            <div class="mesh-bg"></div>
            <div class="noise-overlay"></div>
            <div class="dot-pattern"></div>

            {{-- Floating Orbs --}}
            <div class="brand-orb w-[400px] h-[400px] bg-brand-500/15 -top-[120px] -left-[80px]" style="animation:orbFloat1 20s ease-in-out infinite"></div>
            <div class="brand-orb w-[300px] h-[300px] bg-cyan-500/10 bottom-[10%] -right-[80px]" style="animation:orbFloat2 25s ease-in-out infinite"></div>
            <div class="brand-orb w-[200px] h-[200px] bg-teal-500/10 top-[40%] left-[20%]" style="animation:orbFloat3 18s ease-in-out infinite"></div>

            {{-- Content --}}
            <div class="relative z-10">
                {{-- Logo --}}
                <div class="a-fade-up flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold text-white tracking-tight">Pro<span class="text-brand-300">desa</span></h2>
                        <p class="text-[10px] text-white/40 font-semibold tracking-widest uppercase">Portal Desa Digital</p>
                    </div>
                </div>
            </div>

            {{-- Center: Illustration + Tagline --}}
            <div class="relative z-10 flex-1 flex flex-col items-center justify-center py-8">
                {{-- SVG Illustration --}}
                <div class="a-fade-up d2 w-full max-w-[320px] mb-8" style="animation:floatStat 6s ease-in-out infinite">
                    <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full drop-shadow-2xl">
                        {{-- Base Platform --}}
                        <ellipse cx="200" cy="260" rx="160" ry="20" fill="rgba(16,185,129,.08)" stroke="rgba(16,185,129,.15)" stroke-width="1"/>
                        <ellipse cx="200" cy="260" rx="120" ry="12" fill="rgba(16,185,129,.05)"/>
                        {{-- Main Building --}}
                        <rect x="130" y="120" width="140" height="140" rx="8" fill="url(#bldg1)" stroke="rgba(255,255,255,.1)" stroke-width="1"/>
                        <rect x="140" y="130" width="30" height="25" rx="4" fill="rgba(16,185,129,.2)" stroke="rgba(16,185,129,.3)" stroke-width="1"/>
                        <rect x="185" y="130" width="30" height="25" rx="4" fill="rgba(16,185,129,.15)" stroke="rgba(16,185,129,.25)" stroke-width="1"/>
                        <rect x="230" y="130" width="30" height="25" rx="4" fill="rgba(16,185,129,.2)" stroke="rgba(16,185,129,.3)" stroke-width="1"/>
                        <rect x="140" y="165" width="30" height="25" rx="4" fill="rgba(6,182,212,.15)" stroke="rgba(6,182,212,.25)" stroke-width="1"/>
                        <rect x="185" y="165" width="30" height="25" rx="4" fill="rgba(6,182,212,.2)" stroke="rgba(6,182,212,.3)" stroke-width="1"/>
                        <rect x="230" y="165" width="30" height="25" rx="4" fill="rgba(6,182,212,.15)" stroke="rgba(6,182,212,.25)" stroke-width="1"/>
                        <rect x="180" y="210" width="40" height="50" rx="6" fill="rgba(16,185,129,.3)" stroke="rgba(16,185,129,.4)" stroke-width="1"/>
                        <circle cx="210" cy="235" r="3" fill="rgba(255,255,255,.5)"/>
                        {{-- Roof --}}
                        <path d="M120 125 L200 70 L280 125" stroke="rgba(16,185,129,.4)" stroke-width="2" fill="rgba(16,185,129,.08)" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="200" cy="78" r="6" fill="rgba(16,185,129,.3)" stroke="rgba(16,185,129,.5)" stroke-width="1.5"/>
                        {{-- Signal Waves --}}
                        <path d="M185 60 Q200 40 215 60" stroke="rgba(52,211,153,.4)" stroke-width="1.5" fill="none" stroke-linecap="round" style="animation:dotPulse 2s ease-in-out infinite"/>
                        <path d="M175 52 Q200 25 225 52" stroke="rgba(52,211,153,.25)" stroke-width="1.5" fill="none" stroke-linecap="round" style="animation:dotPulse 2s ease-in-out infinite .3s"/>
                        <path d="M165 45 Q200 12 235 45" stroke="rgba(52,211,153,.15)" stroke-width="1.5" fill="none" stroke-linecap="round" style="animation:dotPulse 2s ease-in-out infinite .6s"/>
                        {{-- Floating Documents --}}
                        <g style="animation:orbFloat1 8s ease-in-out infinite">
                            <rect x="60" y="100" width="50" height="65" rx="8" fill="rgba(255,255,255,.08)" stroke="rgba(255,255,255,.12)" stroke-width="1"/>
                            <line x1="70" y1="118" x2="100" y2="118" stroke="rgba(16,185,129,.4)" stroke-width="2" stroke-linecap="round"/>
                            <line x1="70" y1="128" x2="95" y2="128" stroke="rgba(255,255,255,.15)" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="70" y1="138" x2="100" y2="138" stroke="rgba(255,255,255,.1)" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="70" y1="148" x2="85" y2="148" stroke="rgba(255,255,255,.08)" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="100" cy="108" r="6" fill="rgba(16,185,129,.3)"><animate attributeName="opacity" values="1;.5;1" dur="2s" repeatCount="indefinite"/></circle>
                        </g>
                        {{-- Floating QR --}}
                        <g style="animation:orbFloat2 7s ease-in-out infinite 1s">
                            <rect x="300" y="130" width="55" height="55" rx="10" fill="rgba(255,255,255,.06)" stroke="rgba(255,255,255,.1)" stroke-width="1"/>
                            <rect x="310" y="140" width="14" height="14" rx="2" fill="rgba(16,185,129,.3)"/>
                            <rect x="331" y="140" width="14" height="14" rx="2" fill="rgba(16,185,129,.2)"/>
                            <rect x="310" y="161" width="14" height="14" rx="2" fill="rgba(16,185,129,.2)"/>
                            <rect x="331" y="161" width="6" height="6" rx="1" fill="rgba(16,185,129,.35)"/>
                            <rect x="339" y="161" width="6" height="6" rx="1" fill="rgba(16,185,129,.15)"/>
                            <rect x="331" y="169" width="6" height="6" rx="1" fill="rgba(16,185,129,.15)"/>
                            <rect x="339" y="169" width="6" height="6" rx="1" fill="rgba(16,185,129,.25)"/>
                        </g>
                        {{-- Floating Shield --}}
                        <g style="animation:orbFloat3 9s ease-in-out infinite .5s">
                            <path d="M80 200 L80 185 Q80 175 90 170 L95 168 Q100 166 105 168 L110 170 Q120 175 120 185 L120 200 Q120 215 100 225 Q80 215 80 200Z" fill="rgba(16,185,129,.15)" stroke="rgba(16,185,129,.3)" stroke-width="1"/>
                            <path d="M95 195 L100 200 L110 190" stroke="rgba(52,211,153,.6)" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        {{-- People Silhouettes --}}
                        <g style="animation:orbFloat1 10s ease-in-out infinite 2s">
                            <circle cx="340" cy="220" r="8" fill="rgba(255,255,255,.1)"/>
                            <path d="M325 245 Q325 232 340 232 Q355 232 355 245" fill="rgba(255,255,255,.08)"/>
                            <circle cx="365" cy="225" r="6" fill="rgba(255,255,255,.07)"/>
                            <path d="M354 247 Q354 237 365 237 Q376 237 376 247" fill="rgba(255,255,255,.06)"/>
                        </g>
                        <defs>
                            <linearGradient id="bldg1" x1="130" y1="120" x2="270" y2="260"><stop stop-color="rgba(15,23,42,.6)"/><stop offset="1" stop-color="rgba(30,41,59,.4)"/></linearGradient>
                        </defs>
                    </svg>
                </div>

                {{-- Tagline --}}
                <div class="text-center a-fade-up d3">
                    <h1 class="text-2xl xl:text-3xl font-extrabold text-white leading-tight tracking-tight">
                        Portal Layanan<br>
                        <span class="bg-gradient-to-r from-brand-300 via-teal-300 to-cyan-300 bg-clip-text text-transparent">Digital Desa</span>
                    </h1>
                    <p class="text-sm text-white/40 mt-3 max-w-[280px] mx-auto leading-relaxed">
                        Akses layanan publik desa secara digital, cepat, dan transparan.
                    </p>
                </div>
            </div>

            {{-- Bottom: Stats --}}
            <div class="relative z-10 space-y-2.5 a-fade-up d4">
                <div class="stat-pill" style="animation:floatStat 5s ease-in-out infinite">
                    <div class="w-9 h-9 rounded-xl bg-brand-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-white/40 font-semibold uppercase tracking-wider">Surat Diproses</p>
                        <p class="text-sm font-bold text-white">{{ number_format(\App\Models\PengajuanSurat::count()) }} <span class="text-white/40 text-xs font-medium">dokumen</span></p>
                    </div>
                </div>
                <div class="stat-pill" style="animation:floatStat 5s ease-in-out infinite .5s">
                    <div class="w-9 h-9 rounded-xl bg-cyan-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-white/40 font-semibold uppercase tracking-wider">Layanan Digital</p>
                        <p class="text-sm font-bold text-white">{{ \App\Models\LetterConfig::active()->count() }} <span class="text-white/40 text-xs font-medium">jenis surat</span></p>
                    </div>
                </div>
                <div class="stat-pill" style="animation:floatStat 5s ease-in-out infinite 1s">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-white/40 font-semibold uppercase tracking-wider">Keamanan Data</p>
                        <p class="text-sm font-bold text-white">Enkripsi <span class="text-white/40 text-xs font-medium">SHA-256</span></p>
                    </div>
                </div>
            </div>

            {{-- Bottom credit --}}
            <div class="relative z-10 mt-6 a-fade-up d5">
                <p class="text-[10px] text-white/20 text-center">&copy; {{ date('Y') }} {{ config('village.nama_desa') }}, {{ config('village.nama_kecamatan') }}, {{ config('village.nama_kabupaten') }}</p>
            </div>
        </div>

        {{-- ═══ RIGHT PANEL: AUTH FORM ═══ --}}
        <div class="flex-1 flex items-center justify-center p-8 xl:p-12 relative overflow-hidden" style="background:linear-gradient(160deg,#0f172a 0%,#0f1d2e 30%,#0a2540 60%,#0d1f2d 100%)">
            {{-- Subtle BG Elements --}}
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-[10%] right-[10%] w-[300px] h-[300px] bg-brand-500/5 rounded-full blur-3xl" style="animation:orbFloat1 25s ease-in-out infinite"></div>
                <div class="absolute bottom-[15%] left-[5%] w-[200px] h-[200px] bg-cyan-500/5 rounded-full blur-3xl" style="animation:orbFloat2 20s ease-in-out infinite"></div>
                <div class="dot-pattern"></div>
            </div>

            {{-- Form Card --}}
            <div class="relative z-10 w-full max-w-[420px]">
                {{-- Mobile Logo (hidden on desktop, shown via CSS) --}}
                <div class="hidden max-lg:flex items-center gap-3 mb-8 a-fade-up">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-white tracking-tight">Pro<span class="text-brand-300">desa</span></h2>
                        <p class="text-[9px] text-white/30 font-semibold tracking-widest uppercase">Portal Desa Digital</p>
                    </div>
                </div>

                {{-- Welcome --}}
                <div class="mb-8 a-fade-up d1">
                    <h1 class="text-2xl xl:text-3xl font-extrabold text-white tracking-tight">Selamat Datang <span class="bg-gradient-to-r from-brand-300 to-teal-300 bg-clip-text text-transparent">Kembali</span></h1>
                    <p class="text-sm text-white/40 mt-2 leading-relaxed">Masuk ke akun Anda untuk mengakses layanan digital {{ config('village.nama_desa') }}.</p>
                </div>

                {{-- Error Message --}}
                @error('nik')
                <div class="rounded-2xl p-4 mb-6 flex items-start gap-3 border border-red-500/20 bg-red-500/10 backdrop-blur-sm a-scale" x-data="{show:true}" x-show="show" x-transition>
                    <div class="w-9 h-9 rounded-xl bg-red-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-red-300">{{ $message }}</p>
                        <p class="text-xs text-red-400/60 mt-0.5">Periksa kembali NIK dan password Anda.</p>
                    </div>
                    <button @click="show=false" class="text-red-400/50 hover:text-red-300 transition flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                @enderror

                {{-- Form --}}
                <form action="{{ route('login') }}" method="POST" @submit="submitting=true" class="space-y-5">
                    @csrf

                    {{-- NIK --}}
                    <div class="a-fade-up d2" x-data="{ focused: false, filled: '{{ old('nik') }}' !== '' }">
                        <label class="block text-xs font-semibold text-white/50 mb-2 ml-1">NIK</label>
                        <div class="input-group" :class="{ 'has-error': '{{ $errors->has('nik') }}', 'has-success': filled && !'{{ $errors->has('nik') }}' }">
                            <input type="text" name="nik" id="nik" value="{{ old('nik') }}" required autofocus
                                placeholder="16 digit NIK Anda"
                                maxlength="16"
                                inputmode="numeric"
                                autocomplete="username"
                                oninput="this.value=this.value.replace(/\D/g,'')"
                                @focus="focused=true"
                                @blur="focused=false; filled = $el.value.length > 0"
                                x-init="$el.value && (filled = true)">
                            <div class="input-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-1.5 ml-1">
                            <p class="text-[11px] text-red-400 font-medium" x-show="false" x-cloak>{{ $errors->first('nik') }}</p>
                            <p class="text-[11px] text-white/30 ml-auto tabular-nums"><span x-text="nikLen"></span>/16</p>
                        </div>
                    </div>

                    {{-- PASSWORD --}}
                    <div class="a-fade-up d3" x-data="{ show: false, focused: false, filled: false }">
                        <label class="block text-xs font-semibold text-white/50 mb-2 ml-1">Password</label>
                        <div class="input-group">
                            <input :type="show ? 'text' : 'password'" name="password" id="password" required
                                placeholder="Masukkan password Anda"
                                autocomplete="current-password"
                                @focus="focused=true"
                                @blur="focused=false; filled = $el.value.length > 0">
                            <div class="input-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                            </div>
                            <div class="input-action" @click="show = !show">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- REMEMBER ME --}}
                    <div class="a-fade-up d4 flex items-center justify-between">
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <div class="relative" x-data="{ checked: false }">
                                <input type="checkbox" name="remember" value="1" class="sr-only peer" @change="checked = $el.checked">
                                <div class="w-5 h-5 rounded-lg border-1.5 border-white/20 bg-white/5 peer-checked:bg-brand-500 peer-checked:border-brand-500 transition-all duration-200 flex items-center justify-center cursor-pointer group-hover:border-white/40">
                                    <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </div>
                            <span class="text-sm text-white/50 group-hover:text-white/70 transition-colors">Ingat saya</span>
                        </label>
                    </div>

                    {{-- LOGIN BUTTON --}}
                    <div class="a-fade-up d5">
                        <button type="submit" class="btn-login" :disabled="submitting">
                            <template x-if="!submitting">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                                    Masuk
                                </span>
                            </template>
                            <template x-if="submitting">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                    Memproses...
                                </span>
                            </template>
                        </button>
                    </div>
                </form>

                {{-- Register Link --}}
                <div class="mt-8 text-center a-fade-up d6">
                    <p class="text-sm text-white/35">Belum punya akun? <a href="{{ route('register') }}" class="text-brand-400 hover:text-brand-300 font-semibold transition-colors relative group"><span class="relative z-10">Daftar di sini</span><span class="absolute bottom-0 left-0 w-0 h-px bg-brand-400 group-hover:w-full transition-all duration-300"></span></a></p>
                </div>

                {{-- Bottom Info --}}
                <div class="mt-6 text-center a-fade-up d7">
                    <div class="inline-flex items-center gap-1.5 glass-dark rounded-full px-3 py-1.5">
                        <svg class="w-3 h-3 text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                        <span class="text-[10px] font-semibold text-white/40">Koneksi aman & terenkripsi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════ MOBILE: SINGLE-COLUMN LAYOUT ═══════ --}}
    <div class="lg:hidden min-h-screen flex flex-col relative overflow-hidden" style="background:var(--gradient-hero)">
        {{-- Mesh BG --}}
        <div class="mesh-bg"></div>
        <div class="noise-overlay"></div>
        <div class="dot-pattern"></div>

        {{-- Floating Orbs --}}
        <div class="brand-orb w-[300px] h-[300px] bg-brand-500/10 -top-[100px] -right-[80px]" style="animation:orbFloat1 20s ease-in-out infinite"></div>
        <div class="brand-orb w-[200px] h-[200px] bg-cyan-500/8 bottom-[20%] -left-[60px]" style="animation:orbFloat2 25s ease-in-out infinite"></div>

        {{-- Header --}}
        <div class="relative z-10 flex items-center justify-between px-5 pt-6 pb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/30">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-extrabold text-white tracking-tight">Pro<span class="text-brand-300">desa</span></h2>
                    <p class="text-[8px] text-white/30 font-semibold tracking-widest uppercase">Portal Desa Digital</p>
                </div>
            </div>
            <div class="glass-dark rounded-full px-3 py-1 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-brand-400 animate-pulse"></span>
                <span class="text-[10px] font-semibold text-white/50">{{ config('village.nama_desa') }}</span>
            </div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 flex-1 flex flex-col justify-center px-5 pb-8">

            {{-- Mini Hero --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-2 glass-dark rounded-full px-3.5 py-1.5 mb-4">
                    <svg class="w-3.5 h-3.5 text-brand-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                    <span class="text-[10px] font-semibold text-brand-200/80">Autentikasi</span>
                </div>
                <h1 class="text-2xl font-extrabold text-white tracking-tight">Selamat Datang <span class="bg-gradient-to-r from-brand-300 to-teal-300 bg-clip-text text-transparent">Kembali</span></h1>
                <p class="text-xs text-white/40 mt-2 max-w-[260px] mx-auto">Masuk untuk mengakses layanan digital desa Anda.</p>
            </div>

            {{-- Error Message --}}
            @error('nik')
            <div class="rounded-2xl p-3.5 mb-5 flex items-start gap-3 border border-red-500/20 bg-red-500/10 backdrop-blur-sm">
                <div class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-red-300">{{ $message }}</p>
                </div>
            </div>
            @enderror

            {{-- Form Card --}}
            <div class="glass-card p-6">
                <form action="{{ route('login') }}" method="POST" @submit="submitting=true" class="space-y-4">
                    @csrf

                    {{-- NIK --}}
                    <div>
                        <label class="block text-[11px] font-semibold text-white/50 mb-1.5 ml-1">NIK</label>
                        <div class="input-group">
                            <input type="text" name="nik" value="{{ old('nik') }}" required autofocus
                                placeholder="16 digit NIK Anda"
                                maxlength="16"
                                inputmode="numeric"
                                autocomplete="username"
                                oninput="this.value=this.value.replace(/\D/g,'')"
                                style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15)">
                            <div class="input-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- PASSWORD --}}
                    <div x-data="{ show: false }">
                        <label class="block text-[11px] font-semibold text-white/50 mb-1.5 ml-1">Password</label>
                        <div class="input-group">
                            <input :type="show ? 'text' : 'password'" name="password" required
                                placeholder="Masukkan password Anda"
                                autocomplete="current-password"
                                style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15)">
                            <div class="input-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                            </div>
                            <div class="input-action" @click="show = !show">
                                <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <svg x-show="show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- REMEMBER ME --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember" value="1" class="w-4 h-4 rounded border-white/20 bg-white/5 text-brand-500 focus:ring-brand-500/30 focus:ring-offset-0">
                            <span class="text-xs text-white/50 group-hover:text-white/70 transition-colors">Ingat saya</span>
                        </label>
                    </div>

                    {{-- BUTTON --}}
                    <button type="submit" class="btn-login" :disabled="submitting">
                        <template x-if="!submitting">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                                Masuk
                            </span>
                        </template>
                        <template x-if="submitting">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                Memproses...
                            </span>
                        </template>
                    </button>
                </form>
            </div>

            {{-- Register --}}
            <div class="mt-6 text-center">
                <p class="text-xs text-white/35">Belum punya akun? <a href="{{ route('register') }}" class="text-brand-400 hover:text-brand-300 font-semibold transition">Daftar di sini</a></p>
            </div>

            {{-- Stats Row --}}
            <div class="mt-6 grid grid-cols-3 gap-2">
                <div class="glass-dark rounded-xl p-2.5 text-center">
                    <p class="text-sm font-bold text-white tabular-nums">{{ number_format(\App\Models\PengajuanSurat::count()) }}</p>
                    <p class="text-[8px] text-white/35 font-semibold uppercase mt-0.5">Surat</p>
                </div>
                <div class="glass-dark rounded-xl p-2.5 text-center">
                    <p class="text-sm font-bold text-white tabular-nums">{{ \App\Models\LetterConfig::active()->count() }}</p>
                    <p class="text-[8px] text-white/35 font-semibold uppercase mt-0.5">Layanan</p>
                </div>
                <div class="glass-dark rounded-xl p-2.5 text-center">
                    <p class="text-sm font-bold text-brand-400">24/7</p>
                    <p class="text-[8px] text-white/35 font-semibold uppercase mt-0.5">Online</p>
                </div>
            </div>

            {{-- Footer --}}
            <div class="mt-6 text-center">
                <p class="text-[10px] text-white/20">&copy; {{ date('Y') }} {{ config('village.nama_desa') }}</p>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        function loginPage(){
            return {
                submitting: false,
                nikLen: {{ strlen(old('nik')) }},

                init(){
                    const nikInput = document.getElementById('nik');
                    if(nikInput){
                        nikInput.addEventListener('input', (e) => {
                            this.nikLen = e.target.value.length;
                        });
                    }
                    this.initReveal();
                },

                initReveal(){
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if(entry.isIntersecting){
                                entry.target.classList.add('v');
                                observer.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.1, rootMargin: '0px 0px -20px 0px' });
                    document.querySelectorAll('.a-fade-up,.a-fade-in,.a-scale').forEach(el => observer.observe(el));
                }
            }
        }
    </script>
</body>
</html>
