<div>
    <x-slot name="header">
        <h2>{{ __('zeus-bolt::messages.login_required') }}</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4">
        <x-filament::section :compact="true">
            <x-slot name="heading">
                <div class="flex items-center justify-center gap-2">
                    @svg('heroicon-o-exclamation-triangle','w-5 h-5 text-primary-600')
                    <span class="text-md">
                        {{ __('zeus-bolt::messages.login_required') }}
                    </span>
                </div>
            </x-slot>
            {{ __('zeus-bolt::messages.login_required_to_access_form') }}
            <span class="font-semibold">{{ $zeusForm->name ?? '' }}</span>.
            <x-slot name="description">
                <x-filament::button tag="a" size="sm" href="{{ url('/login') }}">
                    {{ __('zeus-bolt::messages.login') }}
                </x-filament::button>
            </x-slot>
        </x-filament::section>
    </div>
</div>
