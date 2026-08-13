<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 animate-slide-up" style="animation-delay: 0.35s">
    {{-- Queue Status --}}
    <div class="bento-card bg-white rounded-2xl shadow-sm p-5">
        <div class="flex items-center gap-2 mb-4">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse-slow"></span>
            <h2 class="text-sm font-semibold text-gray-800">Status Antrean</h2>
        </div>
        <div class="space-y-3.5">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-400"></span> Menunggu</span>
                <span class="text-sm font-bold text-gray-900">{{ $queue['waiting'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-teal-400"></span> Berjalan</span>
                <span class="text-sm font-bold text-gray-900">{{ $queue['running'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-green-400"></span> Sukses (hari ini)</span>
                <span class="text-sm font-bold text-gray-900">{{ $queue['success'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-red-400"></span> Gagal</span>
                <span class="text-sm font-bold {{ $queue['failed'] > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $queue['failed'] }}</span>
            </div>
            @if ($can['queue.manage'] ?? false)
            <div class="pt-2">
                <a href="{{ route('admin.queue.index') }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700 flex items-center gap-1">Kelola Antrean <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
            </div>
            @endif
        </div>
    </div>

    {{-- System Health --}}
    <div class="bento-card bg-white rounded-2xl shadow-sm p-5">
        <h2 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-4.29-4.3m0 0l-4.29 4.3m4.29-4.3V1.59m0 18.82V21m0-21l4.29 4.3m0 0l4.29-4.3M17.59 9H21M3 9h3.41m10.18 0H21M3 9h3.41"/></svg>
            Kesehatan Sistem
        </h2>
        <div class="space-y-3">
            @php
                $healthItems = [
                    'PHP' => $systemHealth['php'],
                    'Laravel' => $systemHealth['laravel'],
                    'MySQL' => $systemHealth['mysql'],
                    'Queue' => $systemHealth['queue'],
                    'Storage' => $systemHealth['storage'],
                    'Scheduler' => $systemHealth['scheduler'],
                    'Cache' => $systemHealth['cache'],
                ];
            @endphp
            @foreach ($healthItems as $name => $info)
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="health-dot {{ $info['ok'] ? 'ok' : 'fail' }}"></span>
                    <span class="text-sm text-gray-600">{{ $name }}</span>
                </div>
                <span class="text-xs text-gray-500 font-mono bg-gray-50 px-2 py-0.5 rounded-md">{{ $info['version'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Top Performers --}}
    @if (!empty($operatorPerformance))
    <div class="bento-card bg-white rounded-2xl shadow-sm p-5">
        <h2 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
            Top Performer
        </h2>
        <div class="space-y-3">
            @forelse ($operatorPerformance as $op)
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-cyan-100 to-cyan-200 flex items-center justify-center text-[10px] font-bold text-cyan-600 shrink-0 shadow-sm ring-2 ring-white">
                    @php
                        $initials = collect(explode(' ', $op['name']))->map(fn($w) => mb_substr($w, 0, 1))->take(2)->join('');
                    @endphp
                    {{ $initials ?: '?' }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $op['name'] }}</p>
                    <div class="flex items-center gap-2.5 mt-0.5">
                        <span class="text-[11px] text-gray-500">{{ $op['total'] }} tindakan</span>
                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                        <span class="text-[11px] font-medium text-emerald-600">{{ $op['approval_rate'] }}%</span>
                    </div>
                </div>
                <div class="w-14 bg-gray-100 rounded-full h-1.5">
                    <div class="bg-emerald-500 h-1.5 rounded-full transition-all" style="width: {{ $op['approval_rate'] }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">Belum ada data</p>
            @endforelse
        </div>
        @if (!empty($topRtrw))
        <div class="mt-4 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-2">Top RT &amp; RW</p>
            <div class="flex gap-4 text-xs">
                <div class="flex-1">
                    @forelse ($topRtrw['rt'] as $rt)
                    <div class="flex items-center justify-between py-0.5">
                        <span class="text-gray-600">{{ $rt['label'] }}</span>
                        <span class="font-semibold text-gray-800">{{ $rt['total'] }}</span>
                    </div>
                    @empty
                    <span class="text-gray-400">-</span>
                    @endforelse
                </div>
                <div class="flex-1">
                    @forelse ($topRtrw['rw'] as $rw)
                    <div class="flex items-center justify-between py-0.5">
                        <span class="text-gray-600">{{ $rw['label'] }}</span>
                        <span class="font-semibold text-gray-800">{{ $rw['total'] }}</span>
                    </div>
                    @empty
                    <span class="text-gray-400">-</span>
                    @endforelse
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    {{-- Village Info + Events --}}
    <div class="bento-card bg-white rounded-2xl shadow-sm p-5">
        <h2 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/></svg>
            Informasi Desa
        </h2>
        <div class="space-y-2.5">
            <div class="flex justify-between text-sm"><span class="text-gray-500">Desa</span><span class="font-medium text-gray-800">{{ $village['nama_desa'] }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-gray-500">Kecamatan</span><span class="font-medium text-gray-800">{{ $village['nama_kecamatan'] }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-gray-500">Kepala Desa</span><span class="font-medium text-gray-800">{{ $village['nama_kades'] }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-gray-500">Sekretaris</span><span class="font-medium text-gray-800">{{ $village['nama_sekdes'] }}</span></div>
        </div>
        <div class="mt-4 pt-3 border-t border-gray-100 grid grid-cols-2 gap-3">
            <div class="bg-gray-50 rounded-xl p-3 text-center">
                <p class="text-lg font-bold text-gray-900 count-up" x-data x-init="animateNumber($el, {{ $village['total_penduduk'] }})">0</p>
                <p class="text-[11px] text-gray-500">Penduduk</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-3 text-center">
                <p class="text-lg font-bold text-gray-900 count-up" x-data x-init="animateNumber($el, {{ $village['total_kk'] }})">0</p>
                <p class="text-[11px] text-gray-500">KK</p>
            </div>
        </div>
        @if (!empty($events))
        <div class="mt-4 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-2.5">Event Mendatang</p>
            @foreach ($events as $event)
            <div class="flex items-start gap-2.5 mb-2 last:mb-0">
                <div class="shrink-0 w-9 text-center bg-gray-50 rounded-lg py-1">
                    <div class="text-xs font-bold text-emerald-600">{{ \Carbon\Carbon::parse($event['tanggal_full'])->format('d') }}</div>
                    <div class="text-[9px] text-gray-400">{{ \Carbon\Carbon::parse($event['tanggal_full'])->format('M') }}</div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $event['judul'] }}</p>
                    <p class="text-[11px] text-gray-500 truncate">{{ $event['tempat'] }}{{ $event['waktu_mulai'] ? ' • '.$event['waktu_mulai'] : '' }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
