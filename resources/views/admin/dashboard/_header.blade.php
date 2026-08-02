<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 animate-fade-in">
    <div class="flex items-start gap-4">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-400 via-emerald-500 to-emerald-600 flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-emerald-200 shrink-0">
            {{ auth()->user()->avatar_initials }}
        </div>
        <div>
            <div class="flex items-center gap-2 mb-0.5">
                <p class="text-sm text-gray-500 font-medium" x-text="greeting"></p>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    {{ auth()->user()->role_label }}
                </span>
            </div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 tracking-tight">{{ auth()->user()->name }}</h1>
            <div class="flex items-center gap-3 mt-1 text-sm text-gray-400">
                <span class="hidden sm:inline" x-text="currentDate"></span>
                <span class="hidden sm:inline">•</span>
                <span class="font-mono text-emerald-600 font-semibold text-base" x-text="clock"></span>
            </div>
        </div>
    </div>
    <div class="flex items-center gap-2 lg:gap-3">
        <div class="hidden md:flex items-center gap-1.5 text-xs text-gray-500 bg-white/70 backdrop-blur rounded-xl px-3 py-2 border border-gray-200/60 shadow-sm">
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span>{{ config('app.env') === 'production' ? '32°C Cerah' : '--°C' }}</span>
        </div>
        <div class="hidden md:flex items-center gap-2 bg-white/70 backdrop-blur rounded-xl px-3.5 py-2 border border-gray-200/60 shadow-sm text-gray-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Cari..." class="text-xs bg-transparent border-none outline-none w-24 text-gray-600 placeholder-gray-400" x-model="searchQuery" @keydown.enter="search">
        </div>
        <div class="relative" x-data="{ notifOpen: false }">
            <button @click="notifOpen = !notifOpen" class="relative p-2.5 rounded-xl bg-white/70 backdrop-blur border border-gray-200/60 shadow-sm hover:bg-white transition text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                @if (count($notifications) > 0)
                    <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center notification-dot shadow-lg">{{ count($notifications) }}</span>
                @endif
            </button>
            <div x-show="notifOpen" @click.outside="notifOpen = false" x-cloak class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden" x-transition.origin.top.right>
                <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-800">Notifikasi</span>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-400">{{ count($notifications) }} baru</span>
                        @if (count($notifications) > 0)
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        @endif
                    </div>
                </div>
                <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
                    @forelse ($notifications as $notif)
                        <a href="{{ $notif['url'] }}" class="flex items-start gap-3.5 px-5 py-3.5 hover:bg-gray-50/80 transition group">
                            <div class="shrink-0 w-9 h-9 rounded-xl flex items-center justify-center text-white text-sm
                                @switch($notif['type'])
                                    @case('approval') bg-gradient-to-br from-blue-500 to-blue-600 @break
                                    @case('revision') bg-gradient-to-br from-amber-500 to-amber-600 @break
                                    @case('queue') bg-gradient-to-br from-red-500 to-red-600 @break
                                    @case('event') bg-gradient-to-br from-purple-500 to-purple-600 @break
                                    @default bg-gradient-to-br from-gray-500 to-gray-600
                                @endswitch shadow-sm">
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
                                <p class="text-sm text-gray-700 leading-snug group-hover:text-gray-900 transition">{{ $notif['message'] }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @empty
                        <div class="px-5 py-12 text-center">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <p class="text-sm text-gray-400 font-medium">Tidak ada notifikasi</p>
                            <p class="text-xs text-gray-300 mt-1">Semua sistem berjalan normal</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
