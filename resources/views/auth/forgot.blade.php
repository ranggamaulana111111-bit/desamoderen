<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password - {{ config('village.nama_desa', 'Prodesa') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                colors: {
                    brand: { 50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b',950:'#022c22' }
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
            --gradient-brand: linear-gradient(135deg,#059669,#0891b2);
            --gradient-hero: linear-gradient(160deg,#0a1a12 0%,#0d2818 20%,#0f3423 40%,#0a3040 65%,#0c2d48 85%,#0f172a 100%);
            --ease-out-expo: cubic-bezier(.16,1,.3,1);
        }
        [x-cloak]{display:none!important}
        *,*::before,*::after{box-sizing:border-box}
        @keyframes fadeInUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
        @keyframes meshMove{0%,100%{transform:translate(0,0) rotate(0deg)}25%{transform:translate(30px,-20px) rotate(2deg)}50%{transform:translate(-20px,30px) rotate(-1deg)}75%{transform:translate(15px,15px) rotate(1deg)}}
        @keyframes orbFloat1{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(20px,-15px) scale(1.05)}50%{transform:translate(-8px,12px) scale(.95)}75%{transform:translate(-18px,-8px) scale(1.02)}}
        @keyframes orbFloat2{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(-15px,18px) scale(.97)}50%{transform:translate(12px,-10px) scale(1.03)}75%{transform:translate(14px,8px) scale(.98)}}
        .a-fade-up{opacity:0;transform:translateY(24px);transition:all .7s var(--ease-out-expo)}
        .a-fade-up.v{opacity:1;transform:none}
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
        .input-group.has-error input{border-color:rgba(239,68,68,.6);box-shadow:0 0 0 4px rgba(239,68,68,.1)}
        .input-group.has-question input{padding-right:150px}
        .input-group .input-question{position:absolute;right:14px;top:50%;transform:translateY(-50%);display:flex;align-items:center;gap:6px;cursor:pointer;color:#475569;font-size:14px;font-weight:800;letter-spacing:.04em;transition:color .2s;user-select:none;pointer-events:auto}
        .input-group .input-question:hover{color:#0f172a}
        .btn-primary{position:relative;display:inline-flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:14px 24px;font-size:14px;font-weight:700;color:#fff;background:var(--gradient-brand);border:none;border-radius:999px;cursor:pointer;transition:all .3s var(--ease-out-expo);overflow:hidden;box-shadow:0 8px 24px rgba(5,150,105,.3)}
        .btn-primary:hover{box-shadow:0 12px 32px rgba(5,150,105,.4);transform:translateY(-2px)}
        .btn-primary:disabled{opacity:.6;cursor:not-allowed;transform:none!important}
        .btn-ghost{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:12px 20px;font-size:13px;font-weight:600;color:#475569;background:#fff;border:1.5px solid #e2e8f0;border-radius:999px;cursor:pointer;transition:all .3s var(--ease-out-expo)}
        .btn-ghost:hover{background:#f8fafc;color:#0f172a;border-color:#cbd5e1;transform:translateY(-1px)}
        ::-webkit-scrollbar{width:4px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:rgba(0,0,0,.15);border-radius:9999px}
    </style>
</head>
<body class="min-h-screen font-sans antialiased bg-slate-50 overflow-x-clip" x-data="{ submitting: false, showPw: false, captchaA: {{ $captcha[0] }}, captchaB: {{ $captcha[1] }} }">

    <div class="min-h-screen lg:grid lg:grid-cols-[460px_1fr] xl:grid-cols-[520px_1fr]">

        {{-- LEFT PANEL (desktop) --}}
        <aside class="relative hidden lg:flex flex-col justify-between p-10 xl:p-12 overflow-hidden" style="background:var(--gradient-hero)">
            <div class="mesh-bg"></div>
            <div class="noise-overlay"></div>
            <div class="dot-pattern"></div>
            <div class="brand-orb w-[400px] h-[400px] bg-brand-500/15 -top-[120px] -left-[80px]" style="animation:orbFloat1 20s ease-in-out infinite"></div>
            <div class="brand-orb w-[300px] h-[300px] bg-cyan-500/10 bottom-[10%] -right-[80px]" style="animation:orbFloat2 25s ease-in-out infinite"></div>

            <div class="relative z-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold text-white tracking-tight">Pro<span class="text-brand-300">desa</span></h2>
                        <p class="text-[10px] text-white/40 font-semibold tracking-widest uppercase">Portal Desa Digital</p>
                    </div>
                </a>
            </div>

            <div class="relative z-10 flex-1 flex flex-col items-center justify-center text-center">
                <div class="a-fade-up mb-6">
                    <div class="w-20 h-20 mx-auto rounded-3xl bg-gradient-to-br from-brand-500/20 to-cyan-500/20 border border-white/10 flex items-center justify-center" style="animation:floatStat 5s ease-in-out infinite">
                        <svg class="w-9 h-9 text-brand-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/></svg>
                    </div>
                </div>
                <div class="a-fade-up d2">
                    <h1 class="text-2xl xl:text-3xl font-extrabold text-white leading-tight tracking-tight">
                        Atur Ulang<br>
                        <span class="bg-gradient-to-r from-brand-300 via-teal-300 to-cyan-300 bg-clip-text text-transparent">Password Anda</span>
                    </h1>
                    <p class="text-sm text-white/40 mt-3 max-w-[260px] mx-auto leading-relaxed">
                        Verifikasi NIK dan nomor HP terdaftar untuk membuat password baru.
                    </p>
                </div>
            </div>

            <div class="relative z-10 a-fade-up d3">
                <p class="text-[10px] text-white/20 text-center">&copy; {{ date('Y') }} {{ config('village.nama_desa') }}, {{ config('village.nama_kecamatan') }}, {{ config('village.nama_kabupaten') }}</p>
            </div>
        </aside>

        {{-- RIGHT PANEL --}}
        <main class="relative flex flex-col min-h-screen">

            {{-- Mobile hero strip --}}
            <div class="lg:hidden relative overflow-hidden" style="background:var(--gradient-hero)">
                <div class="mesh-bg"></div>
                <div class="noise-overlay"></div>
                <div class="relative z-10 px-5 pt-5 pb-9">
                    <div class="flex items-center justify-between mb-6">
                        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/30">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            </div>
                            <div>
                                <h2 class="text-base font-extrabold text-white tracking-tight">Pro<span class="text-brand-300">desa</span></h2>
                                <p class="text-[8px] text-white/30 font-semibold tracking-widest uppercase">Portal Desa Digital</p>
                            </div>
                        </a>
                    </div>
                    <h1 class="text-xl font-extrabold text-white tracking-tight">Lupa <span class="bg-gradient-to-r from-brand-300 to-teal-300 bg-clip-text text-transparent">Password</span></h1>
                    <p class="text-xs text-white/40 mt-1.5 max-w-[280px]">Verifikasi NIK dan nomor HP terdaftar untuk membuat password baru.</p>
                </div>
            </div>

            {{-- Form area --}}
            <div class="relative flex-1 flex items-center justify-center px-4 sm:px-6 py-8 lg:py-12">
                <div class="w-full max-w-[440px]">
                    <div class="card-auth p-6 sm:p-8 a-fade-up">
                        <div class="mb-6">
                            <div class="flex items-center gap-3 mb-5">
                                <a href="{{ route('login') }}" class="w-10 h-10 rounded-xl border border-slate-200 bg-white flex items-center justify-center text-slate-500 hover:text-slate-800 hover:border-slate-300 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                                </a>
                                <div>
                                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Atur Ulang <span class="bg-gradient-to-r from-brand-600 to-teal-600 bg-clip-text text-transparent">Password</span></h1>
                                    <p class="text-sm text-slate-500 mt-1 leading-relaxed">Masukkan NIK dan nomor HP yang terdaftar di sistem.</p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('password.forgot') }}" method="POST" @submit="submitting=true" class="space-y-5">
                            @csrf

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2 ml-1">NIK</label>
                                <div class="input-group" :class="{ 'has-error': '{{ $errors->has('nik') }}' }">
                                    <input type="text" name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK Anda" required autofocus
                                        maxlength="16" inputmode="numeric" autocomplete="username"
                                        oninput="this.value=this.value.replace(/\D/g,'')">
                                    <span class="input-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
                                    </span>
                                </div>
                                @error('nik')
                                <p class="text-xs text-red-500 mt-1.5 ml-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2 ml-1">No. HP Terdaftar</label>
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
                                <label class="block text-xs font-semibold text-slate-600 mb-2 ml-1">Password Baru</label>
                                <div class="input-group" :class="{ 'has-error': '{{ $errors->has('password') }}' }">
                                    <input :type="showPw ? 'text' : 'password'" name="password" placeholder="Minimal 6 karakter" required autocomplete="new-password">
                                    <span class="input-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                    </span>
                                    <span class="input-action" @click="showPw = !showPw">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </span>
                                </div>
                                @error('password')
                                <p class="text-xs text-red-500 mt-1.5 ml-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2 ml-1">Konfirmasi Password Baru</label>
                                <div class="input-group" :class="{ 'has-error': '{{ $errors->has('password') }}' }">
                                    <input type="password" name="password_confirmation" placeholder="Ulangi password baru" required autocomplete="new-password">
                                    <span class="input-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                    </span>
                                </div>
                            </div>

                            @if($captchaMode === 'turnstile')
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2 ml-1">Verifikasi Keamanan</label>
                                <div class="flex justify-center rounded-2xl border border-slate-200 bg-white p-4">
                                    <div class="cf-turnstile" data-sitekey="{{ config('village.integrasi_turnstile_site_key') }}"></div>
                                </div>
                                @error('cf-turnstile-response')
                                <p class="text-xs text-red-500 mt-1.5 ml-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            @elseif($captchaMode === 'recaptcha')
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2 ml-1">Verifikasi Keamanan</label>
                                <div class="flex justify-center rounded-2xl border border-slate-200 bg-white p-4">
                                    <div class="g-recaptcha" data-sitekey="{{ config('village.integrasi_recaptcha_key') }}"></div>
                                </div>
                                @error('g-recaptcha-response')
                                <p class="text-xs text-red-500 mt-1.5 ml-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            @elseif($captchaMode === 'math')
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
                            @endif

                            <button type="submit" class="btn-primary" :disabled="submitting">
                                <template x-if="submitting">
                                    <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                                </template>
                                <template x-if="!submitting">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                                </template>
                                <span x-text="submitting ? 'Menyimpan...' : 'Reset Password'"></span>
                            </button>
                        </form>

                        <p class="text-center text-sm text-slate-500 mt-6">
                            Ingat password?
                            <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:text-brand-700 transition-colors">Kembali ke Masuk</a>
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
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
        });

        function refreshCaptcha() {
            fetch('{{ route('captcha.refresh') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                const scope = Alpine.$data(document.body);
                scope.captchaA = data[0];
                scope.captchaB = data[1];
            })
            .catch(() => {});
        }
    </script>
    @if($captchaMode === 'recaptcha')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @elseif($captchaMode === 'turnstile')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endif
</body>
</html>
