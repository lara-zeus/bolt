<x-filament::page>
    <x-filament::card>
        @forelse ($rows as $row)
            <x-slot name="header">
                <div>
                    <p>
                        <span class="text-base font-light">{{ __('From') }}</span>:
                        {{ ($row->user->name) ?? '' }}
                    </p>
                    <p>
                        <span class="text-base font-light">{{ __('created at') }}</span>:
                        <span class="font-semibold">{{ $row->created_at->format('Y.m/d') }}-{{ $row->created_at->format('h:i a') }}</span>
                    </p>
                </div>
            </x-slot>

            <div wire:key="row-{{ $row->id }}">
                <div class="divide-y divide-gray-200 flex flex-col">
                    @foreach($fields->where('inShow',true) as $field)
                        <div class="py-2">
                            {{ $field['label'] }}:
                            @if(\Illuminate\Support\Str::contains($field['id'],'.'))
                                {{ ($flattenedRows[$loop->parent->index.'.'.$field['id']]) ?? '' }}
                            @elseif(isset($field['listAtt']))
                                {!! $row->{$field['listAtt']} !!}
                            @elseif(isset($row->{$field['id']}))
                                {{ $row->{$field['id']} }}
                            @else
                                {{ $field['id'] ?? '' }}
                            @endif
                        </div>
                    @endforeach

                    @foreach($row->fieldsResponses as $resp)
                        <div class="py-2">
                            {{ $resp->field->name }}:{{ $resp->response ?? ''}}
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="flex justify-center items-center space-x-2">
                <x-heroicon-o-inbox class="h-8 w-8 text-gray-400"/>
                <span class="font-medium py-8 text-gray-400 text-xl">No {{ $title }} found...</span>
            </div>
        @endforelse

        @if ($rows->hasPages())
            <x-slot name="footer">
                {{ $rows->links() }}
            </x-slot>
        @endif
    </x-filament::card>
</x-filament::page>
