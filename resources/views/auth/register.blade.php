<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - {{ config('village.nama_desa', 'Prodesa') }}</title>
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
        @keyframes pulse{0%,100%{opacity:1}50%{opacity:.5}}
        @keyframes dotPulse{0%,100%{opacity:.3}50%{opacity:1}}
        @keyframes meshMove{0%,100%{transform:translate(0,0) rotate(0deg)}25%{transform:translate(30px,-20px) rotate(2deg)}50%{transform:translate(-20px,30px) rotate(-1deg)}75%{transform:translate(15px,15px) rotate(1deg)}}
        @keyframes floatStat{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}
        @keyframes spin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
        @keyframes checkPop{0%{transform:scale(0) rotate(-45deg)}50%{transform:scale(1.2) rotate(0deg)}100%{transform:scale(1) rotate(0deg)}}
        @keyframes successRing{0%{transform:scale(.8);opacity:0}50%{transform:scale(1.05)}100%{transform:scale(1);opacity:1}}

        .a-fade-up{opacity:0;transform:translateY(24px);transition:all .7s var(--ease-out-expo)}.a-fade-up.v{opacity:1;transform:none}
        .a-fade-in{opacity:0;transition:opacity .6s ease}.a-fade-in.v{opacity:1}
        .a-scale{opacity:0;transform:scale(.95);transition:all .6s var(--ease-out-expo)}.a-scale.v{opacity:1;transform:none}
        .d1{transition-delay:.05s}.d2{transition-delay:.1s}.d3{transition-delay:.15s}.d4{transition-delay:.2s}.d5{transition-delay:.25s}.d6{transition-delay:.3s}.d7{transition-delay:.35s}.d8{transition-delay:.4s}

        .glass-card{background:rgba(255,255,255,.08);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.12);border-radius:20px}
        .glass-dark{background:rgba(0,0,0,.2);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.08)}

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

        .btn-register{position:relative;display:inline-flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:14px 24px;font-size:14px;font-weight:700;color:white;background:var(--gradient-brand);border:none;border-radius:14px;cursor:pointer;transition:all .3s var(--ease-out-expo);overflow:hidden;box-shadow:0 8px 24px rgba(5,150,105,.3)}
        .btn-register:hover{box-shadow:0 12px 32px rgba(5,150,105,.4);transform:translateY(-2px)}
        .btn-register:active{transform:scale(.98);transition-duration:.1s}
        .btn-register:disabled{opacity:.6;cursor:not-allowed;transform:none!important;box-shadow:0 4px 12px rgba(5,150,105,.15)!important}
        .btn-register::after{content:'';position:absolute;inset:0;background:linear-gradient(rgba(255,255,255,.15),transparent);opacity:0;transition:opacity .3s}
        .btn-register:hover::after{opacity:1}

        .btn-ghost{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:12px 20px;font-size:13px;font-weight:600;color:rgba(255,255,255,.6);background:rgba(255,255,255,.06);border:1.5px solid rgba(255,255,255,.1);border-radius:14px;cursor:pointer;transition:all .3s var(--ease-out-expo)}
        .btn-ghost:hover{background:rgba(255,255,255,.1);color:rgba(255,255,255,.9);border-color:rgba(255,255,255,.2);transform:translateY(-1px)}

        .stat-pill{display:flex;align-items:center;gap:8px;padding:10px 14px;border-radius:14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.08);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);transition:all .3s var(--ease-out-expo)}
        .stat-pill:hover{background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.15);transform:translateY(-2px)}

        .brand-orb{position:absolute;border-radius:50%;filter:blur(80px);pointer-events:none}
        .mesh-bg{position:absolute;inset:0;overflow:hidden;pointer-events:none}
        .mesh-bg::before{content:'';position:absolute;width:140%;height:140%;top:-20%;left:-20%;background:conic-gradient(from 0deg at 50% 50%,#064e3b 0deg,#0a3040 60deg,#0c2d48 120deg,#064e3b 180deg,#0a1a12 240deg,#0f3423 300deg,#064e3b 360deg);animation:meshMove 30s ease-in-out infinite;opacity:.4}
        .noise-overlay{position:absolute;inset:0;opacity:.03;pointer-events:none;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");background-repeat:repeat;background-size:128px 128px}
        .dot-pattern{position:absolute;inset:0;background-image:radial-gradient(circle,rgba(255,255,255,.04) 1px,transparent 1px);background-size:20px 20px;pointer-events:none}

        .wizard-step{display:none;animation:fadeInUp .5s var(--ease-out-expo)}.wizard-step.active{display:block}

        .stepper{display:flex;align-items:center;gap:0;padding:0 4px}
        .stepper-dot{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;transition:all .4s var(--ease-out-expo);flex-shrink:0;border:2px solid rgba(255,255,255,.15);background:rgba(255,255,255,.05);color:rgba(255,255,255,.3);position:relative;z-index:2}
        .stepper-dot.done{border-color:var(--brand-500);background:var(--brand-500);color:white}
        .stepper-dot.active{border-color:var(--brand-400);background:rgba(16,185,129,.15);color:var(--brand-400);box-shadow:0 0 0 4px rgba(16,185,129,.1)}
        .stepper-line{flex:1;height:2px;border-radius:1px;background:rgba(255,255,255,.1);transition:background .5s var(--ease-out-expo);position:relative;z-index:1}
        .stepper-line.done{background:var(--brand-500)}

        .strength-bar{height:4px;border-radius:2px;background:rgba(255,255,255,.1);overflow:hidden;transition:all .3s}
        .strength-fill{height:100%;border-radius:2px;transition:all .4s var(--ease-out-expo)}

        .review-row{display:flex;align-items:start;justify-content:space-between;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,.06);gap:12px}
        .review-row:last-child{border-bottom:none}
        .review-label{font-size:12px;color:rgba(255,255,255,.4);flex-shrink:0}
        .review-value{font-size:13px;font-weight:600;color:white;text-align:right}

        ::-webkit-scrollbar{width:4px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:rgba(255,255,255,.15);border-radius:9999px}
    </style>
</head>
<body class="min-h-screen font-sans antialiased overflow-x-hidden" x-data="registerPage()" x-init="init()">

    {{-- ═══════ DESKTOP: TWO-COLUMN LAYOUT ═══════ --}}
    <div class="hidden lg:flex min-h-screen">

        {{-- ═══ LEFT PANEL: BRANDING ═══ --}}
        <div class="relative w-[480px] xl:w-[520px] flex-shrink-0 flex flex-col justify-between p-10 xl:p-12 overflow-hidden" style="background:var(--gradient-hero)">
            <div class="mesh-bg"></div>
            <div class="noise-overlay"></div>
            <div class="dot-pattern"></div>
            <div class="brand-orb w-[400px] h-[400px] bg-brand-500/15 -top-[120px] -left-[80px]" style="animation:orbFloat1 20s ease-in-out infinite"></div>
            <div class="brand-orb w-[300px] h-[300px] bg-cyan-500/10 bottom-[10%] -right-[80px]" style="animation:orbFloat2 25s ease-in-out infinite"></div>
            <div class="brand-orb w-[200px] h-[200px] bg-teal-500/10 top-[40%] left-[20%]" style="animation:orbFloat3 18s ease-in-out infinite"></div>

            {{-- Logo --}}
            <div class="relative z-10 a-fade-up">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold text-white tracking-tight">Pro<span class="text-brand-300">desa</span></h2>
                        <p class="text-[10px] text-white/40 font-semibold tracking-widest uppercase">Portal Desa Digital</p>
                    </div>
                </div>
            </div>

            {{-- Center: Illustration --}}
            <div class="relative z-10 flex-1 flex flex-col items-center justify-center py-6">
                <div class="a-fade-up d2 w-full max-w-[300px] mb-6" style="animation:floatStat 6s ease-in-out infinite">
                    <svg viewBox="0 0 400 280" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full drop-shadow-2xl">
                        <ellipse cx="200" cy="250" rx="140" ry="16" fill="rgba(16,185,129,.06)" stroke="rgba(16,185,129,.12)" stroke-width="1"/>
                        <rect x="140" y="110" width="120" height="140" rx="8" fill="rgba(15,23,42,.5)" stroke="rgba(255,255,255,.08)" stroke-width="1"/>
                        <rect x="152" y="122" width="24" height="20" rx="3" fill="rgba(16,185,129,.2)" stroke="rgba(16,185,129,.3)" stroke-width="1"/>
                        <rect x="188" y="122" width="24" height="20" rx="3" fill="rgba(16,185,129,.15)" stroke="rgba(16,185,129,.25)" stroke-width="1"/>
                        <rect x="224" y="122" width="24" height="20" rx="3" fill="rgba(16,185,129,.2)" stroke="rgba(16,185,129,.3)" stroke-width="1"/>
                        <rect x="152" y="152" width="24" height="20" rx="3" fill="rgba(6,182,212,.15)" stroke="rgba(6,182,212,.25)" stroke-width="1"/>
                        <rect x="188" y="152" width="24" height="20" rx="3" fill="rgba(6,182,212,.2)" stroke="rgba(6,182,212,.3)" stroke-width="1"/>
                        <rect x="224" y="152" width="24" height="20" rx="3" fill="rgba(6,182,212,.15)" stroke="rgba(6,182,212,.25)" stroke-width="1"/>
                        <rect x="182" y="198" width="36" height="52" rx="5" fill="rgba(16,185,129,.3)" stroke="rgba(16,185,129,.4)" stroke-width="1"/>
                        <circle cx="208" cy="224" r="2.5" fill="rgba(255,255,255,.5)"/>
                        <path d="M130 115 L200 65 L270 115" stroke="rgba(16,185,129,.35)" stroke-width="2" fill="rgba(16,185,129,.06)" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="200" cy="72" r="5" fill="rgba(16,185,129,.25)" stroke="rgba(16,185,129,.45)" stroke-width="1.5"/>
                        <path d="M188 58 Q200 40 212 58" stroke="rgba(52,211,153,.35)" stroke-width="1.5" fill="none" stroke-linecap="round" style="animation:dotPulse 2s ease-in-out infinite"/>
                        <path d="M180 50 Q200 28 220 50" stroke="rgba(52,211,129,.2)" stroke-width="1.5" fill="none" stroke-linecap="round" style="animation:dotPulse 2s ease-in-out infinite .3s"/>
                        <g style="animation:orbFloat1 8s ease-in-out infinite">
                            <rect x="60" y="90" width="45" height="58" rx="7" fill="rgba(255,255,255,.06)" stroke="rgba(255,255,255,.1)" stroke-width="1"/>
                            <line x1="68" y1="106" x2="96" y2="106" stroke="rgba(16,185,129,.35)" stroke-width="2" stroke-linecap="round"/>
                            <line x1="68" y1="116" x2="90" y2="116" stroke="rgba(255,255,255,.12)" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="68" y1="126" x2="96" y2="126" stroke="rgba(255,255,255,.08)" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="68" y1="136" x2="82" y2="136" stroke="rgba(255,255,255,.06)" stroke-width="1.5" stroke-linecap="round"/>
                        </g>
                        <g style="animation:orbFloat2 7s ease-in-out infinite 1s">
                            <circle cx="320" cy="140" r="22" fill="rgba(16,185,129,.12)" stroke="rgba(16,185,129,.25)" stroke-width="1"/>
                            <path d="M312 140 L318 146 L330 134" stroke="rgba(52,211,153,.6)" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <g style="animation:orbFloat3 9s ease-in-out infinite .5s">
                            <path d="M300 200 L300 188 Q300 180 308 176 L312 174 Q316 172 320 174 L324 176 Q332 180 332 188 L332 200 Q332 212 316 220 Q300 212 300 200Z" fill="rgba(16,185,129,.12)" stroke="rgba(16,185,129,.25)" stroke-width="1"/>
                            <path d="M311 195 L316 200 L325 191" stroke="rgba(52,211,153,.5)" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                    </svg>
                </div>

                <div class="text-center a-fade-up d3">
                    <h1 class="text-2xl xl:text-3xl font-extrabold text-white leading-tight tracking-tight">
                        Bergabung dengan<br>
                        <span class="bg-gradient-to-r from-brand-300 via-teal-300 to-cyan-300 bg-clip-text text-transparent">Prodesa</span>
                    </h1>
                    <p class="text-sm text-white/40 mt-3 max-w-[260px] mx-auto leading-relaxed">
                        Buat akun untuk mengakses layanan digital desa Anda.
                    </p>
                </div>
            </div>

            {{-- Stats --}}
            <div class="relative z-10 space-y-2.5 a-fade-up d4">
                <div class="stat-pill" style="animation:floatStat 5s ease-in-out infinite">
                    <div class="w-9 h-9 rounded-xl bg-brand-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-white/40 font-semibold uppercase tracking-wider">Keamanan Data</p>
                        <p class="text-sm font-bold text-white">Enkripsi <span class="text-white/40 text-xs font-medium">SHA-256</span></p>
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
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-white/40 font-semibold uppercase tracking-wider">Lokasi</p>
                        <p class="text-sm font-bold text-white">{{ config('village.nama_desa') }} <span class="text-white/40 text-xs font-medium">{{ config('village.nama_kecamatan') }}</span></p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 mt-6 a-fade-up d5">
                <p class="text-[10px] text-white/20 text-center">&copy; {{ date('Y') }} {{ config('village.nama_desa') }}, {{ config('village.nama_kecamatan') }}, {{ config('village.nama_kabupaten') }}</p>
            </div>
        </div>

        {{-- ═══ RIGHT PANEL: WIZARD FORM ═══ --}}
        <div class="flex-1 flex items-center justify-center p-6 xl:p-10 relative overflow-hidden" style="background:linear-gradient(160deg,#0f172a 0%,#0f1d2e 30%,#0a2540 60%,#0d1f2d 100%)">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-[10%] right-[10%] w-[300px] h-[300px] bg-brand-500/5 rounded-full blur-3xl" style="animation:orbFloat1 25s ease-in-out infinite"></div>
                <div class="absolute bottom-[15%] left-[5%] w-[200px] h-[200px] bg-cyan-500/5 rounded-full blur-3xl" style="animation:orbFloat2 20s ease-in-out infinite"></div>
                <div class="dot-pattern"></div>
            </div>

            <div class="relative z-10 w-full max-w-[480px]">

                {{-- Error Messages --}}
                @if ($errors->any())
                <div class="rounded-2xl p-4 mb-5 border border-red-500/20 bg-red-500/10 backdrop-blur-sm a-scale" x-data="{show:true}" x-show="show" x-transition>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-red-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-red-300">Terdapat kesalahan pada pengisian form</p>
                            <ul class="mt-1 space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li class="text-xs text-red-400/70">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button @click="show=false" class="text-red-400/50 hover:text-red-300 transition flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                @endif

                {{-- Welcome --}}
                <div class="mb-6 a-fade-up">
                    <h1 class="text-2xl xl:text-3xl font-extrabold text-white tracking-tight">Buat Akun <span class="bg-gradient-to-r from-brand-300 to-teal-300 bg-clip-text text-transparent">Baru</span></h1>
                    <p class="text-sm text-white/40 mt-2">Isi data diri Anda untuk bergabung dengan Prodesa.</p>
                </div>

                {{-- Stepper --}}
                <div class="glass-card p-4 mb-5 a-fade-up d1">
                    <div class="stepper">
                        @php
                            $stepLabels = ['Identitas','Alamat','Kontak','Keamanan','Review'];
                        @endphp
                        @foreach ($stepLabels as $si => $sl)
                            @php $snum = $si + 1; @endphp
                            <div class="stepper-dot" :class="{ 'done': step > {{ $snum }}, 'active': step === {{ $snum }} }">
                                <template x-if="step > {{ $snum }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </template>
                                <template x-if="step <= {{ $snum }}">
                                    <span x-text="{{ $snum }}"></span>
                                </template>
                            </div>
                            @if (!$loop->last)
                                <div class="stepper-line" :class="{ 'done': step > {{ $snum }} }"></div>
                            @endif
                        @endforeach
                    </div>
                    <div class="flex items-center justify-between mt-2 px-0.5">
                        @foreach ($stepLabels as $si => $sl)
                            <span class="text-[9px] font-semibold text-center transition-colors duration-300"
                                  :class="step >= {{ ($si + 1) }} ? 'text-brand-400' : 'text-white/25'"
                                  style="width:{{ 100 / 5 }}%">{{ $sl }}</span>
                        @endforeach
                    </div>
                </div>

                {{-- ═══ FORM ═══ --}}
                <form id="registerForm" action="{{ route('register') }}" method="POST" @submit="submitting=true" class="space-y-0">
                    @csrf

                    {{-- ═══ STEP 1: IDENTITAS ═══ --}}
                    <div class="wizard-step" :class="{ 'active': step === 1 }">
                        <div class="glass-card p-6 a-fade-up d2">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/20">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-base font-bold text-white">Identitas Diri</h2>
                                    <p class="text-xs text-white/40">Lengkapi data identitas Anda</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                {{-- Nama --}}
                                <div>
                                    <label class="block text-xs font-semibold text-white/50 mb-1.5 ml-1">Nama Lengkap <span class="text-red-400">*</span></label>
                                    <div class="input-group {{ $errors->has('nama_lengkap') ? 'has-error' : '' }}">
                                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                                            placeholder="Masukkan nama lengkap"
                                            maxlength="100"
                                            autocomplete="name">
                                        <div class="input-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                        </div>
                                    </div>
                                    @error('nama_lengkap')<p class="text-[11px] text-red-400 font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                                </div>

                                {{-- NIK --}}
                                <div x-data="{ nikLen: '{{ strlen(old('nik')) }}' }">
                                    <label class="block text-xs font-semibold text-white/50 mb-1.5 ml-1">NIK <span class="text-red-400">*</span></label>
                                    <div class="input-group {{ $errors->has('nik') ? 'has-error' : '' }}">
                                        <input type="text" name="nik" id="nik" value="{{ old('nik') }}" required
                                            placeholder="16 digit NIK Anda"
                                            maxlength="16"
                                            inputmode="numeric"
                                            autocomplete="off"
                                            oninput="this.value=this.value.replace(/\D/g,'')"
                                            @input="nikLen = $el.value.length">
                                        <div class="input-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between mt-1 ml-1">
                                        @error('nik')<p class="text-[11px] text-red-400 font-medium">{{ $message }}</p>@enderror
                                        <p class="text-[11px] text-white/30 ml-auto tabular-nums"><span x-text="nikLen"></span>/16</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ═══ STEP 2: ALAMAT ═══ --}}
                    <div class="wizard-step" :class="{ 'active': step === 2 }">
                        <div class="glass-card p-6 a-fade-up">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-base font-bold text-white">Alamat</h2>
                                    <p class="text-xs text-white/40">Lokasi domisili Anda</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-white/50 mb-1.5 ml-1">RT</label>
                                    <div class="input-group {{ $errors->has('rt') ? 'has-error' : '' }}">
                                        <input type="text" name="rt" value="{{ old('rt') }}"
                                            placeholder="RT"
                                            maxlength="3"
                                            inputmode="numeric"
                                            autocomplete="off"
                                            oninput="this.value=this.value.replace(/\D/g,'')">
                                        <div class="input-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                                        </div>
                                    </div>
                                    @error('rt')<p class="text-[11px] text-red-400 font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-white/50 mb-1.5 ml-1">RW</label>
                                    <div class="input-group {{ $errors->has('rw') ? 'has-error' : '' }}">
                                        <input type="text" name="rw" value="{{ old('rw') }}"
                                            placeholder="RW"
                                            maxlength="3"
                                            inputmode="numeric"
                                            autocomplete="off"
                                            oninput="this.value=this.value.replace(/\D/g,'')">
                                        <div class="input-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                                        </div>
                                    </div>
                                    @error('rw')<p class="text-[11px] text-red-400 font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="mt-4 rounded-xl p-3 bg-white/5 border border-white/8">
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-white/30 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="text-[11px] text-white/35 leading-relaxed">RT dan RW bersifat opsional. Isi jika tersedia di KTP Anda.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ═══ STEP 3: KONTAK ═══ --}}
                    <div class="wizard-step" :class="{ 'active': step === 3 }">
                        <div class="glass-card p-6 a-fade-up">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/20">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-base font-bold text-white">Kontak</h2>
                                    <p class="text-xs text-white/40">Nomor telepon yang aktif</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-white/50 mb-1.5 ml-1">Nomor HP</label>
                                <div class="input-group {{ $errors->has('no_hp') ? 'has-error' : '' }}">
                                    <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                        placeholder="08xxxxxxxxxx"
                                        maxlength="15"
                                        inputmode="numeric"
                                        autocomplete="tel"
                                        oninput="this.value=this.value.replace(/\D/g,'')">
                                    <div class="input-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                                    </div>
                                </div>
                                @error('no_hp')<p class="text-[11px] text-red-400 font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                                <p class="text-[11px] text-white/30 mt-1.5 ml-1">Opsional. Nomor HP untuk keperluan kontak.</p>
                            </div>
                        </div>
                    </div>

                    {{-- ═══ STEP 4: KEAMANAN ═══ --}}
                    <div class="wizard-step" :class="{ 'active': step === 4 }">
                        <div class="glass-card p-6 a-fade-up">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-red-400 to-rose-600 flex items-center justify-center shadow-lg shadow-red-500/20">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-base font-bold text-white">Keamanan</h2>
                                    <p class="text-xs text-white/40">Buat password yang kuat</p>
                                </div>
                            </div>

                            <div class="space-y-4" x-data="{ showPw: false, showPwC: false, pw: '{{ old('password') }}', pwLen: {{ strlen(old('password')) }}, strength: 0, strengthLabel: '', strengthColor: '' }" x-init="$watch('pw', v => { pwLen = v.length; strength = calcStrength(v) })">
                                {{-- Password --}}
                                <div>
                                    <label class="block text-xs font-semibold text-white/50 mb-1.5 ml-1">Password <span class="text-red-400">*</span></label>
                                    <div class="input-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                        <input :type="showPw ? 'text' : 'password'" name="password" id="password" required
                                            placeholder="Minimal 6 karakter"
                                            minlength="6"
                                            autocomplete="new-password"
                                            x-model="pw">
                                        <div class="input-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                        </div>
                                        <div class="input-action" @click="showPw = !showPw">
                                            <svg x-show="!showPw" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <svg x-show="showPw" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                        </div>
                                    </div>
                                    @error('password')<p class="text-[11px] text-red-400 font-medium mt-1 ml-1">{{ $message }}</p>@enderror

                                    {{-- Strength Meter --}}
                                    <div class="mt-2 ml-1" x-show="pwLen > 0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <div class="flex-1 flex gap-1">
                                                <template x-for="i in 4" :key="i">
                                                    <div class="strength-bar flex-1" :class="i <= strength ? strengthColor : ''" :style="i <= strength ? 'background:' + (strength <= 1 ? '#ef4444' : strength <= 2 ? '#f59e0b' : strength <= 3 ? '#06b6d4' : '#10b981') : ''"></div>
                                                </template>
                                            </div>
                                            <span class="text-[10px] font-semibold" :class="strength <= 1 ? 'text-red-400' : strength <= 2 ? 'text-amber-400' : strength <= 3 ? 'text-cyan-400' : 'text-brand-400'" x-text="strength <= 1 ? 'Lemah' : strength <= 2 ? 'Sedang' : strength <= 3 ? 'Kuat' : 'Sangat Kuat'"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Confirm Password --}}
                                <div>
                                    <label class="block text-xs font-semibold text-white/50 mb-1.5 ml-1">Konfirmasi Password <span class="text-red-400">*</span></label>
                                    <div class="input-group">
                                        <input :type="showPwC ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" required
                                            placeholder="Ulangi password Anda"
                                            autocomplete="new-password">
                                        <div class="input-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                        </div>
                                        <div class="input-action" @click="showPwC = !showPwC">
                                            <svg x-show="!showPwC" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <svg x-show="showPwC" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ═══ STEP 5: REVIEW ═══ --}}
                    <div class="wizard-step" :class="{ 'active': step === 5 }">
                        <div class="glass-card p-6 a-fade-up">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-base font-bold text-white">Review & Daftar</h2>
                                    <p class="text-xs text-white/40">Periksa data sebelum mendaftar</p>
                                </div>
                            </div>

                            {{-- Identitas --}}
                            <div class="mb-4">
                                <h3 class="text-[10px] font-bold text-white/30 uppercase tracking-widest mb-2 ml-1">Identitas</h3>
                                <div class="rounded-xl border border-white/8 overflow-hidden">
                                    <div class="review-row">
                                        <span class="review-label">Nama Lengkap</span>
                                        <span class="review-value" x-text="getVal('nama_lengkap') || '-'"></span>
                                    </div>
                                    <div class="review-row">
                                        <span class="review-label">NIK</span>
                                        <span class="review-value font-mono" x-text="getVal('nik') || '-'"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-4">
                                <h3 class="text-[10px] font-bold text-white/30 uppercase tracking-widest mb-2 ml-1">Alamat</h3>
                                <div class="rounded-xl border border-white/8 overflow-hidden">
                                    <div class="review-row">
                                        <span class="review-label">RT / RW</span>
                                        <span class="review-value" x-text="(getVal('rt') || '-') + ' / ' + (getVal('rw') || '-')"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Kontak --}}
                            <div class="mb-4">
                                <h3 class="text-[10px] font-bold text-white/30 uppercase tracking-widest mb-2 ml-1">Kontak</h3>
                                <div class="rounded-xl border border-white/8 overflow-hidden">
                                    <div class="review-row">
                                        <span class="review-label">Nomor HP</span>
                                        <span class="review-value" x-text="getVal('no_hp') || '-'"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Keamanan --}}
                            <div class="mb-4">
                                <h3 class="text-[10px] font-bold text-white/30 uppercase tracking-widest mb-2 ml-1">Keamanan</h3>
                                <div class="rounded-xl border border-white/8 overflow-hidden">
                                    <div class="review-row">
                                        <span class="review-label">Password</span>
                                        <span class="review-value">&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Confirm --}}
                            <div class="rounded-xl p-3 bg-brand-500/10 border border-brand-500/20">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" x-model="confirmed" class="mt-0.5 w-4 h-4 rounded border-white/20 bg-white/5 text-brand-500 focus:ring-brand-500/30 focus:ring-offset-0">
                                    <span class="text-xs text-white/50 leading-relaxed">Saya menyatakan bahwa data yang saya isi adalah <strong class="text-white/80">benar dan lengkap</strong>.</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- ═══ NAVIGATION BUTTONS ═══ --}}
                    <div class="flex items-center justify-between gap-3 mt-5 a-fade-up d3">
                        <button type="button" x-show="step > 1" @click="prevStep()" class="btn-ghost">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            Kembali
                        </button>
                        <div x-show="step === 1"></div>

                        <button type="button" x-show="step < 5" @click="nextStep()" class="btn-register">
                            Selanjutnya
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </button>

                        <button type="submit" x-show="step === 5" :disabled="!confirmed || submitting" class="btn-register" :class="(!confirmed || submitting) ? 'opacity-50 cursor-not-allowed !transform-none !shadow-md' : ''">
                            <template x-if="!submitting">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Daftar Sekarang
                                </span>
                            </template>
                            <template x-if="submitting">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                    Mendaftarkan...
                                </span>
                            </template>
                        </button>
                    </div>
                </form>

                {{-- Login Link --}}
                <div class="mt-6 text-center a-fade-up d4">
                    <p class="text-sm text-white/35">Sudah punya akun? <a href="{{ route('login') }}" class="text-brand-400 hover:text-brand-300 font-semibold transition-colors relative group"><span class="relative z-10">Masuk di sini</span><span class="absolute bottom-0 left-0 w-0 h-px bg-brand-400 group-hover:w-full transition-all duration-300"></span></a></p>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════ MOBILE: SINGLE-COLUMN LAYOUT ═══════ --}}
    <div class="lg:hidden min-h-screen flex flex-col relative overflow-hidden" style="background:var(--gradient-hero)">
        <div class="mesh-bg"></div>
        <div class="noise-overlay"></div>
        <div class="dot-pattern"></div>
        <div class="brand-orb w-[300px] h-[300px] bg-brand-500/10 -top-[100px] -right-[80px]" style="animation:orbFloat1 20s ease-in-out infinite"></div>
        <div class="brand-orb w-[200px] h-[200px] bg-cyan-500/8 bottom-[20%] -left-[60px]" style="animation:orbFloat2 25s ease-in-out infinite"></div>

        {{-- Header --}}
        <div class="relative z-10 flex items-center justify-between px-5 pt-6 pb-4">
            <div class="flex items-center gap-2.5">
                <a href="{{ route('login') }}" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center transition-colors group">
                    <svg class="w-4 h-4 text-white/50 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/30">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-extrabold text-white tracking-tight">Pro<span class="text-brand-300">desa</span></h2>
                    <p class="text-[8px] text-white/30 font-semibold tracking-widest uppercase">Portal Desa Digital</p>
                </div>
            </div>
            <div class="glass-dark rounded-full px-3 py-1 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-brand-400 animate-pulse"></span>
                <span class="text-[10px] font-semibold text-white/50">Langkah <span x-text="step"></span>/5</span>
            </div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 flex-1 flex flex-col justify-center px-5 pb-8 overflow-y-auto">

            {{-- Error --}}
            @if ($errors->any())
            <div class="rounded-2xl p-3.5 mb-4 border border-red-500/20 bg-red-500/10 backdrop-blur-sm">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-red-300">{{ $errors->first() }}</p>
                        @if($errors->count() > 1)
                            <p class="text-[10px] text-red-400/60 mt-0.5">+{{ $errors->count() - 1 }} kesalahan lainnya</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Mobile Stepper --}}
            <div class="glass-card p-3 mb-5">
                <div class="stepper">
                    @foreach ($stepLabels as $si => $sl)
                        @php $snum = $si + 1; @endphp
                        <div class="stepper-dot" :class="{ 'done': step > {{ $snum }}, 'active': step === {{ $snum }} }" style="width:28px;height:28px;font-size:11px">
                            <template x-if="step > {{ $snum }}">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </template>
                            <template x-if="step <= {{ $snum }}">
                                <span x-text="{{ $snum }}"></span>
                            </template>
                        </div>
                        @if (!$loop->last)
                            <div class="stepper-line" :class="{ 'done': step > {{ $snum }} }"></div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Mobile Form Card --}}
            <div class="glass-card p-5">
                <form id="registerFormMobile" action="{{ route('register') }}" method="POST" @submit="submitting=true" class="space-y-0">
                    @csrf

                    {{-- Mobile Step 1 --}}
                    <div class="wizard-step" :class="{ 'active': step === 1 }">
                        <h3 class="text-sm font-bold text-white mb-4">Identitas Diri</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-white/50 mb-1 ml-1">Nama Lengkap <span class="text-red-400">*</span></label>
                                <div class="input-group {{ $errors->has('nama_lengkap') ? 'has-error' : '' }}">
                                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Nama lengkap" maxlength="100" autocomplete="name" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15)">
                                    <div class="input-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg></div>
                                </div>
                                @error('nama_lengkap')<p class="text-[10px] text-red-400 font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                            <div x-data="{ nikLen: '{{ strlen(old('nik')) }}' }">
                                <label class="block text-[11px] font-semibold text-white/50 mb-1 ml-1">NIK <span class="text-red-400">*</span></label>
                                <div class="input-group {{ $errors->has('nik') ? 'has-error' : '' }}">
                                    <input type="text" name="nik" value="{{ old('nik') }}" required placeholder="16 digit NIK" maxlength="16" inputmode="numeric" autocomplete="off" oninput="this.value=this.value.replace(/\D/g,'')" @input="nikLen = $el.value.length" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15)">
                                    <div class="input-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg></div>
                                </div>
                                <div class="flex justify-end mt-1"><p class="text-[10px] text-white/30 tabular-nums"><span x-text="nikLen"></span>/16</p></div>
                                @error('nik')<p class="text-[10px] text-red-400 font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Mobile Step 2 --}}
                    <div class="wizard-step" :class="{ 'active': step === 2 }">
                        <h3 class="text-sm font-bold text-white mb-4">Alamat</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-white/50 mb-1 ml-1">RT</label>
                                <div class="input-group {{ $errors->has('rt') ? 'has-error' : '' }}">
                                    <input type="text" name="rt" value="{{ old('rt') }}" placeholder="RT" maxlength="3" inputmode="numeric" oninput="this.value=this.value.replace(/\D/g,'')" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15)">
                                    <div class="input-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg></div>
                                </div>
                                @error('rt')<p class="text-[10px] text-red-400 font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-white/50 mb-1 ml-1">RW</label>
                                <div class="input-group {{ $errors->has('rw') ? 'has-error' : '' }}">
                                    <input type="text" name="rw" value="{{ old('rw') }}" placeholder="RW" maxlength="3" inputmode="numeric" oninput="this.value=this.value.replace(/\D/g,'')" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15)">
                                    <div class="input-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg></div>
                                </div>
                                @error('rw')<p class="text-[10px] text-red-400 font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <p class="text-[10px] text-white/30 mt-3 ml-1">RT dan RW bersifat opsional.</p>
                    </div>

                    {{-- Mobile Step 3 --}}
                    <div class="wizard-step" :class="{ 'active': step === 3 }">
                        <h3 class="text-sm font-bold text-white mb-4">Kontak</h3>
                        <div>
                            <label class="block text-[11px] font-semibold text-white/50 mb-1 ml-1">Nomor HP</label>
                            <div class="input-group {{ $errors->has('no_hp') ? 'has-error' : '' }}">
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" maxlength="15" inputmode="numeric" autocomplete="tel" oninput="this.value=this.value.replace(/\D/g,'')" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15)">
                                <div class="input-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg></div>
                            </div>
                            @error('no_hp')<p class="text-[10px] text-red-400 font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                            <p class="text-[10px] text-white/30 mt-2 ml-1">Opsional. Nomor HP untuk keperluan kontak.</p>
                        </div>
                    </div>

                    {{-- Mobile Step 4 --}}
                    <div class="wizard-step" :class="{ 'active': step === 4 }" x-data="{ showPw: false, showPwC: false, pw: '{{ old('password') }}', strength: 0, strengthLabel: '', strengthColor: '' }" x-init="$watch('pw', v => { strength = calcStrength(v) })">
                        <h3 class="text-sm font-bold text-white mb-4">Keamanan</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-white/50 mb-1 ml-1">Password <span class="text-red-400">*</span></label>
                                <div class="input-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <input :type="showPw ? 'text' : 'password'" name="password" required placeholder="Minimal 6 karakter" minlength="6" autocomplete="new-password" x-model="pw" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15)">
                                    <div class="input-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg></div>
                                    <div class="input-action" @click="showPw = !showPw"><svg x-show="!showPw" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg><svg x-show="showPw" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg></div>
                                </div>
                                @error('password')<p class="text-[10px] text-red-400 font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                                <div class="mt-2 ml-1" x-show="pw && pw.length > 0">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 flex gap-1"><template x-for="i in 4" :key="i"><div class="strength-bar flex-1" :style="i <= strength ? 'background:' + (strength <= 1 ? '#ef4444' : strength <= 2 ? '#f59e0b' : strength <= 3 ? '#06b6d4' : '#10b981') : ''"></div></template></div>
                                        <span class="text-[9px] font-semibold" :class="strength <= 1 ? 'text-red-400' : strength <= 2 ? 'text-amber-400' : strength <= 3 ? 'text-cyan-400' : 'text-brand-400'" x-text="strength <= 1 ? 'Lemah' : strength <= 2 ? 'Sedang' : strength <= 3 ? 'Kuat' : 'Sangat Kuat'"></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-white/50 mb-1 ml-1">Konfirmasi Password <span class="text-red-400">*</span></label>
                                <div class="input-group">
                                    <input :type="showPwC ? 'text' : 'password'" name="password_confirmation" required placeholder="Ulangi password" autocomplete="new-password" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15)">
                                    <div class="input-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg></div>
                                    <div class="input-action" @click="showPwC = !showPwC"><svg x-show="!showPwC" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg><svg x-show="showPwC" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Mobile Step 5 --}}
                    <div class="wizard-step" :class="{ 'active': step === 5 }">
                        <h3 class="text-sm font-bold text-white mb-4">Review & Daftar</h3>
                        <div class="space-y-3">
                            <div class="rounded-xl border border-white/8 overflow-hidden">
                                <div class="review-row"><span class="review-label">Nama</span><span class="review-value text-xs" x-text="getVal('nama_lengkap') || '-'"></span></div>
                                <div class="review-row"><span class="review-label">NIK</span><span class="review-value text-xs font-mono" x-text="getVal('nik') || '-'"></span></div>
                                <div class="review-row"><span class="review-label">RT/RW</span><span class="review-value text-xs" x-text="(getVal('rt') || '-') + ' / ' + (getVal('rw') || '-')"></span></div>
                                <div class="review-row"><span class="review-label">HP</span><span class="review-value text-xs" x-text="getVal('no_hp') || '-'"></span></div>
                                <div class="review-row"><span class="review-label">Password</span><span class="review-value text-xs">&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;</span></div>
                            </div>
                            <label class="flex items-start gap-2.5 cursor-pointer p-3 rounded-xl bg-brand-500/10 border border-brand-500/20">
                                <input type="checkbox" x-model="confirmed" class="mt-0.5 w-4 h-4 rounded border-white/20 bg-white/5 text-brand-500 focus:ring-brand-500/30 focus:ring-offset-0">
                                <span class="text-[11px] text-white/50 leading-relaxed">Data saya benar dan lengkap.</span>
                            </label>
                        </div>
                    </div>

                    {{-- Mobile Nav --}}
                    <div class="flex items-center justify-between gap-3 mt-5">
                        <button type="button" x-show="step > 1" @click="prevStep()" class="btn-ghost !text-xs !px-3 !py-2.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            Kembali
                        </button>
                        <div x-show="step === 1"></div>
                        <button type="button" x-show="step < 5" @click="nextStep()" class="btn-register !text-xs !py-2.5">
                            Selanjutnya
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </button>
                        <button type="submit" x-show="step === 5" :disabled="!confirmed || submitting" class="btn-register !text-xs !py-2.5" :class="(!confirmed || submitting) ? 'opacity-50 cursor-not-allowed !transform-none' : ''">
                            <template x-if="!submitting"><span class="flex items-center gap-1.5">Daftar Sekarang</span></template>
                            <template x-if="submitting"><span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg> Mendaftarkan...</span></template>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Login --}}
            <div class="mt-5 text-center">
                <p class="text-xs text-white/35">Sudah punya akun? <a href="{{ route('login') }}" class="text-brand-400 hover:text-brand-300 font-semibold transition">Masuk di sini</a></p>
            </div>

            {{-- Mobile Stats --}}
            <div class="mt-5 grid grid-cols-3 gap-2">
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
        </div>
    </div>

    {{-- ═══════ SUCCESS OVERLAY ═══════ --}}
    <div x-show="showSuccess" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="background:rgba(0,0,0,.7);backdrop-filter:blur(8px)">
        <div class="text-center" x-transition:enter="transition ease-out duration-500 delay-100" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center mx-auto mb-5 shadow-2xl shadow-brand-500/40" style="animation:successRing .6s var(--ease-out-expo)">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:checkPop .5s var(--ease-out-expo) .3s both"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h2 class="text-xl font-extrabold text-white mb-2">Selamat Datang!</h2>
            <p class="text-sm text-white/60 max-w-[240px] mx-auto">Akun Anda berhasil dibuat. Mengalihkan ke dashboard...</p>
            <div class="mt-5">
                <div class="w-32 h-1 bg-white/10 rounded-full mx-auto overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-brand-400 to-brand-600 rounded-full" style="animation:shimmer 2s ease-in-out forwards;background-size:200% 100%;background-image:linear-gradient(90deg,transparent,rgba(255,255,255,.3),transparent)"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        function registerPage(){
            return {
                step: 1, totalSteps: 5, submitting: false, confirmed: false, showSuccess: false,

                init(){
                    this.initReveal();
                },

                nextStep(){
                    if(!this.validateCurrentStep())return;
                    this.step++;
                    window.scrollTo({top:0,behavior:'smooth'});
                },
                prevStep(){
                    this.step--;
                    window.scrollTo({top:0,behavior:'smooth'});
                },

                validateCurrentStep(){
                    const form = document.getElementById('registerForm') || document.getElementById('registerFormMobile');
                    if(!form)return true;
                    const steps = form.querySelectorAll('.wizard-step');
                    const current = steps[this.step-1];
                    if(!current)return true;
                    const required = current.querySelectorAll('[required]');
                    let valid = true;
                    required.forEach(el => {
                        if(!el.value || el.value.trim() === ''){
                            valid = false;
                            el.style.borderColor = 'rgba(239,68,68,.5)';
                            el.addEventListener('input', function handler(){
                                if(this.value.trim() !== ''){
                                    this.style.borderColor = '';
                                    this.removeEventListener('input', handler);
                                }
                            }, {once: true});
                        }
                    });
                    if(!valid){
                        const first = current.querySelector('[required]');
                        if(first) first.scrollIntoView({behavior:'smooth',block:'center'});
                    }
                    return valid;
                },

                getVal(key){
                    const el = document.querySelector('#registerForm [name="'+key+'"]') || document.querySelector('#registerFormMobile [name="'+key+'"]');
                    return el ? el.value : '';
                },

                calcStrength(pw){
                    let s = 0;
                    if(pw.length >= 6) s++;
                    if(pw.length >= 8) s++;
                    if(/[A-Z]/.test(pw) && /[a-z]/.test(pw)) s++;
                    if(/[0-9]/.test(pw) || /[^A-Za-z0-9]/.test(pw)) s++;
                    return Math.min(s, 4);
                },

                initReveal(){
                    const o = new IntersectionObserver(e => { e.forEach(x => { if(x.isIntersecting){x.target.classList.add('v');o.unobserve(x.target)} }) },{threshold:.1,rootMargin:'0px 0px -20px 0px'});
                    document.querySelectorAll('.a-fade-up,.a-fade-in,.a-scale').forEach(el => o.observe(el));
                }
            }
        }
    </script>
</body>
</html>
