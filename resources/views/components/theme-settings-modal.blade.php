<div x-show="settingsOpen" @click.outside="settingsOpen = false" x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-[9999] flex items-center justify-center p-4" style="display:none;">
    <div class="fixed inset-0 bg-black/40 dark:bg-black/60 backdrop-blur-sm" @click="settingsOpen = false"></div>
    <div class="relative bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-600 w-full max-w-md overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-600">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-slate-700 flex items-center justify-center">
                    <svg class="w-4 h-4 text-gray-500 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Theme Settings</h3>
                    <p class="text-xs text-gray-400 dark:text-slate-500">Sesuaikan tampilan dashboard</p>
                </div>
            </div>
            <button @click="settingsOpen = false" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-400 dark:text-slate-500 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="p-6 space-y-6">
            <div>
                <label class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-3 block">Mode Tampilan</label>
                <div class="grid grid-cols-3 gap-2">
                    <button @click="theme = 'light'" :class="theme === 'light' ? 'ring-2 ring-emerald-500 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'bg-gray-50 dark:bg-slate-700 text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-600'" class="flex flex-col items-center gap-1.5 p-3 rounded-xl border border-gray-200 dark:border-slate-600 transition text-xs font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
                        Terang
                    </button>
                    <button @click="theme = 'dark'" :class="theme === 'dark' ? 'ring-2 ring-emerald-500 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'bg-gray-50 dark:bg-slate-700 text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-600'" class="flex flex-col items-center gap-1.5 p-3 rounded-xl border border-gray-200 dark:border-slate-600 transition text-xs font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/></svg>
                        Gelap
                    </button>
                    <button @click="theme = 'system'" :class="theme === 'system' ? 'ring-2 ring-emerald-500 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'bg-gray-50 dark:bg-slate-700 text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-600'" class="flex flex-col items-center gap-1.5 p-3 rounded-xl border border-gray-200 dark:border-slate-600 transition text-xs font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 7.41A2.25 2.25 0 012.25 5.495V5.25"/></svg>
                        Sistem
                    </button>
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-3 block">Density</label>
                <div class="grid grid-cols-3 gap-2">
                    <button @click="density = 'compact'" :class="density === 'compact' ? 'ring-2 ring-emerald-500 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'bg-gray-50 dark:bg-slate-700 text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-600'" class="flex flex-col items-center gap-1 p-3 rounded-xl border border-gray-200 dark:border-slate-600 transition text-xs font-medium">
                        <div class="space-y-0.5"><div class="w-6 h-0.5 bg-current rounded"></div><div class="w-6 h-0.5 bg-current rounded"></div><div class="w-6 h-0.5 bg-current rounded"></div></div>
                        Compact
                    </button>
                    <button @click="density = 'comfortable'" :class="density === 'comfortable' ? 'ring-2 ring-emerald-500 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'bg-gray-50 dark:bg-slate-700 text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-600'" class="flex flex-col items-center gap-1 p-3 rounded-xl border border-gray-200 dark:border-slate-600 transition text-xs font-medium">
                        <div class="space-y-1"><div class="w-6 h-0.5 bg-current rounded"></div><div class="w-6 h-0.5 bg-current rounded"></div><div class="w-6 h-0.5 bg-current rounded"></div></div>
                        Normal
                    </button>
                    <button @click="density = 'loose'" :class="density === 'loose' ? 'ring-2 ring-emerald-500 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'bg-gray-50 dark:bg-slate-700 text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-600'" class="flex flex-col items-center gap-1 p-3 rounded-xl border border-gray-200 dark:border-slate-600 transition text-xs font-medium">
                        <div class="space-y-1.5"><div class="w-6 h-0.5 bg-current rounded"></div><div class="w-6 h-0.5 bg-current rounded"></div><div class="w-6 h-0.5 bg-current rounded"></div></div>
                        Longgar
                    </button>
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider mb-3 block">Warna Aksen</label>
                <div class="flex items-center gap-2.5">
                    <template x-for="(hex, name) in accentColors" :key="name">
                        <button @click="accentColor = name" :class="accentColor === name ? 'ring-2 ring-offset-2 ring-offset-white dark:ring-offset-slate-800 scale-110' : 'hover:scale-110'" :style="'background-color:' + hex" class="w-7 h-7 rounded-full transition-all duration-150 shadow-sm" :title="name">
                        </button>
                    </template>
                </div>
            </div>

            <div x-show="saving" x-transition class="flex items-center gap-2 text-xs text-gray-400 dark:text-slate-500">
                <svg class="animate-spin w-3 h-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                Menyimpan...
            </div>
        </div>
    </div>
</div>
