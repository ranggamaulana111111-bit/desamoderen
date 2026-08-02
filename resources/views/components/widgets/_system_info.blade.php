<div class="widget-card h-full">
    <div class="widget-card-header">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-slate-400 to-slate-600 flex items-center justify-center text-white shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z"/></svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-800">Info Sistem</h2>
                <p class="text-[10px] text-gray-400">Resource utilization</p>
            </div>
        </div>
    </div>
    <div class="widget-card-body">
        <div class="space-y-3.5">
            {{-- DB Size --}}
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-[13px] text-gray-600 flex items-center gap-2">
                        <span class="pulse-dot ok"></span> Database
                    </span>
                    <span class="text-sm font-bold text-gray-900">{{ $dbSizeMb }} MB</span>
                </div>
            </div>

            {{-- Storage --}}
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-[13px] text-gray-600 flex items-center gap-2">
                        <span class="pulse-dot {{ $storagePercent > 80 ? 'error' : ($storagePercent > 60 ? 'warn' : 'ok') }}"></span> Storage
                    </span>
                    <span class="text-sm font-bold text-gray-900">{{ $storageUsedGb }} / {{ $storageTotalGb }} GB</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-bar-fill {{ $storagePercent > 80 ? '!bg-red-500' : ($storagePercent > 60 ? '!bg-amber-500' : '') }}" style="width: {{ $storagePercent }}%"></div>
                </div>
                <p class="text-[10px] text-gray-400 mt-1 text-right">{{ $storagePercent }}% terpakai</p>
            </div>

            {{-- PDF Files --}}
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-[13px] text-gray-600 flex items-center gap-2">
                        <span class="pulse-dot ok"></span> File PDF
                    </span>
                    <span class="text-sm font-bold text-gray-900">{{ $pdfCount }} file</span>
                </div>
                <div class="progress-bar progress-bar-sm">
                    <div class="progress-bar-fill" style="width: {{ min($pdfSizeMb / 500 * 100, 100) }}%"></div>
                </div>
                <p class="text-[10px] text-gray-400 mt-1 text-right">{{ $pdfSizeMb }} MB</p>
            </div>

            {{-- Health Summary --}}
            <div class="pt-3 mt-1 border-t border-gray-100/60">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2.5">Service Health</p>
                <div class="grid grid-cols-4 gap-2">
                    <div class="text-center">
                        <span class="pulse-dot {{ $health['php']['ok'] ? 'ok active' : 'error' }} mx-auto"></span>
                        <p class="text-[10px] text-gray-500 mt-1.5 font-medium">PHP</p>
                    </div>
                    <div class="text-center">
                        <span class="pulse-dot {{ $health['mysql']['ok'] ? 'ok active' : 'error' }} mx-auto"></span>
                        <p class="text-[10px] text-gray-500 mt-1.5 font-medium">MySQL</p>
                    </div>
                    <div class="text-center">
                        <span class="pulse-dot {{ $health['queue']['ok'] ? 'ok' : 'warn' }} mx-auto"></span>
                        <p class="text-[10px] text-gray-500 mt-1.5 font-medium">Queue</p>
                    </div>
                    <div class="text-center">
                        <span class="pulse-dot {{ $health['cache']['ok'] ? 'ok active' : 'error' }} mx-auto"></span>
                        <p class="text-[10px] text-gray-500 mt-1.5 font-medium">Cache</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
