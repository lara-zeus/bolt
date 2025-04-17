<div>
    <div class="max-w-4xl mx-auto px-4">
        <x-filament::section>
            @if(!empty($zeusForm->options['confirmation-message']))
                <span class="text-md text-gray-600">
                    {!! $zeusForm->options['confirmation-message'] !!}
                </span>
            @else
                <span class="text-md text-gray-600">
                    {{ __('the form') }}
                    <span class="font-semibold">{{ $zeusForm->name ?? '' }}</span>
                    {{ __('submitted successfully') }}.
                </span>
            @endif

                {!! \LaraZeus\Bolt\Facades\Extensions::init($zeusForm, 'SubmittedRender', [
                    'extensionData' => $extensionData['extInfo']['itemId'] ?? 0,
                    'response' => $extensionData['response'],
                ]) !!}

        </x-filament::section>
    </div>
</div>
