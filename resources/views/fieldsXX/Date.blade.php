<div class="input-group">
    <input type="{{ $field['type'] ?? 'text' }}"
           name="{{ $field['fieldName'] ?? '' }}"
           id="{{ $field['fieldName'] ?? '' }}"
           class="draftable datepicker input-group-field {{ $field['class'] ?? '' }} {{ $field->all_rules }}"
           value="{{ $field['value'] ?? '' }}"
           placeholder="{{ $field['fieldLabel'] ?? '' }}"
           @if(isset($field['attributes']) && !empty($field['attributes']))
               @if (!is_array($field['attributes']))
                    {!! $field['attributes'] !!}
               @elseif(isset($field['attributes']['html']) && !empty($field['attributes']['html']))
                    {!! $field['attributes']['html'] !!}
               @endif
           @endif
           dir="ltr"
    >
    <span class="input-group-label"><i class="fa fa-lg fa-calendar-o"></i></span>
</div>

@push('scripts')
    <script>
        $('.datepicker').datetimepicker({
            format: 'Y-m-d',
            timepicker:false,
            @if(isset($field['attributes']) && !empty($field['attributes']) && is_array($field['attributes']))
                @if(isset($field['attributes']['minDate']))
                    'minDate': {!! $field['attributes']['minDate'] !!},
                @endif

                @if(isset($field['attributes']['maxDate']))
                    'maxDate': {!! $field['attributes']['maxDate'] !!},
                @endif

                @if(isset($field['attributes']['minDate']))
                    'scrollMonth': {!! $field['attributes']['scrollMonth'] !!},
                @endif

                @if(isset($field['attributes']['scrollInput']))
                    'scrollInput': {!! $field['attributes']['scrollInput'] !!},
                @endif
            @endif
        });
    </script>
@endpush
