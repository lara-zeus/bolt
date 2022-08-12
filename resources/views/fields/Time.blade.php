<div class="input-group">
    <input type="{{ $field['type'] ?? 'text' }}"
           name="{{ $field['fieldName'] ?? '' }}"
           id="{{ $field['fieldName'] ?? '' }}"
           class="draftable timepicker input-group-field {{ $field['class'] ?? '' }} {{ $field->all_rules }}"
           value="{{ $field['value'] ?? '' }}"
           placeholder="{{ $field['fieldLabel'] ?? '' }}"
           @if(isset($field['attributes']) && !empty($field['attributes'])) {!! $field['attributes'] !!} @endif
           dir="ltr"
    >
    <span class="input-group-label"><i class="fa fa-lg fa-calendar-o"></i></span>
</div>

@push('scripts')
    <script>
        $('.timepicker').datetimepicker({
            format: 'H:i:s',
            datepicker:false
        });
    </script>
@endpush
