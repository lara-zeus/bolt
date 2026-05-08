<div class="mx-4">
    <x-slot name="header">
        <h2>{{ __('zeus-bolt::forms.browse_entries') }}</h2>
    </x-slot>

    <x-slot name="breadcrumbs">
        <li class="flex items-center">
            {{ __('zeus-bolt::forms.browse_entries') }}
        </li>
    </x-slot>

    <div class="my-6">
        {{ $this->table }}
    </div>
</div>
