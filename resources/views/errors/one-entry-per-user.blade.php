<div>
    <x-slot name="header">
        <h2>{{ __('zeus-bolt::messages.one_entry') }}</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4">
        <x-filament::section :compact="true">
            <x-slot name="heading">
                <div class="flex items-center justify-center gap-2">
                    @svg('heroicon-o-exclamation-triangle','w-5 h-5 text-primary-600')
                    <span class="text-md">
                        {{ __('zeus-bolt::messages.one_entry_per_user') }}
                    </span>
                </div>
            </x-slot>
            {{ __('zeus-bolt::messages.the_form') }}
            <span class="font-semibold">{{ $zeusForm->name ?? '' }}</span>.
            {{ __('zeus-bolt::messages.allow_only_one_entry_per_user') }}
        </x-filament::section>
    </div>
</div>
