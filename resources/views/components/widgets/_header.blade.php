<div class="bento-card bg-white rounded-2xl p-5 sm:p-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
    <div class="flex items-start gap-4">
        <div class="relative">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-brand-400 via-brand-500 to-teal-500 flex items-center justify-center text-white text-lg font-bold shadow-lg shadow-brand-500/25 shrink-0">
                {{ auth()->user()->avatar_initials }}
            </div>
            <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-emerald-400 rounded-full border-2 border-white shadow-sm pulse-dot ok active"></div>
        </div>
        <div>
            <div class="flex flex-wrap items-center gap-2 mb-1">
                <p class="text-sm text-slate-500 font-medium" x-text="greeting"></p>
                <span class="chip bg-gradient-to-r from-brand-50 to-teal-50 text-brand-700 border border-brand-200/60">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand-500 animate-pulse"></span>
                    {{ auth()->user()->role_label }}
                </span>
            </div>
            <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">{{ auth()->user()->name }}</h1>
            <div class="flex items-center gap-3 mt-1.5 text-sm text-slate-400">
                <span class="hidden sm:inline" x-text="currentDate"></span>
                <span class="hidden sm:inline text-slate-300">&middot;</span>
                <span class="font-mono text-brand-600 font-bold text-base tracking-wide" x-text="clock"></span>
            </div>
        </div>
    </div>
    <div class="flex items-center gap-2 lg:gap-2.5 flex-wrap">
        <div class="hidden md:flex items-center gap-1.5 text-xs text-slate-500 bg-white/80 backdrop-blur rounded-xl px-3 py-2 border border-slate-200/60 shadow-sm">
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span>{{ config('app.env') === 'production' ? '32°C Cerah' : '--°C' }}</span>
        </div>
        <div class="hidden md:flex items-center gap-2 bg-white/80 backdrop-blur rounded-xl px-3 py-2 border border-slate-200/60 shadow-sm text-slate-400 focus-within:border-brand-200 focus-within:ring-2 focus-within:ring-brand-500/10 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            <input type="text" placeholder="Cari..." class="text-xs bg-transparent border-none outline-none w-24 text-slate-600 placeholder-slate-400" x-model="searchQuery" @keydown.enter="search">
        </div>
        <button @click="settingsOpen = !settingsOpen" class="interact p-2.5 rounded-xl bg-white/80 backdrop-blur border border-slate-200/60 shadow-sm text-slate-400 hover:text-brand-600 hover:border-brand-200 hover:bg-brand-50/50 transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </button>
        <div class="relative" x-data="{ notifOpen: false }">
            <button @click="notifOpen = !notifOpen" class="interact relative p-2.5 rounded-xl bg-white/80 backdrop-blur border border-slate-200/60 shadow-sm text-slate-400 hover:text-brand-600 hover:border-brand-200 hover:bg-brand-50/50 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                @if (count($notifications) > 0)
                    <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center notification-dot shadow-lg shadow-red-500/30">{{ count($notifications) }}</span>
                @endif
            </button>
            <div x-show="notifOpen" @click.outside="notifOpen = false" x-cloak class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl shadow-slate-200/50 border border-slate-100 z-50 overflow-hidden" x-transition.origin.top.right>
                <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between">
                    <span class="text-sm font-bold text-slate-800">Notifikasi</span>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-400 font-medium">{{ count($notifications) }} baru</span>
                        @if (count($notifications) > 0)
                            <span class="pulse-dot ok active"></span>
                        @endif
                    </div>
                </div>
                <div class="max-h-80 overflow-y-auto divide-y divide-slate-50">
                    @forelse ($notifications as $notif)
                        <a href="{{ $notif['url'] }}" class="flex items-start gap-3 px-5 py-3.5 hover:bg-slate-50/80 transition group">
                            <div class="shrink-0 w-9 h-9 rounded-xl flex items-center justify-center text-white text-sm shadow-sm
                                @switch($notif['type'])
                                    @case('approval') bg-gradient-to-br from-emerald-500 to-emerald-600 @break
                                    @case('revision') bg-gradient-to-br from-amber-500 to-amber-600 @break
                                    @case('queue') bg-gradient-to-br from-red-500 to-red-600 @break
                                    @case('event') bg-gradient-to-br from-purple-500 to-purple-600 @break
                                    @default bg-gradient-to-br from-slate-500 to-slate-600
                                @endswitch">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    @switch($notif['type'])
                                        @case('approval') <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/> @break
                                        @case('revision') <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/> @break
                                        @case('queue') <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/> @break
                                        @case('event') <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/> @break
                                        @default <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                                    @endswitch
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-slate-700 leading-snug group-hover:text-slate-900 transition">{{ $notif['message'] }}</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-300 group-hover:text-brand-500 group-hover:translate-x-0.5 transition shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @empty
                        <div class="px-5 py-12 text-center">
                            <div class="empty-state-icon bg-slate-50 mx-auto border border-slate-100">
                                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                            </div>
                            <p class="text-sm text-slate-400 font-semibold mt-3">Tidak ada notifikasi</p>
                            <p class="text-xs text-slate-300 mt-1">Semua sistem berjalan normal</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@if(!empty($dailySummary) || ($todayStats['todaySubmissions'] + $todayStats['todayCompleted'] + $todayStats['pendingApprovals']) > 0)
    <div class="mt-3 rounded-2xl border border-brand-200/40 bg-gradient-to-r from-brand-50/80 via-white to-teal-50/60 px-5 py-3.5 backdrop-blur-sm">
        @if(!empty($dailySummary))
            <p class="text-sm text-brand-800 font-semibold leading-relaxed">{{ $dailySummary }}</p>
        @endif
        <div class="flex flex-wrap items-center gap-2 mt-2">
            @if($todayStats['todaySubmissions'] > 0)
                <span class="chip bg-teal-50 text-teal-700 border border-teal-200/60">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    {{ $todayStats['todaySubmissions'] }} baru
                </span>
            @endif
            @if($todayStats['todayCompleted'] > 0)
                <span class="chip bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    {{ $todayStats['todayCompleted'] }} selesai
                </span>
            @endif
            @if($todayStats['todayVerified'] > 0)
                <span class="chip bg-cyan-50 text-cyan-700 border border-cyan-200/60">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $todayStats['todayVerified'] }} diverifikasi
                </span>
            @endif
            @if($todayStats['pendingApprovals'] > 0)
                <span class="chip bg-amber-50 text-amber-700 border border-amber-200/60">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $todayStats['pendingApprovals'] }} verifikasi
                </span>
            @endif
        </div>
    </div>
@endif
