<div x-data class="space-y-4 my-6 mx-4 w-full">

    <x-slot name="header">
        <h3>{{ __('Show Entry Details') }}</h3>
    </x-slot>

    <x-slot name="breadcrumps">
        <li class="flex items-center">
            <a href="{{ route('bolt.entries.list') }}">{{ __('My Entries') }}</a>
            <x-iconpark-rightsmall-o class="fill-current w-4 h-4 mx-3" />
        </li>

        <li class="flex items-center">
            {{ __('Show entry') }} # {{ $getRecord()->id }}
        </li>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 space-y-4">
            <x-filament::card>
                <div class="grid grid-cols-1">
                    @foreach($getRecord()->fieldsResponses as $resp)
                        <div class="py-2 text-ellipsis overflow-auto">
                            <p>{{ $resp->field->name }}</p>
                            <p class="font-semibold mb-2">{!! ( new $resp->field->type )->getResponse($resp->field, $resp) !!}</p>
                            <x-filament::hr/>
                        </div>
                    @endforeach
                </div>
            </x-filament::card>
        </div>
        <div class="md:col-span-1 space-y-4">
            <x-filament::card class="w-full">
                <x-filament::card.heading class="text-secondary-600">
                    {{ __('User Details') }}
                </x-filament::card.heading>
                <p>
                    <span class="text-base font-light">{{ __('By') }}</span>:
                    @if($getRecord()->user_id === null)
                        {{ __('Visitor') }}
                    @else
                        {{ ($getRecord()->user->name) ?? '' }}
                    @endif
                </p>
                <p class="flex flex-col">
                    <span class="text-base font-light">{{ __('created at') }}:</span>
                    <span class="font-semibold">{{ $getRecord()->created_at->format('Y.m/d') }}-{{ $getRecord()->created_at->format('h:i a') }}</span>
                </p>
            </x-filament::card>
            <div>
                <div class="space-y-2">
                    <x-filament::card>
                        <x-filament::card.heading class="text-primary-600">
                            <p class="my-3 mx-1 text-secondary-600 font-semibold">{{ __('Entry Details') }}</p>
                        </x-filament::card.heading>

                        <div class="flex flex-col">
                            <span class="text-gray-600">{{ __('Form') }}:</span>
                            {{ $getRecord()->form->name ?? '' }}
                        </div>

                        <div>
                            <span>{{ __('status') }}</span>
                            @php $getStatues = config('zeus-bolt.models.FormsStatus')::where('key',$getRecord()->status)->first() @endphp
                            <span class="{{ $getStatues->class }}" x-tooltip.raw="{{ __('status') }}">
                                @svg($getStatues->icon,'w-4 h-4 inline')
                                {{ $getStatues->label }}
                            </span>
                        </div>

                        <div class="flex flex-col">
                            <span>{{ __('Notes') }}:</span>
                            {!! nl2br($getRecord()->notes) !!}
                        </div>

                    </x-filament::card>
                </div>
            </div>
        </div>
    </div>
</div>
