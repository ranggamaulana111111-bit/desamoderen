<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perbaiki Pengajuan — {{ config('village.nama_desa', 'Prodesa') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config={theme:{extend:{colors:{brand:{50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b',950:'#022c22'},navy:{800:'#1e293b',900:'#0f172a',950:'#020617'}}}}}
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
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
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
        @keyframes dotPulse{0%,100%{opacity:.4}50%{opacity:1}}
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

        .bento-card{border-radius:20px;background:white;box-shadow:var(--shadow-card);transition:all .4s var(--ease-out-expo);overflow:hidden}.bento-card:hover{box-shadow:var(--shadow-hover);transform:translateY(-3px)}

        .field-group{position:relative;margin-bottom:0}
        .field-group label{display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;transition:color .2s}
        .field-group label .required{color:#ef4444;margin-left:2px}
        .field-group input,.field-group select,.field-group textarea{width:100%;border:1.5px solid #e2e8f0;border-radius:14px;padding:12px 16px;font-size:14px;color:#1e293b;background:white;transition:all .3s var(--ease-out-expo);outline:none;font-family:inherit}
        .field-group input:focus,.field-group select:focus,.field-group textarea:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px rgba(16,185,129,.12)}
        .field-group input::placeholder,.field-group textarea::placeholder{color:#94a3b8}
        .field-group textarea{resize:vertical;min-height:100px}
        .field-group select{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;background-size:18px;padding-right:40px}
        .field-group .error-text{font-size:12px;color:#ef4444;margin-top:4px;font-weight:500;display:none}
        .field-group.has-error input,.field-group.has-error select,.field-group.has-error textarea{border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.1)}
        .field-group.has-error .error-text{display:block}

        .upload-zone{border:2px dashed #d1d5db;border-radius:20px;padding:32px 24px;text-align:center;transition:all .3s var(--ease-out-expo);cursor:pointer;background:rgba(0,0,0,.01)}
        .upload-zone:hover{border-color:var(--brand-400);background:rgba(16,185,129,.03)}
        .upload-zone.dragover{border-color:var(--brand-500);background:rgba(16,185,129,.06);box-shadow:0 0 0 4px rgba(16,185,129,.1)}

        .chat-bubble{max-width:82%;padding:12px 16px;border-radius:18px;font-size:14px;line-height:1.5;animation:slideUp .3s ease}.chat-user{background:var(--gradient-brand);color:white;border-bottom-right-radius:4px}.chat-bot{background:#f1f5f9;color:#334155;border-bottom-left-radius:4px}.typing-dot{width:6px;height:6px;border-radius:50%;background:#94a3b8;animation:dotPulse 1.4s ease-in-out infinite}.typing-dot:nth-child(2){animation-delay:.2s}.typing-dot:nth-child(3){animation-delay:.4s}

        .scroll-progress{position:fixed;top:0;left:0;height:3px;background:var(--gradient-brand);z-index:9999;transition:width .1s linear}

        ::-webkit-scrollbar{width:6px;height:6px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:3px}::-webkit-scrollbar-thumb:hover{background:#94a3b8}
    </style>
    @include('components.design-tokens')
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="editForm()">
    <div class="scroll-progress" id="scrollProgress" style="width:0%"></div>

    {{-- FLOATING NAV --}}
    <nav class="fixed top-3 left-1/2 -translate-x-1/2 z-40 a-fade-up" x-data="{ scrolled:false }" x-init="window.addEventListener('scroll',()=>{scrolled=window.scrollY>20})">
        <div :class="scrolled ? 'glass-light shadow-lg' : 'bg-white/70 backdrop-blur-md'" class="rounded-2xl px-3 py-2 flex items-center gap-2.5 transition-all duration-500 border border-white/40">
            <a href="{{ route('warga.surat.show', $pengajuan) }}" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-brand-50 flex items-center justify-center transition-colors group">
                <svg class="w-4 h-4 text-slate-400 group-hover:text-brand-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div class="w-px h-5 bg-slate-200"></div>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <span class="text-sm font-bold text-slate-800 hidden sm:block">Perbaiki Pengajuan</span>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <div class="relative overflow-hidden" style="background:linear-gradient(160deg,#0a1a12 0%,#1a1a08 20%,#2d1f0a 40%,#0a3040 65%,#0c2d48 85%,#0f172a 100%)">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-amber-500/8 rounded-full blur-3xl" style="animation:orbFloat1 20s ease-in-out infinite"></div>
            <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-orange-500/8 rounded-full blur-3xl" style="animation:orbFloat2 25s ease-in-out infinite"></div>
            <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(255,255,255,.03) 1px,transparent 1px);background-size:24px 24px"></div>
        </div>
        <div class="relative max-w-3xl mx-auto px-4 pt-24 pb-8 md:pt-28 md:pb-10">
            <div class="a-fade-up">
                <div class="inline-flex items-center gap-2 glass-dark rounded-full px-3.5 py-1.5 mb-3">
                    <svg class="w-3.5 h-3.5 text-amber-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span class="text-[11px] font-semibold text-amber-200/80">Revisi Diperlukan</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight leading-tight">Perbaiki <span class="text-amber-300">{{ $config->label ?? str_replace('_', ' ', $pengajuan->jenis_surat) }}</span></h1>
                <p class="text-sm text-white/40 mt-2">Perbarui data yang diperlukan dan kirim ulang pengajuan.</p>
            </div>
        </div>
    </div>

    {{-- MAIN --}}
    <main class="max-w-3xl mx-auto px-4 -mt-4 relative z-10 pb-28 md:pb-16">

        {{-- REVISION ALERT --}}
        @if ($revisionNotes && $revisionNotes->catatan)
        <div class="rounded-2xl p-5 mb-6 border border-amber-200/60 bg-gradient-to-r from-amber-50/80 to-orange-50/60 backdrop-blur-sm a-fade-up d2" style="animation:successPop .5s var(--ease-out-expo)">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-amber-800">Catatan dari Petugas</p>
                    <p class="text-xs text-amber-700 mt-1.5 bg-white/60 rounded-xl px-3 py-2 border border-amber-200/40 leading-relaxed">{{ $revisionNotes->catatan }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- ERRORS --}}
        @if ($errors->any())
        <div class="rounded-2xl p-4 mb-5 border border-red-200/60 bg-red-50/80 backdrop-blur-sm a-fade-up d2" style="animation:successPop .5s var(--ease-out-expo)">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-red-800">Terdapat kesalahan pada pengisian form</p>
                    <ul class="mt-1.5 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li class="text-xs text-red-600">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        {{-- FORM --}}
        <form method="POST" action="{{ route('warga.surat.updateAfterRevision', $pengajuan) }}" enctype="multipart/form-data" id="editForm" class="space-y-5">
            @csrf
            @method('PATCH')

            {{-- FIELDS --}}
            @if ($config)
            <div class="bento-card p-5 md:p-7 a-fade-up d3">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Data Pengajuan</h2>
                        <p class="text-xs text-slate-400">Perbarui data sesuai catatan petugas</p>
                    </div>
                </div>

                @php $dt = $pengajuan->data_tambahan ?? []; @endphp
                <div class="space-y-4">
                    @foreach ($config->fields ?? [] as $field)
                        @php
                            $hasError = $errors->has($field['key']);
                            $isRequired = $field['required'] ?? false;
                            $options = isset($field['options']) ? explode(',', $field['options']) : [];
                        @endphp
                        <div class="field-group {{ $hasError ? 'has-error' : '' }}">
                            <label for="{{ $field['key'] }}">
                                {{ $field['label'] }}
                                @if($isRequired)<span class="required">*</span>@endif
                            </label>

                            @if ($field['type'] === 'select')
                                <select name="{{ $field['key'] }}" id="{{ $field['key'] }}" @if($isRequired) required @endif>
                                    <option value="">Pilih {{ $field['label'] }}</option>
                                    @foreach($options as $opt)
                                        <option value="{{ trim($opt) }}" {{ old($field['key'], $dt[$field['key']] ?? '') === trim($opt) ? 'selected' : '' }}>{{ trim($opt) }}</option>
                                    @endforeach
                                </select>
                            @elseif ($field['type'] === 'textarea')
                                <textarea name="{{ $field['key'] }}" id="{{ $field['key'] }}" rows="3" placeholder="Masukkan {{ strtolower($field['label']) }}" @if($isRequired) required @endif>{{ old($field['key'], $dt[$field['key']] ?? '') }}</textarea>
                            @elseif ($field['type'] === 'date')
                                <input type="date" name="{{ $field['key'] }}" id="{{ $field['key'] }}" value="{{ old($field['key'], $dt[$field['key']] ?? '') }}" @if($isRequired) required @endif>
                            @elseif ($field['type'] === 'time')
                                <input type="time" name="{{ $field['key'] }}" id="{{ $field['key'] }}" value="{{ old($field['key'], $dt[$field['key']] ?? '') }}" @if($isRequired) required @endif>
                            @elseif ($field['type'] === 'number')
                                <input type="number" name="{{ $field['key'] }}" id="{{ $field['key'] }}" value="{{ old($field['key'], $dt[$field['key']] ?? '') }}" placeholder="Masukkan {{ strtolower($field['label']) }}" @if($isRequired) required @endif>
                            @else
                                <input type="text" name="{{ $field['key'] }}" id="{{ $field['key'] }}" value="{{ old($field['key'], $dt[$field['key']] ?? '') }}" placeholder="Masukkan {{ strtolower($field['label']) }}" @if($isRequired) required @endif>
                            @endif

                            @if($hasError)
                                <p class="error-text" style="display:block">{{ $errors->first($field['key']) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- LAMPIRAN --}}
            <div class="bento-card p-5 md:p-7 a-fade-up d4">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Unggah Lampiran</h2>
                        <p class="text-xs text-slate-400">Biarkan kosong jika tidak ingin mengganti file</p>
                    </div>
                </div>

                @if($errors->has('lampiran'))
                <div class="rounded-xl p-3 mb-4 bg-red-50 border border-red-200/60 flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span class="text-xs text-red-600 font-semibold">{{ $errors->first('lampiran') }}</span>
                </div>
                @endif

                @php $hasExistingFile = isset($dt['lampiran']); @endphp
                <div x-show="!fileName" class="upload-zone"
                     @click="$refs.fileInput.click()"
                     @dragover.prevent="dragover = true"
                     @dragleave.prevent="dragover = false"
                     @drop.prevent="handleDrop($event)"
                     :class="{ 'dragover': dragover }">
                    @if($hasExistingFile)
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-700">Ganti Lampiran</p>
                    <p class="text-xs text-slate-400 mt-1">Klik atau seret file baru untuk mengganti</p>
                    @else
                    <div class="w-12 h-12 rounded-2xl bg-brand-50 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-700">Seret & lepas file di sini</p>
                    <p class="text-xs text-slate-400 mt-1">atau <span class="text-brand-600 font-semibold">klik untuk memilih</span></p>
                    @endif
                    <p class="text-[10px] text-slate-400 mt-2">PDF, JPG, JPEG, PNG &middot; Maks 2MB</p>
                </div>

                <input type="file" name="lampiran" id="lampiran" x-ref="fileInput" class="hidden"
                       accept=".pdf,.jpg,.jpeg,.png"
                       @change="handleSelect($event)">

                <div x-show="fileName" x-cloak class="rounded-2xl border border-slate-200 bg-white p-4">
                    <div class="flex items-start gap-4">
                        <template x-if="fileType === 'image'">
                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0 border border-slate-200">
                                <img :src="filePreview" alt="Preview" class="w-full h-full object-cover">
                            </div>
                        </template>
                        <template x-if="fileType === 'pdf'">
                            <div class="w-16 h-16 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0 border border-red-200/60">
                                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </div>
                        </template>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate" x-text="fileName"></p>
                            <p class="text-xs text-slate-400 mt-0.5" x-text="fileSize"></p>
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-full border border-brand-100 mt-2">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Siap diunggah
                            </span>
                        </div>
                        <button type="button" @click="removeFile()" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-red-50 flex items-center justify-center transition group flex-shrink-0">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-red-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <button type="button" @click="$refs.fileInput.click()" class="mt-3 text-xs font-semibold text-brand-600 hover:text-brand-700 transition">Ganti file lain</button>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="flex items-center gap-3 a-fade-up d5">
                <a href="{{ route('warga.surat.show', $pengajuan) }}" class="btn-ghost interact">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    Batal
                </a>
                <button type="submit" class="btn-primary flex-1 interact" :disabled="submitting" :class="submitting ? 'opacity-50 cursor-not-allowed !transform-none !shadow-md' : ''">
                    <template x-if="!submitting">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Kirim Ulang Pengajuan
                        </span>
                    </template>
                    <template x-if="submitting">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            Mengirim...
                        </span>
                    </template>
                </button>
            </div>
        </form>

        {{-- TIPS --}}
        <div class="mt-8 rounded-2xl p-5 border border-slate-100 bg-white a-fade-up d6" style="box-shadow:var(--shadow-card)">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-1 h-4 rounded-full bg-gradient-to-b from-amber-400 to-orange-400"></div>
                <h3 class="text-xs font-bold text-slate-800 tracking-wide uppercase">Tips Perbaikan</h3>
            </div>
            <div class="space-y-2.5">
                <div class="flex items-start gap-2.5">
                    <div class="w-6 h-6 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-[11px] text-slate-600 leading-relaxed">Baca catatan petugas dengan teliti sebelum memperbaiki data.</p>
                </div>
                <div class="flex items-start gap-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-[11px] text-slate-600 leading-relaxed">Pastikan semua kolom wajib (<span class="text-red-500">*</span>) sudah terisi dengan benar.</p>
                </div>
                <div class="flex items-start gap-2.5">
                    <div class="w-6 h-6 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-[11px] text-slate-600 leading-relaxed">Jika lampiran tidak perlu diganti, biarkan kolom file kosong.</p>
                </div>
            </div>
        </div>

    </main>

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
        function editForm(){return{
            submitting:false,dragover:false,fileName:'',fileSize:'',fileType:'',filePreview:null,
            init(){
                window.addEventListener('scroll',()=>{const b=document.getElementById('scrollProgress');if(b){const h=document.documentElement.scrollHeight-window.innerHeight;b.style.width=(window.scrollY/h*100)+'%'}});
                this.initReveal();
            },
            handleSelect(e){const file=e.target.files[0];if(file)this.setFile(file)},
            handleDrop(e){this.dragover=false;const file=e.dataTransfer.files[0];if(file)this.setFile(file)},
            setFile(file){
                const allowed=['application/pdf','image/jpeg','image/png'];
                if(!allowed.includes(file.type)){alert('Format file tidak didukung. Gunakan PDF, JPG, atau PNG.');return}
                if(file.size>2*1024*1024){alert('Ukuran file maksimal 2MB.');return}
                this.fileName=file.name;this.fileSize=this.formatSize(file.size);
                this.fileType=file.type==='application/pdf'?'pdf':'image';
                if(this.fileType==='image'){const r=new FileReader();r.onload=e=>{this.filePreview=e.target.result};r.readAsDataURL(file)}else{this.filePreview=null}
            },
            removeFile(){this.fileName='';this.fileSize='';this.fileType='';this.filePreview=null;const inp=this.$refs.fileInput||document.querySelector('[x-ref=fileInput]');if(inp)inp.value=''},
            formatSize(bytes){if(bytes===0)return'0 B';const k=1024,s=['B','KB','MB','GB'];const i=Math.floor(Math.log(bytes)/Math.log(k));return parseFloat((bytes/Math.pow(k,i)).toFixed(1))+' '+s[i]},
            initReveal(){const o=new IntersectionObserver(e=>{e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('v');o.unobserve(x.target)}})},{threshold:.08,rootMargin:'0px 0px -30px 0px'});document.querySelectorAll('.a-fade-up,.a-fade-in,.a-slide-l,.a-slide-r,.a-scale').forEach(e=>o.observe(e))}
        }}
    </script>
</body>
</html>
