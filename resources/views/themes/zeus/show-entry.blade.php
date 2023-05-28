<div x-data class="space-y-4 my-6 mx-4 ">

    <x-slot name="header">
        <h2>{{ __('Show Entry Details') }}</h2>
    </x-slot>

    <x-slot name="breadcrumps">
        <li class="flex items-center">
            <a href="{{ route('bolt.user.entries.list') }}">{{ __('My Entries') }}</a>
            <x-iconpark-rightsmall-o class="fill-current w-4 h-4 mx-3" />
        </li>

        <li class="flex items-center">
            {{ __('Show entry') }} # {{ $response->id }}
        </li>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 space-y-4">
            <x-filament::card>
                <x-filament::card.heading>
                    {{ __('Entry Details') }}
                </x-filament::card.heading>
                <div class="grid grid-cols-1">
                    @foreach($response->fieldsResponses as $resp)
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
                <x-filament::card.heading>
                    {{ __('User Details') }}
                </x-filament::card.heading>
                <p>
                    <span class="text-base font-light">{{ __('By') }}</span>:
                    @if($response->user_id === null)
                        {{ __('Visitor') }}
                    @else
                        {{ ($response->user->name) ?? '' }}
                    @endif
                </p>
                <p>
                    <span class="text-base font-light">{{ __('created at') }}</span>:
                    <span class="font-semibold">{{ $response->created_at->format('Y.m/d') }}-{{ $response->created_at->format('h:i a') }}</span>
                </p>
            </x-filament::card>
            <div>
                <p class="my-3 mx-1 text-secondary-600 font-semibold">{{ __('Entry Details') }}</p>
                <div class="space-y-2">
                    <x-filament::card>
                        <span class="text-gray-600">{{ __('Form') }}:</span>
                        <x-filament::card.heading class="text-primary-600">{{ $response->form->name ?? '' }}</x-filament::card.heading>
                    </x-filament::card>

                    <x-filament::card>
                        @php $getStatues = config('zeus-bolt.models.FormsStatus')::where('key',$response->status)->first() @endphp
                        <span class="text-gray-600">
                            <span>{{ __('status') }}:</span>
                            <span class="{{ $getStatues->class }}" x-tooltip.raw="{{ __('status') }}">{{ $response->status }}</span>
                        </span>
                        <x-filament::card.heading class="text-primary-600">
                            @svg($getStatues->icon,'w-6 h-6 inline')
                            {{ $getStatues->label }}
                        </x-filament::card.heading>
                    </x-filament::card>
                </div>
            </div>
        </div>
    </div>
</div>
