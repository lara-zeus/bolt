<div x-data class="space-y-4 my-6 mx-4 w-full">
    @php
        $getRecord = $getRecord();
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2">
            <x-filament::section>
                @foreach($getRecord->fieldsResponses as $resp)
                    @if($resp->field !== null)
                        <div class="py-2 text-ellipsis overflow-auto">
                            <p>{{ $resp->field->name ?? '' }}</p>
                            <p class="font-semibold mb-2">
                                {!! ( new $resp->field->type )->getResponse($resp->field, $resp) !!}
                            </p>
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
                @if($getRecord->user_id === null)
                    <span>{{ __('By') }} {{ __('Visitor') }}</span>
                @else
                    <div class="flex gap-2 items-center">
                        <x-filament::avatar
                                class="rounded-full"
                                size="lg"
                                :src="$getRecord->user->avatar"
                                :alt="($getRecord->user->{config('auth.providers.users.model')::getBoltUserFullNameAttribute()}) ?? ''"
                        />
                        <p class="flex flex-col gap-1">
                            <span>{{ ($getRecord->user->{config('auth.providers.users.model')::getBoltUserFullNameAttribute()}) ?? '' }}</span>
                            <span>{{ ($getRecord->user->email) ?? '' }}</span>
                        </p>
                    </div>
                @endif
                <p class="flex flex-col my-1 gap-1">
                    <span class="text-base font-light">{{ __('created at') }}:</span>
                    <span class="font-semibold">{{ $getRecord->created_at->format(\Filament\Infolists\Infolist::$defaultDateDisplayFormat) }}-{{ $getRecord->created_at->format(\Filament\Infolists\Infolist::$defaultTimeDisplayFormat) }}</span>
                </p>
            </x-filament::section>
            <x-filament::section>
                <x-slot name="heading" class="text-primary-600">
                    <p class="text-primary-600 font-semibold">{{ __('Entry Details') }}</p>
                </x-slot>

                <div class="flex flex-col mb-4">
                    <span class="text-gray-600">{{ __('Form') }}:</span>
                    <span>{{ $getRecord->form->name ?? '' }}</span>
                </div>

                <div class="mb-4">
                    <span>{{ __('status') }}</span>
                    @php $getStatues = $getRecord->statusDetails() @endphp
                    <span class="{{ $getStatues['class']}}"
                          x-tooltip="{
                                    content: @js(__('status')),
                                    theme: $store.theme,
                                  }">
                        @svg($getStatues['icon'],'w-4 h-4 inline')
                        {{ $getStatues['label'] }}
                    </span>
                </div>

                <div class="flex flex-col">
                    <span>{{ __('Notes') }}:</span>
                    {!! nl2br($getRecord->notes) !!}
                </div>
            </x-filament::section>
        </div>
    </div>
</div>
