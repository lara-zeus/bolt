@php
    $min = ($field['type'] == 'number') ? ' min=0 ' : '';
@endphp
11
<x-zeus::input.checkbox wire:model="selectPage"/>
11


<input type="{{ $field['type'] ?? 'text' }}" {{ $min }}
    name="{{ $field['fieldName'] ?? '' }}"
    id="{{ $field['fieldName'] ?? '' }}"
    class="{{ $field['class'] ?? '' }} block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
    @if(!is_array($field['value']))
        value="{{ $field['value'] ?? '' }}"
    @endif
    placeholder="{{ $field['fieldLabel'] ?? '' }}"
@if(isset($field['attributes']) && !empty($field['attributes'])) {!! $field['attributes'] !!} @endif
>
