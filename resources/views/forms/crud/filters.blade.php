<div class="mb-10 bg-gray-100 p-4 rounded shadow">

    <div class="grid grid-cols-3 gap-4">
        @foreach($filterFields as $filter)
            <div>
                <x-zeus::input.group for="filter-{{ $filter['id'] }}" label="{{ $filter['label'] }}" :error="$errors->first('filters.'.$filter['id'])">
                    <x-dynamic-component :component="'zeus::'.$filter['type']" wire:model="filters.{{ $filter['id'] }}" id="filter-{{ $filter['id'] }}" placeholder="{{ $filter['label'] }}"/>
                </x-zeus::input.group>
            </div>
        @endforeach
    </div>

    <div class="">
        <x-zeus::elements.link wire:click="resetAll" class="p-2">Reset Filters</x-zeus::elements.link>
    </div>
</div>
