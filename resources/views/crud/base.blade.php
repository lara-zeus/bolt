<div x-data x-init="tippy('[data-tippy-content]', {animation: 'perspective'});">
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="header">
        <h2>{{ $title }}</h2>
    </x-slot>

    <x-slot name="breadcrumb">
        <x-zeus::layouts.breadcrumb-item :label="$breadcrumbTitle"/>
    </x-slot>

    @if($setListView !== null)
        @include($setListView)
    @else
        <x-zeus::box>
            @if($oprations['create'])
                <div class="text-gray-500 mb-2">
                    {{--<h2 class="text-xl">{{ $title }}</h2>--}}
                    @if(isset($desc) && !empty($desc))
                        <p class="text-sm">{!! $desc !!}</p>
                    @endif
                </div>
            @endif

            <div class="flex justify-between">
                <div>
                    @if(!$oprations['create'])
                        <div class="text-gray-500 mb-2">
                            {{--<h2 class="text-xl">{{ $title }}</h2>--}}
                            @if(isset($desc) && !empty($desc))
                                <p class="text-sm">{!! $desc !!}</p>
                            @endif
                        </div>
                    @endif

                    {{--this is so uggly, todo, ref: https://github.com/laravel/framework/issues/32045--}}
                    @if($oprations['create'])
                        @if(isset($createRoute) && $createRoute !== null)
                            @if($createRoute === 'COMPONENT')
                                @livewire('forms.create-collection', ['fld'=>1,'options'=>false], key(1))
                            @else
                                <x-zeus::elements.button-link url="{{ route($createRoute) }}">
                                    <x-heroicon-o-plus class="h-5 w-5 inline align-middle"/>
                                    New
                                </x-zeus::elements.button-link>
                            @endif
                        @else
                            <x-zeus::elements.button-link wire:click="create">
                                <x-heroicon-o-plus class="h-5 w-5 inline align-middle"/>
                                New
                            </x-zeus::elements.button-link>
                        @endif
                    @endif
                </div>

                <div class="flex space-x-4 mb-4">
                    @if($oprations['search'] || $oprations['filters'])
                        @if($filters['search'] || $sorts)
                            <x-zeus::elements.link wire:click="resetAll" class="mt-2">
                                <x-heroicon-o-refresh class="h-6 w-6 text-primary-600"/>
                            </x-zeus::elements.link>
                        @endif

                        <x-zeus::dropdown.main>
                            <x-slot name="icon">
                                <x-heroicon-o-adjustments class="h-5 w-5 text-primary-600"/>
                            </x-slot>
                            <x-zeus::dropdown.item type="button" class="flex items-center space-x-2">
                                <div class="flex flex-col w-full text-left">
                                    <p class="block">
                                        <x-heroicon-o-menu class="inline-block w-5 h-5 text-gray-400"/>
                                        Per Page:
                                    </p>
                                    <x-zeus::input.select wire:model="perPage" id="perPage" class="">
                                        <option value="2">2</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </x-zeus::input.select>
                                </div>
                            </x-zeus::dropdown.item>
                            <x-zeus::dropdown.item type="button" wire:click="exportSelected" class="flex items-center space-x-2">
                                <x-heroicon-o-download class="h-4 w-4 text-gray-400"/>
                                <span>Export</span>
                            </x-zeus::dropdown.item>
                            <x-zeus::dropdown.item type="button" wire:click="$toggle('modals.showDeleteModal')" class="flex items-center space-x-2">
                                <x-heroicon-o-trash class="h-4 w-4 text-gray-400"/>
                                <span>Delete</span>
                            </x-zeus::dropdown.item>
                        </x-zeus::dropdown.main>

                        <x-zeus::input.text wire:model="filters.search" placeholder="Search...">
                            {{--<x-slot name="addOne">
                                <x-zeus::elements.link wire:click="$toggle('modals.showFilters')">
                                    <x-heroicon-o-trash class="h-4 w-4 text-gray-400" />
                                </x-zeus::elements.link>
                            </x-slot>--}}
                        </x-zeus::input.text>
                    @endif
                </div>
            </div>

            {{--<div>
                @if ($modals['showFilters'])
                    @include('zeus::crud.filters')
                @endif
            </div>--}}

            @include('zeus-bolt::crud.body')

            @if ($rows->hasPages())
                <x-slot name="footer">
                    {{ $rows->links() }}
                </x-slot>
            @endif

        </x-zeus::box>

        <!-- Delete form Modal -->
        <form wire:submit.prevent="deleteSelected">
            <x-zeus::modal.confirmation wire:model.defer="modals.showDeleteModal">
                <x-slot name="title">Delete form</x-slot>

                <x-slot name="content">
                    <div class="py-8 text-gray-700">Are you sure you? This action is irreversible.</div>
                </x-slot>

                <x-slot name="footer">
                    <x-zeus::elements.button color="white" wire:click="$toggle('modals.showDeleteModal')">Cancel</x-zeus::elements.button>

                    <x-zeus::elements.button color="red" type="submit">Delete</x-zeus::elements.button>
                </x-slot>
            </x-zeus::modal.confirmation>
        </form>

        @if($oprations['create'] || $oprations['edit'])
            @include('zeus-bolt::crud.form')
        @endif

        @if($oprations['show'] && !$rows->isEmpty())
            @include('zeus-bolt::crud.show')
        @endif
    @endif
</div>
