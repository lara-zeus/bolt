<div x-data x-init="tippy('[data-tippy-content]', {animation: 'perspective',});">
    <x-slot name="header">
        <h2>{{ $zeusForm->name ?? '' }}</h2>
        <p class="text-gray-400 text-mdd my-4">{{ $zeusForm->desc ?? '' }}</p>
    </x-slot>

    <form wire:submit.prevent="store">
        {!! nl2br($zeusForm->details) !!}
        <div class="text-gray-400 text-sm">
            @if($zeusForm->start_date !== null)
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ __('Available from') }}:

                <span>{{ optional($zeusForm->start_date)->format('Y/m/d') }}</span>,
                {{ trans('to') }}: <span>{{ optional($zeusForm->end_date)->format('Y/m/d') }}</span>
            @endif
        </div>

        <div>
            @if (app()->isLocal() && $errors->any())
                <div class="mt-5">
                    <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
                    <p class="text-gray-400 text-xs">this shown for dev only!</p>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="container mx-auto my-10">
            {{ $this->form }}
        </div>

        <div id="result"></div>

        <div class="p-4 text-center">
            <x-zeus::elements.button type="submit">Save</x-zeus::elements.button>
        </div>
    </form>
</div>
