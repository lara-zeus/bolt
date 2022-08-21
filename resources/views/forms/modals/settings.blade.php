<x-filament::modal width="4xl">
    <x-slot name="trigger">
        <button x-on:click="isOpen = true" type="button" data-tippy-content="form activation and access options">
            <x-clarity-slider-line class="h-6 w-6 text-green-600" />
        </button>
    </x-slot>
    <x-slot name="header">
        <x-filament::modal.heading>
            <p class="text-green-700">
                <x-clarity-slider-line class="h-6 w-6 inline" />
                Form Settings
            </p>
        </x-filament::modal.heading>
    </x-slot>

    <div class="space-y-10">
        <x-zeus::input.group inline for="data.is_active" label="Activate the form">
            <x-zeus::input.toggle wireTo="data.is_active" />
        </x-zeus::input.group>

        <x-zeus::input.group inline for="data.options.requireLogin" label="require Login">
            <x-slot name="cite">
                User must be logged in or create an account before can submit a new entry
            </x-slot>
            <x-zeus::input.toggle wireTo="data.options.requireLogin" />
        </x-zeus::input.group>

        <div>
                <x-zeus::input.group inline for="data.options.oneEntryPerUser" label="One Entry Per User">
                    <x-slot name="cite">
                        to check if the user already submitted an entry in this form
                    </x-slot>
                    <x-zeus::input.toggle wireTo="data.options.oneEntryPerUser" />
                </x-zeus::input.group>
        </div>

        <x-zeus::input.group inline for="data.options.sectionsToPages" label="sections To Pages">
            <x-slot name="cite">
                instead of showing all section in one page, separate them in multiple pages with next and previous buttons
            </x-slot>
            <x-zeus::input.toggle wireTo="data.options.sectionsToPages" />
        </x-zeus::input.group>
    </div>

    <x-slot name="footer">
        <x-filament::modal.actions>
            <x-filament::button x-on:click="isOpen = false">Save</x-filament::button>
        </x-filament::modal.actions>
    </x-slot>
</x-filament::modal>
