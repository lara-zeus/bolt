@php
    $min = ($field['type'] == 'number') ? ' min=0 ' : '';
@endphp
<input wire:model="fieldResponse.{{ $field['id'] }}.response" type="{{ $field['type'] ?? 'text' }}" {{ $min }}
    name="{{ $field['html_id'] ?? '' }}"
    id="{{ $field['html_id'] ?? '' }}"
    class="{{ $field['class'] ?? '' }}
        @error('fieldResponse.'.$field['id'].'.response') border-red-300 @enderror
        block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
    @if(!is_array($field['value']))
        value="{{ $field['value'] ?? '' }}"
    @endif
    placeholder="{{ $field['fieldLabel'] ?? '' }}"
    @if(isset($field['attributes']) && !empty($field['attributes'])) {!! $field['attributes'] !!} @endif
>
