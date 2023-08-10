<div>
    <x-slot name="header">
        <h2>{{ __('form submitted successfully') }}</h2>
    </x-slot>
    <x-slot name="breadcrumb"></x-slot>
    <div class="max-w-4xl mx-auto px-4">
        <x-filament::section>
            @if(!empty($zeusForm->options['confirmation_message']))
                <span class="text-md text-gray-600">
                    {!! $zeusForm->options['confirmation_message'] !!}
                </span>
            @else
                <span class="text-md text-gray-600">
                    {{ __('the form') }}
                    <span class="font-semibold">{{ $zeusForm->name ?? '' }}</span>
                    {{ __('submitted successfully') }}.
                </span>
            @endif

            {!! \LaraZeus\Bolt\Facades\Extensions::init($zeusForm, 'SubmittedRender', ['extensionData' => $extensionData['extInfo']['itemId'] ?? 0]) !!}

        </x-filament::section>
    </div>
</div>
