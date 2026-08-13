<div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
    {{-- Main Card: Total Surat (spans 8 cols) --}}
    <div class="lg:col-span-8">
        <div class="bento-card bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 rounded-2xl shadow-lg shadow-emerald-500/20 p-6 h-full text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/3"></div>
            <div class="relative">
                <div class="flex items-start justify-between mb-5">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium">Total Pengajuan Surat</p>
                        <p class="text-5xl font-extrabold mt-1 tracking-tight" x-data x-init="animateNumber($el, {{ $stats['totalSurat']['value'] }})">0</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @php
                        $subStats = [
                            ['label' => 'Menunggu', 'value' => $stats['pending']['value'], 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z', 'bg' => 'bg-amber-400/20'],
                            ['label' => 'Diproses', 'value' => $stats['proses']['value'], 'icon' => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182', 'bg' => 'bg-teal-400/20'],
                            ['label' => 'Selesai', 'value' => $stats['selesai']['value'], 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'bg' => 'bg-green-400/20'],
                            ['label' => 'Ditolak', 'value' => $stats['ditolak']['value'], 'icon' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'bg' => 'bg-red-400/20'],
                        ];
                    @endphp
                    @foreach ($subStats as $sub)
                    <div class="stat-micro flex items-center gap-2.5 bg-white/15 backdrop-blur rounded-xl p-3">
                        <div class="w-9 h-9 rounded-lg {{ $sub['bg'] }} flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $sub['icon'] }}"/></svg>
                        </div>
                        <div>
                            <p class="text-lg font-bold leading-none" x-data x-init="animateNumber($el, {{ $sub['value'] }})">0</p>
                            <p class="text-[10px] text-emerald-200 mt-0.5">{{ $sub['label'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-3 border-t border-white/20 flex items-center justify-between text-xs">
                    <span class="text-emerald-200">30 hari terakhir</span>
                    <div class="flex items-center gap-1">
                        <span class="font-semibold">{{ $stats['totalSurat']['growth'] > 0 ? '+' : '' }}{{ $stats['totalSurat']['growth'] }}%</span>
                        <span class="w-2 h-2 rounded-full {{ $stats['totalSurat']['growth'] >= 0 ? 'bg-green-300' : 'bg-red-300' }}"></span>
                    </div>
                </div>
                @if (!empty($stats['totalSurat']['sparkline']))
                    @php
                        $sparkData = array_slice($stats['totalSurat']['sparkline'], -30);
                        $sparkMax = max($sparkData) ?: 1;
                    @endphp
                    <div class="flex items-end gap-px h-5 mt-2">
                        @foreach ($sparkData as $val)
                            <div class="sparkline-bar" style="height: {{ ($val / $sparkMax) * 100 }}%"></div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Side Stats (spans 4 cols) --}}
    <div class="lg:col-span-4 grid grid-cols-2 lg:grid-cols-1 gap-4">
        @php
            $sideStats = [
                ['value' => $stats['totalWarga']['value'], 'growth' => $stats['totalWarga']['growth'], 'label' => 'Total Warga', 'color' => 'emerald', 'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z'],
                ['value' => $stats['eventBulanIni']['value'], 'growth' => $stats['eventBulanIni']['growth'], 'label' => 'Event Bulan Ini', 'color' => 'pink', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
                ['value' => $stats['beritaAktif']['value'], 'growth' => $stats['beritaAktif']['growth'], 'label' => 'Berita Aktif', 'color' => 'teal', 'icon' => 'M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z'],
            ];
        @endphp
        @foreach ($sideStats as $bs)
        <div class="stat-micro bento-card bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-{{ $bs['color'] }}-50 text-{{ $bs['color'] }}-600 flex items-center justify-center shrink-0 border border-{{ $bs['color'] }}-100/50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $bs['icon'] }}"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-xl font-bold text-gray-900 count-up" x-data x-init="animateNumber($el, {{ $bs['value'] }})">0</p>
                <p class="text-[11px] text-gray-500 truncate">{{ $bs['label'] }}</p>
                <div class="flex items-center gap-1 mt-0.5">
                    <span class="text-[10px] font-semibold text-{{ $bs['growth'] >= 0 ? 'green' : 'red' }}-600">{{ $bs['growth'] >= 0 ? '+' : '' }}{{ $bs['growth'] }}%</span>
                    <span class="text-[10px] text-gray-400">vs bulan lalu</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Top RT / RW + Operator Performance --}}
@if (!empty($topRtrw['rt']) || !empty($topRtrw['rw']) || !empty($operatorPerformance))
<div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mt-4">
    {{-- Top RT --}}
    @if (!empty($topRtrw['rt']))
    <div class="widget-card">
        <div class="widget-card-header">
            <div class="flex items-center gap-2.5">
                <div class="widget-icon bg-emerald-50 text-emerald-600 border border-emerald-100/50">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                </div>
                <h3 class="text-xs font-semibold text-gray-800">Top RT</h3>
            </div>
        </div>
        <div class="widget-card-body pt-0">
            <div class="space-y-3">
                @foreach ($topRtrw['rt'] as $i => $item)
                <div class="flex items-center gap-2.5">
                    <span class="w-5 h-5 rounded-full {{ $i === 0 ? 'bg-emerald-500 text-white shadow-sm shadow-emerald-200' : 'bg-emerald-100 text-emerald-700' }} text-[9px] font-bold flex items-center justify-center shrink-0">{{ $i + 1 }}</span>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-medium text-gray-700">{{ $item['label'] }}</span>
                            <span class="text-[10px] font-bold text-emerald-600">{{ $item['total'] }}</span>
                        </div>
                        <div class="progress-bar progress-bar-sm">
                            <div class="progress-bar-fill !bg-emerald-500" style="width: {{ $topRtrw['rt'][0]['total'] > 0 ? ($item['total'] / $topRtrw['rt'][0]['total']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Top RW --}}
    @if (!empty($topRtrw['rw']))
    <div class="widget-card">
        <div class="widget-card-header">
            <div class="flex items-center gap-2.5">
                <div class="widget-icon bg-purple-50 text-purple-600 border border-purple-100/50">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/></svg>
                </div>
                <h3 class="text-xs font-semibold text-gray-800">Top RW</h3>
            </div>
        </div>
        <div class="widget-card-body pt-0">
            <div class="space-y-3">
                @foreach ($topRtrw['rw'] as $i => $item)
                <div class="flex items-center gap-2.5">
                    <span class="w-5 h-5 rounded-full {{ $i === 0 ? 'bg-purple-500 text-white shadow-sm shadow-purple-200' : 'bg-purple-100 text-purple-700' }} text-[9px] font-bold flex items-center justify-center shrink-0">{{ $i + 1 }}</span>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-medium text-gray-700">{{ $item['label'] }}</span>
                            <span class="text-[10px] font-bold text-purple-600">{{ $item['total'] }}</span>
                        </div>
                        <div class="progress-bar progress-bar-sm">
                            <div class="progress-bar-fill !bg-purple-500" style="width: {{ $topRtrw['rw'][0]['total'] > 0 ? ($item['total'] / $topRtrw['rw'][0]['total']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Performa Operator --}}
    @if (!empty($operatorPerformance))
    <div class="widget-card">
        <div class="widget-card-header">
            <div class="flex items-center gap-2.5">
                <div class="widget-icon bg-amber-50 text-amber-600 border border-amber-100/50">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                </div>
                <h3 class="text-xs font-semibold text-gray-800">Performa Operator</h3>
            </div>
        </div>
        <div class="widget-card-body pt-0">
            <div class="overflow-x-auto">
                <table class="table-enhanced">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">OK</th>
                            <th class="text-center">Tolak</th>
                            <th class="text-center">Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($operatorPerformance as $op)
                        <tr>
                            <td class="font-medium text-gray-700">{{ $op['name'] }}</td>
                            <td class="text-center font-bold text-gray-900">{{ $op['total'] }}</td>
                            <td class="text-center text-emerald-600 font-medium">{{ $op['approvals'] }}</td>
                            <td class="text-center text-red-500 font-medium">{{ $op['rejections'] }}</td>
                            <td class="text-center">
                                <span class="chip {{ $op['approval_rate'] >= 80 ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : ($op['approval_rate'] >= 50 ? 'bg-amber-50 text-amber-700 border border-amber-100' : 'bg-red-50 text-red-700 border border-red-100') }}">
                                    {{ $op['approval_rate'] }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endif
