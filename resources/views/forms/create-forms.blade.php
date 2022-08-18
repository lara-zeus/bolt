<div x-data x-init="tippy('[data-tippy-content]', {animation: 'perspective'});">
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
                    @include('zeus-bolt::forms.modals.options')
                    @include('zeus-bolt::forms.modals.texts')
                    @include('zeus-bolt::forms.modals.settings')
                </div>
            </div>
        </div>
    </x-zeus::box>

    @livewire('bolt.create-section', ['formId' => $form->id])

    <div class="p-4 text-center flex items-center justify-center">
        <div>
            <button wire:click="store" class="flex items-stretch justify-evenly justify-items-stretch px-4 py-2 text-base leading-6 font-medium rounded-md text-white focus:outline-none bg-green-600 hover:bg-green-500 transition-all duration-100 ease-in-out w-20">
                <span>Save</span>
            </button>
        </div>
    </div>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6.3.7/animations/perspective.css"/>

    @push('beforeCoreScripts')
        <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://unpkg.com/tippy.js@6.3.7/dist/tippy-bundle.umd.min.js"></script>
        <script src="https://unpkg.com/moment@2.29.1/moment.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    @endpush
</div>
