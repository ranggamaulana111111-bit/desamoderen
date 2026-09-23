@php
    $suggestions = ($field['type'] ?? '') === 'textarea' && isset($field['options']) && $field['options'] ? array_map('trim', explode(',', $field['options'])) : [];
    $currentVal = trim((string) ($currentValue ?? ''));
@endphp
@if(!empty($suggestions))
<div class="suggestion-box" data-field="{{ $field['key'] }}">
    <p class="suggestion-hint">Pilih salah satu, atau ketik keperluan sendiri:</p>
    <div class="suggestion-chips">
        @foreach($suggestions as $opt)
            @if($opt !== '')
                <button type="button" class="suggestion-chip{{ $currentVal === $opt ? ' active' : '' }}" data-value="{{ $opt }}">{{ $opt }}</button>
            @endif
        @endforeach
    </div>
</div>
@endif