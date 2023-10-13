@php
    $colors = \Illuminate\Support\Arr::toCssStyles([
        \Filament\Support\get_color_css_variables($zeusForm->options['primary_color'] ?? 'primary', shades: [50, 100, 200, 300, 400, 500, 600, 700, 800, 900]),
    ]);
@endphp

<div class="not-prose" style="{{ $colors }}">
    @if(class_exists(\LaraZeus\Bolt\BoltProServiceProvider::class) && optional($zeusForm->options)['logo'] !== null && optional($zeusForm)->options['cover'] !== null)
        <div style="background-image: url('{{ \Illuminate\Support\Facades\Storage::disk(config('zeus-bolt.uploadDisk'))->url($zeusForm->options['cover']) }}')"
             class="flex justify-start items-center px-4 py-6 gap-4 rounded-lg bg-clip-border bg-origin-border bg-cover bg-center">
            <div>
                <img
                    class="bg-white rounded-full shadow-md shadow-custom-100 sm:h-24 sm:w-24 object-cover"
                    src="{{ \Illuminate\Support\Facades\Storage::disk(config('zeus-bolt.uploadDisk'))->url($zeusForm->options['logo']) }}"
                    alt="logo"
                />
            </div>
            <div class="bg-white/40 p-4 space-y-1 rounded-lg w-full text-left">
                <h4 class="text-custom-600 text-2xl font-bold dark:text-white">
                    {{ $zeusForm->name ?? '' }}
                </h4>
                @if(filled($zeusForm->description))
                    <h5 class="text-custom-600 font-normal">
                        {{ $zeusForm->description ?? '' }}
                    </h5>
                @endif
                @if($zeusForm->start_date !== null)
                    <div class="text-custom-800 flex items-center justify-start gap-2 text-sm">
                        @svg('heroicon-o-calendar','h-5 w-5 inline-flex')
                        <span class="flex items-center justify-center gap-1">
                            <span>{{ __('Available from') }}:</span>
                            <span>{{ optional($zeusForm->start_date)->format('Y/m/d') }}</span>,
                            <span>{{ __('to') }}:</span>
                            <span>{{ optional($zeusForm->end_date)->format('Y/m/d') }}</span>
                        </span>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if(!$inline)
        @if(!class_exists(\LaraZeus\Bolt\BoltProServiceProvider::class) || (optional($zeusForm->options)['logo'] === null && optional($zeusForm->options)['cover'] === null))
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
        @endif

        <x-slot name="breadcrumbs">
            <li class="flex items-center">
                <a href="{{ route('bolt.forms.list') }}">{{ __('Forms') }}</a>
                @svg('iconpark-rightsmall-o','fill-current w-4 h-4 mx-3 rtl:rotate-180')
            </li>
            <li class="flex items-center">
                {{ $zeusForm->name }}
            </li>
        </x-slot>
    @endif

    @if($sent)
        @include($boltTheme.'.submitted')
    @else
        <x-filament-panels::form wire:submit.prevent="store" class="mx-2">
            @if(!$inline)
                {{ \LaraZeus\Bolt\Facades\Bolt::renderHookBlade('zeus-form.before') }}
            @endif

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
                <x-filament::button type="submit" :color="$zeusForm->options['primary_color'] ?? 'primary'">
                    {{ __('Save') }}
                </x-filament::button>
            </div>

            @if(!$inline)
                {{ \LaraZeus\Bolt\Facades\Bolt::renderHookBlade('zeus-form.after') }}
            @endif
        </x-filament-panels::form>
    @endif
</div>
