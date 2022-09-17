<x-filament::page>
    @forelse ($rows as $row)
        <div class="flex justify-between gap-4">
            <x-filament::card class="w-full">
                <x-filament::card.heading>User Details</x-filament::card.heading>
                <p>
                    <span class="text-base font-light">{{ __('By') }}</span>:
                    {{ ($row->user->name) ?? '' }}
                </p>
                <p>
                    <span class="text-base font-light">{{ __('created at') }}</span>:
                    <span class="font-semibold">{{ $row->created_at->format('Y.m/d') }}-{{ $row->created_at->format('h:i a') }}</span>
                </p>
            </x-filament::card>
            <x-filament::card class="w-full">
                <x-filament::card.heading>Form Details</x-filament::card.heading>
                <p>{{ ($row->form->name) ?? '' }}</p>
                <p>{{ ($row->form->desc) ?? '' }}</p>
            </x-filament::card>
        </div>
        <x-filament::card.heading>Respons Details</x-filament::card.heading>
        <div class="grid grid-cols-1 grid-cols-2 gap-4">
            @foreach($row->fieldsResponses as $resp)
                <x-filament::card>
                    <p>{{ $resp->field->name }}</p>
                    <p class="font-semibold mb-2">{!! ( new $resp->field->type )->getResponse($resp->field, $resp) !!}</p>
                </x-filament::card>
            @endforeach
        </div>
    @empty
        <div class="flex justify-center items-center space-x-2">
            <x-clarity-data-cluster-line class="h-8 w-8 text-gray-400"/>
            <span class="font-medium py-8 text-gray-400 text-xl">No responses found...</span>
        </div>
    @endforelse

    @if ($rows->hasPages())
        {{ $rows->links() }}
    @endif
</x-filament::page>
