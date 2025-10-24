<div>
    <x-slot name="header">
        <h2>{{ __('Date Not Available') }}</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4">
        <x-filament::section :compact="true">
            <x-slot name="heading">
                <div class="flex items-center justify-center gap-2">
                    @svg('heroicon-o-exclamation-triangle','w-5 h-5 text-primary-600')
                    <span class="text-md">
                        {{ __('Date Not Available') }}
                    </span>
                </div>
            </x-slot>
            {{ __('the form is not available for submission') }}
            <span class="font-semibold">{{ $zeusForm->name ?? '' }}</span>.

            <x-slot name="description">
                <span class="text-sm text-gray-500">{{ __('Start date') }}</span>:
                <span class="text-sm">{{ $zeusForm->start_date->format($this->form->getDefaultDateDisplayFormat()) }}</span>,
                <span class="text-sm text-gray-500">{{ __('End date') }}</span>:
                <span class="text-sm">{{ $zeusForm->end_date->format($this->form->getDefaultDateDisplayFormat()) }}</span>
            </x-slot>
        </x-filament::section>
    </div>
</div>
