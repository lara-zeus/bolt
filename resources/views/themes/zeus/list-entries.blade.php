<div class="mx-4">
    <x-slot name="header">
        <h2>{{ __('browse your forms') }}</h2>
    </x-slot>

    <x-slot name="breadcrumb"></x-slot>

    <div class="my-6">
        {{ $this->table }}
    </div>
</div>
