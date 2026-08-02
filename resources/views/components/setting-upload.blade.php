@props(['name', 'label', 'value' => '', 'accept' => 'image/png,image/jpeg'])

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ $label }}</label>
    @if (!empty($value) && Storage::disk('public')->exists($value))
    <div class="mb-2">
        <img src="{{ asset('storage/' . $value) }}" alt="{{ $label }}" class="h-20 w-auto rounded-lg border border-gray-200 shadow-sm">
    </div>
    @endif
    <input type="file"
           name="{{ $name }}"
           accept="{{ $accept }}"
           {{ $attributes->merge(['class' => 'block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 file:transition cursor-pointer']) }}>
    <p class="text-xs text-gray-400 mt-1">Format: {{ str_replace(',', ', ', $accept) }}, maks. 2 MB</p>
</div>
