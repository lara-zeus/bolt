<form wire:submit.prevent="save">
    <x-zeus::modal.dialog wire:model.defer="modals.showEditModal">
        <x-slot name="title">
            {{ \Illuminate\Support\Str::title($action) }} {{ \Illuminate\Support\Str::title($titleSingular) ?? 'item' }}
            @if($action === 'edit')
                <div class="text-xs mt-2">
                    <span class="text-gray-400">Created at:</span> <span class="text-gray-600">{{ $row->created_at->format(config('zeus.defaultDateFormat')) }}</span> ·
                    <span class="text-gray-400">Last updated at:</span><span class="text-gray-600"> {{ $row->updated_at->format(config('zeus.defaultDateFormat')) }}</span> ·
                    <span class="text-gray-400">by:</span> <span class="text-gray-600">{{ $row->user->name }}</span>
                </div>
            @endif
        </x-slot>

        <x-slot name="content">
            @foreach($fields->where('type') as $field)
                <x-zeus::input.group for="{{ $field['id'] }}" label="{{ $field['label'] }}" :error="$errors->first('model.'.$field['id'])">
                    {{ $model }}
                    <x-dynamic-component :component="'zeus::'.$field['type']" wire:model="model.{{ $field['id'] }}" id="{{ $field['id'] }}" placeholder="{{ $field['label'] }}"/>
                </x-zeus::input.group>
            @endforeach
        </x-slot>

        <x-slot name="footer">
            <x-zeus::elements.button color="white" wire:click="$set('modals.showEditModal', false)">Cancel</x-zeus::elements.button>

            <x-zeus::elements.button type="submit">Save</x-zeus::elements.button>
        </x-slot>
    </x-zeus::modal.dialog>
</form>
