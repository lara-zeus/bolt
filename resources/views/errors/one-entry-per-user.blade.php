<div>
    <x-slot name="header">
        <h2>{{ __('one entry') }}</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4">
        <x-filament::section :compact="true">
            <x-slot name="heading">
                <div class="flex items-center justify-center gap-2">
                    @svg('heroicon-o-exclamation-triangle','w-5 h-5 text-primary-600')
                    <span class="text-md">
                        {{ __('one entry per user') }}
                    </span>
                </div>
            </x-slot>
            {{ __('the form') }}
            <span class="font-semibold">{{ $zeusForm->name ?? '' }}</span>.
            {{ __('allow only one entry per user') }}
        </x-filament::section>
    </div>
</div>
