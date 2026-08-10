<x-admin-layout title="Monitoring Antrean" maxWidth="max-w-[1440px]">
    @if (session('success'))
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-1">Monitoring Antrean</h1>
        <p class="text-gray-500 text-sm">Status antrean dan pekerjaan latar (queue) sistem.</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6" id="statCards">
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900">{{ $stats['waiting'] }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Menunggu</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900">{{ $batchStatuses['processing'] }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Sedang Diproses</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-green-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900">{{ $batchStatuses['completed'] }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Selesai</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-400 to-rose-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900">{{ $stats['failed'] }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Gagal</p>
                </div>
            </div>
            <p class="text-[10px] text-gray-400 mt-2 ml-[52px]">Batch gagal: {{ $batchStatuses['failed'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="widget-card">
            <div class="widget-card-header">
                <h2 class="text-sm font-semibold text-gray-700">Waktu Proses Rata-rata</h2>
            </div>
            <div class="widget-card-body">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-xs text-gray-500">Keseluruhan</div>
                        <div class="text-lg font-bold text-gray-800">{{ number_format($processingTime['overall_avg_seconds'], 1) }} <span class="text-sm font-normal text-gray-400">detik</span></div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Hari Ini</div>
                        <div class="text-lg font-bold text-gray-800">{{ number_format($processingTime['today_avg_seconds'], 1) }} <span class="text-sm font-normal text-gray-400">detik</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="widget-card">
            <div class="widget-card-header">
                <h2 class="text-sm font-semibold text-gray-700">Antrean per Jalur</h2>
            </div>
            <div class="widget-card-body">
                @if (count($jobsByQueue) > 0)
                    <div class="space-y-2">
                        @foreach ($jobsByQueue as $item)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">{{ $item->queue }}</span>
                                <span class="font-semibold text-gray-800">{{ $item->total }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-sm">Tidak ada antrean menunggu.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="widget-card">
            <div class="widget-card-header">
                <h2 class="text-sm font-semibold text-gray-700">Tren 7 Hari Terakhir</h2>
            </div>
            <div class="widget-card-body">
                <canvas id="weeklyChart" height="200"></canvas>
            </div>
        </div>
        <div class="widget-card">
            <div class="widget-card-header">
                <h2 class="text-sm font-semibold text-gray-700">Status Batch</h2>
            </div>
            <div class="widget-card-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="widget-card">
        <div class="widget-card-header">
            <h2 class="text-sm font-semibold text-gray-700">Failed Jobs</h2>
            <div class="flex items-center gap-2">
                @can('queue.manage')
                    @if ($failed['total'] > 0)
                        <form action="{{ route('admin.queue.retryAll') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1 text-xs text-amber-700 bg-amber-50 hover:bg-amber-600 hover:text-white border border-amber-200 px-3 py-1.5 rounded-lg transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Retry Semua
                            </button>
                        </form>
                        <form action="{{ route('admin.queue.destroyAll') }}" method="POST" class="inline" onsubmit="return confirm('Hapus semua failed jobs?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1 text-xs text-red-700 bg-red-50 hover:bg-red-600 hover:text-white border border-red-200 px-3 py-1.5 rounded-lg transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus Semua
                            </button>
                        </form>
                    @endif
                @endcan
            </div>
        </div>

        @if ($failed['total'] > 0)
            <div class="widget-card-body-compact">
                <div class="overflow-x-auto">
                    <table class="table-enhanced">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Job</th>
                                <th>Queue</th>
                                <th>Exception</th>
                                <th>Gagal Pada</th>
                                @can('queue.manage')
                                    <th class="text-right">Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($failed['items'] as $job)
                                <tr class="group hover:bg-gray-50/50 transition-colors">
                                    <td class="text-gray-800 font-mono text-xs">#{{ $job->id }}</td>
                                    <td class="text-gray-800 max-w-[180px] truncate" title="{{ $job->display_name }}">{{ $job->display_name }}</td>
                                    <td class="text-gray-600">{{ $job->queue }}</td>
                                    <td>
                                        <button onclick="alert(`{{ addslashes($job->exception_preview) }}`)" class="text-xs text-red-600 hover:text-red-800 underline">Lihat</button>
                                    </td>
                                    <td class="text-gray-500 text-xs whitespace-nowrap">{{ $job->failed_at }}</td>
                                    @can('queue.manage')
                                        <td class="text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1">
                                                <form action="{{ route('admin.queue.retry', $job->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-xs text-amber-700 bg-amber-50 hover:bg-amber-600 hover:text-white border border-amber-200 px-2 py-1 rounded-lg transition-all" title="Retry">Retry</button>
                                                </form>
                                                <form action="{{ route('admin.queue.destroy', $job->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus failed job #{{ $job->id }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs text-red-700 bg-red-50 hover:bg-red-600 hover:text-white border border-red-200 px-2 py-1 rounded-lg transition-all" title="Hapus">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    @endcan
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-400 py-10">Tidak ada failed jobs.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($failed['last_page'] > 1)
                    <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                        <span>Halaman {{ $failed['current_page'] }} dari {{ $failed['last_page'] }} ({{ $failed['total'] }} total)</span>
                        <div class="flex gap-1">
                            @if ($failed['current_page'] > 1)
                                <a href="{{ route('admin.queue.index', ['page' => $failed['current_page'] - 1]) }}" class="px-2 py-1 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">&laquo;</a>
                            @endif
                            @if ($failed['has_more'])
                                <a href="{{ route('admin.queue.index', ['page' => $failed['current_page'] + 1]) }}" class="px-2 py-1 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">&raquo;</a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon bg-emerald-50">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-sm text-gray-400">Tidak ada failed jobs. Semua antrean berjalan lancar.</p>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        const weeklyData = @json($weeklyStats);

        new Chart(document.getElementById('weeklyChart'), {
            type: 'bar',
            data: {
                labels: weeklyData.map(d => d.label.substring(0, 3) + ' ' + d.date.slice(-5)),
                datasets: [
                    {
                        label: 'Selesai',
                        data: weeklyData.map(d => d.processed),
                        backgroundColor: 'rgba(16, 185, 129, 0.6)',
                        borderColor: '#10b981',
                        borderWidth: 1
                    },
                    {
                        label: 'Gagal',
                        data: weeklyData.map(d => d.failed),
                        backgroundColor: 'rgba(239, 68, 68, 0.6)',
                        borderColor: '#ef4444',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top', labels: { boxWidth: 12, padding: 12 } } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        const statusData = @json($batchStatuses);

        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Selesai', 'Diproses', 'Gagal', 'Dibatalkan'],
                datasets: [{
                    data: [statusData.completed, statusData.processing, statusData.failed, statusData.cancelled],
                    backgroundColor: ['#10b981', '#3b82f6', '#ef4444', '#6b7280'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'right', labels: { boxWidth: 12, padding: 12 } }
                }
            }
        });
    </script>
    @endpush
</x-admin-layout>
