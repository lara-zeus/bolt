<div>
    <div class="flex flex-row-reverse">
        <x-zeus::elements.link class="text-green-600" wire:click.prevent="addSection" autocomplete="false">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add Section
        </x-zeus::elements.link>
    </div>

    @foreach($sections as $key => $value)

        <x-zeus::box shadowless>
            <x-slot name="header">
                <div class="flex justify-between" x-data x-init="{{--$refs.sectionName.focus()--}}">
                    <div class="flex items-center">
                        <div class="text-xs">section #<span>{{ $key + 1 }}</span></div>
                        <div>
                            <label class="sr-only" for="section-name-{{ $key }}"></label>
                            <x-zeus::input.text-clear id="section-name-{{ $key }}" wire:model.lazy="sections.{{ $key }}.name" x-ref="sectionName" placeholder="section name" />
                            @error('sections.'.$key.'.name') <div class="mt-3 text-red-500 text-sm">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="space-x-2">
                        <x-zeus::elements.link class="text-green-600" wire:click.prevent="addField({{ $key }})">
                            <svg xmlns="http://www.w3.org/2000/svg" class="align-bottom h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Field
                        </x-zeus::elements.link>
                        <x-zeus::elements.link class="text-red-600" data-tippy-content="Delete Section and it's fields" wire:click.prevent="removeSection({{ $key }})">
                            <svg xmlns="http://www.w3.org/2000/svg" class="align-bottom h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </x-zeus::elements.link>
                    </div>
                </div>
            </x-slot>

            @livewire('bolt.create-field',['formId' => $value->form_id, 'sec'=>$key],key($key))

        </x-zeus::box>
    @endforeach
</div>
