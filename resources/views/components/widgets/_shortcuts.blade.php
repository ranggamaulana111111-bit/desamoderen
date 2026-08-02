<div class="widget-card">
    <div class="widget-card-body">
        <div class="flex items-center gap-2 flex-wrap">
            @foreach ($shortcuts as $s)
            <a href="{{ $s['url'] }}" class="group inline-flex items-center gap-2 bg-white border border-gray-200/60 rounded-xl px-3.5 py-2 text-xs font-medium text-gray-600 hover:bg-{{ $s['color'] }}-50 hover:border-{{ $s['color'] }}-200 hover:text-{{ $s['color'] }}-700 hover:shadow-sm transition-all duration-200">
                <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/></svg>
                {{ $s['label'] }}
            </a>
            @endforeach
        </div>
    </div>
</div>
