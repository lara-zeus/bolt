<select
        data-placeholder="{{ trans('Crud.selecteOption') }} : {{ $field['fieldLabel'] ?? '' }}"
        style="width: 100%"
        @if(isset($field['attributes']) && !empty($field['attributes'])) {!! $field['attributes'] !!} @endif
        id="{{ $field['fieldName'] ?? '' }}"
        name="{{ $field['fieldName'] ?? '' }}"
        class="draftable selectSearch {{ $field['class'] ?? '' }} {{ $field->all_rules }}">
    <option value=""></option>

    @foreach ($field['data']['values'] as $key => $val)
        @if ( isset($field['value']) && ! is_null($field['value']) && $key == $field['value'])
            <option value="{{ $key }}" selected="selected">{{ $val }}</option>
        @else
            <option value="{{ $key }}">{{ $val }}</option>
        @endif
    @endforeach

</select>
@if(request()->ajax())
    <script>
        $('.selectSearch').select2({placeholder: footer_selecteOption, allowClear: true});
    </script>
@endif
