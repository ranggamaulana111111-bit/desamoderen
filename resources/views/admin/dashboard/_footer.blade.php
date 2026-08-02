<div class="border-t border-gray-200 pt-5 pb-2 animate-fade-in" style="animation-delay: 0.45s">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-[11px] text-gray-400">
        <div class="flex items-center gap-3 flex-wrap">
            <span class="font-semibold text-gray-500">Prodesa v1.0</span>
            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
            <span>Laravel {{ $systemHealth['laravel']['version'] }}</span>
            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
            <span>PHP {{ $systemHealth['php']['version'] }}</span>
            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
            <span>MySQL {{ $systemHealth['mysql']['version'] }}</span>
            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
            <span class="{{ $queue['failed'] > 0 ? 'text-amber-600' : 'text-green-600' }} font-medium">{{ $queue['failed'] > 0 ? 'Degraded' : 'Healthy' }}</span>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-1.5">
                <span>Cache</span>
                <span class="health-dot {{ $systemHealth['cache']['ok'] ? 'ok' : 'fail' }}"></span>
            </div>
            <div class="flex items-center gap-1.5">
                <span>Queue</span>
                <span class="health-dot {{ $systemHealth['queue']['ok'] ? 'ok' : 'warn' }}"></span>
            </div>
            <div class="flex items-center gap-1.5">
                <span>DB</span>
                <span class="health-dot {{ $systemHealth['mysql']['ok'] ? 'ok' : 'fail' }}"></span>
            </div>
        </div>
    </div>
</div>
