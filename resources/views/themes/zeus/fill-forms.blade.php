<div x-data x-init="tippy('[data-tippy-content]', {animation: 'perspective'});">
    <x-slot name="header">
        <h2>{{ $zeusForm->name ?? '' }}</h2>
        <p class="text-gray-400 text-mdd my-2">{{ $zeusForm->desc ?? '' }}</p>

        @if($zeusForm->start_date !== null)
            <div class="text-gray-400 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-flex" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>{{ __('Available from') }}:</span>
                <span>{{ optional($zeusForm->start_date)->format('Y/m/d') }}</span>,
                <span>{{ trans('to') }}:</span>
                <span>{{ optional($zeusForm->end_date)->format('Y/m/d') }}</span>
            </div>
        @endif
    </x-slot>

    <form wire:submit.prevent="store">

        {{ \Filament\Facades\Filament::renderHook('zeus-form.before') }}

        @if($zeusForm->details !== null)
            <div class="m-4">
                <x-zeus::box>
                    {!! nl2br($zeusForm->details) !!}
                </x-zeus::box>
            </div>
        @endif

        <div class="container mx-auto my-10">
            <div class="mx-4">
                {{ $this->form }}
            </div>
        </div>

        <div class="p-4 text-center">
            <x-filament::button type="submit">
                {{ __('Save') }}
            </x-filament::button>
        </div>
    </form>
</div>
