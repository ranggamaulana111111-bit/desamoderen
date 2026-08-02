@props(['name', 'label', 'value' => '', 'required' => false, 'rows' => 2])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1.5">
        {{ $label }}
        @if ($required)<span class="text-red-400">*</span>@endif
    </label>
    <textarea id="{{ $name }}"
              name="{{ $name }}"
              rows="{{ $rows }}"
              @if ($required) required @endif
              {{ $attributes->merge(['class' => 'w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white transition']) }}>{{ old($name, $value) }}</textarea>
</div>
