<div class="input-group">
    <input type="{{ $field['type'] ?? 'text' }}"
           name="{{ $field['fieldName'] ?? '' }}"
           id="{{ $field['fieldName'] ?? '' }}"
           class="draftable input-group-field {{ $field['class'] ?? '' }}"
           value="{{ $field['value'] ?? '' }}"
           placeholder="{{ $field['fieldLabel'] ?? '' }}"
           @if(isset($field['attributes']) && !empty($field['attributes'])) {!! $field['attributes'] !!} @endif
           dir="ltr"
    >
    <span class="input-group-label"><i class="fa fa-lg fa-calendar-o"></i></span>
</div>

@push('scripts')
    <script>
        $('#'+ '{{ $field['fieldName'] }}').calendarsPicker({
            dateFormat: 'yyyy-mm-dd',
            calendar: $.calendars.instance('UmmAlQura', '{{ $field['lang'] }}'),
        });
    </script>
@endpush
