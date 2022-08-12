<div>
    <x-slot name="header">
        <h2>{{ __('form submitted successfully') }}</h2>
    </x-slot>

    <x-slot name="breadcrumb"></x-slot>

    <x-zeus::box>
        @if(isset($form->options['confirmationMessage']) && !empty($form->options['confirmationMessage']))
            {!! $form->options['confirmationMessage'] !!}
        @else
            <span class="text-xs text-gray-400">
                the form {{ $form->name ?? '' }} submitted successfully.
            </span>
            <br>
        @endif
    </x-zeus::box>
</div>
