@if (!empty($pipeline) && count($pipeline) > 0)
@php
    $totalAll = array_sum(array_column($pipeline, 'total'));
    $maxTotal = max(array_column($pipeline, 'total')) ?: 1;
@endphp
<div class="widget-card p-5">
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-2.5">
            <div class="widget-icon bg-cyan-50 text-cyan-600 border border-cyan-100/50">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
            </div>
            <h3 class="text-xs font-semibold text-gray-800">Workflow Pipeline</h3>
        </div>
        <span class="chip bg-gray-50 text-gray-500 border border-gray-100">{{ $totalAll }} total</span>
    </div>

    {{-- Horizontal Pipeline --}}
    <div class="relative">
        {{-- Connection line --}}
        <div class="absolute top-4 left-4 right-4 h-0.5 bg-gray-200"></div>
        <div class="absolute top-4 left-4 h-0.5 bg-gradient-to-r from-teal-500 via-purple-500 to-emerald-500 transition-all duration-700" style="width: {{ $totalAll > 0 ? 'calc(' . round(($pipeline[array_key_last($pipeline)]['total'] / $totalAll) * 100) . '% - 2rem)' : '0' }}"></div>

        <div class="relative flex items-center justify-between">
            @foreach ($pipeline as $i => $step)
                @php
                    $isActive = $step['total'] > 0;
                    $pct = $totalAll > 0 ? round(($step['total'] / $totalAll) * 100) : 0;
                @endphp
                <div class="flex flex-col items-center text-center z-10" style="width: {{ 100 / count($pipeline) }}%">
                    <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center text-[10px] font-bold transition-all
                        {{ $isActive
                            ? "border-{$step['color']}-500 bg-{$step['color']}-500 text-white shadow-lg shadow-{$step['color']}-200"
                            : "border-gray-300 bg-white text-gray-400"
                        }}">
                        {{ $step['total'] }}
                    </div>
                    <span class="text-[10px] font-medium text-gray-600 mt-1.5 leading-tight">{{ $step['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Progress bars --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 mt-5 pt-4 border-t border-gray-100/60">
        @foreach ($pipeline as $step)
        <div class="text-center">
            <div class="progress-bar progress-bar-sm mb-1">
                <div class="progress-bar-fill !bg-{{ $step['color'] }}-500" style="width: {{ $maxTotal > 0 ? ($step['total'] / $maxTotal) * 100 : 0 }}%"></div>
            </div>
            <span class="text-[9px] text-gray-400 font-medium">{{ $step['label'] }}</span>
        </div>
        @endforeach
    </div>
</div>
@endif
