<x-filament::modal width="4xl">
    <x-slot name="trigger">
        <button x-on:click="isOpen = true" type="button" data-tippy-content="Set Form Texts, like desc and details">
            <x-clarity-talk-bubbles-line class="h-6 w-6 text-green-600" />
        </button>
    </x-slot>
    <x-slot name="header">
        <x-filament::modal.heading>
            <p class="text-green-700">
                <x-clarity-talk-bubbles-line class="h-6 w-6 inline" />
                Form Texts
            </p>
        </x-filament::modal.heading>
    </x-slot>

    <div class="space-y-10">
        <x-zeus::input.group inline for="desc" label="Desc" :error="$errors->first('data.desc')">
            <x-zeus::input.textarea wire:model="data.desc" placeholder="Form Desc"/>
        </x-zeus::input.group>

        <x-zeus::input.group inline label="Details" for="data.details" :error="$errors->first('data.details')" help-text="Write a few details about the form.">
            <x-zeus::input.rich-text wire:model.lazy="data.details" id="data.details"/>
        </x-zeus::input.group>

        <x-zeus::input.group inline for="options.confirmationMessage" label="Confirmation Message">
            <x-slot name="cite">
                optional,
                show a massage whenever any one submit a new entery
            </x-slot>
            <x-zeus::input.textarea wire:model="data.options.confirmationMessage" placeholder="Confirmation Message"/>
        </x-zeus::input.group>
    </div>

    <x-slot name="footer">
        <x-filament::modal.actions>
            <x-filament::button x-on:click="isOpen = false">Save</x-filament::button>
        </x-filament::modal.actions>
    </x-slot>
</x-filament::modal>
