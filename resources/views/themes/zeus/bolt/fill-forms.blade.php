<div class="not-prose">
    <x-slot name="header">
        <h2>{{ $zeusForm->name ?? '' }}</h2>
        <p class="text-gray-400 text-mdd my-2">{{ $zeusForm->description ?? '' }}</p>

        @if($zeusForm->start_date !== null)
            <div class="text-gray-400 text-sm">
                @svg('heroicon-o-calendar','h-4 w-4 inline-flex')
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
            @svg('iconpark-rightsmall-o','fill-current w-4 h-4 mx-3 rtl:rotate-180')
        </li>
        <li class="flex items-center">
            {{ $zeusForm->name }}
        </li>
    </x-slot>

    @if($sent)
        @include(app('boltTheme').'.submitted')
    @else
        <x-filament-panels::form wire:submit.prevent="store" class="mx-2">
            {{ \LaraZeus\Bolt\Facades\Bolt::renderHookBlade('zeus-form.before') }}

            {!! \LaraZeus\Bolt\Facades\Extensions::init($zeusForm, 'render',$extensionData) !!}

            @if(!empty($zeusForm->details))
                <div class="m-4">
                    <x-filament::section :compact="true">
                        {!! nl2br($zeusForm->details) !!}
                    </x-filament::section>
                </div>
            @endif

            {{ $this->form }}

            <div class="px-4 py-2 text-center">
                <x-filament::button type="submit">
                    {{ __('Save') }}
                </x-filament::button>
            </div>

            {{ \LaraZeus\Bolt\Facades\Bolt::renderHookBlade('zeus-form.after') }}
        </x-filament-panels::form>
    @endif
</div>
