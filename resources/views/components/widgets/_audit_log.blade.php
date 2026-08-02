<div class="widget-card h-full">
    <div class="widget-card-header">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-violet-400 to-purple-600 flex items-center justify-center text-white shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-800">Log Aktivitas</h2>
                <p class="text-[10px] text-gray-400">Audit trail & ringkasan hari ini</p>
            </div>
        </div>
        @if ($totalToday > 0)
            <span class="chip bg-violet-50 text-violet-700 border border-violet-100">{{ $totalToday }} hari ini</span>
        @endif
    </div>
    <div class="widget-card-body">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mb-4">
            @if ($myPending > 0)
            <div class="stat-micro bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-3 text-center border border-amber-100/40">
                <p class="text-lg font-extrabold text-amber-700">{{ $myPending }}</p>
                <p class="text-[10px] text-amber-600 font-semibold">Menunggu Anda</p>
            </div>
            @endif
            <div class="stat-micro bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-3 text-center border border-blue-100/40">
                <p class="text-lg font-extrabold text-blue-900">{{ $todaySubmissions }}</p>
                <p class="text-[10px] text-blue-600 font-semibold">Pengajuan Baru</p>
            </div>
            <div class="stat-micro bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl p-3 text-center border border-emerald-100/40">
                <p class="text-lg font-extrabold text-emerald-700">{{ $completedToday }}</p>
                <p class="text-[10px] text-emerald-600 font-semibold">Selesai</p>
            </div>
            <div class="stat-micro bg-gradient-to-br from-purple-50 to-violet-50 rounded-xl p-3 text-center border border-purple-100/40">
                <p class="text-lg font-extrabold text-purple-900">{{ $loginToday }}</p>
                <p class="text-[10px] text-purple-600 font-semibold">Login</p>
            </div>
        </div>

        @if (!empty($summary))
        <div class="flex flex-wrap gap-1.5 mb-4">
            @foreach ($summary as $aksi => $count)
                @php
                    $color = match(true) {
                        str_contains($aksi, 'approve') => 'emerald',
                        str_contains($aksi, 'reject') => 'red',
                        str_contains($aksi, 'create') => 'blue',
                        str_contains($aksi, 'delete') || str_contains($aksi, 'cancel') => 'red',
                        str_contains($aksi, 'login') => 'purple',
                        default => 'gray',
                    };
                @endphp
                <span class="chip bg-{{ $color }}-50 text-{{ $color }}-700 border border-{{ $color }}-100">
                    {{ $aksi }}: {{ $count }}
                </span>
            @endforeach
        </div>
        @endif

        @if (!empty($logs))
        <div class="space-y-0 divide-y divide-gray-50">
            @foreach (array_slice($logs, 0, 8) as $log)
            <div class="flex items-start gap-2.5 py-2.5 first:pt-0 last:pb-0">
                <div class="shrink-0 w-7 h-7 rounded-full bg-{{ $log['color'] }}-100 text-{{ $log['color'] }}-600 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $log['icon'] }}"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-700 leading-snug">
                        <span class="font-semibold">{{ $log['user_name'] }}</span>
                        <span class="text-gray-500"> {{ $log['deskripsi'] }}</span>
                    </p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-[10px] text-gray-400">{{ $log['created_at'] }}</span>
                        @if ($log['tipe'])
                            <span class="chip bg-gray-50 text-gray-500 border border-gray-100">{{ $log['tipe'] }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if (count($logs) > 8)
        <div class="mt-3 pt-3 border-t border-gray-100/60 text-center">
            <a href="{{ route('admin.activity-log.index') }}" class="text-xs font-medium text-violet-600 hover:text-violet-700 transition">Lihat Semua Aktivitas &rarr;</a>
        </div>
        @endif
        @else
        <div class="empty-state">
            <div class="empty-state-icon bg-gray-50 border border-gray-100">
                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            </div>
            <p class="text-sm text-gray-400 font-medium">Belum ada aktivitas</p>
            <p class="text-xs text-gray-300 mt-0.5">Aktivitas akan tercatat di sini</p>
        </div>
        @endif
    </div>
</div>
