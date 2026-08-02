@if (!empty($systemHealth))
<div class="widget-card h-full">
    <div class="widget-card-header">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center text-white shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-800">Kesehatan Sistem</h2>
                <p class="text-[10px] text-gray-400">Service status overview</p>
            </div>
        </div>
        <span class="chip {{ $systemHealth['health_percent'] === 100 ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : ($systemHealth['health_percent'] >= 60 ? 'bg-amber-50 text-amber-700 border border-amber-100' : 'bg-red-50 text-red-700 border border-red-100') }}">
            {{ $systemHealth['health_percent'] }}%
        </span>
    </div>
    <div class="widget-card-body">
        @php
            $healthItems = [
                'PHP' => ['info' => $systemHealth['php'], 'icon' => 'M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5'],
                'Laravel' => ['info' => $systemHealth['laravel'], 'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25'],
                'MySQL' => ['info' => $systemHealth['mysql'], 'icon' => 'M4.5 12.75l6 6 9-13.5'],
                'Storage' => ['info' => $systemHealth['storage'], 'icon' => 'M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375'],
                'Scheduler' => ['info' => $systemHealth['scheduler'], 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
                'Cache' => ['info' => $systemHealth['cache'], 'icon' => 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z'],
            ];
        @endphp
        <div class="space-y-2">
            @foreach ($healthItems as $name => $data)
                @php $info = $data['info']; @endphp
                <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-gray-50/80 transition">
                    <span class="pulse-dot {{ $info['ok'] ? 'ok' : 'error' }} shrink-0"></span>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] font-medium text-gray-700">{{ $name }}</span>
                            <span class="text-[10px] font-mono text-gray-400 bg-gray-50 px-2 py-0.5 rounded-md">{{ $info['version'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4 pt-3 border-t border-gray-100/60 grid grid-cols-2 gap-3">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-3 text-center border border-blue-100/40">
                <p class="text-lg font-extrabold text-blue-900">{{ $systemHealth['memory_usage'] }}<span class="text-xs font-medium text-blue-600">MB</span></p>
                <p class="text-[10px] text-blue-600 font-medium mt-0.5">Memory</p>
            </div>
            <div class="bg-gradient-to-br {{ $systemHealth['disk_usage'] > 80 ? 'from-red-50 to-rose-50 border-red-100/40' : 'from-emerald-50 to-green-50 border-emerald-100/40' }} rounded-xl p-3 text-center border">
                <p class="text-lg font-extrabold {{ $systemHealth['disk_usage'] > 80 ? 'text-red-900' : 'text-emerald-900' }}">{{ $systemHealth['disk_usage'] }}<span class="text-xs font-medium {{ $systemHealth['disk_usage'] > 80 ? 'text-red-600' : 'text-emerald-600' }}">%</span></p>
                <p class="text-[10px] {{ $systemHealth['disk_usage'] > 80 ? 'text-red-600' : 'text-emerald-600' }} font-medium mt-0.5">Disk</p>
            </div>
        </div>
    </div>
</div>
@endif
