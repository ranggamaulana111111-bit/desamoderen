<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pengajuan — {{ config('village.nama_desa', 'Prodesa') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config={theme:{extend:{colors:{brand:{50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b',950:'#022c22'},navy:{800:'#1e293b',900:'#0f172a',950:'#020617'}}}}}
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @include('components.favicon')
    @include('components.fonts')
    <style>
        :root{--brand-50:#ecfdf5;--brand-100:#d1fae5;--brand-200:#a7f3d0;--brand-300:#6ee7b7;--brand-400:#34d399;--brand-500:#10b981;--brand-600:#059669;--brand-700:#047857;--brand-800:#065f46;--brand-900:#064e3b;--teal-500:#14b8a6;--teal-600:#0d9488;--cyan-500:#06b6d4;--cyan-600:#0891b2;--navy-800:#1e293b;--navy-900:#0f172a;--shadow-soft:0 4px 24px -4px rgba(0,0,0,.08);--shadow-elevated:0 20px 60px rgba(0,0,0,.12),0 4px 12px rgba(0,0,0,.06);--shadow-card:0 1px 3px rgba(0,0,0,.04),0 8px 24px rgba(0,0,0,.06);--shadow-hover:0 12px 40px rgba(0,0,0,.1),0 4px 12px rgba(0,0,0,.05);--gradient-brand:linear-gradient(135deg,#059669,#0891b2);--gradient-hero:linear-gradient(160deg,#0a1a12 0%,#0d2818 20%,#0f3423 40%,#0a3040 65%,#0c2d48 85%,#0f172a 100%);--ease-out-expo:cubic-bezier(.16,1,.3,1)}
        [x-cloak]{display:none!important}*,*::before,*::after{box-sizing:border-box}
        @keyframes fadeInUp{from{opacity:0;transform:translateY(28px)}to{opacity:1;transform:translateY(0)}}
        @keyframes fadeIn{from{opacity:0}to{opacity:1}}
        @keyframes slideUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
        @keyframes scaleIn{from{opacity:0;transform:scale(.92)}to{opacity:1;transform:scale(1)}}
        @keyframes orbFloat1{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(30px,-20px) scale(1.05)}50%{transform:translate(-10px,15px) scale(.95)}75%{transform:translate(-25px,-10px) scale(1.02)}}
        @keyframes orbFloat2{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(-20px,25px) scale(.97)}50%{transform:translate(15px,-15px) scale(1.03)}75%{transform:translate(20px,10px) scale(.98)}}
        @keyframes successPop{0%{transform:scale(.9);opacity:0}50%{transform:scale(1.02)}100%{transform:scale(1);opacity:1}}
        @keyframes progressPulse{0%,100%{box-shadow:0 0 0 0 rgba(16,185,129,.4)}50%{box-shadow:0 0 0 6px rgba(16,185,129,0)}}
        @keyframes dotPulse{0%,100%{opacity:.4}50%{opacity:1}}
        @keyframes checkBounce{0%{transform:scale(0)}50%{transform:scale(1.2)}100%{transform:scale(1)}}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
        @keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}

        .a-fade-up{opacity:0;transform:translateY(28px);transition:all .7s var(--ease-out-expo)}.a-fade-up.v{opacity:1;transform:none}
        .a-fade-in{opacity:0;transition:opacity .7s ease}.a-fade-in.v{opacity:1}
        .a-scale{opacity:0;transform:scale(.92);transition:all .6s var(--ease-out-expo)}.a-scale.v{opacity:1;transform:none}
        .a-slide-l{opacity:0;transform:translateX(-20px);transition:all .6s var(--ease-out-expo)}.a-slide-l.v{opacity:1;transform:none}
        .a-slide-r{opacity:0;transform:translateX(20px);transition:all .6s var(--ease-out-expo)}.a-slide-r.v{opacity:1;transform:none}
        .d1{transition-delay:.05s}.d2{transition-delay:.1s}.d3{transition-delay:.15s}.d4{transition-delay:.2s}.d5{transition-delay:.25s}.d6{transition-delay:.3s}.d7{transition-delay:.35s}.d8{transition-delay:.4s}

        .glass{background:rgba(255,255,255,.06);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.1)}
        .glass-dark{background:rgba(0,0,0,.2);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.08)}
        .glass-light{background:rgba(255,255,255,.82);backdrop-filter:blur(32px) saturate(200%);-webkit-backdrop-filter:blur(32px) saturate(200%);border:1px solid rgba(255,255,255,.5)}

        .interact{transition:all .3s var(--ease-out-expo);cursor:pointer}.interact:hover{transform:translateY(-2px)}.interact:active{transform:scale(.97);transition-duration:.1s}
        .btn-primary{position:relative;display:inline-flex;align-items:center;justify-content:center;gap:8px;background:var(--gradient-brand);color:white;font-weight:600;font-size:14px;padding:12px 24px;border-radius:16px;box-shadow:0 8px 24px rgba(5,150,105,.25);transition:all .3s var(--ease-out-expo);overflow:hidden}.btn-primary:hover{box-shadow:0 12px 32px rgba(5,150,105,.35);transform:translateY(-2px)}.btn-primary:active{transform:scale(.97);transition-duration:.1s}.btn-primary::after{content:'';position:absolute;inset:0;background:linear-gradient(rgba(255,255,255,.2),transparent);opacity:0;transition:opacity .3s}.btn-primary:hover::after{opacity:1}
        .btn-ghost{display:inline-flex;align-items:center;justify-content:center;gap:6px;background:rgba(0,0,0,.04);color:#475569;font-weight:600;font-size:13px;padding:10px 18px;border-radius:14px;transition:all .25s ease;border:1px solid transparent}.btn-ghost:hover{background:rgba(0,0,0,.07);color:#1e293b;transform:translateY(-1px)}.btn-ghost:active{transform:scale(.97);transition-duration:.1s}
        .btn-amber{display:inline-flex;align-items:center;justify-content:center;gap:6px;background:#fffbeb;color:#d97706;font-weight:600;font-size:13px;padding:10px 18px;border-radius:14px;transition:all .25s ease;border:1px solid #fde68a}.btn-amber:hover{background:#fef3c7;transform:translateY(-1px)}.btn-amber:active{transform:scale(.97);transition-duration:.1s}
        .btn-danger{display:inline-flex;align-items:center;justify-content:center;gap:6px;background:#fef2f2;color:#dc2626;font-weight:600;font-size:13px;padding:10px 18px;border-radius:14px;transition:all .25s ease;border:1px solid #fecaca}.btn-danger:hover{background:#fee2e2;transform:translateY(-1px)}.btn-danger:active{transform:scale(.97);transition-duration:.1s}

        .bento-card{border-radius:20px;background:white;box-shadow:var(--shadow-card);transition:all .4s var(--ease-out-expo);overflow:hidden}.bento-card:hover{box-shadow:var(--shadow-hover);transform:translateY(-3px)}

        .step-dot{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;transition:all .4s var(--ease-out-expo);flex-shrink:0;border:2.5px solid #e2e8f0;background:white;color:#94a3b8;position:relative;z-index:2}
        .step-dot.done{border-color:var(--brand-500);background:var(--brand-500);color:white}
        .step-dot.done svg{animation:checkBounce .4s var(--ease-out-expo)}
        .step-dot.active{border-color:var(--brand-500);background:white;color:var(--brand-600);animation:progressPulse 2s ease-in-out infinite}
        .step-dot.rejected{border-color:#ef4444;background:#ef4444;color:white}
        .step-dot.revision{border-color:#f59e0b;background:#f59e0b;color:white}
        .step-line{flex:1;height:3px;border-radius:2px;background:#e5e7eb;transition:background .5s var(--ease-out-expo);position:relative;z-index:1}
        .step-line.done{background:var(--brand-500)}
        .step-line.partial{background:linear-gradient(90deg,var(--brand-500),#e5e7eb)}

        .timeline-item{position:relative;padding-left:32px;padding-bottom:24px}.timeline-item::before{content:'';position:absolute;left:7px;top:24px;bottom:0;width:2px;background:linear-gradient(to bottom,#e2e8f0,transparent)}.timeline-item:last-child::before{display:none}
        .timeline-dot{position:absolute;left:0;top:4px;width:16px;height:16px;border-radius:50%;border:2.5px solid;background:white;display:flex;align-items:center;justify-content:center}
        .timeline-dot.t-submitted{border-color:#14b8a6}.timeline-dot.t-verified{border-color:#6366f1}.timeline-dot.t-approved_operator{border-color:#06b6d4}.timeline-dot.t-approved_sekdes{border-color:#8b5cf6}.timeline-dot.t-approved_kades{border-color:var(--brand-500)}.timeline-dot.t-completed{border-color:var(--brand-500);background:var(--brand-500)}.timeline-dot.t-rejected{border-color:#ef4444}.timeline-dot.t-revision{border-color:#f59e0b}

        .chat-bubble{max-width:82%;padding:12px 16px;border-radius:18px;font-size:14px;line-height:1.5;animation:slideUp .3s ease}.chat-user{background:var(--gradient-brand);color:white;border-bottom-right-radius:4px}.chat-bot{background:#f1f5f9;color:#334155;border-bottom-left-radius:4px}.typing-dot{width:6px;height:6px;border-radius:50%;background:#94a3b8;animation:dotPulse 1.4s ease-in-out infinite}.typing-dot:nth-child(2){animation-delay:.2s}.typing-dot:nth-child(3){animation-delay:.4s}

        .scroll-progress{position:fixed;top:0;left:0;height:3px;background:var(--gradient-brand);z-index:9999;transition:width .1s linear}

        ::-webkit-scrollbar{width:6px;height:6px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:3px}::-webkit-scrollbar-thumb:hover{background:#94a3b8}
    </style>
    @include('components.design-tokens')
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="scroll-progress" id="scrollProgress" style="width:0%"></div>

    {{-- FLOATING NAV --}}
    <nav class="fixed top-3 left-1/2 -translate-x-1/2 z-40 a-fade-up" x-data="{ scrolled:false }" x-init="window.addEventListener('scroll',()=>{scrolled=window.scrollY>20})">
        <div :class="scrolled ? 'glass-light shadow-lg' : 'bg-white/70 backdrop-blur-md'" class="rounded-2xl px-3 py-2 flex items-center gap-2.5 transition-all duration-500 border border-white/40">
            <a href="{{ route('warga.surat.index') }}" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-brand-50 flex items-center justify-center transition-colors group">
                <svg class="w-4 h-4 text-slate-400 group-hover:text-brand-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div class="w-px h-5 bg-slate-200"></div>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <span class="text-sm font-bold text-slate-800 hidden sm:block">Detail Pengajuan</span>
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
        <div class="relative max-w-4xl mx-auto px-4 pt-24 pb-8 md:pt-28 md:pb-10">
            <div class="a-fade-up">
                <div class="inline-flex items-center gap-2 glass-dark rounded-full px-3.5 py-1.5 mb-3">
                    <svg class="w-3.5 h-3.5 text-brand-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="text-[11px] font-semibold text-brand-200/80">Detail Pengajuan</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight leading-tight capitalize">{{ str_replace('_', ' ', $pengajuan->jenis_surat) }}</h1>
                <div class="flex flex-wrap items-center gap-2 mt-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                        {{ match($pengajuan->status) {
                            'submitted' => 'bg-teal-500/20 text-teal-300 border border-teal-400/30',
                            'verified' => 'bg-cyan-500/20 text-cyan-300 border border-cyan-400/30',
                            'approved_operator' => 'bg-cyan-500/20 text-cyan-300 border border-cyan-400/30',
                            'approved_sekdes' => 'bg-purple-500/20 text-purple-300 border border-purple-400/30',
                            'approved_kades' => 'bg-brand-500/20 text-brand-300 border border-brand-400/30',
                            'completed' => 'bg-emerald-500/20 text-emerald-300 border border-emerald-400/30',
                            'revision' => 'bg-amber-500/20 text-amber-300 border border-amber-400/30',
                            'rejected' => 'bg-red-500/20 text-red-300 border border-red-400/30',
                            default => 'bg-white/10 text-white/60 border border-white/20',
                        } }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ in_array($pengajuan->status, ['completed']) ? 'bg-emerald-400' : 'bg-current animate-pulse' }}"></span>
                        {{ $pengajuan->status_label }}
                    </span>
                    @if($pengajuan->nomor_surat)
                    <span class="glass-dark rounded-full px-3 py-1 flex items-center gap-1.5">
                        <svg class="w-3 h-3 text-cyan-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 20h10a2 2 0 002-2V8a2 2 0 00-2-2h-2.28a1 1 0 01-.707-.293l-2.414-2.414a1 1 0 00-.707-.293H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span class="text-[10px] font-semibold text-brand-200/80">{{ $pengajuan->nomor_surat }}</span>
                    </span>
                    @endif
                    <span class="glass-dark rounded-full px-3 py-1 flex items-center gap-1.5">
                        <svg class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-[10px] font-semibold text-brand-200/80">{{ $pengajuan->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN --}}
    <main class="max-w-4xl mx-auto px-4 -mt-4 relative z-10 pb-28 md:pb-16">

        {{-- FLASH --}}
        @if (session('success'))
        <div class="rounded-2xl p-4 mb-5 flex items-center gap-3 border border-green-200/60 bg-green-50/80 backdrop-blur-sm a-scale" style="animation:successPop .5s var(--ease-out-expo)">
            <div class="w-9 h-9 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-sm font-semibold text-green-800">{{ session('success') }}</span>
        </div>
        @endif

        {{-- WORKFLOW STEPPER --}}
        <div class="glass-light rounded-2xl p-5 mb-6 shadow-lg a-fade-up d2">
            <div class="flex items-center gap-0">
                @foreach ($stepProgress as $i => $step)
                    @php $statusColor = match($step['status']) {
                        'completed' => 'done',
                        'active' => 'active',
                        'rejected' => 'rejected',
                        default => ''
                    }; @endphp
                    <div class="step-dot {{ $statusColor }}">
                        @if ($step['status'] === 'completed')
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        @else
                            {{ $i + 1 }}
                        @endif
                    </div>
                    @if ($i < count($stepProgress) - 1)
                        <div class="step-line {{ $step['status'] === 'completed' ? 'done' : '' }} {{ ($step['status'] === 'active' && isset($stepProgress[$i+1]) && $stepProgress[$i+1]['status'] === 'completed') ? 'partial' : '' }}"></div>
                    @endif
                @endforeach
            </div>
            <div class="hidden md:flex items-center justify-between mt-2 px-1">
                @foreach ($stepProgress as $i => $step)
                    <span class="text-[10px] font-semibold text-center transition-colors duration-300
                        {{ $step['status'] === 'completed' ? 'text-brand-600' : ($step['status'] === 'active' ? 'text-brand-600 font-bold' : 'text-slate-400') }}"
                        style="width:{{ 100 / count($stepProgress) }}%">{{ $step['label'] }}</span>
                @endforeach
            </div>
        </div>

        {{-- DETAIL INFO --}}
        <div class="bento-card p-5 md:p-7 mb-6 a-fade-up d3">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Informasi Pengajuan</h2>
                    <p class="text-xs text-slate-400">Data lengkap pengajuan surat Anda</p>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-100 divide-y divide-slate-50">
                <div class="flex items-center justify-between px-4 py-3">
                    <span class="text-xs text-slate-400 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Jenis Surat
                    </span>
                    <span class="text-sm font-semibold text-slate-800 capitalize">{{ str_replace('_', ' ', $pengajuan->jenis_surat) }}</span>
                </div>
                @if($pengajuan->nomor_surat)
                <div class="flex items-center justify-between px-4 py-3">
                    <span class="text-xs text-slate-400 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 20h10a2 2 0 002-2V8a2 2 0 00-2-2h-2.28a1 1 0 01-.707-.293l-2.414-2.414a1 1 0 00-.707-.293H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Nomor Surat
                    </span>
                    <span class="text-sm font-semibold text-slate-800">{{ $pengajuan->nomor_surat }}</span>
                </div>
                @endif
                <div class="flex items-center justify-between px-4 py-3">
                    <span class="text-xs text-slate-400 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Tanggal Pengajuan
                    </span>
                    <span class="text-sm font-semibold text-slate-800">{{ $pengajuan->created_at->locale('id')->translatedFormat('d F Y, H:i') }}</span>
                </div>
                <div class="flex items-center justify-between px-4 py-3">
                    <span class="text-xs text-slate-400 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Terakhir Diperbarui
                    </span>
                    <span class="text-sm font-semibold text-slate-800">{{ $pengajuan->updated_at->locale('id')->translatedFormat('d F Y, H:i') }}</span>
                </div>
                @if($config)
                <div class="flex items-center justify-between px-4 py-3">
                    <span class="text-xs text-slate-400 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Kode Klasifikasi
                    </span>
                    <span class="text-sm font-semibold text-slate-800">{{ $config->kode_klasifikasi }}</span>
                </div>
                @endif
            </div>

            {{-- SUBMITTED DATA --}}
            @php $dt = $pengajuan->data_tambahan ?? []; @endphp
            @if (!empty(array_filter($dt, fn($v, $k) => $k !== 'lampiran' && !is_array($v), ARRAY_FILTER_USE_BOTH)))
            <div class="mt-5">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-teal-500"></div>
                    Data yang Disubmit
                </h3>
                <div class="rounded-2xl border border-slate-100 divide-y divide-slate-50">
                    @foreach ($dt as $key => $val)
                        @if ($key !== 'lampiran' && !is_array($val))
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="text-xs text-slate-400 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                            <span class="text-sm font-semibold text-slate-800 text-right max-w-[60%] truncate">{{ $val ?: '-' }}</span>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- REVISION ALERT --}}
        @if ($pengajuan->status === 'revision')
        <div class="rounded-2xl p-5 mb-6 border border-amber-200/60 bg-gradient-to-r from-amber-50/80 to-orange-50/60 backdrop-blur-sm a-fade-up d4" style="animation:successPop .5s var(--ease-out-expo)">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-amber-800">Pengajuan Memerlukan Perbaikan</p>
                    <p class="text-xs text-amber-600 mt-1">Silakan perbaiki data sesuai catatan dari petugas, lalu kirim ulang.</p>
                    <a href="{{ route('warga.surat.edit', $pengajuan) }}"
                        class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-amber-800 bg-amber-100 hover:bg-amber-200 px-4 py-2.5 rounded-xl transition interact">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Perbaiki &amp; Kirim Ulang
                    </a>
                </div>
            </div>
        </div>
        @endif

        {{-- REJECTED ALERT --}}
        @if ($pengajuan->status === 'rejected')
        <div class="rounded-2xl p-5 mb-6 border border-red-200/60 bg-gradient-to-r from-red-50/80 to-rose-50/60 backdrop-blur-sm a-fade-up d4" style="animation:successPop .5s var(--ease-out-expo)">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-2xl bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-red-800">Pengajuan Ditolak</p>
                    @if($pengajuan->catatan_admin)
                    <p class="text-xs text-red-600 mt-1 bg-white/60 rounded-xl px-3 py-2 border border-red-200/40">{{ $pengajuan->catatan_admin }}</p>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- TIMELINE --}}
        <div class="bento-card p-5 md:p-7 mb-6 a-fade-up d5">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-cyan-400 to-purple-500 flex items-center justify-center shadow-lg shadow-cyan-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Riwayat Proses</h2>
                    <p class="text-xs text-slate-400">Alur persetujuan pengajuan surat</p>
                </div>
            </div>

            @if ($timeline->count())
                <div class="space-y-0">
                    @foreach ($timeline as $idx => $log)
                        <div class="timeline-item t-{{ $log->status }}">
                            <div class="timeline-dot t-{{ $log->status }}"></div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold
                                    {{ match($log->status) {
                                        'submitted' => 'bg-teal-50 text-teal-700 border border-teal-200/60',
                                        'verified' => 'bg-cyan-50 text-cyan-700 border border-cyan-200/60',
                                        'approved_operator' => 'bg-cyan-50 text-cyan-700 border border-cyan-200/60',
                                        'approved_sekdes' => 'bg-purple-50 text-purple-700 border border-purple-200/60',
                                        'approved_kades' => 'bg-brand-50 text-brand-700 border border-brand-200/60',
                                        'completed' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/60',
                                        'rejected' => 'bg-red-50 text-red-600 border border-red-200/60',
                                        'revision' => 'bg-amber-50 text-amber-700 border border-amber-200/60',
                                        default => 'bg-slate-50 text-slate-600 border border-slate-200',
                                    } }}">
                                    {{ $log->label }}
                                </span>
                                <span class="text-[11px] text-slate-400">oleh {{ $log->user->name ?? 'Sistem' }}</span>
                            </div>
                            @if ($log->catatan)
                                <div class="mt-1.5 text-xs text-slate-600 bg-slate-50 rounded-xl px-3 py-2 border border-slate-100">{{ $log->catatan }}</div>
                            @endif
                            <div class="text-[10px] text-slate-400 mt-1">{{ $log->created_at->locale('id')->translatedFormat('d F Y, H:i:s') }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-600">Belum ada riwayat proses</p>
                    <p class="text-xs text-slate-400 mt-1">Riwayat akan muncul setelah pengajuan diproses</p>
                </div>
            @endif
        </div>

        {{-- ACTIONS --}}
        <div class="flex flex-wrap items-center gap-3 a-fade-up d6">
            @if ($pengajuan->status === 'revision')
                <a href="{{ route('warga.surat.edit', $pengajuan) }}" class="btn-amber interact">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Perbaiki &amp; Kirim Ulang
                </a>
            @endif

            @if ($pengajuan->status === 'completed')
                <a href="{{ route('warga.surat.cetak', $pengajuan) }}" target="_blank" class="btn-primary interact">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak PDF Surat
                </a>
                @if (!empty($pengajuan->qr_verifikasi_svg))
                    <button x-data="{ showQr:false }" @click="showQr=true" class="btn-ghost interact">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        QR Verifikasi
                    </button>
                    <template x-teleport="body">
                        <div x-show="showQr" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showQr=false"></div>
                            <div class="relative bg-white rounded-3xl shadow-2xl p-6 w-80 text-center" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center mx-auto mb-3 shadow-lg shadow-brand-500/20"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></div>
                                <h3 class="font-bold text-slate-900">QR Verifikasi</h3><p class="text-xs text-slate-400 mt-1">Scan untuk verifikasi keaslian surat</p>
                                <div class="mt-4 flex justify-center"><img src="data:image/svg+xml;base64,{{ base64_encode($pengajuan->qr_verifikasi_svg) }}" alt="QR Verifikasi" class="w-40 h-40"></div>
                                <button @click="showQr=false" class="mt-4 w-full text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 px-4 py-2.5 rounded-2xl transition">Tutup</button>
                            </div>
                        </div>
                    </template>
                @endif
            @endif

            @if ($pengajuan->status === 'submitted')
                <form method="POST" action="{{ route('warga.surat.destroy', $pengajuan) }}" onsubmit="return confirm('Batalkan pengajuan ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger interact">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Batalkan Pengajuan
                    </button>
                </form>
            @endif

            <a href="{{ route('warga.surat.index') }}" class="btn-ghost interact ml-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Riwayat
            </a>
        </div>

    </main>

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
                    <button type="submit" class="w-10 h-10 rounded-full bg-[#10b981] text-white flex items-center justify-center shadow-md shadow-emerald-500/20 hover:bg-[#059669] transition-all disabled:opacity-50" :disabled="!input.trim()||sending"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg></button>
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
                <a href="{{ route('warga.surat.create', $pengajuan->jenis_surat) }}" class="flex flex-col items-center gap-0.5 py-2 rounded-xl text-slate-400 hover:text-brand-600 transition">
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
        function aiChat(){return{
            open:false,input:'',sending:false,messages:[{text:'Halo! Saya Asisten Prodesa. Ada yang bisa saya bantu?',isUser:false}],prompts:['Cara ajukan surat','Syarat SKTM','Jam pelayanan','Cetak surat'],
            async send(t){const q=t||this.input.trim();if(!q)return;this.input='';this.messages.push({text:q,isUser:true});this.sending=true;this.$nextTick(()=>{this.$refs.chatBox.scrollTop=this.$refs.chatBox.scrollHeight});try{const r=await fetch('{{route("faq.ask")}}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{csrf_token()}}'},body:JSON.stringify({question:q})});const d=await r.json();this.messages.push({text:d.answer||'Maaf, saya tidak bisa menjawab.',isUser:false})}catch{this.messages.push({text:'Terjadi kesalahan. Coba lagi.',isUser:false})}this.sending=false;this.$nextTick(()=>{this.$refs.chatBox.scrollTop=this.$refs.chatBox.scrollHeight})}
        }}
        document.addEventListener('DOMContentLoaded',()=>{
            window.addEventListener('scroll',()=>{const b=document.getElementById('scrollProgress');if(b){const h=document.documentElement.scrollHeight-window.innerHeight;b.style.width=(window.scrollY/h*100)+'%'}});
            const obs=new IntersectionObserver(e=>{e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('v');obs.unobserve(x.target)}})},{threshold:.08,rootMargin:'0px 0px -30px 0px'});
            document.querySelectorAll('.a-fade-up,.a-fade-in,.a-slide-l,.a-slide-r,.a-scale').forEach(e=>obs.observe(e));
        });
    </script>
</body>
</html>
