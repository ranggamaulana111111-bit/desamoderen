@props(['name', 'label', 'type' => 'text', 'value' => '', 'required' => false, 'step' => null, 'placeholder' => null])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1.5">
        {{ $label }}
        @if ($required)<span class="text-red-400">*</span>@endif
    </label>
    <input type="{{ $type }}"
           id="{{ $name }}"
           name="{{ $name }}"
           value="{{ old($name, $value) }}"
           @if ($required) required @endif
           @if ($step) step="{{ $step }}" @endif
           @if ($placeholder) placeholder="{{ $placeholder }}" @endif
           {{ $attributes->merge(['class' => 'w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white transition']) }}>
</div>
