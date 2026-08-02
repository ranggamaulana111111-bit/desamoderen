<div class="widget-card h-full">
    <div class="widget-card-header">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center text-white shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-800">Event Mendatang</h2>
                <p class="text-[10px] text-gray-400">Jadwal kegiatan desa</p>
            </div>
        </div>
        @if (!empty($events) && count($events) > 0)
            <span class="chip bg-pink-50 text-pink-700 border border-pink-100">{{ count($events) }} aktif</span>
        @endif
    </div>
    @if (!empty($events) && count($events) > 0)
        <div class="widget-card-body-compact">
            @foreach ($events as $event)
            <div class="flex items-start gap-3 px-5 py-3.5 hover:bg-gray-50/50 transition {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                <div class="shrink-0 w-11 text-center bg-gradient-to-br from-pink-50 to-rose-50 rounded-xl py-2 border border-pink-100/50">
                    <div class="text-lg font-extrabold text-pink-700 leading-none">{{ \Carbon\Carbon::parse($event['tanggal_full'])->format('d') }}</div>
                    <div class="text-[9px] text-pink-500 font-semibold uppercase mt-0.5">{{ \Carbon\Carbon::parse($event['tanggal_full'])->format('M') }}</div>
                </div>
                <div class="flex-1 min-w-0 pt-0.5">
                    <p class="text-[13px] font-semibold text-gray-800 truncate">{{ $event['judul'] }}</p>
                    <div class="flex items-center gap-1.5 mt-1">
                        <svg class="w-3 h-3 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        <span class="text-[11px] text-gray-500 truncate">{{ $event['tempat'] }}</span>
                    </div>
                    @if($event['waktu_mulai'])
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <svg class="w-3 h-3 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-[11px] text-gray-500">{{ $event['waktu_mulai'] }} WIB</span>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="widget-card-body">
            <div class="empty-state">
                <div class="empty-state-icon bg-pink-50 border border-pink-100/50">
                    <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </div>
                <p class="text-sm text-gray-500 font-medium">Tidak ada event</p>
                <p class="text-xs text-gray-400 mt-0.5">Belum ada event yang dijadwalkan</p>
                @can('event.manage')
                <a href="{{ route('admin.events.create') }}" class="mt-3 inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-semibold text-pink-600 bg-pink-50 hover:bg-pink-100 border border-pink-100 rounded-xl transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Buat Event
                </a>
                @endcan
            </div>
        </div>
    @endif
</div>
