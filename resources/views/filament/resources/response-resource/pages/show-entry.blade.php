<x-filament::page>
    <div x-data class="space-y-4 my-6 mx-4 w-full">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <x-filament::section>
                    @foreach($response->fieldsResponses as $resp)
                        @if($resp->field !== null)
                            <div class="py-2 text-ellipsis overflow-auto">
                                <p>{{ $resp->field->name ?? '' }}</p>
                                <div class="items-center flex justify-between">
                                    <p class="font-semibold mb-2">
                                        {!! ( new $resp->field->type )->entry($resp->field, $resp) !!}
                                    </p>
                                    @if($resp->form->extensions === 'LaraZeus\\BoltPro\\Extensions\\Grades')
                                        <livewire:bolt-pro.grading :response="$resp" />
                                    @endif
                                </div>
                                <hr/>
                            </div>
                        @endif
                    @endforeach
                </x-filament::section>
            </div>
            <div class="space-y-4">
                <x-filament::section>
                    <x-slot name="heading" class="text-primary-600">
                        {{ __('User Details') }}
                    </x-slot>
                    @if($response->user_id === null)
                        <span>{{ __('By') }} {{ __('Visitor') }}</span>
                    @else
                        <div class="flex gap-2 items-center">
                            <x-filament::avatar
                                    class="rounded-full"
                                    size="lg"
                                    :src="$response->user->avatar"
                                    :alt="($response->user->{config('auth.providers.users.model')::getBoltUserFullNameAttribute()}) ?? ''"
                            />
                            <p class="flex flex-col gap-1">
                                <span>{{ ($response->user->{config('auth.providers.users.model')::getBoltUserFullNameAttribute()}) ?? '' }}</span>
                                <span>{{ ($response->user->email) ?? '' }}</span>
                            </p>
                        </div>
                    @endif
                    <p class="flex flex-col my-1 gap-1">
                        <span class="text-base font-light">{{ __('created at') }}:</span>
                        <span class="font-semibold">
                            {{ $response->created_at->format($this->form->getDefaultDateDisplayFormat()) }}
                            -
                            {{ $response->created_at->format($this->form->getDefaultDateDisplayFormat()) }}
                        </span>
                    </p>
                </x-filament::section>
                <x-filament::section>
                    <x-slot name="heading" class="text-primary-600">
                        <p class="text-primary-600 font-semibold">{{ __('Entry Details') }}</p>
                    </x-slot>

                    <div class="flex flex-col mb-4">
                        <span class="text-gray-600">{{ __('Form') }}:</span>
                        <span>{{ $response->form->name ?? '' }}</span>
                    </div>

                    <div class="mb-4">
                        <span>{{ __('status') }}</span>
                        <span
                            color="{{ $response->status->getColor() }}"
                            x-tooltip="{
                                content: @js(__('status')),
                                theme: $store.theme,
                            }"
                        >
                            @svg($response->status->getIcon(),'w-4 h-4 inline')
                            {{ $response->status->getLabel() }}
                        </span>
                    </div>

                    <div class="flex flex-col">
                        <span>{{ __('Notes') }}:</span>
                        {!! nl2br($response->notes) !!}
                    </div>
                </x-filament::section>
            </div>
        </div>
    </div>
</x-filament::page>
