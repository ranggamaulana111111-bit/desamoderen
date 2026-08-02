@if (!empty($queue))
<div class="widget-card h-full">
    <div class="widget-card-header">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L12 12.75 6.429 9.75m11.142 0l4.179 2.25-9.75 5.25-9.75-5.25 4.179-2.25"/></svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-800">Status Antrean</h2>
                <p class="text-[10px] text-gray-400">Real-time queue monitor</p>
            </div>
        </div>
        <span class="pulse-dot {{ $queue['waiting'] > 0 || $queue['failed'] > 0 ? 'warn active' : 'ok' }}"></span>
    </div>
    <div class="widget-card-body">
        <div class="grid grid-cols-2 gap-3">
            <div class="stat-micro bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-3.5 border border-amber-100/50">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                    <span class="text-[10px] font-semibold text-amber-700 uppercase tracking-wider">Menunggu</span>
                </div>
                <p class="text-2xl font-extrabold text-amber-900" x-data x-init="animateNumber($el, {{ $queue['waiting'] }})">0</p>
            </div>
            <div class="stat-micro bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-3.5 border border-blue-100/50">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-400 animate-pulse"></span>
                    <span class="text-[10px] font-semibold text-blue-700 uppercase tracking-wider">Berjalan</span>
                </div>
                <p class="text-2xl font-extrabold text-blue-900" x-data x-init="animateNumber($el, {{ $queue['running'] }})">0</p>
            </div>
            <div class="stat-micro bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl p-3.5 border border-emerald-100/50">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                    <span class="text-[10px] font-semibold text-emerald-700 uppercase tracking-wider">Sukses</span>
                </div>
                <p class="text-2xl font-extrabold text-emerald-900" x-data x-init="animateNumber($el, {{ $queue['success'] }})">0</p>
            </div>
            <div class="stat-micro bg-gradient-to-br {{ $queue['failed'] > 0 ? 'from-red-50 to-rose-50 border-red-100/50' : 'from-gray-50 to-slate-50 border-gray-100/50' }} rounded-xl p-3.5 border">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2.5 h-2.5 rounded-full {{ $queue['failed'] > 0 ? 'bg-red-400 animate-pulse' : 'bg-gray-300' }}"></span>
                    <span class="text-[10px] font-semibold {{ $queue['failed'] > 0 ? 'text-red-700' : 'text-gray-500' }} uppercase tracking-wider">Gagal</span>
                </div>
                <p class="text-2xl font-extrabold {{ $queue['failed'] > 0 ? 'text-red-900' : 'text-gray-400' }}" x-data x-init="animateNumber($el, {{ $queue['failed'] }})">0</p>
            </div>
        </div>
        @if ($queue['waiting'] > 0 || $queue['running'] > 0)
        <div class="mt-4 pt-3 border-t border-gray-100/60">
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <svg class="w-3.5 h-3.5 text-amber-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                <span>{{ $queue['waiting'] + $queue['running'] }} job sedang diproses...</span>
            </div>
        </div>
        @endif
        @if ($canManage ?? false)
        <div class="mt-3 pt-3 border-t border-gray-100/60">
            <a href="{{ route('admin.queue.index') }}" class="group flex items-center justify-between px-3 py-2 rounded-xl bg-gray-50 hover:bg-indigo-50 border border-gray-100 hover:border-indigo-200 transition-all text-xs font-medium text-gray-600 hover:text-indigo-700">
                <span class="flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Kelola Antrean
                </span>
                <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-indigo-500 group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        @endif
    </div>
</div>
@else
    <x-widgets._empty icon="queue" title="Antrean Kosong" description="Tidak ada job yang menunggu diproses" />
@endif
