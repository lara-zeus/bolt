<div class="flex-col space-y-4">
    @php $listFields = $fields->where('formOnly',false) @endphp
    <x-zeus::table.main>
        <x-slot name="head">
            @if($oprations['bulkActions'])
                <x-zeus::table.heading class="bg-gray-100 w-1">
                    <x-zeus::input.checkbox wire:model="selectPage"/>
                </x-zeus::table.heading>
            @endif

            @foreach($listFields as $field)
                <x-zeus::table.heading sortable multi-column wire:click="sortBy('{{ $field['id'] }}')" :direction="$sorts[$field['id']] ?? null" class="bg-gray-100">
                    {{ $field['label'] }}
                </x-zeus::table.heading>
            @endforeach

            <x-zeus::table.heading sortable multi-column wire:click="sortBy('{{ $field['id'] }}')" :direction="$sorts[$field['id']] ?? null" class="bg-gray-100">
                {{ __('Last update') }}
            </x-zeus::table.heading>

            @if($oprations['edit'] || $oprations['show'] || $buttons !== null || $oprations['delete'])
                <x-zeus::table.heading class="bg-gray-100 w-1"/>
            @endif
        </x-slot>

        <x-slot name="body">
            <div>
                @if($oprations['bulkActions'])
                    @if ($selectPage && ($rows->count() !== $rows->total()))
                        <x-zeus::table.row class="bg-gray-50" wire:key="row-message">
                            <x-zeus::table.cell colspan="{{ $listFields->count() + 3 }}">
                                @unless ($selectAll)
                                    <div>
                                        <span>You have selected <strong class="font-bold text-primary-600">{{ $rows->count() }}</strong> items, do you want to select all <strong class="font-bold text-primary-600">{{ $rows->total() }}</strong> ?</span>
                                        <x-zeus::elements.link wire:click="selectAll" class="ml-1 text-gray-600 bg-gray-200 px-2 py-0.5 rounded hover:text-primary-600">Select All</x-zeus::elements.link>
                                    </div>
                                @else
                                    <span>You are currently selecting all <strong class="font-bold text-primary-600">{{ $rows->total() }}</strong> items.</span>
                                @endif
                            </x-zeus::table.cell>
                        </x-zeus::table.row>
                    @endif
                @endif
            </div>
            @forelse ($rows as $row)
                <x-zeus::table.row class="hover:bg-gray-50 transition duration-150 ease-in-out" wire:key="row-{{ $row->id }}">

                    @if($oprations['bulkActions'])
                        <x-zeus::table.cell class="pr-0">
                            <x-zeus::input.checkbox wire:model="selected" value="{{ $row->id }}"/>
                        </x-zeus::table.cell>
                    @endif

                    @foreach($listFields as $field)
                        <x-zeus::table.cell>
                            @if($field['type'] === 'input.file-upload')
                                <img class="w-20 h-20" src="{{ asset('storage/'.$row->{$field['id']}) }}">
                            @else
                                @if(\Illuminate\Support\Str::contains($field['id'],'.'))
                                    {{ ($flattenedRows[$loop->parent->index.'.'.$field['id']]) ?? '' }}
                                @elseif(isset($field['listAtt']))
                                    {!! $row->{$field['listAtt']} !!}
                                @elseif(isset($row->{$field['id']}))
                                    {{ $row->{$field['id']} }}
                                @else
                                    {{ $field['id'] ?? '' }}
                                @endif
                            @endif
                        </x-zeus::table.cell>
                    @endforeach

                    <x-zeus::table.cell>{!! $row->last_updated !!}</x-zeus::table.cell>

                    @if($oprations['edit'] || $oprations['show'] || $buttons !== null || $oprations['delete'])
                        <x-zeus::table.cell>
                        <x-zeus::dropdown.main>
                            <x-slot name="icon">
                                <x-heroicon-o-dots-vertical class="h-5 w-5 text-gray-400"/>
                            </x-slot>

                            @if($oprations['edit'])
                                @if(isset($editRoute) && $editRoute !== null)
                                    <x-zeus::dropdown.item type="link" href="{{ route($editRoute, ['formId' => $row->id]) }}" class="flex items-center space-x-2">
                                        <x-heroicon-o-pencil-alt class="h-5 w-5 text-gray-400"/>
                                        <span>{{ __('Edit') }}</span>
                                    </x-zeus::dropdown.item>
                                @else
                                    <x-zeus::dropdown.item type="link" wire:click="edit({{ $row->id }})" class="flex items-center space-x-2">
                                        <x-heroicon-o-pencil-alt class="h-5 w-5 text-gray-400"/>
                                        <span>{{ __('Edit') }}</span>
                                    </x-zeus::dropdown.item>
                                @endif
                            @endif

                            @if($oprations['show'])
                                <x-zeus::dropdown.item type="link" wire:click="show({{ $row->id }})" class="flex items-center space-x-2">
                                    <x-heroicon-o-eye class="h-5 w-5 text-gray-400"/>
                                    <span>{{ __('show details') }}</span>
                                </x-zeus::dropdown.item>
                            @endif

                            @if($buttons !== null)
                                @foreach($buttons as $id => $button)
                                    @if(\Illuminate\Support\Str::contains($button['link'],':'))
                                        <?php
                                        $linkURI = explode(':', $button['link']);
                                        $link = $linkURI[1] ?? '';
                                        ?>
                                        <x-zeus::dropdown.item type="link" href="{{ route($linkURI[0],[$link=>$row->{$link}]) }}" target="{{ $button['target'] ?? '_self' }}" class="flex items-center space-x-2">
                                            @if(isset($button['icon']))
                                                {{ svg($button['icon'])->class('h-5 w-5 text-gray-400') }}
                                            @endif
                                            <span>{{ $button['title'] ?? '' }}</span>
                                        </x-zeus::dropdown.item>
                                    @else
                                        <x-zeus::dropdown.item type="link" href="{{ route($button['link']) }}" target="{{ $button['target'] ?? '_self' }}" class="flex items-center space-x-2">
                                            @if(isset($button['icon']))
                                                {{ svg($button['icon'])->class('h-5 w-5 text-gray-400') }}
                                            @endif
                                            <span>{{ $button['title'] ?? '' }}</span>
                                        </x-zeus::dropdown.item>
                                    @endif
                                @endforeach
                            @endif

                            @if($oprations['delete'])
                                <x-zeus::dropdown.item type="link" wire:click="$toggle('showDeleteModal')" class="flex items-center space-x-2">
                                    <x-heroicon-o-trash class="text-red-400 h-5 w-5 text-gray-400"/>
                                    <span class="text-red-400 ">{{ __('delete') }}</span>
                                </x-zeus::dropdown.item>
                            @endif
                        </x-zeus::dropdown.main>
                    </x-zeus::table.cell>
                    @endif
                </x-zeus::table.row>
            @empty
                <x-zeus::table.row>
                    <x-zeus::table.cell colspan="{{ $fields->count() + 3 }}">
                        <div class="flex justify-center items-center space-x-2">
                            <x-heroicon-o-inbox class="h-8 w-8 text-gray-400"/>
                            <span class="font-medium py-8 text-gray-400 text-xl">No {{ $breadcrumbTitle }} found...</span>
                        </div>
                    </x-zeus::table.cell>
                </x-zeus::table.row>
            @endforelse
        </x-slot>
    </x-zeus::table.main>
</div>