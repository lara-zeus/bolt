<div class="space-y-4">

    {{ $sec }}.{{ $fld }}

    <x-zeus::input.group for="dataSource-{{ $fld }}" inline label="Data Source">
        <x-slot name="labelIcon">
            @livewire('forms.create-collection', ['fld'=>$fld])
        </x-slot>

        <x-zeus::input.select id="field-type-{{ $fld }}" wire:model="fields.{{ $sec }}.{{ $fld }}.options.dataSource" id="dataSource-{{ $fld }}">
            @if($fields[$sec][$fld]['options']['dataSource'] /*&& in_array($fields[$sec][$fld]['options']['dataSource'], $allCollection->pluck('id')->toArray(), true)*/)
                <x-slot name="addOne">
                    <x-zeus::elements.link wire:click="addCollection({{ $fields[$sec][$fld]['options']['dataSource'] }})" data-tippy-content="Edit this List">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </x-zeus::elements.link>
                </x-slot>
            @endif

            <option @if(!in_array($fields[$sec][$fld]['options']['dataSource'], $allCollection->pluck('id')->toArray(), true)) selected @else disabled @endif  value="0">select data source...</option>
            @foreach($allCollection as $collection)
                <option @if($fields[$sec][$fld]['options']['dataSource'] === $collection->id) selected @endif value="{{ $collection->id }}">{{ $collection->name }}</option>
            @endforeach
        </x-zeus::input.select>
    </x-zeus::input.group>

    <x-zeus::input.group for="dataType-{{ $fld }}" inline label="Data Type">
        <div class="flex justify-between px-2">
            <div class="w-full"><x-zeus::input.radio value="multiple" label="Multiple" name="dataType-{{ $sec }}-{{ $fld }}" id="dataType-{{ $fld }}" wire:model="fields.{{ $sec }}.{{ $fld }}.options.dataType"/></div>
            <div class="w-full"><x-zeus::input.radio value="single" label="Single" name="dataType-{{ $sec }}-{{ $fld }}" id="dataType-{{ $fld }}" wire:model="fields.{{ $sec }}.{{ $fld }}.options.dataType"/></div>
        </div>
    </x-zeus::input.group>

    <x-zeus::input.group for="showAs-{{ $fld }}" inline label="Show As">
        <div class="flex justify-between px-2">
            <div class="w-full">
                @if(isset($fields[$sec][$fld]['options']['dataType']) && $fields[$sec][$fld]['options']['dataType'] === 'single')
                    <x-zeus::input.radio value="radio" label="Radio" name="showAs-{{ $sec }}-{{ $fld }}" wire:model="fields.{{ $sec }}.{{ $fld }}.options.showAs"/>
                @else
                    <x-zeus::input.radio value="checkbox" label="Checkboxes" name="showAs-{{ $sec }}-{{ $fld }}" wire:model="fields.{{ $sec }}.{{ $fld }}.options.showAs"/>
                @endif
            </div>
            <div class="w-full"><x-zeus::input.radio value="select" name="showAs-{{ $sec }}-{{ $fld }}" label="Select Menu" wire:model="fields.{{ $sec }}.{{ $fld }}.options.showAs"/></div>
        </div>
    </x-zeus::input.group>

    <div>
        @if(isset($fields[$sec][$fld]['options']['showAs']) && $fields[$sec][$fld]['options']['showAs'] === 'select')
            <x-zeus::input.group for="searchable-{{ $fld }}" inline label="Allow search">
                <div class="flex justify-between px-2">
                    <div class="w-full"><x-zeus::input.radio value="searchable" label="Yes" name="searchable-{{ $sec }}-{{ $fld }}" id="searchable-{{ $fld }}" wire:model="fields.{{ $sec }}.{{ $fld }}.options.searchable"/></div>
                    <div class="w-full"><x-zeus::input.radio value="not-searchable" label="No" name="searchable-{{ $sec }}-{{ $fld }}" id="searchable-{{ $fld }}" wire:model="fields.{{ $sec }}.{{ $fld }}.options.searchable"/></div>
                </div>
            </x-zeus::input.group>
        @endif
    </div>
</div>
