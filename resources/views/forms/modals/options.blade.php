<x-filament::modal width="4xl">
    <x-slot name="trigger">
        <button x-on:click="isOpen = true" type="button" data-tippy-content="{{ __('Other Form Options') }}">
            <x-clarity-cog-line class="h-6 w-6 text-green-600" />
        </button>
    </x-slot>
    <x-slot name="header">
        <x-filament::modal.heading>
            <p class="text-green-700">
                <x-clarity-cog-line class="h-6 w-6 inline" />
                {{ __('Form Options') }}
            </p>
        </x-filament::modal.heading>
    </x-slot>

    <div class="space-y-10">
        <x-zeus::input.group for="category_id" inline label="{{ __('Category') }}">
            <cite class="text-gray-500 text-xs mb-4 block">
                {{ __('optional, organize your forms into categories') }}
            </cite>
            <x-zeus::input.select id="category_id" wire:model="data.category_id">
                <option value="">{{ __('Select Category...') }}</option>
                @foreach(\LaraZeus\Bolt\Models\Category::get() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </x-zeus::input.select>
        </x-zeus::input.group>

        <div>
            <h4 class="block text-base font-medium leading-5 text-green-700">{{ __('Form Dates') }}</h4>
            <cite class="text-gray-500 text-xs mb-4 block">
                {{ __('optional, specify when the form will be active and receiving new entries') }}
            </cite>
            <div class="flex justify-between gap-2">
                <div class="w-full">
                    <x-zeus::input.group inline for="start_date" label="{{ __('Start Date') }}">
                        <x-zeus::input.date wire:model="data.start_date" placeholder="{{ __('Start Date') }}" id="start_date" />
                    </x-zeus::input.group>
                </div>

                <div class="w-full">
                    <x-zeus::input.group inline for="end_date" label="{{ __('End Date') }}">
                        <x-zeus::input.date wire:model="data.end_date" placeholder="{{ __('End Date') }}"/>
                    </x-zeus::input.group>
                </div>
            </div>
        </div>

        <x-zeus::input.group inline for="data.options.emailsNotification" label="{{ __('Emails Notifications') }}" help-text="{{ __('separate emails with a comma') }}">
            <x-slot name="cite">
                {{ __('optional, enter the emails you want to receive notification when ever you got a new entry') }}
            </x-slot>
            <x-zeus::input.text wire:model="data.options.emailsNotification" placeholder="{{ __('emailOne , emailTwo') }}"/>
        </x-zeus::input.group>

        <x-zeus::input.group inline for="data.options.webHook" label="Send to a webhook" help-text="{{ __('enter webHook URL') }}">
            <x-slot name="cite">
                {{ __('Send the form data to a webHook.') }}
            </x-slot>
            <x-zeus::input.text wire:model="data.options.webHook" placeholder="https://site/etc"/>
        </x-zeus::input.group>
    </div>
    <x-slot name="footer">
        <x-filament::modal.actions>
            <x-filament::button x-on:click="isOpen = false">{{ __('Save') }}</x-filament::button>
        </x-filament::modal.actions>
    </x-slot>
</x-filament::modal>
