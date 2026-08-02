@if (!empty($latestSubmissions) && count($latestSubmissions) > 0)
<div class="bento-card bg-white rounded-2xl shadow-sm overflow-hidden animate-slide-up" style="animation-delay: 0.3s">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-800">Pengajuan Terbaru</h2>
                <p class="text-xs text-gray-400">{{ count($latestSubmissions) }} pengajuan terakhir</p>
            </div>
        </div>
        <a href="{{ route('admin.pengajuan.index') }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700 flex items-center gap-1 bg-emerald-50 px-3 py-1.5 rounded-lg transition hover:bg-emerald-100">Lihat Semua <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-50 text-sm">
            <thead>
                <tr class="bg-gray-50/80">
                    <th class="px-5 py-3.5 text-left font-medium text-gray-500 text-[11px] uppercase tracking-wider">Pemohon</th>
                    <th class="px-5 py-3.5 text-left font-medium text-gray-500 text-[11px] uppercase tracking-wider">Jenis</th>
                    <th class="px-5 py-3.5 text-left font-medium text-gray-500 text-[11px] uppercase tracking-wider hidden sm:table-cell">Progress</th>
                    <th class="px-5 py-3.5 text-left font-medium text-gray-500 text-[11px] uppercase tracking-wider hidden md:table-cell">Status</th>
                    <th class="px-5 py-3.5 text-left font-medium text-gray-500 text-[11px] uppercase tracking-wider hidden lg:table-cell">Tanggal</th>
                    <th class="px-5 py-3.5 text-center font-medium text-gray-500 text-[11px] uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($latestSubmissions as $item)
                <tr class="hover:bg-gray-50/50 transition group">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-600 shrink-0 shadow-sm ring-2 ring-white">
                                {{ $item['user_avatar'] }}
                            </div>
                            <span class="font-medium text-gray-900 text-sm">{{ $item['user_name'] }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-gray-700 text-sm capitalize">{{ $item['jenis_surat'] }}</td>
                    <td class="px-5 py-3.5 hidden sm:table-cell">
                        <div class="flex items-center gap-2">
                            <div class="progress-bar w-20">
                                <div class="progress-bar-fill bg-emerald-500" style="width: {{ $item['progress'] }}%"></div>
                            </div>
                            <span class="text-[11px] text-gray-500 font-medium">{{ $item['progress'] }}%</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 hidden md:table-cell">
                        <span class="badge-status {{ $item['status_color'] }}">{{ $item['status_label'] }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs hidden lg:table-cell whitespace-nowrap">{{ $item['created_at'] }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <a href="{{ $item['url'] }}" class="inline-flex items-center gap-1.5 text-emerald-600 hover:text-emerald-700 text-xs font-medium bg-emerald-50 hover:bg-emerald-100 px-3.5 py-1.5 rounded-lg transition shadow-sm hover:shadow">
                            Detail
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
