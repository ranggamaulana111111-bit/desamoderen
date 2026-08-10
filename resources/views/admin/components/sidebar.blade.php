<aside id="sidebar" class="fixed top-0 left-0 z-40 w-[260px] h-screen bg-gradient-to-b from-[#0c1524] via-[#0f1a2e] to-[#111827] text-white hidden lg:flex lg:flex-col transition-all duration-300 overflow-hidden">
    {{-- Decorative mesh --}}
    <div class="absolute inset-0 opacity-[.04]" style="background-image: radial-gradient(circle at 20% 50%, rgba(16,185,129,.5) 0, transparent 50%), radial-gradient(circle at 80% 20%, rgba(6,182,212,.3) 0, transparent 40%); pointer-events: none;"></div>

    {{-- Brand --}}
    <div class="relative flex items-center gap-3 px-5 py-5 border-b border-white/[.08]">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-400 via-brand-500 to-teal-500 flex items-center justify-center text-white font-extrabold text-sm shadow-lg shadow-brand-500/30 ring-2 ring-white/10">
            P
        </div>
        <div>
            <p class="font-bold text-[15px] leading-tight tracking-tight">Pro<span class="text-brand-400">desa</span></p>
            <p class="text-[10px] text-white/35 leading-tight font-medium">{{ config('village.nama_desa', 'Portal Desa') }}</p>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">
        <p class="text-[9px] font-bold text-white/25 uppercase tracking-widest px-3 mb-2">Menu Utama</p>

        <a href="{{ route('admin.dashboard') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.dashboard') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
            </div>
            Dashboard
        </a>

        @can('letter.final_approve')
        <a href="{{ route('admin.kades.dashboard') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.kades.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.kades.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
            </div>
            Panel Kades
        </a>
        @endcan

        @can('letter.verify')
        <a href="{{ route('admin.sekdes.dashboard') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.sekdes.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.sekdes.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
            </div>
            Panel Sekdes
        </a>
        @endcan

        @can('letter.view')
        <a href="{{ route('admin.pengajuan.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.pengajuan.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.pengajuan.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            </div>
            Pelayanan Surat
        </a>
        @endcan

        @can('office.view')
        <div class="pt-3 pb-1"><p class="text-[9px] font-bold text-white/25 uppercase tracking-widest px-3">Ketatausahaan</p></div>

        <a href="{{ route('admin.surat-masuk.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.surat-masuk.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.surat-masuk.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51"/></svg>
            </div>
            Surat Masuk
        </a>
        <a href="{{ route('admin.surat-keluar.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.surat-keluar.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.surat-keluar.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
            </div>
            Surat Keluar
        </a>
        <a href="{{ route('admin.disposisi.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.disposisi.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.disposisi.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
            </div>
            Disposisi
        </a>
        @endcan

        @can('user.view')
        <div class="pt-3 pb-1"><p class="text-[9px] font-bold text-white/25 uppercase tracking-widest px-3">Kepegawaian</p></div>

        <a href="{{ route('admin.warga.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.warga.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.warga.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
            </div>
            Data Warga
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.users.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.users.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
            </div>
            Manajemen Pengguna
        </a>
        @endcan

        @can('role.manage')
        <a href="{{ route('admin.roles.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.roles.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.roles.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
            </div>
            Role &amp; Permission
        </a>
        @endcan

        @can('inventaris.view')
        <div class="pt-3 pb-1"><p class="text-[9px] font-bold text-white/25 uppercase tracking-widest px-3">Inventaris & Aset</p></div>

        <a href="{{ route('admin.inventaris.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.inventaris.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.inventaris.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
            </div>
            Inventaris & Aset
        </a>
        @endcan

        @can('anggaran.view')
        <a href="{{ route('admin.apbdesa.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.apbdesa.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.apbdesa.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
            </div>
            APBDesa
        </a>
        @endcan

        @can('news.manage')
        <div class="pt-3 pb-1"><p class="text-[9px] font-bold text-white/25 uppercase tracking-widest px-3">Konten</p></div>

        <a href="{{ route('admin.berita.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.berita.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.berita.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
            </div>
            Berita Desa
        </a>
        @endcan

        @can('event.manage')
        <a href="{{ route('admin.events.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.events.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.events.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/></svg>
            </div>
            Kalender Event
        </a>
        @endcan

        @can('lembaga.manage')
        <a href="{{ route('admin.lembaga.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.lembaga.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.lembaga.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            Data Lembaga
        </a>
        @endcan

        @can('queue.view')
        <div class="pt-3 pb-1"><p class="text-[9px] font-bold text-white/25 uppercase tracking-widest px-3">Sistem</p></div>

        <a href="{{ route('admin.queue.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.queue.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.queue.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L12 12.75 6.429 9.75m11.142 0l4.179 2.25-9.75 5.25-9.75-5.25 4.179-2.25"/></svg>
            </div>
            Monitoring Antrean
        </a>

        <a href="{{ route('admin.queue.pickup') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.queue.pickup') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.queue.pickup') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5zM13.5 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5z"/></svg>
            </div>
            Pengambilan Surat
        </a>
        @endcan

        @can('analytics.view')
        <a href="{{ route('admin.analytics.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.analytics.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.analytics.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
            </div>
            Analitik &amp; Laporan
        </a>
        @endcan

        @can('lembaga.report')
        <a href="{{ route('admin.lembaga-report.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.lembaga-report.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.lembaga-report.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            Kinerja Lembaga
        </a>
        @endcan

        @can('dashboard.view')
        <a href="{{ route('admin.laporan.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.laporan.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.laporan.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            </div>
            Laporan Desa
        </a>
        @endcan

        @can('setting.manage')
        <a href="{{ route('admin.letter-config.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.letter-config.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.letter-config.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            </div>
            Template Surat
        </a>
        @endcan

        @can('setting.manage')
        <a href="{{ route('admin.setting.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.setting.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.setting.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            Pengaturan Desa
        </a>
        @endcan

        @can('audit.view')
        <a href="{{ route('admin.activity-log.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('admin.activity-log.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('admin.activity-log.*') ? 'bg-accent-500/25 text-[#85c2ef]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            </div>
            Log Aktivitas
        </a>
        @endcan
    </nav>

    {{-- User Footer --}}
    <div class="relative px-4 py-4 border-t border-white/[.08]">
        <div class="flex items-center gap-3 px-2 mb-3">
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-xs font-bold text-white shadow-lg shadow-brand-500/30 ring-2 ring-white/10">
                {{ auth()->user()->avatar_initials }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[13px] font-semibold truncate text-white/90">{{ auth()->user()->name }}</p>
                <p class="text-[10px] text-white/35 truncate font-medium">{{ auth()->user()->role_label }}</p>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-[12px] font-medium text-white/40 hover:text-red-400 hover:bg-red-500/10 transition-all duration-200">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

{{-- Mobile Top Bar --}}
<div class="lg:hidden fixed top-0 left-0 right-0 z-50 glass-header px-4 py-3 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white font-bold text-xs shadow-md shadow-brand-500/20">P</div>
        <span class="font-bold text-sm text-slate-800">Prodesa</span>
    </div>
    <div class="flex items-center gap-1">
        <button onclick="document.getElementById('mobile-sidebar').classList.toggle('hidden')" class="p-2 hover:bg-slate-100 rounded-xl transition">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
        </button>
    </div>
</div>

{{-- Mobile Slide-down Drawer --}}
<div id="mobile-sidebar" class="hidden lg:hidden fixed top-[52px] left-0 right-0 z-40 bg-gradient-to-b from-[#0c1524] to-[#111827] text-white shadow-2xl max-h-[calc(100vh-52px)] overflow-y-auto">
    <nav class="p-3 space-y-0.5">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
            Dashboard
        </a>
        @can('letter.final_approve')
        <a href="{{ route('admin.kades.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.kades.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/></svg>
            Panel Kades
        </a>
        @endcan
        @can('letter.verify')
        <a href="{{ route('admin.sekdes.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.sekdes.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
            Panel Sekdes
        </a>
        @endcan
        @can('letter.view')
        <a href="{{ route('admin.pengajuan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.pengajuan.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            Pelayanan Surat
        </a>
        @endcan
        @can('office.view')
        <a href="{{ route('admin.surat-masuk.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.surat-masuk.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51"/></svg>
            Surat Masuk
        </a>
        <a href="{{ route('admin.surat-keluar.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.surat-keluar.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
            Surat Keluar
        </a>
        <a href="{{ route('admin.disposisi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.disposisi.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
            Disposisi
        </a>
        @endcan
        @can('user.view')
        <a href="{{ route('admin.warga.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.warga.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
            Data Warga
        </a>
        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.users.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
            Manajemen Pengguna
        </a>
        @endcan
        @can('role.manage')
        <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.roles.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
            Role &amp; Permission
        </a>
        @endcan
        @can('inventaris.view')
        <a href="{{ route('admin.inventaris.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.inventaris.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
            Inventaris & Aset
        </a>
        @endcan
        @can('anggaran.view')
        <a href="{{ route('admin.apbdesa.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.apbdesa.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
            APBDesa
        </a>
        @endcan
        @can('news.manage')
        <a href="{{ route('admin.berita.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.berita.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
            Berita Desa
        </a>
        @endcan
        @can('event.manage')
        <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.events.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
            Kalender Event
        </a>
        @endcan
        @can('lembaga.manage')
        <a href="{{ route('admin.lembaga.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.lembaga.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Data Lembaga
        </a>
        @endcan
        @can('queue.view')
        <a href="{{ route('admin.queue.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.queue.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L12 12.75 6.429 9.75m11.142 0l4.179 2.25-9.75 5.25-9.75-5.25 4.179-2.25"/></svg>
            Monitoring Antrean
        </a>
        <a href="{{ route('admin.queue.pickup') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.queue.pickup') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5zM13.5 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5z"/></svg>
            Pengambilan Surat
        </a>
        @endcan
        @can('analytics.view')
        <a href="{{ route('admin.analytics.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.analytics.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
            Analitik &amp; Laporan
        </a>
        @endcan
        @can('lembaga.report')
        <a href="{{ route('admin.lembaga-report.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.lembaga-report.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Kinerja Lembaga
        </a>
        @endcan
        @can('dashboard.view')
        <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.laporan.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            Laporan Desa
        </a>
        @endcan
        @can('setting.manage')
        <a href="{{ route('admin.letter-config.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.letter-config.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            Template Surat
        </a>
        @endcan
        @can('setting.manage')
        <a href="{{ route('admin.setting.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.setting.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Pengaturan Desa
        </a>
        @endcan
        @can('audit.view')
        <a href="{{ route('admin.activity-log.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('admin.activity-log.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#DFBD4D]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            Log Aktivitas
        </a>
        @endcan
    </nav>
    <div class="px-4 py-4 border-t border-white/[.08]">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-[12px] font-medium text-white/50 hover:text-red-400 hover:bg-red-500/10 transition-all">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                Keluar
            </button>
        </form>
    </div>
</div>

<div class="flex min-h-screen">
    <div class="hidden lg:block w-[260px] shrink-0"></div>
