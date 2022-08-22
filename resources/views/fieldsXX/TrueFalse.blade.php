@php $keys = array_keys($field['keys']); @endphp
<div class="switch {{ $field['size'] ?? '' }}" style="{{ $field['style'] ?? '' }}">
    <input
            {{ $field['check'] ?? '' }}
            @if(isset($field['attributes']) && !empty($field['attributes'])) {!! $field['attributes'] !!} @endif
            class="draftable {{ $field['class'] ?? '' }} switch-input"
            value="{{ $field['keys'][0] ?? '' }}"
            name="{{ $field['fieldName'] ?? '' }}" id="{{ $field['fieldName'] ?? '' }}" type="checkbox">
    <label class="switch-paddle" for="{{ $field['fieldName'] ?? '' }}">
        <span class="show-for-sr">{{ $field['fieldLabel'] ?? '' }}</span>
        <span class="switch-active" aria-hidden="true">{{ $field['opt1'] ?? '' }}</span>
        <span class="switch-inactive text-primary" aria-hidden="true">{{ $field['opt2'] ?? '' }}</span>
    </label>
</div>
