<form wire:submit.prevent="save">
    <x-zeus::modal.dialog wire:model.defer="modals.showEditModal">
        <x-slot name="title">
            {{ \Illuminate\Support\Str::title($action) }} {{ \Illuminate\Support\Str::title($titleSingular) ?? 'item' }}
            @if($action === 'edit')
                <div class="text-xs mt-2">
                    <span class="text-gray-400">Created at:</span> <span class="text-gray-600">{{ $model->created_at->format(config('zeus.defaultDateFormat', 'M, d Y · h:i a')) }}</span> ·
                    <span class="text-gray-400">Last updated at:</span><span class="text-gray-600"> {{ $model->updated_at->format(config('zeus.defaultDateFormat', 'M, d Y · h:i a')) }}</span> ·
                    <span class="text-gray-400">by:</span> <span class="text-gray-600">{{ $model->user->name }}</span>
                </div>
            @endif
        </x-slot>

        <x-slot name="content">
            @foreach($fields->where('type') as $field)
                @if($field['type'] === 'input.array')
                    {{--@livewire('zeus.form-collection', ['fld'=>1], key(1))--}}
                @elseif($field['type'] === 'input.file-upload')
                    <x-zeus::input.group for="{{ $field['id'] }}" label="{{ $field['label'] }}" :error="$errors->first($field['id'])">
                        <x-dynamic-component :component="'zeus::'.$field['type']" wire:model="{{ $field['id'] }}" id="{{ $field['id'] }}" placeholder="{{ $field['label'] }}"/>
                    </x-zeus::input.group>
                @else
                    <x-zeus::input.group for="{{ $field['id'] }}" label="{{ $field['label'] }}" :error="$errors->first('model.'.$field['id'])">
                        <x-dynamic-component :component="'zeus::'.$field['type']" wire:model="model.{{ $field['id'] }}" id="{{ $field['id'] }}" placeholder="{{ $field['label'] }}"/>
                    </x-zeus::input.group>
                @endif
            @endforeach
        </x-slot>

        <x-slot name="footer">
            <x-zeus::elements.button color="white" wire:click="$set('modals.showEditModal', false)">Cancel</x-zeus::elements.button>

            <x-zeus::elements.button type="submit">Save</x-zeus::elements.button>
        </x-slot>
    </x-zeus::modal.dialog>
</form>