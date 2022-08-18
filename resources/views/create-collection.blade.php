<div>
    <x-filament::modal width="4xl">
        <x-slot name="trigger">
            <button x-on:click="isOpen = true" type="button" data-tippy-content="Set Form Texts, like desc and details">
                <x-heroicon-o-plus class="h-5 w-5 text-green-600 mt-1" />
            </button>
        </x-slot>
        <x-slot name="header">
            <x-filament::modal.heading>
                <p class="text-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline align-bottom" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Create New List
                </p>
            </x-filament::modal.heading>
        </x-slot>

        <div class="mb-4">
            <x-zeus::input.group inline for="collectionName" label="Collection Name">
                <x-zeus::input.text wire:model="collection.name" placeholder="Collection Name" id="collectionName"/>
            </x-zeus::input.group>
        </div>
        <x-zeus::input.array
                wireTo="collection.values"
                label="List Items"
                addAction="addListItem"
                :itemsData="$collection->values"
                :keys="['itemKey'=>['label'=>'Key','type'=>'input.text'],'itemValue'=>['label'=>'Value','type'=>'input.text'],'itemIsDefault'=>['label'=>'Is Default','type'=>'input.checkbox']]"
                id="list">
        </x-zeus::input.array>

        <x-slot name="footer">
            <x-filament::button x-on:click="isOpen = false" wire:click="saveCollection()">Save</x-filament::button>
        </x-slot>
    </x-filament::modal>

    <x-zeus::elements.link target="_blank" href="{{ route('filament.resources.collections.create') }}" data-tippy-content="Manage Lists">
        <x-heroicon-o-cog class="h-5 w-5 text-green-600 mt-1" />
    </x-zeus::elements.link>
</div>
