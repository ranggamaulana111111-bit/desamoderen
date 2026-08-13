<x-admin-layout title="Laporan Kinerja Lembaga" maxWidth="max-w-[1500px]">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Laporan Kinerja Lembaga</h1>
            <p class="text-sm text-slate-500 mt-1">Jumlah upload berita &amp; event per lembaga per bulan/tahun.</p>
        </div>
        <form method="GET" action="{{ route('admin.lembaga-report.index') }}" class="flex flex-wrap items-center gap-3">
            <select name="jenis" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                <option value="total" @selected($type === 'total')>Berita + Event</option>
                <option value="berita" @selected($type === 'berita')>Berita saja</option>
                <option value="event" @selected($type === 'event')>Event saja</option>
            </select>
            <select name="tahun" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                @foreach($availableYears as $y)
                    <option value="{{ $y }}" @selected($y === $year)>{{ $y }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary">Tampilkan</button>
        </form>
    </div>

    {{-- Stat Cards --}}
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bento-card p-5">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Konten {{ $year }}</p>
            <p class="text-2xl font-bold text-slate-900 mt-2">{{ $report['grand_total'] }}</p>
        </div>
        <div class="bento-card p-5">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Berita</p>
            <p class="text-2xl font-bold text-slate-900 mt-2">{{ array_sum(collect($report['lembagas'])->pluck('berita_total')->all()) }}</p>
        </div>
        <div class="bento-card p-5">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Event</p>
            <p class="text-2xl font-bold text-slate-900 mt-2">{{ array_sum(collect($report['lembagas'])->pluck('event_total')->all()) }}</p>
        </div>
        <div class="bento-card p-5">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Lembaga Aktif</p>
            <p class="text-2xl font-bold text-slate-900 mt-2">{{ collect($report['lembagas'])->where('status', 'aktif')->count() }}</p>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid lg:grid-cols-3 gap-6 mb-6">
        <div class="bento-card p-6 lg:col-span-2">
            <div class="section-header"><h3>Tren Upload per Bulan ({{ $year }})</h3><div class="shimmer-line"></div></div>
            <div class="h-72">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
        <div class="bento-card p-6">
            <div class="section-header"><h3>Kontribusi per Lembaga ({{ $year }})</h3><div class="shimmer-line"></div></div>
            <div class="h-72">
                <canvas id="donutChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bento-card p-6 mb-6">
        <div class="section-header"><h3>Perbandingan Tahunan</h3><div class="shimmer-line"></div></div>
        <div class="h-64">
            <canvas id="trendChart"></canvas>
        </div>
    </div>

    {{-- Matrix Table --}}
    <div class="bento-card overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="section-header !mb-0"><h3>Rincian per Lembaga &amp; Bulan — {{ $year }}</h3><div class="shimmer-line"></div></div>
            <span class="text-xs text-slate-400">Kolom = jumlah {{ $type === 'berita' ? 'berita' : ($type === 'event' ? 'event' : 'berita + event') }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="table-enhanced">
                <thead>
                    <tr>
                        <th>Lembaga</th>
                        @foreach(['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'] as $bln)
                            <th class="text-center">{{ $bln }}</th>
                        @endforeach
                        <th class="text-center">Total</th>
                        <th class="text-center">Berita</th>
                        <th class="text-center">Event</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($report['lembagas'] as $row)
                    <tr>
                        <td>
                            <p class="font-semibold text-slate-800">{{ $row['nama'] }}</p>
                            <span class="badge-status {{ $row['status'] === 'aktif' ? 'bg-completed' : 'bg-rejected' }}">{{ $row['status'] === 'aktif' ? 'Aktif' : 'Nonaktif' }}</span>
                        </td>
                        @foreach($row['months'] as $count)
                            <td class="text-center">
                                @if($count > 0)
                                    <span class="inline-flex items-center justify-center min-w-7 h-7 px-1.5 rounded-lg bg-brand-50 text-brand-700 font-bold text-xs">{{ $count }}</span>
                                @else
                                    <span class="text-slate-300">0</span>
                                @endif
                            </td>
                        @endforeach
                        <td class="text-center font-bold text-slate-900">{{ $row['total'] }}</td>
                        <td class="text-center text-slate-600">{{ $row['berita_total'] }}</td>
                        <td class="text-center text-slate-600">{{ $row['event_total'] }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="17" class="text-center py-8 text-sm text-slate-400">Belum ada lembaga terdaftar.</td></tr>
                    @endforelse
                    @if(count($report['lembagas']) > 0)
                    <tr class="bg-slate-50">
                        <td class="font-bold text-slate-900">Total</td>
                        @foreach($report['totals'] as $count)
                            <td class="text-center font-bold text-slate-900">{{ $count }}</td>
                        @endforeach
                        <td class="text-center font-bold text-brand-600">{{ $report['grand_total'] }}</td>
                        <td class="text-center font-bold text-slate-900">{{ array_sum(collect($report['lembagas'])->pluck('berita_total')->all()) }}</td>
                        <td class="text-center font-bold text-slate-900">{{ array_sum(collect($report['lembagas'])->pluck('event_total')->all()) }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        const lembagaColors = ['#10b981','#14b8a6','#8b5cf6','#f59e0b','#06b6d4','#f43f5e','#84cc16','#ec4899','#14b8a6','#a855f7','#f97316','#64748b','#22d3ee','#eab308','#6366f1','#ef4444','#34d399','#fbbf24','#2dd4bf','#c084fc'];

        // ── Monthly chart ──
        new Chart(document.getElementById('monthlyChart'), {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah upload',
                    data: @json(array_values($report['totals'])),
                    backgroundColor: 'rgba(16,185,129,.75)',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });

        // ── Donut chart ──
        const donutLembaga = @json(array_values(array_map(fn ($r) => ['nama' => $r['nama'], 'total' => $r['total']], $report['lembagas'])));
        new Chart(document.getElementById('donutChart'), {
            type: 'doughnut',
            data: {
                labels: donutLembaga.map(r => r.nama),
                datasets: [{
                    data: donutLembaga.map(r => r.total),
                    backgroundColor: lembagaColors,
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } },
                    tooltip: { callbacks: { label: (ctx) => ` ${ctx.label}: ${ctx.raw} konten` } }
                }
            }
        });

        // ── Trend chart ──
        const trend = @json($trend);
        new Chart(document.getElementById('trendChart'), {
            type: 'line',
            data: {
                labels: trend.map(t => t.year),
                datasets: [
                    { label: 'Berita', data: trend.map(t => t.berita), borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,.15)', tension: .4, fill: true },
                    { label: 'Event', data: trend.map(t => t.event), borderColor: '#8b5cf6', backgroundColor: 'rgba(139,92,246,.15)', tension: .4, fill: true },
                    { label: 'Total', data: trend.map(t => t.total), borderColor: '#f59e0b', backgroundColor: 'rgba(245,158,11,.15)', tension: .4, fill: false, borderDash: [6, 4] },
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    </script>
    @endpush

</x-admin-layout>
