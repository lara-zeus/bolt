<div>
    <x-slot name="header">
        <h2>{{ $zeusForm->name ?? '' }}</h2>
        <p class="text-gray-400 text-mdd my-2">{{ $zeusForm->description ?? '' }}</p>

        @if($zeusForm->start_date !== null)
            <div class="text-gray-400 text-sm">
                <x-heroicon-o-calendar class="h-4 w-4 inline-flex" />
                <span>{{ __('Available from') }}:</span>
                <span>{{ optional($zeusForm->start_date)->format('Y/m/d') }}</span>,
                <span>{{ __('to') }}:</span>
                <span>{{ optional($zeusForm->end_date)->format('Y/m/d') }}</span>
            </div>
        @endif
    </x-slot>

    <x-slot name="breadcrumps">
        <li class="flex items-center">
            <a href="{{ route('bolt.forms.list') }}">{{ __('Forms') }}</a>
            <x-iconpark-rightsmall-o class="fill-current w-4 h-4 mx-3 rtl:rotate-180" />
        </li>
        <li class="flex items-center">
            {{ $zeusForm->name }}
        </li>
    </x-slot>

    <x-filament::form wire:submit.prevent="store" class="mx-2">
        {{ \LaraZeus\Bolt\Facades\Bolt::renderHookBlade('zeus-form.before') }}

        {!! \LaraZeus\Bolt\Facades\Extensions::init($this->zeusForm, 'render') !!}

        @if(!empty($zeusForm->details))
            <div class="m-4">
                <x-filament::card>
                    {!! nl2br($zeusForm->details) !!}
                </x-filament::card>
            </div>
        @endif

        {{ $this->form }}

        <div class="px-4 py-2 text-center">
            <x-filament-support::button type="submit">
                {{ __('Save') }}
            </x-filament-support::button>
        </div>

        {{ \LaraZeus\Bolt\Facades\Bolt::renderHookBlade('zeus-form.after') }}
    </x-filament::form>
</div>
