<div>
    <x-slot name="header">
        <h2>{{ __('Login Required') }}</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4">
        <x-filament::card>
            <x-slot name="heading">
                <div class="flex items-center justify-center gap-2">
                    <x-heroicon-o-exclamation class="w-5 h-5 text-secondary-600"/>
                    <span class="text-md">
                        {{ __('Login Required') }}
                    </span>
                </div>
            </x-slot>
            {{ __('Login is required to access the form') }}
            <span class="font-semibold">{{ $zeusForm->name ?? '' }}</span>.
            <x-slot name="actions">
                <x-filament::button tag="a" size="sm" href="{{ url('/login') }}">
                    {{ __('Login') }}
                </x-filament::button>
            </x-slot>
        </x-filament::card>
    </div>
</div>
