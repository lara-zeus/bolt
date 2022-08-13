<div class="flex-col space-y-4">
    <x-zeus::box>
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

                <div class="divide-y divide-gray-200 {{--gap-4--}} flex flex-col">
                    @foreach($fields->where('inShow',true) as $field)
                        <div class="{{--border-b border-gray-200--}} py-2">
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
                        <div class="{{--border-b border-gray-200--}} py-2">
                            {{ $resp->field->name }}:{{ $resp->response ?? ''}}
                        </div>
                    @endforeach
                </div>

                @if($oprations['edit'])
                    @if(isset($editRoute) && $editRoute !== null)
                        <x-zeus::elements.link href="{{ route($editRoute, ['formId' => $row->id]) }}" data-tippy-content="Edit item">
                            <x-heroicon-o-pencil-alt class="h-5 w-5 text-gray-400"/>
                        </x-zeus::elements.link>
                    @else
                        <x-zeus::elements.link wire:click="edit({{ $row->id }})" data-tippy-content="Edit item">
                            <x-heroicon-o-pencil-alt class="h-5 w-5 text-gray-400"/>
                        </x-zeus::elements.link>
                    @endif
                @endif

                @if($buttons !== null)
                    @foreach($buttons as $id => $button)
                        @if(\Illuminate\Support\Str::contains($button['link'],':'))
                            <?php
                            $linkURI = explode(':', $button['link']);
                            $link = $linkURI[1] ?? '';
                            ?>
                            <x-zeus::elements.link href="{{ route($linkURI[0],[$link=>$row->{$link}]) }}" target="{{ $button['target'] ?? '_self' }}" data-tippy-content="{{ $button['title'] ?? '' }}">
                                @if(isset($button['icon']))
                                    {{ svg($button['icon'])->class('h-5 w-5 text-gray-400') }}
                                @endif
                            </x-zeus::elements.link>
                        @else
                            <x-zeus::elements.link href="{{ route($button['link']) }}" target="{{ $button['target'] ?? '_self' }}" data-tippy-content="{{ $button['title'] ?? '' }}">
                                @if(isset($button['icon']))
                                    {{ svg($button['icon'])->class('h-5 w-5 text-gray-400') }}
                                @endif
                            </x-zeus::elements.link>
                        @endif
                    @endforeach
                @endif
                {{--<x-zeus::elements.link wire:click="$toggle('showDeleteModal')"> todo
                    <x-heroicon-o-trash class="h-5 w-5 text-gray-400" />
                </x-zeus::elements.link>--}}
            </div>
        @empty
            <div class="flex justify-center items-center space-x-2">
                <x-heroicon-o-inbox class="h-8 w-8 text-gray-400"/>
                <span class="font-medium py-8 text-gray-400 text-xl">No {{ $breadcrumbTitle }} found...</span>
            </div>
        @endforelse

        @if ($rows->hasPages())
            <x-slot name="footer">
                {{ $rows->links() }}
            </x-slot>
        @endif
    </x-zeus::box>
</div>
