@props(['name', 'label', 'type' => 'text', 'value' => '', 'required' => false, 'step' => null, 'placeholder' => null, 'hint' => null])

<div>
    <label for="{{ $name }}" class="setting-label">
        {{ $label }}
        @if ($required)<span class="text-rose-400">*</span>@endif
    </label>
    <input type="{{ $type }}"
           id="{{ $name }}"
           name="{{ $name }}"
           value="{{ old($name, $value) }}"
           @if ($required) required @endif
           @if ($step) step="{{ $step }}" @endif
           @if ($placeholder) placeholder="{{ $placeholder }}" @endif
           @if (old($name, $value) !== null && $errors->has($name)) aria-invalid="true" @endif
           {{ $attributes->merge(['class' => 'setting-input']) }}>
    @if ($hint)
    <p class="setting-hint">{{ $hint }}</p>
    @elseif ($errors->has($name))
    <p class="setting-hint !text-rose-600">{{ $errors->first($name) }}</p>
    @endif
</div>
