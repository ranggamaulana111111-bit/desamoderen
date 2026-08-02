{{-- Configuration Versioning Bar --}}
<div class="px-6 py-3 border-b border-gray-100 bg-gradient-to-r from-amber-50/30 to-white">
    <div class="flex items-center flex-wrap gap-2">
        <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="text-xs font-medium text-gray-600">Configuration Versioning:</span>

        <div class="flex items-center gap-1">
            @php $latestV = $currentVersion ?? 0; @endphp
            @for ($i = max(1, $latestV - 4); $i <= $latestV; $i++)
                @php
                    $isCurrent = $i === $latestV;
                    $version = collect($versions ?? [])->firstWhere('version_number', $i);
                @endphp
                <a href="{{ $version ? route('admin.setting.versions.rollback', $version['id']) : '#' }}"
                   onclick="return {{ $isCurrent ? 'false' : 'confirm(\'Yakin rollback ke v' . $i . '?\')' }}"
                   class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-medium transition
                   {{ $isCurrent ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-gray-50 text-gray-500 border border-gray-200 hover:bg-amber-50 hover:border-amber-200' }}">
                    v{{ $i }}
                    @if ($isCurrent)
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    @endif
                </a>
            @endfor
        </div>

        @if ($latestV > 0)
        <span class="text-[10px] text-gray-400 ml-auto">
            Terakhir: v{{ $latestV }}
        </span>
        @endif
    </div>
</div>
