<div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
    @foreach ($items as $item)
    <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-{{ $item['color'] }}-50 text-{{ $item['color'] }}-600 flex items-center justify-center shrink-0 border border-{{ $item['color'] }}-100/50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-xl font-extrabold text-gray-900" x-data x-init="animateNumber($el, {{ $item['count'] }})">0</p>
                <p class="text-[10px] text-gray-500 leading-tight font-medium">{{ $item['message'] }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>
