<div class="bento-card bg-white rounded-2xl shadow-sm p-6 animate-slide-up" style="animation-delay: 0.15s">
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
            </div>
            <h2 class="text-sm font-semibold text-gray-800">Workflow Pipeline</h2>
        </div>
        <div class="flex items-center gap-1.5 text-xs text-gray-400">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            <span>{{ count($workflow) }} tahap</span>
        </div>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        @foreach ($workflow as $i => $step)
        <div class="relative flex flex-col items-center text-center p-3.5 rounded-xl bg-gradient-to-b from-{{ $step['color'] }}-50 to-white border border-{{ $step['color'] }}-200/60 hover:shadow-md transition">
            <div class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-{{ $step['color'] }}-500 text-white text-[9px] font-bold flex items-center justify-center shadow-sm">{{ $i + 1 }}</div>
            <div class="w-9 h-9 rounded-full bg-{{ $step['color'] }}-100 text-{{ $step['color'] }}-600 flex items-center justify-center mb-2 shadow-sm">
                @if ($loop->first || $loop->last)
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @else
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                @endif
            </div>
            <p class="text-xl font-bold text-gray-900 count-up" x-data x-init="animateNumber($el, {{ $step['total'] }})">0</p>
            <p class="text-[11px] text-gray-500 leading-tight mt-0.5">{{ $step['label'] }}</p>
        </div>
        @endforeach
    </div>
</div>
