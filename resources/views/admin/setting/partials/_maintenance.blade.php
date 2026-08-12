<div x-show="activeTab === 'maintenance'" x-cloak class="animate-fade-in space-y-4">
    {{-- Update Aplikasi dari GitHub --}}
    @hasrole('Super Admin')
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden" x-data="updateApp()" x-init="initUpdate()">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-emerald-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-base font-semibold text-gray-900">Update Aplikasi</h2>
                    <p class="text-xs text-gray-500">Periksa &amp; perbarui aplikasi ke versi terbaru dari GitHub</p>
                </div>
                <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                    Super Admin
                </span>
            </div>
        </div>
        <div class="p-6">
            <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                <div class="flex-1 space-y-3">
                    <div x-show="statusLoaded" x-cloak class="rounded-xl border border-gray-200 bg-gray-50/60 p-4 space-y-3">
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Versi terpasang</span>
                            <span class="text-xs font-mono text-gray-700" x-text="current.shortHash || '-'"></span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800" x-text="current.message || '—'"></p>
                            <p class="text-xs text-gray-500 mt-0.5" x-text="current.date ? formatDate(current.date) : ''"></p>
                        </div>
                    </div>

                    <div x-show="statusError" x-cloak class="rounded-xl border border-red-200 bg-red-50 p-4">
                        <p class="text-sm font-medium text-red-700" x-text="statusError"></p>
                    </div>

                    <div x-show="hasUpdate" x-cloak class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 space-y-2">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            <p class="text-sm font-bold text-emerald-800">
                                Update tersedia — <span x-text="behindCount"></span> commit baru
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800" x-text="'#' + (latestHash || '') + ' ' + (latestMessage || '')"></p>
                            <p class="text-xs text-gray-500 mt-0.5" x-text="latestDate ? formatDate(latestDate) : ''"></p>
                        </div>
                    </div>

                    <div x-show="isUpToDate" x-cloak class="rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-sm font-semibold text-emerald-800">Aplikasi sudah versi terbaru</p>
                        </div>
                    </div>

                    <div x-show="logVisible" x-cloak>
                        <pre class="text-[11px] font-mono text-gray-200 bg-gray-900 rounded-xl p-4 overflow-x-auto max-h-72 whitespace-pre-wrap" x-text="logText"></pre>
                    </div>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap items-center gap-3">
                <button type="button" @click="check()" :disabled="busy"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-200 transition disabled:opacity-50">
                    <svg x-show="checking" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                    <svg x-show="!checking" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                    <span x-text="checking ? 'Memeriksa...' : 'Periksa Update'"></span>
                </button>

                <button type="button" @click="updateNow()" x-show="hasUpdate" :disabled="busy"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition disabled:opacity-50">
                    <svg x-show="updating" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                    <svg x-show="!updating" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                    <span x-text="updating ? 'Mengupdate...' : 'Update ke Versi Terbaru'"></span>
                </button>
            </div>

            <p class="mt-4 text-[11px] text-gray-400 leading-relaxed">
                Update menjalankan: git pull, composer install, migrate, npm build, dan clear cache. Hanya role Super Admin. Server harus berupa git clone dan direktori aplikasi writable oleh www-data.
            </p>
        </div>
    </div>
    @endhasrole

    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-4.29-4.3m0 0l-4.29 4.3m4.29-4.3V1.59m0 18.82V21m0-21l4.29 4.3m0 0l4.29-4.3M17.59 9H21M3 9h3.41m10.18 0H21M3 9h3.41"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Maintenance</h2>
                    <p class="text-xs text-gray-500">Pemeliharaan dan pembersihan sistem</p>
                </div>
            </div>
        </div>
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $maintenanceActions = [
                    ['action' => 'cache', 'label' => 'Clear Cache', 'desc' => 'Bersihkan semua cache aplikasi', 'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z', 'color' => 'emerald'],
                    ['action' => 'config', 'label' => 'Clear Config', 'desc' => 'Bersihkan cache konfigurasi', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'color' => 'amber'],
                    ['action' => 'route', 'label' => 'Clear Route', 'desc' => 'Bersihkan cache route', 'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7', 'color' => 'blue'],
                    ['action' => 'view', 'label' => 'Clear View', 'desc' => 'Bersihkan cache view Blade', 'icon' => 'M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25z', 'color' => 'purple'],
                    ['action' => 'optimize', 'label' => 'Clear All', 'desc' => 'Bersihkan semua cache sekaligus (cache, config, route, view)', 'icon' => 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z', 'color' => 'orange'],
                    ['action' => 'storage-link', 'label' => 'Storage Link', 'desc' => 'Buat symbolic link storage', 'icon' => 'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244', 'color' => 'teal'],
                ];
            @endphp
            @foreach ($maintenanceActions as $action)
            <form action="{{ route('admin.setting.maintenance', $action['action']) }}" method="POST" class="group" x-data="{ running: false }" @@submit="running = true">
                @csrf
                <button type="submit" :disabled="running"
                    class="w-full text-left p-4 rounded-xl border border-gray-200 hover:border-{{ $action['color'] }}-300 hover:bg-{{ $action['color'] }}-50/50 transition disabled:opacity-50">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-{{ $action['color'] }}-100 text-{{ $action['color'] }}-600 flex items-center justify-center shrink-0">
                            <svg x-show="!running" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $action['icon'] }}"/></svg>
                            <svg x-show="running" class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800 group-hover:text-{{ $action['color'] }}-700">
                                <span x-text="running ? 'Menjalankan...' : '{{ $action['label'] }}'"></span>
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $action['desc'] }}</p>
                        </div>
                    </div>
                </button>
            </form>
            @endforeach
        </div>
    </div>
</div>
