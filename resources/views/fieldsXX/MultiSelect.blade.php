<select
        data-placeholder="{{ trans('Crud.selecteOption') }} : {{ $field['fieldLabel'] ?? '' }}"
        style="width: 100%"
        @if(isset($field['attributes']) && !empty($field['attributes'])) {!! $field['attributes'] !!} @endif
        id="{{ $field['fieldName'] ?? '' }}"
        name="{{ $field['dynamicFieldName'] ?? $field['fieldName'] }}[]"
        class="draftable selectSearchMultiple {{ $field['class'] ?? '' }} {{ $field->all_rules }}"
        multiple
>
    <option value=""></option>

    @foreach ($field['data']['values'] as $key => $val)
        @if ( ! empty($field['vas']) && in_array($key, $field['vas']))
            <option value="{{ $key }}" selected="selected">{{ $val }}</option>
        @else
            <option value="{{ $key }}">{{ $val }}</option>
        @endif
    @endforeach

</select>

@if(request()->ajax())
    <script>
        $('.selectSearchMultiple').select2({placeholder: footer_selecteOption});
    </script>
@endif
