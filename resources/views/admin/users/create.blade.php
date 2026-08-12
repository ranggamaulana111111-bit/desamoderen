@php
    $editUser = $user ?? null;
    $editRole = $editUser ? ($editUser->roles->first()->name ?? '') : '';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@if($editUser) Edit Pengguna @else Tambah Pengguna @endif — {{ config('village.nama_desa', 'Prodesa') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b' },
                        sidebar: '#1e3a5f', 'sidebar-hover': '#2a4a7f',
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @include('components.favicon')
    @include('components.fonts')
    <style>
        :root { --ease-out-expo:cubic-bezier(.16,1,.3,1); }
        [x-cloak]{display:none!important}
        @keyframes fadeInUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
        @keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
        @keyframes orbFloat{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(15px,-10px) scale(1.03)}}
        @keyframes pulseDot{0%,100%{opacity:1}50%{opacity:.5}}
        @keyframes slideRight{from{transform:scaleX(0)}to{transform:scaleX(1)}}
        @keyframes strengthFill{from{width:0}to{width:var(--target-width)}}
        @keyframes checkPop{0%{transform:scale(0)}50%{transform:scale(1.2)}100%{transform:scale(1)}}
        @keyframes ripple{to{transform:scale(4);opacity:0}}

        .reveal{opacity:0;transform:translateY(16px);transition:all .5s var(--ease-out-expo)}.reveal.v{opacity:1;transform:none}
        .reveal-d1{transition-delay:.08s}.reveal-d2{transition-delay:.16s}.reveal-d3{transition-delay:.24s}.reveal-d4{transition-delay:.32s}.reveal-d5{transition-delay:.4s}

        .form-input{width:100%;border:1.5px solid #e2e8f0;border-radius:12px;padding:10px 14px;font-size:14px;color:#1e293b;background:#f8fafc;outline:none;transition:all .2s ease}
        .form-input:focus{border-color:#10b981;background:white;box-shadow:0 0 0 3px rgba(16,185,129,.1)}
        .form-input::placeholder{color:#94a3b8}

        .card-surface{background:white;border:1px solid rgba(0,0,0,.04);border-radius:16px;box-shadow:0 1px 3px rgba(0,0,0,.04),0 4px 12px rgba(0,0,0,.03);transition:all .25s var(--ease-out-expo)}
        .card-surface:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}

        .role-card{border:2px solid #e2e8f0;border-radius:14px;padding:14px;cursor:pointer;transition:all .2s var(--ease-out-expo);position:relative;overflow:hidden;background:white}
        .role-card:hover{border-color:#a7f3d0;transform:translateY(-1px);box-shadow:0 4px 12px rgba(16,185,129,.08)}
        .role-card.selected{border-color:#10b981;background:linear-gradient(135deg,rgba(16,185,129,.03),rgba(20,184,166,.02));box-shadow:0 0 0 3px rgba(16,185,129,.1)}
        .role-card.selected::after{content:'';position:absolute;top:8px;right:8px;width:20px;height:20px;border-radius:50%;background:#10b981;display:flex;align-items:center;justify-content:center;animation:checkPop .3s var(--ease-out-expo)}

        .btn-submit{position:relative;overflow:hidden;background:linear-gradient(135deg,#059669,#0891b2);color:white;font-weight:600;font-size:14px;padding:14px 28px;border-radius:14px;box-shadow:0 8px 24px rgba(5,150,105,.25);transition:all .25s var(--ease-out-expo);cursor:pointer;border:none;width:100%}
        .btn-submit:hover{box-shadow:0 12px 32px rgba(5,150,105,.35);transform:translateY(-2px)}
        .btn-submit:active{transform:scale(.98);transition-duration:.1s}

        .strength-bar{height:4px;border-radius:9999px;transition:all .4s var(--ease-out-expo)}

        ::-webkit-scrollbar{width:4px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:9999px}
    </style>
    @include('components.design-tokens')
</head>
<body class="bg-[#f0f0eb] font-sans antialiased text-slate-700 overflow-x-clip"
      style="background-image:radial-gradient(ellipse 80% 50% at 20% 0%,rgba(16,185,129,.04),transparent),radial-gradient(ellipse 60% 40% at 80% 100%,rgba(99,102,241,.03),transparent)">

    @include('admin.components.sidebar')

    <main class="flex-1 overflow-y-auto pt-16 md:pt-0 min-h-screen">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="max-w-[1400px] mx-auto" x-data="userForm()" x-init="init()">

                {{-- ═══ HERO HEADER ═══ --}}
                <div class="reveal mb-6">
                    <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-[#061a10] via-[#0c3521] to-[#0a7e6a] p-6 sm:p-8 text-white" style="box-shadow:0 20px 50px -12px rgba(6,78,59,.3)">
                        <div class="absolute inset-0 overflow-hidden pointer-events-none">
                            <div class="absolute -top-16 -right-16 w-60 h-60 bg-white/[.03] rounded-full" style="animation:orbFloat 12s ease-in-out infinite"></div>
                            <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-emerald-400/[.04] rounded-full" style="animation:orbFloat 14s ease-in-out infinite reverse"></div>
                            <div class="absolute inset-0" style="background-image:radial-gradient(rgba(255,255,255,.03) 1px,transparent 1px);background-size:20px 20px"></div>
                        </div>
                        <div class="relative">
                            {{-- Breadcrumb --}}
                            <div class="flex items-center gap-1.5 text-emerald-200/60 text-[11px] font-medium mb-3">
                                <a href="{{ route('admin.users.index') }}" class="hover:text-white transition-colors">Pengguna</a>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                                <span class="text-emerald-100">{{ isset($user) ? 'Edit Pengguna' : 'Tambah Baru' }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div>
                                    <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight">{{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h1>
                                    <p class="text-emerald-200/70 text-sm mt-1">{{ isset($user) ? 'Perbarui data pengguna di dalam sistem Prodesa' : 'Daftarkan pengguna baru ke dalam sistem Prodesa' }}</p>
                                </div>
                                <a href="{{ route('admin.users.index') }}"
                                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white/10 backdrop-blur-sm text-xs font-semibold hover:bg-white/20 transition-all border border-white/10 self-start">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ═══ TWO-COLUMN LAYOUT ═══ --}}
                <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                    @csrf
                    @if(isset($user)) @method('PUT') @endif

                    {{-- ── LEFT: FORM COLUMNS (7 cols) ── --}}
                    <div class="lg:col-span-7 space-y-5">

                        {{-- CARD: Informasi Akun --}}
                        <div class="card-surface p-5 sm:p-6 reveal reveal-d1">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100/60">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-sm font-bold text-gray-900">Informasi Akun</h2>
                                    <p class="text-[11px] text-gray-400">Data login pengguna</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                                    <input type="text" name="name" x-model="form.name" required
                                           class="form-input" placeholder="Masukkan nama lengkap" value="{{ old('name', $user->name ?? '') }}">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Email Address</label>
                                    <input type="email" name="email" x-model="form.email" required
                                           class="form-input" placeholder="nama@domain.com" value="{{ old('email', $user->email ?? '') }}">
                                </div>
                            </div>
                        </div>

                        {{-- CARD: Identitas --}}
                        <div class="card-surface p-5 sm:p-6 reveal reveal-d2">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-9 h-9 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center border border-violet-100/60">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-sm font-bold text-gray-900">Identitas</h2>
                                    <p class="text-[11px] text-gray-400">Nomor Induk Kependudukan</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">NIK (16 digit)</label>
                                <input type="text" name="nik" x-model="form.nik" required maxlength="16" minlength="16"
                                       class="form-input font-mono tracking-wider" placeholder="0000000000000000"
                                       pattern="[0-9]{16}" title="NIK harus 16 digit angka"
                                       value="{{ old('nik', $user->nik ?? '') }}"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <p class="text-[10px] text-gray-400 mt-1.5 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    Harus unik. NIK sudah terdaftar tidak dapat digunakan kembali.
                                </p>
                            </div>
                            <div class="mt-4">
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">No. HP</label>
                                <input type="tel" name="no_hp" x-model="form.no_hp" maxlength="15"
                                       class="form-input" placeholder="08xxxxxxxxxx" value="{{ old('no_hp', $editUser->no_hp ?? '') }}"
                                       oninput="this.value = this.value.replace(/[^0-9+]/g, '')">
                                <p class="text-[10px] text-gray-400 mt-1.5">Digunakan untuk verifikasi reset password (lupa password).</p>
                            </div>
                            <div class="mt-4">
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Alamat</label>
                                <textarea name="alamat" x-model="form.alamat" rows="2"
                                          class="form-input" placeholder="Alamat lengkap tempat tinggal">{{ old('alamat', $editUser->alamat ?? '') }}</textarea>
                            </div>
                        </div>

                        {{-- CARD: Keamanan --}}
                        <div class="card-surface p-5 sm:p-6 reveal reveal-d3">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100/60">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-sm font-bold text-gray-900">Keamanan</h2>
                                    <p class="text-[11px] text-gray-400">Password untuk login</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                                    Password @if(isset($user)) <span class="text-amber-500 normal-case font-medium">(kosongkan jika tidak diubah)</span> @endif
                                </label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" name="password" x-model="form.password" @if(!isset($user)) required @endif
                                           class="form-input pr-24 font-mono text-sm" placeholder="{{ isset($user) ? 'Kosongkan untuk tetap memakai password lama' : 'Masukkan password' }}" autocomplete="new-password">
                                    <div class="absolute right-1.5 top-1/2 -translate-y-1/2 flex items-center gap-1">
                                        <button type="button" @click="showPassword = !showPassword"
                                                class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors" :title="showPassword ? 'Sembunyikan' : 'Tampilkan'">
                                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                        </button>
                                        <button type="button" @click="generatePassword()"
                                                class="p-1.5 rounded-lg text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors" title="Generate password acak">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- Password Strength --}}
                                <div x-show="form.password.length > 0" x-cloak class="mt-3">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-[10px] font-bold uppercase tracking-wider" :class="strengthColor" x-text="strengthLabel"></span>
                                        <span class="text-[10px] font-bold" :class="strengthColor"><span x-text="strengthPercent"></span>%</span>
                                    </div>
                                    <div class="h-1.5 rounded-full bg-gray-100 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-500" :class="strengthBarClass" :style="`width:${strengthPercent}%`"></div>
                                    </div>
                                    <div class="flex gap-1 mt-2">
                                        <template x-for="(tip, i) in strengthTips" :key="i">
                                            <span class="inline-flex items-center gap-0.5 text-[9px] font-semibold px-1.5 py-0.5 rounded-full border"
                                                  :class="tip.passed ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-gray-50 text-gray-400 border-gray-100'">
                                                <svg x-show="tip.passed" class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                <span x-text="tip.label"></span>
                                            </span>
                                        </template>
                                    </div>
                                </div>

                                {{-- Copy Button --}}
                                <div x-show="form.password.length > 0" x-cloak class="mt-3">
                                    <button type="button" @click="copyPassword()"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-semibold bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-100 transition-colors">
                                        <svg x-show="!copied" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9.75a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/></svg>
                                        <svg x-show="copied" x-cloak class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        <span x-text="copied ? 'Tersalin!' : 'Salin Password'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- CARD: Hak Akses --}}
                        <div class="card-surface p-5 sm:p-6 reveal reveal-d4">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100/60">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-sm font-bold text-gray-900">Hak Akses</h2>
                                    <p class="text-[11px] text-gray-400">Pilih role pengguna</p>
                                </div>
                            </div>
                            <input type="hidden" name="role" x-model="form.role">
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                                @foreach($roles as $role)
                                    @php
                                        $roleIcons = match($role->name) {
                                            'Super Admin' => ['icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'rose', 'desc' => 'Akses penuh ke seluruh sistem'],
                                            'Operator Pelayanan' => ['icon' => 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0', 'color' => 'blue', 'desc' => 'Mengelola pelayanan surat'],
                                            'Sekretaris Desa' => ['icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z', 'color' => 'violet', 'desc' => 'Verifikasi & administrasi'],
                                            'Kepala Desa' => ['icon' => 'M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z', 'color' => 'amber', 'desc' => 'Persetujuan akhir surat'],
                                            'RT' => ['icon' => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21', 'color' => 'teal', 'desc' => 'Ketua Rukun Tetangga'],
                                            'RW' => ['icon' => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21', 'color' => 'cyan', 'desc' => 'Ketua Rukun Warga'],
                                            'Warga' => ['icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z', 'color' => 'slate', 'desc' => 'Membuat pengajuan surat'],
                                            default => ['icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0', 'color' => 'gray', 'desc' => ''],
                                        };
                                        $ri = $roleIcons;
                                    @endphp
                                    <div class="role-card" :class="form.role === '{{ $role->name }}' && 'selected'" @click="form.role = '{{ $role->name }}'">
                                        <div class="flex flex-col items-center text-center gap-1.5">
                                            <div class="w-10 h-10 rounded-xl bg-{{ $ri['color'] }}-50 text-{{ $ri['color'] }}-600 flex items-center justify-center border border-{{ $ri['color'] }}-100/60 transition-transform duration-200 group-hover:scale-105"
                                                 :class="form.role === '{{ $role->name }}' && 'scale-110'">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $ri['icon'] }}"/></svg>
                                            </div>
                                            <span class="text-[11px] font-bold text-gray-700 leading-tight">{{ $role->name }}</span>
                                            @if($ri['desc'])
                                                <span class="text-[9px] text-gray-400 leading-tight">{{ $ri['desc'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <p x-show="!form.role" x-cloak class="text-[10px] text-amber-500 font-semibold mt-3 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
                                Pilih salah satu role untuk melanjutkan
                            </p>
                        </div>

                        {{-- SUBMIT --}}
                        <div class="reveal reveal-d5">
                            <button type="submit" class="btn-submit flex items-center justify-center gap-2"
                                    :disabled="!form.role || !form.name || !form.email || !form.nik || ({{ isset($user) ? 'false' : '!form.password' }})"
                                    :class="(!form.role || !form.name || !form.email || !form.nik || ({{ isset($user) ? 'false' : '!form.password' }})) && 'opacity-50 cursor-not-allowed'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                {{ isset($user) ? 'Simpan Perubahan' : 'Simpan Pengguna' }}
                            </button>
                        </div>
                    </div>

                    {{-- ── RIGHT: PREVIEW PANEL (5 cols) ── --}}
                    <div class="lg:col-span-5 space-y-5">
                        <div class="lg:sticky lg:top-6 space-y-5">

                            {{-- LIVE PREVIEW CARD --}}
                            <div class="card-surface overflow-hidden reveal reveal-d2">
                                <div class="h-20 bg-gradient-to-br from-[#061a10] via-[#0c3521] to-[#0a7e6a] relative">
                                    <div class="absolute inset-0" style="background-image:radial-gradient(rgba(255,255,255,.04) 1px,transparent 1px);background-size:16px 16px"></div>
                                </div>
                                <div class="px-5 pb-5 -mt-10 relative">
                                    {{-- Avatar --}}
                                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-2xl font-extrabold border-4 border-white shadow-lg shadow-emerald-500/20 mb-3 transition-all duration-300"
                                         :style="form.name ? 'background:linear-gradient(135deg,' + getAvatarColor() + ')' : ''">
                                        <span x-text="getInitials()"></span>
                                    </div>
                                    {{-- Name --}}
                                    <h3 class="text-lg font-extrabold text-gray-900 leading-tight">
                                        <span x-text="form.name || 'Nama Pengguna'"></span>
                                    </h3>
                                    {{-- Email --}}
                                    <p class="text-[12px] text-gray-400 mt-0.5">
                                        <span x-text="form.email || 'email@domain.com'"></span>
                                    </p>
                                    {{-- Role Badge --}}
                                    <div class="mt-2.5">
                                        <span x-show="form.role" x-cloak
                                              class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold border"
                                              :class="getRoleBadgeClass()">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                            <span x-text="form.role"></span>
                                        </span>
                                        <span x-show="!form.role" class="text-[10px] text-gray-400 italic">Belum memilih role</span>
                                    </div>
                                    {{-- Divider --}}
                                    <div class="border-t border-gray-100 mt-4 pt-3">
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between">
                                                <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">NIK</span>
                                                <span class="text-[12px] font-mono font-bold text-gray-700" x-text="form.nik || '—'"></span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Password</span>
                                                <span class="text-[12px] font-mono text-gray-500" x-text="form.password ? '•'.repeat(Math.min(form.password.length, 12)) : '—'"></span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Status</span>
                                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    Aktif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ROLE DESCRIPTION --}}
                            <div class="card-surface p-5 reveal reveal-d3" x-show="form.role" x-cloak
                                 x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                                <div class="section-label"><h3 class="text-gray-700">Hak Akses Role</h3></div>
                                <div class="space-y-2" x-html="getRoleDescription()"></div>
                            </div>

                            {{-- SECURITY TIPS --}}
                            <div class="card-surface p-5 reveal reveal-d4">
                                <div class="section-label"><h3 class="text-gray-700">Tips Keamanan</h3></div>
                                <div class="space-y-2">
                                    <div class="flex items-start gap-2">
                                        <div class="w-5 h-5 rounded-md bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        </div>
                                        <p class="text-[11px] text-gray-500">Gunakan kombinasi huruf, angka, dan simbol</p>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <div class="w-5 h-5 rounded-md bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        </div>
                                        <p class="text-[11px] text-gray-500">Minimal 8 karakter untuk keamanan optimal</p>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <div class="w-5 h-5 rounded-md bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        </div>
                                        <p class="text-[11px] text-gray-500">Hindari menggunakan nama atau tanggal lahir</p>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <div class="w-5 h-5 rounded-md bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        </div>
                                        <p class="text-[11px] text-gray-500">Gunakan fitur generate untuk password kuat</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function userForm() {
            return {
                form: @json([
                    'name' => $editUser->name ?? '',
                    'email' => $editUser->email ?? '',
                    'nik' => $editUser->nik ?? '',
                    'password' => '',
                    'role' => $editRole,
                    'no_hp' => $editUser->no_hp ?? '',
                    'alamat' => $editUser->alamat ?? '',
                ]),
                showPassword: false,
                copied: false,

                init() {
                    this.initReveal();
                },

                initReveal() {
                    const obs = new IntersectionObserver((entries) => {
                        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('v'); obs.unobserve(e.target); } });
                    }, { threshold: 0.08 });
                    document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
                },

                getInitials() {
                    if (!this.form.name) return '?';
                    return this.form.name.split(' ').map(w => w.charAt(0).toUpperCase()).slice(0, 2).join('');
                },

                getAvatarColor() {
                    const colors = [
                        ['#10b981','#059669'],['#3b82f6','#2563eb'],['#8b5cf6','#7c3aed'],
                        ['#f59e0b','#d97706'],['#ef4444','#dc2626'],['#ec4899','#db2777'],
                        ['#06b6d4','#0891b2'],['#14b8a6','#0d9488'],
                    ];
                    const idx = this.form.name.length % colors.length;
                    return colors[idx][0] + ',' + colors[idx][1];
                },

                getRoleBadgeClass() {
                    const map = {
                        'Super Admin': 'bg-rose-50 text-rose-600 border-rose-100',
                        'Operator Pelayanan': 'bg-blue-50 text-blue-600 border-blue-100',
                        'Sekretaris Desa': 'bg-violet-50 text-violet-600 border-violet-100',
                        'Kepala Desa': 'bg-amber-50 text-amber-600 border-amber-100',
                        'RT': 'bg-teal-50 text-teal-600 border-teal-100',
                        'RW': 'bg-cyan-50 text-cyan-600 border-cyan-100',
                        'Warga': 'bg-slate-50 text-slate-600 border-slate-100',
                    };
                    return map[this.form.role] || 'bg-gray-50 text-gray-600 border-gray-100';
                },

                getRoleDescription() {
                    const desc = {
                        'Super Admin': '<div class="flex items-center gap-2 p-2 rounded-lg bg-rose-50/80 border border-rose-100/50"><div class="w-6 h-6 rounded-md bg-rose-100 text-rose-600 flex items-center justify-center shrink-0"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div><div><p class="text-[11px] font-bold text-rose-700">Super Admin</p><p class="text-[10px] text-rose-500">Akses penuh ke seluruh fitur sistem</p></div></div>',
                        'Operator Pelayanan': '<div class="flex items-center gap-2 p-2 rounded-lg bg-blue-50/80 border border-blue-100/50"><div class="w-6 h-6 rounded-md bg-blue-100 text-blue-600 flex items-center justify-center shrink-0"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div><div><p class="text-[11px] font-bold text-blue-700">Operator Pelayanan</p><p class="text-[10px] text-blue-500">Review & proses pengajuan surat</p></div></div>',
                        'Sekretaris Desa': '<div class="flex items-center gap-2 p-2 rounded-lg bg-violet-50/80 border border-violet-100/50"><div class="w-6 h-6 rounded-md bg-violet-100 text-violet-600 flex items-center justify-center shrink-0"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div><div><p class="text-[11px] font-bold text-violet-700">Sekretaris Desa</p><p class="text-[10px] text-violet-500">Verifikasi surat sebelum ke Kades</p></div></div>',
                        'Kepala Desa': '<div class="flex items-center gap-2 p-2 rounded-lg bg-amber-50/80 border border-amber-100/50"><div class="w-6 h-6 rounded-md bg-amber-100 text-amber-600 flex items-center justify-center shrink-0"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div><div><p class="text-[11px] font-bold text-amber-700">Kepala Desa</p><p class="text-[10px] text-amber-500">Persetujuan akhir & tanda tangan</p></div></div>',
                        'RT': '<div class="flex items-center gap-2 p-2 rounded-lg bg-teal-50/80 border border-teal-100/50"><div class="w-6 h-6 rounded-md bg-teal-100 text-teal-600 flex items-center justify-center shrink-0"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div><div><p class="text-[11px] font-bold text-teal-700">Ketua RT</p><p class="text-[10px] text-teal-500">Melihat pengajuan warga di wilayahnya</p></div></div>',
                        'RW': '<div class="flex items-center gap-2 p-2 rounded-lg bg-cyan-50/80 border border-cyan-100/50"><div class="w-6 h-6 rounded-md bg-cyan-100 text-cyan-600 flex items-center justify-center shrink-0"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div><div><p class="text-[11px] font-bold text-cyan-700">Ketua RW</p><p class="text-[10px] text-cyan-500">Melihat pengajuan warga di wilayahnya</p></div></div>',
                        'Warga': '<div class="flex items-center gap-2 p-2 rounded-lg bg-slate-50/80 border border-slate-100/50"><div class="w-6 h-6 rounded-md bg-slate-100 text-slate-600 flex items-center justify-center shrink-0"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div><div><p class="text-[11px] font-bold text-slate-700">Warga</p><p class="text-[10px] text-slate-500">Membuat pengajuan surat mandiri</p></div></div>',
                    };
                    return desc[this.form.role] || '';
                },

                get strengthLevel() {
                    const p = this.form.password;
                    let score = 0;
                    if (p.length >= 8) score++;
                    if (p.length >= 12) score++;
                    if (/[a-z]/.test(p) && /[A-Z]/.test(p)) score++;
                    if (/\d/.test(p)) score++;
                    if (/[^a-zA-Z0-9]/.test(p)) score++;
                    return Math.min(score, 4);
                },

                get strengthPercent() { return this.strengthLevel * 25; },

                get strengthLabel() {
                    return ['', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'][this.strengthLevel];
                },

                get strengthColor() {
                    return ['', 'text-red-500', 'text-amber-500', 'text-blue-500', 'text-emerald-500'][this.strengthLevel];
                },

                get strengthBarClass() {
                    return ['', 'bg-red-400', 'bg-amber-400', 'bg-blue-400', 'bg-emerald-400'][this.strengthLevel];
                },

                get strengthTips() {
                    const p = this.form.password;
                    return [
                        { label: '8+ karakter', passed: p.length >= 8 },
                        { label: 'Huruf & angka', passed: /[a-z]/.test(p) && /\d/.test(p) },
                        { label: 'Huruf besar', passed: /[A-Z]/.test(p) },
                        { label: 'Simbol', passed: /[^a-zA-Z0-9]/.test(p) },
                    ];
                },

                generatePassword() {
                    const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789!@#$%&*';
                    let pass = '';
                    const arr = new Uint8Array(16);
                    crypto.getRandomValues(arr);
                    for (let i = 0; i < 16; i++) pass += chars[arr[i] % chars.length];
                    this.form.password = pass;
                    this.showPassword = true;
                },

                copyPassword() {
                    navigator.clipboard.writeText(this.form.password).then(() => {
                        this.copied = true;
                        setTimeout(() => this.copied = false, 2000);
                    });
                }
            }
        }
    </script>
</body>
</html>