@props(['type' => 'success', 'dismissible' => true])

@if(session($type))
    <div x-data="{ show: true }" x-show="show" x-transition
         class="flex items-center gap-3 px-4 py-3 rounded-lg mb-6 text-sm
                {{ $type === 'success' ? 'bg-green-100 border border-green-300 text-green-800' : '' }}
                {{ $type === 'error' ? 'bg-red-100 border border-red-300 text-red-800' : '' }}
                {{ $type === 'warning' ? 'bg-yellow-100 border border-yellow-300 text-yellow-800' : '' }}"
        role="alert">
        @if($type === 'success')
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        @elseif($type === 'error')
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        @endif
        <span class="flex-1">{{ session($type) }}</span>
        @if($dismissible)
            <button @click="show = false" class="ml-auto opacity-70 hover:opacity-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        @endif
    </div>
@endif
