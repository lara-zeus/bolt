<x-zeus::modal.dialog wire:model.defer="modals.showDetails">
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
        @foreach($fields as $field)
            <x-zeus::input.group for="{{ $field['id'] }}" label="{{ $field['label'] }}">
                @if(\Illuminate\Support\Str::contains($field['id'],'.'))
                    {{ ($flattenedRows[$loop->index.'.'.$field['id']]) ?? '' }}
                @elseif(isset($field['listAtt']))
                    {!! $model->{$field['listAtt']} !!}
                @elseif(isset($model->{$field['id']}))
                    {{ $model->{$field['id']} }}
                @else
                    {{ $field['id'] ?? '' }}
                @endif
            </x-zeus::input.group>
        @endforeach
    </x-slot>

    <x-slot name="footer">
        <x-zeus::elements.button wire:click="$set('modals.showDetails', false)">close</x-zeus::elements.button>
    </x-slot>
</x-zeus::modal.dialog>
