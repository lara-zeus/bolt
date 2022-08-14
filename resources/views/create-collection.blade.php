<div>
    <x-zeus::elements.link wire:click="addCollection" data-tippy-content="Add New List">
        <x-heroicon-o-plus class="h-5 w-5 text-green-600 mt-1" />
    </x-zeus::elements.link>

    <x-zeus::elements.link target="_blank" href="{{ route('filament.resources.collections.create') }}" data-tippy-content="Manage Lists">
        <x-heroicon-o-cog class="h-5 w-5 text-green-600 mt-1" />
    </x-zeus::elements.link>
    <x-zeus::modal.dialog wire:model.defer="showCollectionModals" x-cloak>
        <x-slot name="title">
            <p class="text-green-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline align-bottom" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Create New List
            </p>
        </x-slot>
        <x-slot name="content">
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
        </x-slot>
        <x-slot name="footer">
            <x-zeus::elements.button wire:click="saveCollection()">Save</x-zeus::elements.button>
        </x-slot>
    </x-zeus::modal.dialog>
</div>
