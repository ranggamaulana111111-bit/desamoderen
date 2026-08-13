<div class="grid grid-cols-12 gap-4 auto-rows-auto animate-slide-up" style="animation-delay: 0.1s">
    {{-- Main Card: Total Surat --}}
    <div class="col-span-12 lg:col-span-6 lg:row-span-2">
        <div class="bento-card bg-white rounded-2xl shadow-sm p-6 h-full glow-emerald gradient-border">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Pengajuan Surat</p>
                    <p class="text-4xl font-bold text-gray-900 mt-1 count-up tracking-tight" x-data x-init="animateNumber($el, {{ $stats['totalSurat']['value'] }})">0</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-2">
                @php
                    $subStats = [
                        ['label' => 'Diproses', 'value' => $stats['proses']['value'], 'color' => 'purple', 'icon' => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182'],
                        ['label' => 'Selesai', 'value' => $stats['selesai']['value'], 'color' => 'green', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['label' => 'Menunggu', 'value' => $stats['pending']['value'], 'color' => 'amber', 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['label' => 'Ditolak', 'value' => $stats['ditolak']['value'], 'color' => 'red', 'icon' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ];
                @endphp
                @foreach ($subStats as $sub)
                <div class="flex items-center justify-between p-3 rounded-xl bg-{{ $sub['color'] }}-50/50 border border-{{ $sub['color'] }}-100/50">
                    <div>
                        <p class="text-[11px] text-gray-500">{{ $sub['label'] }}</p>
                        <p class="text-xl font-bold text-gray-900 count-up" x-data x-init="animateNumber($el, {{ $sub['value'] }})">0</p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-{{ $sub['color'] }}-100 flex items-center justify-center text-{{ $sub['color'] }}-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $sub['icon'] }}"/></svg>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
                <span>30 hari terakhir</span>
                <div class="flex items-center gap-1">
                    <span class="text-emerald-600 font-medium">{{ $stats['totalSurat']['growth'] > 0 ? '+' : '' }}{{ $stats['totalSurat']['growth'] }}%</span>
                    <span class="w-2 h-2 rounded-full {{ $stats['totalSurat']['growth'] >= 0 ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                </div>
            </div>
        </div>
    </div>

    @php
        $miniStats = [
            ['key' => 'pending', 'label' => 'Menunggu Verifikasi', 'color' => 'amber', 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['key' => 'proses', 'label' => 'Sedang Diproses', 'color' => 'purple', 'icon' => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182'],
            ['key' => 'selesai', 'label' => 'Selesai', 'color' => 'green', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['key' => 'ditolak', 'label' => 'Ditolak', 'color' => 'red', 'icon' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ];
    @endphp
    @foreach ($miniStats as $ms)
    <div class="col-span-6 lg:col-span-3">
        <div class="bento-card bg-white rounded-2xl shadow-sm p-5 h-full">
            <div class="flex items-start justify-between mb-2">
                <div class="w-9 h-9 rounded-xl bg-{{ $ms['color'] }}-100 text-{{ $ms['color'] }}-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $ms['icon'] }}"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900 count-up" x-data x-init="animateNumber($el, {{ $stats[$ms['key']]['value'] }})">0</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ $ms['label'] }}</p>
        </div>
    </div>
    @endforeach

    @php
        $bottomStats = [
            ['value' => $stats['totalWarga']['value'], 'growth' => $stats['totalWarga']['growth'], 'label' => 'Total Warga', 'color' => 'teal', 'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z'],
            ['value' => $stats['eventBulanIni']['value'], 'growth' => $stats['eventBulanIni']['growth'], 'label' => 'Event Bulan Ini', 'color' => 'pink', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
            ['value' => $stats['beritaAktif']['value'], 'growth' => $stats['beritaAktif']['growth'], 'label' => 'Berita Aktif', 'color' => 'teal', 'icon' => 'M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z'],
        ];
    @endphp
    @foreach ($bottomStats as $bs)
    <div class="col-span-12 md:col-span-4">
        <div class="bento-card bg-white rounded-2xl shadow-sm p-5 h-full">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-{{ $bs['color'] }}-100 text-{{ $bs['color'] }}-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $bs['icon'] }}"/></svg>
                </div>
                <div>
                    <p class="text-lg font-bold text-gray-900 count-up" x-data x-init="animateNumber($el, {{ $bs['value'] }})">0</p>
                    <p class="text-xs text-gray-500">{{ $bs['label'] }}</p>
                </div>
            </div>
            <div class="mt-3 flex items-center justify-between text-xs text-gray-400">
                <span>Pertumbuhan</span>
                <span class="text-{{ $bs['growth'] >= 0 ? 'green' : 'red' }}-600 font-medium">{{ $bs['growth'] >= 0 ? '+' : '' }}{{ $bs['growth'] }}%</span>
            </div>
        </div>
    </div>
    @endforeach
</div>
