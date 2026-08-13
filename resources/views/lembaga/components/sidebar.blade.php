<aside id="sidebar" class="fixed top-0 left-0 z-40 w-[260px] h-screen bg-gradient-to-b from-[#022c22] via-[#052e22] to-[#064e3b] text-white hidden lg:flex lg:flex-col transition-all duration-300 overflow-hidden">
    {{-- Decorative mesh --}}
    <div class="absolute inset-0 opacity-[.04]" style="background-image: radial-gradient(circle at 20% 50%, rgba(16,185,129,.5) 0, transparent 50%), radial-gradient(circle at 80% 20%, rgba(6,182,212,.3) 0, transparent 40%); pointer-events: none;"></div>

    {{-- Brand --}}
    <div class="relative flex items-center gap-3 px-5 py-5 border-b border-white/[.08]">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-400 via-brand-500 to-teal-500 flex items-center justify-center text-white font-extrabold text-sm shadow-lg shadow-brand-500/30 ring-2 ring-white/10">
            L
        </div>
        <div>
            <p class="font-bold text-[15px] leading-tight tracking-tight">Pro<span class="text-brand-400">desa</span> <span class="text-brand-400">Lembaga</span></p>
            <p class="text-[10px] text-white/35 leading-tight font-medium">{{ config('village.nama_desa', 'Portal Desa') }}</p>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">
        <p class="text-[9px] font-bold text-white/25 uppercase tracking-widest px-3 mb-2">Menu Lembaga</p>

        <a href="{{ route('lembaga.dashboard') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('lembaga.dashboard') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#34d399]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('lembaga.dashboard') ? 'bg-accent-500/25 text-[#6ee7b7]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
            </div>
            Dashboard
        </a>

        <div class="pt-3 pb-1"><p class="text-[9px] font-bold text-white/25 uppercase tracking-widest px-3">Konten</p></div>

        <a href="{{ route('lembaga.berita.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('lembaga.berita.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#34d399]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('lembaga.berita.*') ? 'bg-accent-500/25 text-[#6ee7b7]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
            </div>
            Berita Saya
        </a>

        <a href="{{ route('lembaga.events.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('lembaga.events.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#34d399]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('lembaga.events.*') ? 'bg-accent-500/25 text-[#6ee7b7]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/></svg>
            </div>
            Event Saya
        </a>

        <a href="{{ route('lembaga.profil.edit') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all {{ request()->routeIs('lembaga.profil.*') ? 'bg-accent-500/20 text-white shadow-lg shadow-accent-900/20 border-l-2 border-[#34d399]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('lembaga.profil.*') ? 'bg-accent-500/25 text-[#6ee7b7]' : 'bg-white/[.06] text-white/40 group-hover:text-white/70 group-hover:bg-white/[.1]' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
            </div>
            Profil Lembaga
        </a>
    </nav>

    {{-- User Footer --}}
    <div class="relative px-4 py-4 border-t border-white/[.08]">
        <div class="flex items-center gap-3 px-2 mb-3">
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-xs font-bold text-white shadow-lg shadow-brand-500/30 ring-2 ring-white/10">
                {{ auth()->user()->avatar_initials }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[13px] font-semibold truncate text-white/90">{{ auth()->user()->name }}</p>
                <p class="text-[10px] text-white/35 truncate font-medium">{{ auth()->user()->lembaga?->nama }}</p>
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
        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white font-bold text-xs shadow-md shadow-brand-500/20">L</div>
        <span class="font-bold text-sm text-slate-800">Prodesa Lembaga</span>
    </div>
    <div class="flex items-center gap-1">
        <button onclick="document.getElementById('mobile-sidebar').classList.toggle('hidden')" class="p-2 hover:bg-slate-100 rounded-xl transition">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
        </button>
    </div>
</div>

{{-- Mobile Slide-down Drawer --}}
<div id="mobile-sidebar" class="hidden lg:hidden fixed top-[52px] left-0 right-0 z-40 bg-gradient-to-b from-[#022c22] to-[#064e3b] text-white shadow-2xl max-h-[calc(100vh-52px)] overflow-y-auto">
    <nav class="p-3 space-y-0.5">
        <a href="{{ route('lembaga.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('lembaga.dashboard') ? 'bg-accent-500/25 text-white border-l-2 border-[#34d399]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
            Dashboard
        </a>
        <a href="{{ route('lembaga.berita.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('lembaga.berita.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#34d399]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
            Berita Saya
        </a>
        <a href="{{ route('lembaga.events.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('lembaga.events.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#34d399]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
            Event Saya
        </a>
        <a href="{{ route('lembaga.profil.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium {{ request()->routeIs('lembaga.profil.*') ? 'bg-accent-500/25 text-white border-l-2 border-[#34d399]' : 'text-white/60 hover:text-white hover:bg-white/[.06]' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
            Profil Lembaga
        </a>
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
