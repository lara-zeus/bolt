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
                    $colors = collect(\Filament\Support\Colors\Color::all())
                        ->forget(['slate','zinc','neutral','stone'])
                        ->mapWithKeys(function($colors,$color){
                            return [$color=>$colors[500]];
                        })
                        ->toArray();
                @endphp

                <a
                    :class="state === null ? 'mx-1 ring-gray-500 ring-offset-2 ring-2' : ''"
                    @click="state = null"
                    style="background-color: var(--primary-500);"
                    x-tooltip="{
                        content: 'default color',
                        theme: $store.theme,
                    }"
                    class="hover:ring-gray-500 hover:ring-offset-2 hover:ring-2 transition-all ease-in-out duration-300 cursor-pointer size-6 bg-primary-500 px-2 py-2 rounded-full">
                </a>

                <span></span>

                @foreach($colors as $color => $okl)
                    <a
                        :class="state === '{{ $color }}' ? 'mx-1 ring-gray-500 ring-offset-2 ring-2' : ''"
                        @click="state = '{{ $color }}'"
                        style="background-color: {{ $okl }};"
                        x-tooltip="{
                            content: '{{ str($color)->title() }}',
                            theme: $store.theme,
                        }"
                        class="fi-color hover:ring-gray-500 hover:ring-offset-2 hover:ring-2 transition-all ease-in-out duration-300 cursor-pointer w-6 h-6 bg-primary-500 px-2 py-2 rounded-full">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-dynamic-component>
