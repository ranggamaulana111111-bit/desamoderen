<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $mode === 'register' ? 'Daftar' : 'Masuk' }} - {{ config('village.nama_desa', 'Prodesa') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                colors: {
                    brand: { 50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b',950:'#022c22' },
                    navy: { 800:'#1e293b',900:'#0f172a',950:'#020617' }
                }
            }}
        };
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @include('components.favicon')
    @include('components.fonts')
    <style>
        :root {
            --brand-50:#ecfdf5; --brand-100:#d1fae5; --brand-200:#a7f3d0; --brand-300:#6ee7b7;
            --brand-400:#34d399; --brand-500:#10b981; --brand-600:#059669; --brand-700:#047857;
            --brand-800:#065f46; --brand-900:#064e3b;
            --teal-500:#14b8a6; --teal-600:#0d9488;
            --cyan-500:#06b6d4; --cyan-600:#0891b2;
            --navy-800:#1e293b; --navy-900:#0f172a;
            --gradient-brand: linear-gradient(135deg,#059669,#0891b2);
            --gradient-hero: linear-gradient(160deg,#0a1a12 0%,#0d2818 20%,#0f3423 40%,#0a3040 65%,#0c2d48 85%,#0f172a 100%);
            --ease-out-expo: cubic-bezier(.16,1,.3,1);
        }
        [x-cloak]{display:none!important}
        *,*::before,*::after{box-sizing:border-box}
        @keyframes fadeInUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
        @keyframes fadeIn{from{opacity:0}to{opacity:1}}
        @keyframes orbFloat1{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(20px,-15px) scale(1.05)}50%{transform:translate(-8px,12px) scale(.95)}75%{transform:translate(-18px,-8px) scale(1.02)}}
        @keyframes orbFloat2{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(-15px,18px) scale(.97)}50%{transform:translate(12px,-10px) scale(1.03)}75%{transform:translate(14px,8px) scale(.98)}}
        @keyframes orbFloat3{0%,100%{transform:translate(0,0)}33%{transform:translate(10px,-12px)}66%{transform:translate(-8px,6px)}}
        @keyframes dotPulse{0%,100%{opacity:.3}50%{opacity:1}}
        @keyframes meshMove{0%,100%{transform:translate(0,0) rotate(0deg)}25%{transform:translate(30px,-20px) rotate(2deg)}50%{transform:translate(-20px,30px) rotate(-1deg)}75%{transform:translate(15px,15px) rotate(1deg)}}
        @keyframes floatStat{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}
        @keyframes checkPop{0%{transform:scale(0) rotate(-45deg)}50%{transform:scale(1.2) rotate(0deg)}100%{transform:scale(1) rotate(0deg)}}
        @keyframes successRing{0%{transform:scale(.8);opacity:0}50%{transform:scale(1.05)}100%{transform:scale(1);opacity:1}}
        .a-fade-up{opacity:0;transform:translateY(24px);transition:all .7s var(--ease-out-expo)}
        .a-fade-up.v{opacity:1;transform:none}
        .d1{transition-delay:.05s}.d2{transition-delay:.1s}.d3{transition-delay:.15s}.d4{transition-delay:.2s}.d5{transition-delay:.25s}.d6{transition-delay:.3s}
        .mesh-bg{position:absolute;inset:0;overflow:hidden;pointer-events:none}
        .mesh-bg::before{content:'';position:absolute;width:140%;height:140%;top:-20%;left:-20%;background:conic-gradient(from 0deg at 50% 50%,#064e3b 0deg,#0a3040 60deg,#0c2d48 120deg,#064e3b 180deg,#052e22 240deg,#0f3423 300deg,#064e3b 360deg);animation:meshMove 30s ease-in-out infinite;opacity:.4}
        .noise-overlay{position:absolute;inset:0;opacity:.03;pointer-events:none;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");background-repeat:repeat;background-size:128px 128px}
        .dot-pattern{position:absolute;inset:0;background-image:radial-gradient(circle,rgba(255,255,255,.04) 1px,transparent 1px);background-size:20px 20px;pointer-events:none}
        .brand-orb{position:absolute;border-radius:50%;filter:blur(80px);pointer-events:none}
        .glass-dark{background:rgba(0,0,0,.2);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.08)}
        .card-auth{background:#fff;border:1px solid #f1f5f9;border-radius:24px;box-shadow:0 20px 60px rgba(0,0,0,.12),0 4px 12px rgba(0,0,0,.05)}
        .input-group{position:relative}
        .input-group input{width:100%;padding:14px 44px 14px 48px;font-size:14px;color:#0f172a;background:#fff;border:1.5px solid #e2e8f0;border-radius:24px;outline:none;transition:all .3s var(--ease-out-expo);font-family:inherit}
        .input-group input::placeholder{color:#94a3b8}
        .input-group input:focus{border-color:rgba(16,185,129,.6);box-shadow:0 0 0 4px rgba(16,185,129,.12)}
        .input-group .input-icon{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#94a3b8;transition:color .3s;pointer-events:none}
        .input-group input:focus ~ .input-icon{color:rgba(5,150,105,.9)}
        .input-group .input-action{position:absolute;right:12px;top:50%;transform:translateY(-50%);color:#94a3b8;cursor:pointer;transition:color .2s;padding:4px}
        .input-group .input-action:hover{color:#0f172a}
        .input-group.has-error input{border-color:rgba(239,68,68,.6);box-shadow:0 0 0 4px rgba(239,68,68,.1)}
        .input-group.has-success input{border-color:rgba(16,185,129,.5)}
        .input-group.has-question input{padding-right:150px}
        .input-group .input-question{position:absolute;right:14px;top:50%;transform:translateY(-50%);display:flex;align-items:center;gap:6px;cursor:pointer;color:#475569;font-size:14px;font-weight:800;letter-spacing:.04em;transition:color .2s;user-select:none;pointer-events:auto}
        .input-group .input-question:hover{color:#0f172a}
        .btn-primary{position:relative;display:inline-flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:14px 24px;font-size:14px;font-weight:700;color:#fff;background:var(--gradient-brand);border:none;border-radius:999px;cursor:pointer;transition:all .3s var(--ease-out-expo);overflow:hidden;box-shadow:0 8px 24px rgba(5,150,105,.3)}
        .btn-primary:hover{box-shadow:0 12px 32px rgba(5,150,105,.4);transform:translateY(-2px)}
        .btn-primary:active{transform:scale(.98);transition-duration:.1s}
        .btn-primary:disabled{opacity:.6;cursor:not-allowed;transform:none!important;box-shadow:0 4px 12px rgba(5,150,105,.15)!important}
        .btn-ghost{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:12px 20px;font-size:13px;font-weight:600;color:#475569;background:#fff;border:1.5px solid #e2e8f0;border-radius:999px;cursor:pointer;transition:all .3s var(--ease-out-expo)}
        .btn-ghost:hover{background:#f8fafc;color:#0f172a;border-color:#cbd5e1;transform:translateY(-1px)}
        .stat-pill{display:flex;align-items:center;gap:8px;padding:10px 14px;border-radius:14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.08);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);transition:all .3s var(--ease-out-expo)}
        .stat-pill:hover{background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.15);transform:translateY(-2px)}
        .wizard-step{display:none;animation:fadeInUp .5s var(--ease-out-expo)}
        .wizard-step.active{display:block}
        .stepper{display:flex;align-items:center;gap:0;padding:0 4px}
        .stepper-dot{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;transition:all .4s var(--ease-out-expo);flex-shrink:0;border:2px solid #e2e8f0;background:#f8fafc;color:#94a3b8;position:relative;z-index:2}
        .stepper-dot.done{border-color:var(--brand-500);background:var(--brand-500);color:#fff}
        .stepper-dot.active{border-color:var(--brand-500);background:#ecfdf5;color:var(--brand-600);box-shadow:0 0 0 4px rgba(16,185,129,.12)}
        .stepper-line{flex:1;height:2px;border-radius:1px;background:#e2e8f0;transition:background .5s var(--ease-out-expo);position:relative;z-index:1}
        .stepper-line.done{background:var(--brand-500)}
        .strength-bar{height:4px;border-radius:2px;background:#e2e8f0;overflow:hidden}
        .review-row{display:flex;align-items:start;justify-content:space-between;padding:12px 16px;border-bottom:1px solid #f1f5f9;gap:12px}
        .review-row:last-child{border-bottom:none}
        .review-label{font-size:12px;color:#94a3b8;flex-shrink:0}
        .review-value{font-size:13px;font-weight:600;color:#0f172a;text-align:right}
        ::-webkit-scrollbar{width:4px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:rgba(0,0,0,.15);border-radius:9999px}
    </style>
</head>
<body class="min-h-screen font-sans antialiased bg-slate-50 overflow-x-clip" x-data="authPage('{{ $mode }}', {{ $captcha[0] }}, {{ $captcha[1] }})" x-init="init()">

    <div class="min-h-screen lg:grid lg:grid-cols-[460px_1fr] xl:grid-cols-[520px_1fr]">

        {{-- LEFT PANEL: BRANDING (desktop) --}}
        <aside class="relative hidden lg:flex flex-col justify-between p-10 xl:p-12 overflow-hidden z-10" style="background:var(--gradient-hero);box-shadow:18px 0 40px -18px rgba(0,0,0,.35)">
            <div class="mesh-bg"></div>
            <div class="noise-overlay"></div>
            <div class="dot-pattern"></div>
            <div class="brand-orb w-[400px] h-[400px] bg-brand-500/15 -top-[120px] -left-[80px]" style="animation:orbFloat1 20s ease-in-out infinite"></div>
            <div class="brand-orb w-[300px] h-[300px] bg-cyan-500/10 bottom-[10%] -right-[80px]" style="animation:orbFloat2 25s ease-in-out infinite"></div>
            <div class="brand-orb w-[200px] h-[200px] bg-teal-500/10 top-[40%] left-[20%]" style="animation:orbFloat3 18s ease-in-out infinite"></div>

            <div class="relative z-10">
                <div class="a-fade-up flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-extrabold text-white tracking-tight">Pro<span class="text-brand-300">desa</span></h2>
                            <p class="text-[10px] text-white/40 font-semibold tracking-widest uppercase">Portal Desa Digital</p>
                        </div>
                    </div>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-white/50 hover:text-white transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        Beranda
                    </a>
                </div>
            </div>

            <div class="relative z-10 flex-1 flex flex-col items-center justify-center py-10">
                <div class="a-fade-up d2 w-full max-w-[300px] mb-8" style="animation:floatStat 6s ease-in-out infinite">
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
                    </svg>
                </div>
                <div class="text-center a-fade-up d3">
                    <h1 class="text-2xl xl:text-3xl font-extrabold text-white leading-tight tracking-tight">
                        Layanan Desa<br>
                        <span class="bg-gradient-to-r from-brand-300 via-teal-300 to-cyan-300 bg-clip-text text-transparent">Digital &amp; Modern</span>
                    </h1>
                    <p class="text-sm text-white/40 mt-3 max-w-[260px] mx-auto leading-relaxed">
                        Urus surat desa kapan saja, di mana saja. Cepat, mudah, dan transparan.
                    </p>
                </div>
            </div>

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
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-white/40 font-semibold uppercase tracking-wider">Keamanan Data</p>
                        <p class="text-sm font-bold text-white">Terenkripsi <span class="text-white/40 text-xs font-medium">AES-256</span></p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 mt-6 a-fade-up d5">
                <p class="text-[10px] text-white/20 text-center">&copy; {{ date('Y') }} {{ config('village.nama_desa') }}, {{ config('village.nama_kecamatan') }}, {{ config('village.nama_kabupaten') }}</p>
            </div>
        </aside>

        {{-- RIGHT PANEL: AUTH --}}
        <main class="relative flex flex-col min-h-screen">

            {{-- Mobile hero strip --}}
            <div class="lg:hidden relative overflow-hidden" style="background:var(--gradient-hero)">
                <div class="mesh-bg"></div>
                <div class="noise-overlay"></div>
                <div class="relative z-10 px-5 pt-5 pb-9">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/30">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            </div>
                            <div>
                                <h2 class="text-base font-extrabold text-white tracking-tight">Pro<span class="text-brand-300">desa</span></h2>
                                <p class="text-[8px] text-white/30 font-semibold tracking-widest uppercase">Portal Desa Digital</p>
                            </div>
                        </div>
                        <a href="{{ route('home') }}" class="glass-dark rounded-full px-3 py-1.5 inline-flex items-center gap-1.5 text-[10px] font-semibold text-white/50 hover:text-white transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            Beranda
                        </a>
                    </div>
                    <h1 class="text-xl font-extrabold text-white tracking-tight">Selamat Datang di <span class="bg-gradient-to-r from-brand-300 to-teal-300 bg-clip-text text-transparent">Prodesa</span></h1>
                    <p class="text-xs text-white/40 mt-1.5 max-w-[280px]">Akses layanan digital desa — cepat, mudah, dan transparan.</p>
                </div>
            </div>

            {{-- Form area --}}
            <div class="relative flex-1 flex items-center justify-center px-4 sm:px-6 py-8 lg:py-12">
                <div class="w-full max-w-[440px]">

                    {{-- Segmented toggle --}}
                    <div class="a-fade-up grid grid-cols-2 gap-1 p-1 rounded-2xl bg-slate-200/60 border border-slate-200 mb-6">
                        <button type="button" @click="mode = 'login'" :class="mode === 'login' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500 hover:text-slate-700'" class="rounded-xl py-2.5 text-sm font-bold transition-all duration-200">
                            Masuk
                        </button>
                        <button type="button" @click="mode = 'register'" :class="mode === 'register' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500 hover:text-slate-700'" class="rounded-xl py-2.5 text-sm font-bold transition-all duration-200">
                            Daftar
                        </button>
                    </div>

                    {{-- LOGIN FORM --}}
                    <div x-show="mode === 'login'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="card-auth p-6 sm:p-8 a-fade-up d1">
                            <div class="mb-6">
                                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Selamat Datang <span class="bg-gradient-to-r from-brand-600 to-teal-600 bg-clip-text text-transparent">Kembali</span></h1>
                                <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">Masuk untuk mengakses layanan digital {{ config('village.nama_desa') }}.</p>
                            </div>

                            @if (session('status'))
                            <div class="rounded-2xl p-4 mb-5 flex items-start gap-3 border border-brand-200 bg-brand-50">
                                <div class="w-9 h-9 rounded-xl bg-brand-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <p class="text-sm font-semibold text-brand-800">{{ session('status') }}</p>
                            </div>
                            @endif

                            <form id="loginForm" action="{{ route('login') }}" method="POST" @submit="submitting=true" class="space-y-5">
                                @csrf

                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-2 ml-1">NIK</label>
                                    <div class="input-group" :class="{ 'has-error': '{{ $errors->has('nik') }}', 'has-success': loginNikLen === 16 }">
                                        <input type="text" name="nik" id="login-nik" value="{{ old('nik') }}" required autofocus
                                            placeholder="16 digit NIK Anda"
                                            maxlength="16"
                                            inputmode="numeric"
                                            autocomplete="username"
                                            oninput="this.value=this.value.replace(/\D/g,'')"
                                            x-init="loginNikLen = $el.value.length"
                                            @input="loginNikLen = $el.value.length">
                                        <span class="input-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
                                        </span>
                                        <span class="input-action" x-show="loginNikLen === 16" x-cloak>
                                            <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </span>
                                    </div>
                                    @error('nik')
                                    <p class="text-xs text-red-500 mt-1.5 ml-1 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <div class="flex items-center justify-between mb-2 ml-1">
                                        <label class="block text-xs font-semibold text-slate-600">Password</label>
                                        <a href="{{ route('password.request') }}" class="text-[11px] font-semibold text-brand-600 hover:text-brand-700 transition-colors">Lupa password?</a>
                                    </div>
                                    <div class="input-group" :class="{ 'has-error': '{{ $errors->has('password') }}' }">
                                        <input :type="showPw ? 'text' : 'password'" name="password" placeholder="Masukkan password"
                                            required autocomplete="current-password">
                                        <span class="input-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                        </span>
                                        <span class="input-action" @click="showPw = !showPw">
                                            <template x-if="showPw">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                            </template>
                                            <template x-if="!showPw">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            </template>
                                        </span>
                                    </div>
                                    @error('password')
                                    <p class="text-xs text-red-500 mt-1.5 ml-1 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <div class="flex items-center justify-between mb-2 ml-1">
                                        <label class="block text-xs font-semibold text-slate-600">Captcha</label>
                                        <button type="button" @click="refreshCaptcha()" class="inline-flex items-center gap-1 text-[11px] font-semibold text-brand-600 hover:text-brand-700 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                                            Ganti soal
                                        </button>
                                    </div>
                                    <div class="input-group has-question">
                                        <input type="text" name="captcha" placeholder="Jawaban" required inputmode="numeric" maxlength="3"
                                            oninput="this.value=this.value.replace(/\D/g,'')">
                                        <span class="input-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 7.5C16.5 5.29 14.485 3.5 12 3.5S7.5 5.29 7.5 7.5c0 4-4.5 4.5-4.5 9 0 1.657 1.343 3 3 3h12c1.657 0 3-1.343 3-3 0-4.5-4.5-5-4.5-9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.5a2.5 2.5 0 002.5-2.5"/></svg>
                                        </span>
                                        <span class="input-question" @click="refreshCaptcha()" title="Klik untuk ganti soal">
                                            <span class="tabular-nums" x-text="captchaA"></span> + <span class="tabular-nums" x-text="captchaB"></span> = ?
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                                        </span>
                                    </div>
                                    @error('captcha')
                                    <p class="text-xs text-red-500 mt-1.5 ml-1 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if ($errors->any())
                                <div class="rounded-2xl border border-red-200 bg-red-50 p-4">
                                    <div class="flex items-start gap-2.5">
                                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                                        <div class="text-sm text-red-600 font-medium leading-relaxed">
                                            @foreach ($errors->all() as $e)
                                            <p>{{ $e }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <button type="submit" class="btn-primary" :disabled="submitting">
                                    <template x-if="submitting">
                                        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                                    </template>
                                    <template x-if="!submitting">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                                    </template>
                                    <span x-text="submitting ? 'Memproses...' : 'Masuk ke Akun'"></span>
                                </button>
                            </form>

                            {{-- Demo akun --}}
                            <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2.5">Akun Demo</p>
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-500 to-teal-600 flex items-center justify-center text-white font-extrabold text-xs flex-shrink-0">W</div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-slate-800 truncate">Warga Demo</p>
                                            <p class="text-[11px] text-slate-500 font-mono truncate">NIK 3216010101010001</p>
                                        </div>
                                    </div>
                                    <button type="button" @click="fillDemo()" class="btn-ghost shrink-0 !py-2 !px-3 text-[11px]">Isi Otomatis</button>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-2.5">Password: <span class="font-mono font-semibold">demo1234</span></p>
                            </div>

                            <p class="text-center text-sm text-slate-500 mt-6">
                                Belum punya akun?
                                <button type="button" @click="mode = 'register'" class="font-bold text-brand-600 hover:text-brand-700 transition-colors">Daftar sekarang</button>
                            </p>
                        </div>
                    </div>

                    {{-- REGISTER FORM (WIZARD) --}}
                    <div x-show="mode === 'register'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="card-auth p-6 sm:p-8 a-fade-up d1">
                            <div class="mb-6">
                                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Buat <span class="bg-gradient-to-r from-brand-600 to-teal-600 bg-clip-text text-transparent">Akun Warga</span></h1>
                                <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">Pendaftaran warga {{ config('village.nama_desa') }}. Isi data Anda untuk mulai mengurus surat secara online.</p>
                            </div>

                            @error('register_step')
                            <div class="rounded-2xl border border-red-200 bg-red-50 p-4 mb-5">
                                <p class="text-sm text-red-600 font-medium">{{ $message }}</p>
                            </div>
                            @enderror

                            {{-- Stepper --}}
                            <div class="stepper mb-8">
                                <template x-for="(label, i) in stepLabels" :key="i">
                                    <span class="contents">
                                        <template x-if="i > 0">
                                            <span class="stepper-line" :class="registerStep > i + 1 ? 'done' : ''"></span>
                                        </template>
                                        <span class="stepper-dot" :class="{ 'active': registerStep === i + 1, 'done': registerStep > i + 1 }">
                                            <template x-if="registerStep > i + 1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                            </template>
                                            <template x-if="registerStep <= i + 1">
                                                <span x-text="i + 1"></span>
                                            </template>
                                        </span>
                                    </span>
                                </template>
                            </div>
                            <p class="text-center text-[11px] text-slate-400 font-semibold mb-6" x-text="'Langkah ' + registerStep + ' dari ' + stepLabels.length + ' — ' + stepLabels[registerStep - 1]"></p>

                            <form id="registerForm" action="{{ route('register') }}" method="POST" @submit.prevent="submitRegister()" class="space-y-5">
                                @csrf

                                {{-- STEP 1: IDENTITAS --}}
                                <div class="wizard-step" :class="{ 'active': registerStep === 1 }">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Identitas Diri</p>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-2 ml-1">Nama Lengkap</label>
                                        <div class="input-group" :class="{ 'has-error': '{{ $errors->has('nama_lengkap') }}' }">
                                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Sesuai KTP" required autocomplete="name">
                                            <span class="input-icon">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                            </span>
                                        </div>
                                        @error('nama_lengkap')
                                        <p class="text-xs text-red-500 mt-1.5 ml-1 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-between mb-2 ml-1">
                                            <label class="block text-xs font-semibold text-slate-600">NIK</label>
                                            <span class="text-[11px] font-medium text-slate-400">16 digit</span>
                                        </div>
                                        <div class="input-group" :class="nikLen === 16 ? 'has-success' : (nikLen > 0 && nikLen !== 16 ? 'has-error' : '')">
                                            <input type="text" name="nik" value="{{ old('nik') }}" placeholder="Nomor Induk Kependudukan" required
                                                maxlength="16" inputmode="numeric"
                                                oninput="this.value=this.value.replace(/\D/g,'')"
                                                x-init="nikLen = $el.value.length"
                                                @input="nikLen = $el.value.length">
                                            <span class="input-icon">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
                                            </span>
                                        </div>
                                        @error('nik')
                                        <p class="text-xs text-red-500 mt-1.5 ml-1 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- STEP 2: ALAMAT --}}
                                <div class="wizard-step" :class="{ 'active': registerStep === 2 }">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Alamat &amp; Domisili</p>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-2 ml-1">Alamat Lengkap</label>
                                        <div class="input-group">
                                            <textarea name="alamat" rows="2" placeholder="Nama jalan, RT/RW, Dusun, Kecamatan" required class="w-full text-sm border-1.5 border-slate-200 rounded-2xl p-4 focus:outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition font-sans resize-none">{{ old('alamat') }}</textarea>
                                        </div>
                                        @error('alamat')
                                        <p class="text-xs text-red-500 mt-1.5 ml-1 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-2 ml-1">RT</label>
                                            <div class="input-group">
                                                <input type="text" name="rt" value="{{ old('rt') }}" placeholder="—" inputmode="numeric" maxlength="3" oninput="this.value=this.value.replace(/\D/g,'')">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-2 ml-1">RW</label>
                                            <div class="input-group">
                                                <input type="text" name="rw" value="{{ old('rw') }}" placeholder="—" inputmode="numeric" maxlength="3" oninput="this.value=this.value.replace(/\D/g,'')">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                            {{-- STEP 3: KONTAK --}}
                                <div class="wizard-step" :class="{ 'active': registerStep === 3 }">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Kontak</p>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-2 ml-1">No. WhatsApp</label>
                                        <div class="input-group" :class="{ 'has-error': '{{ $errors->has('no_hp') }}' }">
                                            <input type="tel" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" required autocomplete="tel">
                                            <span class="input-icon">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                                            </span>
                                        </div>
                                        @error('no_hp')
                                        <p class="text-xs text-red-500 mt-1.5 ml-1 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-2 ml-1">Email <span class="text-slate-400 font-normal">(opsional)</span></label>
                                        <div class="input-group">
                                            <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="email">
                                            <span class="input-icon">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- STEP 4: PASSWORD --}}
                                <div class="wizard-step" :class="{ 'active': registerStep === 4 }" x-data="{ pw: '', pwLen: 0, strength: 0, showPwC: false }">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Keamanan</p>
                                    <div>
                                        <div class="flex items-center justify-between mb-2 ml-1">
                                            <label class="block text-xs font-semibold text-slate-600">Password</label>
                                            <span class="text-[11px] font-medium text-slate-400">min. 8 karakter</span>
                                        </div>
                                        <div class="input-group" :class="{ 'has-error': '{{ $errors->has('password') }}' }">
                                            <input type="password" name="password" placeholder="Buat password kuat" required autocomplete="new-password"
                                                x-model="pw"
                                                @input="pwLen = $el.value.length; strength = calcStrength($el.value)">
                                            <span class="input-icon">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                            </span>
                                        </div>
                                        <div class="mt-2 flex items-center gap-2 px-1">
                                            <div class="strength-bar flex-1">
                                                <div class="h-full transition-all duration-500"
                                                    :style="{ width: (strength * 25) + '%' }"
                                                    :class="strength >= 4 ? 'bg-brand-500' : strength >= 3 ? 'bg-teal-500' : strength >= 2 ? 'bg-amber-500' : 'bg-red-400'"></div>
                                            </div>
                                            <span class="text-[11px] font-bold"
                                                :class="strength >= 4 ? 'text-brand-600' : strength >= 3 ? 'text-teal-600' : strength >= 2 ? 'text-amber-600' : 'text-red-500'"
                                                x-text="strength >= 4 ? 'Kuat' : strength === 3 ? 'Bagus' : strength === 2 ? 'Cukup' : strength === 1 ? 'Lemah' : ''"></span>
                                        </div>
                                        @error('password')
                                        <p class="text-xs text-red-500 mt-1.5 ml-1 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-2 ml-1">Konfirmasi Password</label>
                                        <div class="input-group">
                                            <input :type="showPwC ? 'text' : 'password'" name="password_confirmation" placeholder="Ulangi password" required autocomplete="new-password" x-model="pwC">
                                            <span class="input-icon">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                            </span>
                                            <span class="input-action" @click="showPwC = !showPwC">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- STEP 5: KONFIRMASI --}}
                                <div class="wizard-step" :class="{ 'active': registerStep === 5 }">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Konfirmasi &amp; Verifikasi</p>
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 overflow-hidden mb-5">
                                        <div class="review-row">
                                            <span class="review-label">Nama</span>
                                            <span class="review-value" x-text="getVal('nama_lengkap')"></span>
                                        </div>
                                        <div class="review-row">
                                            <span class="review-label">NIK</span>
                                            <span class="review-value font-mono" x-text="getVal('nik')"></span>
                                        </div>
                                        <div class="review-row">
                                            <span class="review-label">No. WhatsApp</span>
                                            <span class="review-value" x-text="getVal('no_hp')"></span>
                                        </div>
                                        <div class="review-row">
                                            <span class="review-label">Alamat</span>
                                            <span class="review-value" x-text="getVal('alamat')"></span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-between mb-2 ml-1">
                                            <label class="block text-xs font-semibold text-slate-600">Captcha</label>
                                            <button type="button" @click="refreshCaptcha()" class="inline-flex items-center gap-1 text-[11px] font-semibold text-brand-600 hover:text-brand-700 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                                                Ganti soal
                                            </button>
                                        </div>
                                        <div class="input-group has-question">
                                            <input type="text" name="captcha" placeholder="Jawaban" required inputmode="numeric" maxlength="3"
                                                oninput="this.value=this.value.replace(/\D/g,'')">
                                            <span class="input-icon">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 7.5C16.5 5.29 14.485 3.5 12 3.5S7.5 5.29 7.5 7.5c0 4-4.5 4.5-4.5 9 0 1.657 1.343 3 3 3h12c1.657 0 3-1.343 3-3 0-4.5-4.5-5-4.5-9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.5a2.5 2.5 0 002.5-2.5"/></svg>
                                            </span>
                                            <span class="input-question" @click="refreshCaptcha()" title="Klik untuk ganti soal">
                                                <span class="tabular-nums" x-text="captchaA"></span> + <span class="tabular-nums" x-text="captchaB"></span> = ?
                                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                                            </span>
                                        </div>
                                        @error('captcha')
                                        <p class="text-xs text-red-500 mt-1.5 ml-1 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 cursor-pointer">
                                        <input type="checkbox" name="confirmed" @change="confirmed = $el.checked" class="w-4 h-4 mt-0.5 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                        <span class="text-xs text-slate-500 leading-relaxed">Saya menyatakan data di atas benar dan bersedia mempertanggungjawabkan. Dengan mendaftar, saya setuju dengan <span class="font-semibold text-slate-700">Ketentuan Layanan</span> Prodesa.</span>
                                    </label>
                                    @error('confirmed')
                                    <p class="text-xs text-red-500 mt-1.5 ml-1 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Nav buttons --}}
                                <div class="flex items-center gap-3 pt-1">
                                    <button type="button" @click="prevStep()" x-show="registerStep > 1" class="btn-ghost !w-auto px-5" :disabled="submitting">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                                        Kembali
                                    </button>
                                    <button type="button" @click="nextStep()" x-show="registerStep < 5" class="btn-primary">
                                        Lanjut
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                    </button>
                                    <button type="submit" x-show="registerStep === 5" class="btn-primary" :disabled="submitting || !confirmed">
                                        <template x-if="submitting">
                                            <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                                        </template>
                                        <template x-if="!submitting">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </template>
                                        <span x-text="submitting ? 'Mendaftarkan...' : 'Daftar Sekarang'"></span>
                                    </button>
                                </div>
                            </form>

                            <p class="text-center text-sm text-slate-500 mt-6">
                                Sudah punya akun?
                                <button type="button" @click="mode = 'login'" class="font-bold text-brand-600 hover:text-brand-700 transition-colors">Masuk di sini</button>
                            </p>
                        </div>
                    </div>

                    {{-- Benefit strip under card --}}
                    <div class="grid grid-cols-3 gap-3 mt-6 a-fade-up d2">
                        <div class="flex items-center gap-2.5 rounded-2xl border border-slate-200 bg-white p-3">
                            <div class="w-9 h-9 rounded-xl bg-brand-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                            </div>
                            <p class="text-[11px] font-bold text-slate-700 leading-tight">Proses Cepat<br><span class="font-medium text-slate-400">Workflow digital</span></p>
                        </div>
                        <div class="flex items-center gap-2.5 rounded-2xl border border-slate-200 bg-white p-3">
                            <div class="w-9 h-9 rounded-xl bg-teal-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            </div>
                            <p class="text-[11px] font-bold text-slate-700 leading-tight">Aman &amp; Legal<br><span class="font-medium text-slate-400">Verifikasi QR</span></p>
                        </div>
                        <div class="flex items-center gap-2.5 rounded-2xl border border-slate-200 bg-white p-3">
                            <div class="w-9 h-9 rounded-xl bg-cyan-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                            </div>
                            <p class="text-[11px] font-bold text-slate-700 leading-tight">24/7 Akses<br><span class="font-medium text-slate-400">Pantau realtime</span></p>
                        </div>
                    </div>

                    <p class="text-center text-[11px] text-slate-400 mt-6 a-fade-up d3">
                        Dengan menggunakan Prodesa, Anda menyetujui Ketentuan Layanan &amp; Kebijakan Privasi
                    </p>
                </div>
            </div>
        </main>
    </div>

    {{-- SUCCESS OVERLAY --}}
    <div x-show="showSuccess" x-cloak x-transition.opacity.duration.300ms class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(2,6,23,.6);backdrop-filter:blur(6px)">
        <div class="card-auth w-full max-w-[380px] p-8 text-center" style="animation:successRing .5s var(--ease-out-expo)">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-brand-500 flex items-center justify-center shadow-xl shadow-brand-500/30" style="animation:checkPop .6s var(--ease-out-expo) .15s both">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            </div>
            <h2 class="text-xl font-extrabold text-slate-900 mt-5">Pendaftaran Berhasil!</h2>
            <p class="text-sm text-slate-500 mt-2 leading-relaxed">Akun Anda telah dibuat. Silakan masuk menggunakan NIK dan password Anda.</p>
            <button type="button" @click="finishRegister()" class="btn-primary mt-6">Lanjut ke Masuk</button>
        </div>
    </div>

    <script>
        function authPage(initialMode, capA, capB) {
            return {
                mode: initialMode,
                captchaA: capA,
                captchaB: capB,
                submitting: false,
                showPw: false,
                loginNikLen: 0,
                nikLen: 0,
                showSuccess: false,
                registerStep: 1,
                confirmed: false,
                totalSteps: 5,
                stepLabels: ['Identitas', 'Alamat', 'Kontak', 'Keamanan', 'Konfirmasi'],

                init() {
                    const els = document.querySelectorAll('.a-fade-up');
                    const io = new IntersectionObserver((entries) => {
                        entries.forEach((e) => {
                            if (e.isIntersecting) {
                                e.target.classList.add('v');
                                io.unobserve(e.target);
                            }
                        });
                    }, { threshold: 0.1 });
                    els.forEach((el) => io.observe(el));
                },

                async refreshCaptcha() {
                    try {
                        const res = await fetch('{{ route('captcha.refresh') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });
                        if (res.ok) {
                            const data = await res.json();
                            this.captchaA = data[0];
                            this.captchaB = data[1];
                        }
                    } catch (err) {}
                },

                fillDemo() {
                    const f = document.getElementById('loginForm');
                    f.elements['nik'].value = '3216010101010001';
                    f.elements['password'].value = 'demo1234';
                    this.loginNikLen = 16;
                },

                getVal(key) {
                    const f = document.getElementById('registerForm');
                    return f && f.elements[key] ? f.elements[key].value : '';
                },

                calcStrength(pw) {
                    if (!pw) return 0;
                    let score = 0;
                    if (pw.length >= 8) score++;
                    if (pw.length >= 12) score++;
                    if (/[A-Z]/.test(pw) && /[a-z]/.test(pw)) score++;
                    if (/\d/.test(pw) && /[^A-Za-z0-9]/.test(pw)) score++;
                    return score;
                },

                validateCurrentStep() {
                    const form = document.getElementById('registerForm');
                    const step = form.querySelector('.wizard-step.active');
                    if (!step) return true;
                    const inputs = step.querySelectorAll('input[required], textarea[required]');
                    for (const el of inputs) {
                        if (!el.value.trim()) {
                            el.focus();
                            return false;
                        }
                    }
                    const nik = form.elements['nik'].value;
                    if (this.registerStep === 1 && nik && nik.length !== 16) {
                        form.elements['nik'].focus();
                        return false;
                    }
                    return true;
                },

                nextStep() {
                    if (this.registerStep >= this.totalSteps) return;
                    if (!this.validateCurrentStep()) return;
                    this.registerStep++;
                },

                prevStep() {
                    if (this.registerStep > 1) this.registerStep--;
                },

                submitRegister() {
                    if (!this.confirmed) return;
                    const form = document.getElementById('registerForm');
                    if (!form.checkValidity()) {
                        form.reportValidity();
                        return;
                    }
                    this.submitting = true;
                    this.showSuccess = true;
                    setTimeout(() => form.submit(), 1200);
                },

                finishRegister() {
                    this.showSuccess = false;
                    this.mode = 'login';
                }
            };
        }
    </script>
</body>
</html>
