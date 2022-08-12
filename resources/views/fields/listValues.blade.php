<?php
$list = \LaraZeus\Bolt\Models\Collection::find($field->options['dataSource']);
?>

<select wire:model="fieldResponse.{{ $field['id'] }}.response"
        @if(isset($field['attributes']) && !empty($field['attributes'])) {!! $field['attributes'] !!} @endif
        id="{{ $field['html_id'] ?? '' }}"
        name="{{ $field['html_id'] ?? '' }}"
        class="w-1/2 {{ $field['class'] ?? '' }} {{ $field->all_rules }}">
    <option value="" disabled>Select</option>
    @foreach ($list->values as $item)
        @if ($item['itemIsDefault'])
            <option value="{{ $item['itemKey'] }}" selected="selected">{{ $item['itemValue'] }}</option>
        @else
            <option value="{{ $item['itemKey'] }}">{{ $item['itemValue'] }}</option>
        @endif
    @endforeach
</select>
