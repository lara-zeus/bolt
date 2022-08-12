{{--<x-filament::page>--}}
    <div x-data x-init="tippy('[data-tippy-content]', {animation: 'perspective'});">

        @include('zeus-bolt::forms.modals.options')
        @include('zeus-bolt::forms.modals.texts')
        @include('zeus-bolt::forms.modals.settings')

        {{--<button wire:click="fuckingOpenIt('memberManagementModal')">sdfsdfs</button>

        <x-filament::modal id="memberManagementModal">
            <x-slot name="subheading">
                subheading
            </x-slot>

            <x-slot name="heading">
                <p class="text-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Form Options
                </p>
            </x-slot>

            <div>
                <x-zeus::input.group inline for="desc" label="Desc" :error="$errors->first('form.desc')">
                    <x-zeus::input.textarea wire:model="form.desc" placeholder="Form Desc"/>
                </x-zeus::input.group>
            </div>

            <x-slot name="footer">
                <x-filament::button type="submit">
                    Adicionar
                </x-filament::button>
            </x-slot>
        </x-filament::modal>--}}

        <x-zeus::box shadowless class="bg-gray-50 mb-10 shadow-sm">
            <div class="flex-grow">
                <div class="flex items-center justify-between gap-4">
                    <div class="w-1/3">
                        <x-zeus::input.group for="form.name" inline label="Name" :error="$errors->first('form.name')">
                            <x-zeus::input.text wire:change="setSlug" wire:model.lazy="form.name" placeholder="Title"/>
                        </x-zeus::input.group>
                    </div>
                    <div class="w-1/3 flex flex-shrink-0">
                        <x-zeus::input.group for="form.name" inline label="Name" :error="$errors->first('form.slug')">
                            <x-zeus::input.text-clear wire:model.lazy="form.slug" placeholder="Form Slug" class="pl-0 pr-0 text-xs">
                                <x-slot name="preAddOne">{{ url(config('zeus.user.prefix').'/') }}/</x-slot>
                            </x-zeus::input.text-clear>
                        </x-zeus::input.group>
                    </div>
                    <div class="flex gap-2 w-1/3 flex-row-reverse">
                        <x-zeus::elements.link wire:click="$toggle('modals.FormSettings')" data-tippy-content="form activation and access options">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                        </x-zeus::elements.link>

                        <x-zeus::elements.link wire:click="$toggle('modals.FormTexts')" data-tippy-content="Set Form Texts, like desc and details">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                            </svg>
                        </x-zeus::elements.link>

                        <x-zeus::elements.link wire:click="$toggle('modals.FormOptions')" data-tippy-content="Other Form Options">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </x-zeus::elements.link>
                    </div>
                </div>
            </div>
        </x-zeus::box>

        @livewire('bolt.create-section', ['formId' => $form->id])

        <div class="p-4 text-center flex items-center justify-center">
            {{--loading = (loading) ? false : true--}}
            <div x-data="{loading: false}">
                <button :disabled="loading" @click="loading = true" wire:click="store" :class="{'cursor-not-allowed w-32': loading}" class="flex items-stretch justify-evenly justify-items-stretch px-4 py-2 text-base leading-6 font-medium rounded-md text-white focus:outline-none bg-green-600 hover:bg-green-500 transition-all duration-100 ease-in-out w-20">
                    <span>Save</span>
                    <span class="flex items-center" x-show="loading" x-cloak>
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
                </button>
            </div>
        </div>

        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
        <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/perspective.css"/>

        @push('beforeCoreScripts')
            <script src="https://unpkg.com/@popperjs/core@2"></script>
            <script src="https://unpkg.com/tippy.js@6"></script>
            <script src="https://unpkg.com/moment@2.29.1/moment.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
        @endpush
    </div>
{{--
</x-filament::page>
--}}
