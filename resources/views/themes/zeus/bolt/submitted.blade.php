<div>
    <div class="max-w-4xl mx-auto px-4">
        <x-filament::section>
            @if(!empty($zeusForm->options['confirmation-message']))
                <span class="text-md text-gray-600">
                    {!! \LaraZeus\Bolt\Facades\Bolt::sanitizeHtml($zeusForm->options['confirmation-message']) !!}
                </span>
            @else
                <span class="text-md text-gray-600">
                    {{ __('zeus-bolt::messages.the_form') }}
                    <span class="font-semibold">{{ $zeusForm->name ?? '' }}</span>
                    {{ __('zeus-bolt::messages.submitted_successfully') }}.
                </span>
            @endif

                {!! \LaraZeus\Bolt\Facades\Extensions::init($zeusForm, 'SubmittedRender', [
                    'extensionData' => $extensionData['extInfo']['itemId'] ?? 0,
                    'response' => $extensionData['response'],
                ]) !!}

        </x-filament::section>
    </div>
</div>
