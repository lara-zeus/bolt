<x-zeus::modal.dialog wire:model.defer="modals.FormOptions" x-cloak>
    <x-slot name="title">
        <p class="text-green-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Form Options
        </p>
    </x-slot>

    <x-slot name="content">


        <div class="bord my-32">
            aaa
        </div>



        <div class="space-y-10">

            <x-zeus::input.group for="category_id" inline label="Category">
                <x-zeus::input.select id="category_id" wire:model="form.category_id">
                    <option value="">Select Category...</option>
                    {{--@foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach--}}
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
                            <x-zeus::input.date wire:model="form.start_date" placeholder="Start Date"/>
                        </x-zeus::input.group>
                    </div>
                    <div class="w-full">
                        <x-zeus::input.group inline for="end_date" label="End Date">
                            <x-zeus::input.date wire:model="form.end_date" placeholder="End Date"/>
                        </x-zeus::input.group>
                    </div>
                </div>
            </div>

            <x-zeus::input.group inline for="form.options.emailsNotification" label="Emails Notifications" help-text="separate emails with a comma">
                <x-slot name="cite">
                    optional,
                    enter the emails you want to receive notification when ever you got a new entry
                </x-slot>
                <x-zeus::input.text wire:model="form.options.emailsNotification" placeholder="emailOne , emailTwo" />
            </x-zeus::input.group>

            <x-zeus::input.group inline for="form.options.webHook" label="Send to a webhook" help-text="enter webHook URL">
                <x-slot name="cite">
                    Send the form data to a webHook, <a>read more</a>
                </x-slot>
                <x-zeus::input.text wire:model="form.options.webHook" placeholder="" />
            </x-zeus::input.group>
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-zeus::elements.button wire:click="$toggle('modals.FormOptions')">Save</x-zeus::elements.button>
    </x-slot>
</x-zeus::modal.dialog>
