<div x-data class="space-y-4 my-6 mx-4 w-full">

    <x-slot name="header">
        <h2>{{ __('zeus-bolt::messages.show_entry_details') }}</h2>
    </x-slot>

    <x-slot name="breadcrumbs">
        <li class="flex items-center">
            <a href="{{ route('bolt.entries.list') }}">{{ __('zeus-bolt::messages.my_entries') }}</a>
            @svg('heroicon-s-arrow-small-right','fill-current w-4 h-4 mx-3')
        </li>

        <li class="flex items-center">
            {{ __('zeus-bolt::response.show_entry') }} # {{ $response->id }}
        </li>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 space-y-4">
            <x-filament::section>
                <div class="grid grid-cols-1">
                    @foreach($response->fieldsResponses as $resp)
                        <div class="py-2 text-ellipsis overflow-auto">
                            <p>{{ $resp->field->name }}</p>
                            <p class="font-semibold mb-2">{!! ( new $resp->field->type )->getResponse($resp->field, $resp) !!}</p>
                            <hr/>
                        </div>
                    @endforeach
                </div>
            </x-filament::section>
        </div>
        <div class="md:col-span-1 space-y-4">
            <x-filament::section class="w-full">
                <x-slot name="heading" class="text-primary-600">
                    {{ __('zeus-bolt::messages.user_details') }}
                </x-slot>
                <p>
                    <span class="text-base font-light">{{ __('zeus-bolt::messages.by') }}</span>:
                    @if($response->user_id === null)
                        {{ __('zeus-bolt::messages.visitor') }}
                    @else
                        {{ ($response->user->name) ?? '' }}
                    @endif
                </p>
                <p class="flex flex-col">
                    <span class="text-base font-light">{{ __('zeus-bolt::response.created_at') }}:</span>
                    <span class="font-semibold">{{ $response->created_at->format($this->form->getDefaultDateDisplayFormat()) }}-{{ $response->created_at->format($this->form->getDefaultDateDisplayFormat()) }}</span>
                </p>
            </x-filament::section>
            <div>
                <div class="space-y-2">
                    <x-filament::section>
                        <x-slot name="heading" class="text-primary-600">
                            <p class="my-3 mx-1 text-primary-600 font-semibold">{{ __('zeus-bolt::messages.entry_details') }}</p>
                        </x-slot>

                        <div class="flex flex-col">
                            <span class="text-gray-600">{{ __('zeus-bolt::messages.form') }}:</span>
                            {{ $response->form->name ?? '' }}
                        </div>

                        <div>
                            <span>{{ __('zeus-bolt::forms.status') }}</span>
                            <span
                                color="{{ $response->status->getColor() }}"
                                x-tooltip="{
                                    content: @js(__('zeus-bolt::forms.status')),
                                    theme: $store.theme,
                                }"
                            >
                                @svg($response->status->getIcon(),'w-4 h-4 inline')
                                {{ $response->status->getLabel() }}
                            </span>
                        </div>

                        <div class="flex flex-col">
                            <span>{{ __('zeus-bolt::forms.notes') }}:</span>
                            {!! nl2br($response->notes) !!}
                        </div>

                    </x-filament::section>
                </div>
            </div>
        </div>
    </div>
</div>
