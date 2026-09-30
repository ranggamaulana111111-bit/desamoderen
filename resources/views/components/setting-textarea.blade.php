@props(['name', 'label', 'value' => '', 'required' => false, 'rows' => 2, 'hint' => null])

<div>
    <label for="{{ $name }}" class="setting-label">
        {{ $label }}
        @if ($required)<span class="text-rose-400">*</span>@endif
    </label>
    <textarea id="{{ $name }}"
              name="{{ $name }}"
              rows="{{ $rows }}"
              @if ($required) required @endif
              @if ($errors->has($name)) aria-invalid="true" @endif
              {{ $attributes->merge(['class' => 'setting-input']) }}>{{ old($name, $value) }}</textarea>
    @if ($hint)
    <p class="setting-hint">{{ $hint }}</p>
    @elseif ($errors->has($name))
    <p class="setting-hint !text-rose-600">{{ $errors->first($name) }}</p>
    @endif
</div>
