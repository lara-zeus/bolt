<div class="mx-4">
    <x-slot name="header">
        <h2>{{ __('browse your Entries') }}</h2>
    </x-slot>

    <x-slot name="breadcrumbs">
        <li class="flex items-center">
            <a href="{{ url('/') }}">{{ __('Home') }}</a>
            @svg('iconpark-rightsmall-o','fill-current w-4 h-4 mx-3 rtl:rotate-180')
        </li>
        <li class="flex items-center">
            {{ __('browse your Entries') }}
        </li>
    </x-slot>

    <div class="my-6">
        {{ $this->table }}
    </div>
</div>
