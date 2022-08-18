<x-filament::modal width="4xl">
    <x-slot name="trigger">
        <button x-on:click="isOpen = true" type="button" data-tippy-content="Set Form Texts, like desc and details">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
            </svg>
        </button>
    </x-slot>
    <x-slot name="header">
        <x-filament::modal.heading>
            <p class="text-green-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                </svg>
                Form Texts
            </p>
        </x-filament::modal.heading>
    </x-slot>

    <div class="space-y-10">
        <x-zeus::input.group inline for="desc" label="Desc" :error="$errors->first('form.desc')">
            <x-zeus::input.textarea wire:model="form.desc" placeholder="Form Desc"/>
        </x-zeus::input.group>

        <x-zeus::input.group inline label="Details" for="details" :error="$errors->first('details')" help-text="Write a few details about the form.">
            <x-zeus::input.rich-text wire:model.lazy="form.details" id="details"/>
        </x-zeus::input.group>

        <x-zeus::input.group inline for="options.confirmationMessage" label="Confirmation Message">
            <x-slot name="cite">
                optional,
                show a massage whenever any one submit a new entery
            </x-slot>
            <x-zeus::input.textarea wire:model="form.options.confirmationMessage" placeholder="Confirmation Message"/>
        </x-zeus::input.group>
    </div>

    <x-slot name="footer">
        <x-filament::modal.actions>
            <x-filament::button x-on:click="isOpen = false">Save</x-filament::button>
        </x-filament::modal.actions>
    </x-slot>
</x-filament::modal>
