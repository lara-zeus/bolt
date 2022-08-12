<div>
    @if ($errors->any())
        <div class="mb-4">
            <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-4 grid grid-cols-3 gap-6">
        @foreach($fields[$sec] as $fld => $value)
            <div x-data="{ isCollapsed: false, showOptionsFor: false }" x-init="showOptionsFor = '{{ $fields[$sec][$fld]['type'] ?? '' }}', $refs.fieldName.focus()">
                <div>
                    @include('zeus-bolt::forms.modals.fieldsModals')
                </div>
                <div class="mb-4 p-4 transition ease-in-out duration-500 shadow-md group rounded-2xl hover:shadow-lg border-t-8 border-green-400 hover:border-green-500 bg-gray-200">
                    <div class="text-gray-600 flex justify-between">
                        <div class="text-xs">field #<span>{{ $fld + 1 }}</span></div>
                        <div class="space-x-2">
                            @if(count($fields[$sec]) > 1)
                                <x-zeus::elements.link>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                </x-zeus::elements.link>
                            @endif

                            <x-zeus::elements.link wire:click="openFieldModals({{$fld}},'settings')" data-tippy-content="Fields Options">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </x-zeus::elements.link>

                            <x-zeus::elements.link wire:click.prevent="removeField({{ $fld }})" data-tippy-content="Delete Field">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </x-zeus::elements.link>
                        </div>
                    </div>

                    <div class="mt-4 space-y-4">
                        <x-zeus::input.group for="name" inline label="Name">
                            <x-zeus::input.text wire:model="fields.{{ $sec }}.{{ $fld }}.name" :error="$errors->first('fields.'.$sec . '.'. $fld.'.name')" x-ref="fieldName" placeholder="field name"/>
                        </x-zeus::input.group>

                        @include('zeus-bolt::fields.fieldType')
                        {{--
                        ALL: title, desc, type, rouls

                        textarea : isWishing?

                        values list: show vertical
                            defualt value selected

                        stars
                        range from to

                        pre list: $$
                            countries and cities
                            countries only
                            cities only pre defined conutry
                            nationalties
                            genders
                        --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
