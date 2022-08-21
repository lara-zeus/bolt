<x-filament::modal width="4xl">
    <x-slot name="trigger">
        <button x-on:click="isOpen = true" type="button" data-tippy-content="Other Form Options">
            <x-clarity-cog-line class="h-6 w-6 text-green-600" />
        </button>
    </x-slot>
    <x-slot name="header">
        <x-filament::modal.heading>
            <p class="text-green-700">
                <x-clarity-cog-line class="h-6 w-6 inline" />
                Form Options
            </p>
        </x-filament::modal.heading>
    </x-slot>

    <div class="space-y-10">
        <x-zeus::input.group for="category_id" inline label="Category">
            <cite class="text-gray-500 text-xs mb-4 block">
                optional,
                organize your forms into categories
            </cite>
            <x-zeus::input.select id="category_id" wire:model="data.category_id">
                <option value="">Select Category...</option>
                @foreach(\LaraZeus\Bolt\Models\Category::get() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </x-zeus::input.select>
        </x-zeus::input.group>

        <div>
            <h4 class="block text-base font-medium leading-5 text-green-700">Form Dates</h4>
            <cite class="text-gray-500 text-xs mb-4 block">
                optional,
                specify when the form will be active and receiving new entries
            </cite>
            <div class="flex justify-between gap-2">
                <div class="w-full">
                    <x-zeus::input.group inline for="start_date" label="Start Date">
                        <x-zeus::input.date wire:model="data.start_date" placeholder="Start Date" id="start_date" />
                    </x-zeus::input.group>
                </div>

                <div class="w-full">
                    <x-zeus::input.group inline for="end_date" label="End Date">
                        <x-zeus::input.date wire:model="data.end_date" placeholder="End Date"/>
                    </x-zeus::input.group>
                </div>
            </div>
        </div>

        <x-zeus::input.group inline for="data.options.emailsNotification" label="Emails Notifications" help-text="separate emails with a comma">
            <x-slot name="cite">
                optional,
                enter the emails you want to receive notification when ever you got a new entry
            </x-slot>
            <x-zeus::input.text wire:model="data.options.emailsNotification" placeholder="emailOne , emailTwo"/>
        </x-zeus::input.group>

        <x-zeus::input.group inline for="data.options.webHook" label="Send to a webhook" help-text="enter webHook URL">
            <x-slot name="cite">
                Send the form data to a webHook, <a>read more</a>
            </x-slot>
            <x-zeus::input.text wire:model="data.options.webHook" placeholder=""/>
        </x-zeus::input.group>
    </div>
    <x-slot name="footer">
        <x-filament::modal.actions>
            <x-filament::button x-on:click="isOpen = false">Save</x-filament::button>
        </x-filament::modal.actions>
    </x-slot>
</x-filament::modal>
