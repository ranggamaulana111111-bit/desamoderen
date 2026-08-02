@if (!empty($analyticsSummary))
<div class="bento-card bg-white rounded-2xl shadow-sm p-5 animate-slide-up" style="animation-delay: 0.4s">
    <h2 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
        Ringkasan Analitik
    </h2>
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
        <div class="bg-gray-50 rounded-xl p-3.5 text-center">
            <p class="text-[11px] text-gray-500 mb-0.5">Hari Ini</p>
            <p class="text-xl font-bold text-gray-900 count-up" x-data x-init="animateNumber($el, {{ $analyticsSummary['today'] }})">0</p>
            <p class="text-[10px] text-emerald-600">{{ $analyticsSummary['todayCompleted'] }} selesai</p>
        </div>
        <div class="bg-gray-50 rounded-xl p-3.5 text-center">
            <p class="text-[11px] text-gray-500 mb-0.5">Minggu Ini</p>
            <p class="text-xl font-bold text-gray-900 count-up" x-data x-init="animateNumber($el, {{ $analyticsSummary['thisWeek'] }})">0</p>
            <p class="text-[10px] text-emerald-600">{{ $analyticsSummary['thisWeekCompleted'] }} selesai</p>
        </div>
        <div class="bg-gray-50 rounded-xl p-3.5 text-center">
            <p class="text-[11px] text-gray-500 mb-0.5">Bulan Ini</p>
            <p class="text-xl font-bold text-gray-900 count-up" x-data x-init="animateNumber($el, {{ $analyticsSummary['thisMonth'] }})">0</p>
            <p class="text-[10px] text-emerald-600">{{ $analyticsSummary['thisMonthCompleted'] }} selesai</p>
        </div>
        <div class="bg-gray-50 rounded-xl p-3.5 text-center">
            <p class="text-[11px] text-gray-500 mb-0.5">Tahun Ini</p>
            <p class="text-xl font-bold text-gray-900 count-up" x-data x-init="animateNumber($el, {{ $analyticsSummary['thisYear'] }})">0</p>
        </div>
        <div class="bg-gray-50 rounded-xl p-3.5 text-center">
            <p class="text-[11px] text-gray-500 mb-0.5">Rata-rata Proses</p>
            <p class="text-xl font-bold text-gray-900">{{ $analyticsSummary['avgProcessingTime'] }}</p>
            <p class="text-[10px] text-gray-400">jam</p>
        </div>
        <div class="bg-gray-50 rounded-xl p-3.5 text-center">
            <p class="text-[11px] text-gray-500 mb-0.5">Tingkat Sukses</p>
            <p class="text-xl font-bold text-emerald-600">{{ $analyticsSummary['successRate'] }}%</p>
        </div>
        <div class="bg-gray-50 rounded-xl p-3.5 text-center">
            <p class="text-[11px] text-gray-500 mb-0.5">Tingkat Tolak</p>
            <p class="text-xl font-bold text-red-600">{{ $analyticsSummary['rejectionRate'] }}%</p>
        </div>
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-3.5 text-center text-white shadow-sm">
            <p class="text-[11px] text-emerald-100 mb-0.5">Kesehatan</p>
            <p class="text-lg font-bold mt-0.5">{{ $systemHealth['health_percent'] }}%</p>
            <p class="text-[10px] text-emerald-100">{{ $systemHealth['health_status'] }}</p>
        </div>
    </div>
</div>
@endif
