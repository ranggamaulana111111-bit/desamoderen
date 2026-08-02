@if (!empty($trends))
<div class="grid grid-cols-1 xl:grid-cols-3 gap-5 animate-slide-up" style="animation-delay: 0.2s"
     x-data="chartSection()" x-init="initCharts()">
    <div class="xl:col-span-2 bento-card bg-white rounded-2xl shadow-sm p-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/></svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-800">Tren Pengajuan Surat</h2>
            </div>
            <div class="flex items-center gap-1.5 flex-wrap">
                @foreach ([7 => '7H', 30 => '30H', 90 => '90H', 365 => '1TH'] as $days => $label)
                <button
                    @click="filterMainChart({{ $days }})"
                    :class="mainChartDays === {{ $days }} ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50'"
                    class="text-xs px-3 py-1.5 rounded-lg border transition font-medium">
                    {{ $label }}
                </button>
                @endforeach
            </div>
        </div>
        <div class="chart-container" style="min-height: 240px">
            <canvas id="mainChart"></canvas>
        </div>
    </div>
    <div class="bento-card bg-white rounded-2xl shadow-sm p-5">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-7 h-7 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z"/></svg>
            </div>
            <h2 class="text-sm font-semibold text-gray-800">Distribusi Surat</h2>
        </div>
        <div class="chart-container" style="min-height: 200px">
            <canvas id="donutChart"></canvas>
        </div>
        <div class="mt-4 space-y-2.5" id="donutLegend"></div>
    </div>
</div>
@endif
