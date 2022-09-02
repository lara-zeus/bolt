<x-forms::field-wrapper
        :id="$getId()"
        :label="$getLabel()"
        :label-sr-only="$isLabelHidden()"
        :helper-text="$getHelperText()"
        :hint="$getHint()"
        :hint-icon="$getHintIcon()"
        :required="$isRequired()"
        :state-path="$getStatePath()"
>
    <div class="space-y-4" x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">

        <div class="flex justify-between gap-4">
            <x-filament::card class="w-full">
                <x-filament::card.heading>User Details</x-filament::card.heading>
                <p>
                    <span class="text-base font-light">{{ __('By') }}</span>:
                    @if($getRecord()->user_id === null)
                        {{ __('Visitor') }}
                    @else
                        {{ ($getRecord()->user->name) ?? '' }}
                    @endif
                </p>
                <p>
                    <span class="text-base font-light">{{ __('created at') }}</span>:
                    <span class="font-semibold">{{ $getRecord()->created_at->format('Y.m/d') }}-{{ $getRecord()->created_at->format('h:i a') }}</span>
                </p>
            </x-filament::card>
            <x-filament::card class="w-full">
                <x-filament::card.heading>Form Details</x-filament::card.heading>
                <p>{{ ($getRecord()->form->name) ?? '' }}</p>
                <p>{{ ($getRecord()->form->desc) ?? '' }}</p>
            </x-filament::card>
        </div>

        <x-filament::card>
            <x-filament::card.heading>Respons Details</x-filament::card.heading>
            @foreach($getRecord()->fieldsResponses as $resp)
                <div class="py-2">
                    <p>{{ $resp->field->name }}</p>
                    <p class="font-semibold mb-2">{{ ( new $resp->field->type )->getResponse($resp->field, $resp) }}</p>
                    <x-filament::hr/>
                </div>
            @endforeach
        </x-filament::card>
    </div>
</x-forms::field-wrapper>
