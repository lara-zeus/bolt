<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">

        <input type="hidden" x-model="state" />

        <div class="space-y-2 my-4" x-data="">
            <p>{{ __('Color') }}</p>

            <div class="flex gap-2 flex-wrap">
                @php
                    $colors = collect(\Filament\Support\Colors\Color::all())->forget(['slate','zinc','neutral','stone'])->keys()->toArray();
                @endphp
                @foreach($colors as $color)
                    @php
                        $setColor = \Illuminate\Support\Arr::toCssStyles([
                            \Filament\Support\get_color_css_variables($color, shades: [500]),
                        ]);
                    @endphp
                    <a :class="state === '{{ $color }}' ? 'mx-1 ring-gray-500 ring-offset-2 ring-2' : ''"
                        @click="state = '{{ $color }}'"
                        style="{{ $setColor }}"
                        x-tooltip="{
                            content: '{{ str($color)->title() }}',
                            theme: $store.theme,
                        }"
                       class="hover:ring-gray-500 hover:ring-offset-2 hover:ring-2 transition-all ease-in-out duration-300 cursor-pointer w-6 h-6 bg-custom-500 px-2 py-2 rounded-full">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-dynamic-component>
