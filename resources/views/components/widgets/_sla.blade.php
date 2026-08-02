<div class="widget-card overflow-hidden">
    <div class="widget-card-header">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center text-white shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-800">SLA Monitoring</h2>
                <p class="text-xs text-gray-400">Pengajuan melebihi batas waktu 3 hari</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-4 text-xs">
                <div class="text-center">
                    <p class="text-xl font-bold text-gray-900">{{ $overdueCount }}</p>
                    <p class="text-[10px] text-gray-400 font-medium">Melebihi SLA</p>
                </div>
                <div class="w-px h-8 bg-gray-200"></div>
                <div class="text-center">
                    <p class="text-xl font-bold {{ $avgProcessingHours > 72 ? 'text-red-600' : ($avgProcessingHours > 48 ? 'text-amber-600' : 'text-emerald-600') }}">{{ $avgProcessingHours }}<span class="text-xs font-medium">j</span></p>
                    <p class="text-[10px] text-gray-400 font-medium">Rata-rata</p>
                </div>
            </div>
            <span class="pulse-dot {{ $overdueCount > 0 ? 'error active' : 'ok' }}"></span>
        </div>
    </div>

    @if (!empty($overdue) && count($overdue) > 0)
    <div class="overflow-x-auto">
        <table class="table-enhanced">
            <thead>
                <tr>
                    <th>Pemohon</th>
                    <th>Jenis Surat</th>
                    <th>Status</th>
                    <th class="text-center">Lama Proses</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($overdue as $item)
                <tr class="{{ $item['days'] > 7 ? 'bg-red-50/30' : '' }}">
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-600 shrink-0 ring-2 ring-white shadow-sm">
                                {{ $item['user_avatar'] }}
                            </div>
                            <span class="font-medium text-gray-900 text-sm">{{ $item['user_name'] }}</span>
                        </div>
                    </td>
                    <td class="text-gray-600 text-xs capitalize">{{ $item['jenis_surat'] }}</td>
                    <td><span class="badge-status {{ $item['status_color'] }}">{{ $item['status_label'] }}</span></td>
                    <td class="text-center">
                        <span class="chip {{ $item['days'] > 7 ? 'bg-red-50 text-red-700 border border-red-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                            {{ $item['days'] }} hari
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ $item['url'] }}" class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg border border-emerald-100 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                            Proses
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="px-6 py-14 text-center">
        <div class="empty-state-icon bg-emerald-50 mx-auto border border-emerald-100/50">
            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-sm text-gray-500 font-medium mt-3">Semua surat dalam SLA</p>
        <p class="text-xs text-gray-400 mt-0.5">Tidak ada surat yang melebihi batas waktu</p>
    </div>
    @endif
</div>
