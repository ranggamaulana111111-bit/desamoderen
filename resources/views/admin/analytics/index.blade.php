<x-admin-layout title="Analitik & Laporan" maxWidth="max-w-[1440px]">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Analitik &amp; Laporan</h1>
            <p class="text-gray-500 text-sm mt-1">Ringkasan data pengajuan surat dan performa layanan.</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <span id="analytics-updated" class="hidden sm:inline text-[11px] text-gray-400"></span>
            <form method="GET" class="flex items-center gap-2 flex-wrap">
                <input type="date" name="start" value="{{ $start?->format('Y-m-d') }}"
                    class="border border-gray-200 rounded-xl px-3 py-1.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                <span class="text-gray-400 text-sm">s/d</span>
                <input type="date" name="end" value="{{ $end?->format('Y-m-d') }}"
                    class="border border-gray-200 rounded-xl px-3 py-1.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-3 py-1.5 rounded-xl text-sm font-semibold shadow-sm transition-all">Filter</button>
                @if ($start || $end)
                    <a href="{{ route('admin.analytics.index') }}" class="text-gray-500 text-sm hover:text-gray-700 px-2">Reset</a>
                @endif
            </form>
            <a href="{{ route('admin.analytics.export') }}{{ $start || $end ? '?'.http_build_query(request()->only(['start', 'end'])) : '' }}"
                class="inline-flex items-center gap-1 text-sm text-emerald-700 bg-emerald-50 hover:bg-emerald-600 hover:text-white border border-emerald-200 px-3 py-1.5 rounded-xl font-semibold transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export CSV
            </a>
        </div>
    </div>

    @if (in_array('overview', $activeWidgets))
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p id="ov-total" class="text-xl font-extrabold text-gray-900">{{ $stats['overview']['total'] }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Total</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-green-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p id="ov-completed" class="text-xl font-extrabold text-gray-900">{{ $stats['overview']['completed'] }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Selesai</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-400 to-rose-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p id="ov-rejected" class="text-xl font-extrabold text-gray-900">{{ $stats['overview']['rejected'] }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Ditolak</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p id="ov-active" class="text-xl font-extrabold text-gray-900">{{ $stats['overview']['active'] }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Dalam Proses</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <div>
                    <p id="ov-approvalRate" class="text-xl font-extrabold text-gray-900">{{ $stats['overview']['approvalRate'] }}%</p>
                    <p class="text-[10px] text-gray-500 font-medium">% Disetujui</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-400 to-pink-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                </div>
                <div>
                    <p id="ov-rejectionRate" class="text-xl font-extrabold text-gray-900">{{ $stats['overview']['rejectionRate'] }}%</p>
                    <p class="text-[10px] text-gray-500 font-medium">% Ditolak</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (in_array('trends', $activeWidgets) || in_array('popular', $activeWidgets))
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        @if (in_array('trends', $activeWidgets))
        <div class="widget-card">
            <div class="widget-card-header">
                <h2 class="text-sm font-semibold text-gray-700">Tren Pengajuan per Bulan</h2>
            </div>
            <div class="widget-card-body">
                <canvas id="monthlyChart" height="200"></canvas>
            </div>
        </div>
        @endif
        @if (in_array('popular', $activeWidgets))
        <div class="widget-card">
            <div class="widget-card-header">
                <h2 class="text-sm font-semibold text-gray-700">Jenis Surat Terpopuler</h2>
            </div>
            <div class="widget-card-body">
                <canvas id="letterTypeChart" height="200"></canvas>
            </div>
        </div>
        @endif
    </div>
    @endif

    @if (in_array('status', $activeWidgets) || in_array('users', $activeWidgets))
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        @if (in_array('status', $activeWidgets))
        <div class="widget-card">
            <div class="widget-card-header">
                <h2 class="text-sm font-semibold text-gray-700">Distribusi Status</h2>
            </div>
            <div class="widget-card-body">
                <canvas id="statusChart" height="220"></canvas>
            </div>
        </div>
        @endif
        @if (in_array('users', $activeWidgets))
        <div class="widget-card">
            <div class="widget-card-header">
                <h2 class="text-sm font-semibold text-gray-700">Pertumbuhan Pengguna</h2>
            </div>
            <div class="widget-card-body">
                <canvas id="userGrowthChart" height="220"></canvas>
            </div>
        </div>
        @endif
    </div>
    @endif

    @if (in_array('processing', $activeWidgets))
    <div class="widget-card mb-6">
        <div class="widget-card-header">
            <h2 class="text-sm font-semibold text-gray-700">Rata-rata Waktu Proses per Jenis Surat</h2>
        </div>
        <div class="widget-card-body-compact">
            <div class="overflow-x-auto">
                <table class="table-enhanced">
                    <thead>
                        <tr>
                            <th>Jenis Surat</th>
                            <th>Rata-rata (jam)</th>
                            <th>Rata-rata (hari)</th>
                            <th>Sampel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stats['avgProcessingTime'] as $item)
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="text-gray-800">{{ $item['label'] }}</td>
                                <td class="text-gray-600">{{ number_format($item['avg_hours'], 1) }}</td>
                                <td class="text-gray-600">{{ number_format($item['avg_days'], 1) }}</td>
                                <td class="text-gray-600">{{ $item['sample_count'] }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-gray-400 py-10">Belum ada data pengajuan selesai.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <div class="widget-card">
        <div class="widget-card-header">
            <h2 class="text-sm font-semibold text-gray-700">Performa Petugas</h2>
        </div>
        <div class="widget-card-body-compact">
            <div class="overflow-x-auto">
                <table class="table-enhanced">
                    <thead>
                        <tr>
                            <th>Petugas</th>
                            <th>Total Tindakan</th>
                            <th>Setuju</th>
                            <th>Tolak</th>
                            <th>Revisi</th>
                            <th>Approval Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stats['operatorPerformance'] as $op)
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="text-gray-800">{{ $op['name'] }}</td>
                                <td class="text-gray-600">{{ $op['total'] }}</td>
                                <td class="text-emerald-600 font-medium">{{ $op['approvals'] }}</td>
                                <td class="text-red-600 font-medium">{{ $op['rejections'] }}</td>
                                <td class="text-amber-600 font-medium">{{ $op['revisions'] }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="progress-bar w-20">
                                            <div class="progress-bar-fill" style="width: {{ $op['approval_rate'] }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-600">{{ $op['approval_rate'] }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-gray-400 py-10">Belum ada aktivitas petugas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const refreshInterval = @json($refreshInterval);
        const monthlyData = @json($stats['monthlyTrends']);
        const typeData = @json($stats['popularTypes']);
        const statusData = @json($stats['statusDistribution']);
        const growthData = @json($stats['userGrowth']);
        const charts = {};

        if (document.getElementById('monthlyChart')) {
            charts.monthly = new Chart(document.getElementById('monthlyChart'), {
                type: 'line',
                data: {
                    labels: monthlyData.map(d => d.label.substring(0, 6)),
                    datasets: [
                        { label: 'Total', data: monthlyData.map(d => d.total), borderColor: '#6366f1', backgroundColor: 'rgba(99,102,241,0.1)', tension: 0.3, fill: true },
                        { label: 'Selesai', data: monthlyData.map(d => d.selesai), borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)', tension: 0.3, fill: true },
                        { label: 'Ditolak', data: monthlyData.map(d => d.ditolak), borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,0.1)', tension: 0.3, fill: true }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top', labels: { boxWidth: 12, padding: 12 } } },
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                }
            });
        }

        if (document.getElementById('letterTypeChart')) {
            charts.letterType = new Chart(document.getElementById('letterTypeChart'), {
                type: 'bar',
                data: {
                    labels: typeData.map(d => d.label),
                    datasets: [
                        { label: 'Total', data: typeData.map(d => d.total), backgroundColor: 'rgba(99,102,241,0.6)', borderColor: '#6366f1', borderWidth: 1 },
                        { label: 'Selesai', data: typeData.map(d => d.selesai), backgroundColor: 'rgba(16,185,129,0.6)', borderColor: '#10b981', borderWidth: 1 },
                        { label: 'Ditolak', data: typeData.map(d => d.ditolak), backgroundColor: 'rgba(239,68,68,0.6)', borderColor: '#ef4444', borderWidth: 1 }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top', labels: { boxWidth: 12, padding: 12 } } },
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                }
            });
        }

        if (document.getElementById('statusChart')) {
            charts.status = new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: statusData.map(d => d.label),
                    datasets: [{
                        data: statusData.map(d => d.total),
                        backgroundColor: statusData.map(d => d.chart_color),
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'right', labels: { boxWidth: 12, padding: 8, font: { size: 11 } } }
                    }
                }
            });
        }

        if (document.getElementById('userGrowthChart')) {
            charts.userGrowth = new Chart(document.getElementById('userGrowthChart'), {
                type: 'line',
                data: {
                    labels: growthData.map(d => d.label.substring(0, 6)),
                    datasets: [
                        { label: 'Pengguna Baru', data: growthData.map(d => d.baru), backgroundColor: 'rgba(20,184,166,0.2)', borderColor: '#14b8a6', tension: 0.3, fill: true },
                        { label: 'Total Akumulasi', data: growthData.map(d => d.total_akumulasi), borderColor: '#8b5cf6', tension: 0.3, borderDash: [5, 3], pointRadius: 2 }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top', labels: { boxWidth: 12, padding: 12 } } },
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                }
            });
        }

        async function refreshAnalytics() {
            const params = new URLSearchParams(window.location.search);
            const query = params.toString();
            const url = '{{ route('admin.analytics.chart') }}' + (query ? '?' + query : '');

            try {
                const resp = await fetch(url, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
                const s = await resp.json();

                const setOv = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
                setOv('ov-total', s.overview.total);
                setOv('ov-completed', s.overview.completed);
                setOv('ov-rejected', s.overview.rejected);
                setOv('ov-active', s.overview.active);
                setOv('ov-approvalRate', s.overview.approvalRate + '%');
                setOv('ov-rejectionRate', s.overview.rejectionRate + '%');

                if (charts.monthly) {
                    charts.monthly.data.labels = s.monthlyTrends.map(d => d.label.substring(0, 6));
                    charts.monthly.data.datasets[0].data = s.monthlyTrends.map(d => d.total);
                    charts.monthly.data.datasets[1].data = s.monthlyTrends.map(d => d.selesai);
                    charts.monthly.data.datasets[2].data = s.monthlyTrends.map(d => d.ditolak);
                    charts.monthly.update();
                }
                if (charts.letterType) {
                    charts.letterType.data.labels = s.popularTypes.map(d => d.label);
                    charts.letterType.data.datasets[0].data = s.popularTypes.map(d => d.total);
                    charts.letterType.data.datasets[1].data = s.popularTypes.map(d => d.selesai);
                    charts.letterType.data.datasets[2].data = s.popularTypes.map(d => d.ditolak);
                    charts.letterType.update();
                }
                if (charts.status) {
                    charts.status.data.labels = s.statusDistribution.map(d => d.label);
                    charts.status.data.datasets[0].data = s.statusDistribution.map(d => d.total);
                    charts.status.data.datasets[0].backgroundColor = s.statusDistribution.map(d => d.chart_color);
                    charts.status.update();
                }
                if (charts.userGrowth) {
                    charts.userGrowth.data.labels = s.userGrowth.map(d => d.label.substring(0, 6));
                    charts.userGrowth.data.datasets[0].data = s.userGrowth.map(d => d.baru);
                    charts.userGrowth.data.datasets[1].data = s.userGrowth.map(d => d.total_akumulasi);
                    charts.userGrowth.update();
                }

                const updated = document.getElementById('analytics-updated');
                if (updated) updated.textContent = 'Diperbarui ' + new Date().toLocaleTimeString('id-ID');
            } catch (e) {
                console.error('Analytics refresh failed', e);
            }
        }

        if (refreshInterval > 0) {
            setInterval(refreshAnalytics, refreshInterval * 1000);
        }
    </script>
    @endpush
</x-admin-layout>
