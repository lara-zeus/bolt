@php
    use LaraZeus\Bolt\Facades\Bolt;
    use LaraZeus\Bolt\Facades\Extensions;
    use \Illuminate\Support\Arr;

    use function \Filament\Support\get_color_css_variables;

    $colors = '';
    if(optional($zeusForm->options)['primary_color'] !== null) {
        $colors = Arr::toCssStyles([
            get_color_css_variables($zeusForm->options['primary_color'], shades: [50, 100, 200, 300, 400, 500, 600, 700, 800, 900]),
        ]);

        $colors = str($colors)->replace('--color-','--primary-')->toString();
    }
@endphp

<div class="not-prose" style="{{ $colors }}">
    @if(!$inline)
        <x-slot name="breadcrumbs">
            @if($zeusForm->extensions === null)
                <li class="flex items-center">
                    <a href="{{ route('bolt.forms.list') }}">{{ __('Forms') }}</a>
                    @svg('heroicon-s-arrow-small-right','fill-current w-4 h-4 mx-3 rtl:rotate-180')
                </li>
            @else
                <li class="flex items-center">
                    <a href="{{ Extensions::init($zeusForm, 'route') }}">{{ Extensions::init($zeusForm, 'label') }}</a>
                    @svg('heroicon-s-arrow-small-right','fill-current w-4 h-4 mx-3 rtl:rotate-180')
                </li>
            @endif
            <li class="flex items-center">
                {{ $zeusForm->name }}
            </li>
        </x-slot>

        @if(!Bolt::hasPro() || (optional($zeusForm->options)['logo'] === null && optional($zeusForm->options)['cover'] === null))
            <x-slot name="header">
                <h2>{{ $zeusForm->name ?? '' }}</h2>
                <p class="text-gray-400 text-mdd my-2">{{ $zeusForm->description ?? '' }}</p>

                @if($zeusForm->start_date !== null)
                    <div class="text-gray-400 text-sm">
                        @svg('heroicon-o-calendar','h-4 w-4 inline-flex')
                        <span>{{ __('Available from') }}:</span>
                        <span>{{ optional($zeusForm->start_date)->format($this->form->getDefaultDateDisplayFormat()) }}</span>,
                        <span>{{ __('to') }}:</span>
                        <span>{{ optional($zeusForm->end_date)->format($this->form->getDefaultDateDisplayFormat()) }}</span>
                    </div>
                @endif
            </x-slot>
        @endif

        @include($boltTheme.'.loading')
    @endif

    @include($boltTheme.'.pro')

    @if($sent)
        @include($boltTheme.'.submitted')
    @else
        <form wire:submit.prevent="store" class="{{ (!$inline) ? 'mx-2' : '' }}">
            @if(!$inline)
                {{ Bolt::renderHookBlade('zeus-form.before') }}
            @endif

            {!! Extensions::init($zeusForm, 'render',$extensionData) !!}

            @if(!empty($zeusForm->details))
                <div class="my-4">
                    <x-filament::section :compact="true">
                        {!! nl2br($zeusForm->details) !!}
                    </x-filament::section>
                </div>
            @endif

            {{ $this->form }}

            <div class="px-4 py-2 text-center">
                <x-filament::button
                    form="store"
                    type="submit"
                    :color="$zeusForm->options['primary_color'] ?? 'primary'"
                >
                    {{ __('Save') }}
                </x-filament::button>
            </div>

            @if(!$inline)
                {{ Bolt::renderHookBlade('zeus-form.after') }}
            @endif
        </form>

        <x-filament-actions::modals />
    @endif
</div>
