@props(['lines' => 3, 'chart' => false, 'stats' => false])

<div class="animate-pulse space-y-3 p-5">
    @if ($stats)
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach(range(1, 4) as $i)
            <div class="bg-gray-100 rounded-xl p-4 space-y-2">
                <div class="h-3 bg-gray-200 rounded w-16"></div>
                <div class="h-7 bg-gray-200 rounded w-12"></div>
                <div class="h-2 bg-gray-200 rounded w-20"></div>
            </div>
            @endforeach
        </div>
    @elseif ($chart)
        <div class="flex items-end gap-2 h-40 px-4">
            @foreach(range(1, 12) as $i)
                <div class="flex-1 bg-gray-200 rounded-t" style="height: {{ rand(20, 100) }}%"></div>
            @endforeach
        </div>
        <div class="flex justify-between px-4">
            @foreach(range(1, 6) as $i)
                <div class="h-2 bg-gray-200 rounded w-8"></div>
            @endforeach
        </div>
    @else
        @foreach(range(1, $lines) as $i)
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-gray-200 shrink-0"></div>
            <div class="flex-1 space-y-1.5">
                <div class="h-3 bg-gray-200 rounded w-{{ rand(40, 90) }}/{{ rand(40, 100) }}"></div>
                <div class="h-2 bg-gray-100 rounded w-{{ rand(20, 60) }}/{{ rand(30, 80) }}"></div>
            </div>
        </div>
        @endforeach
    @endif
</div>
