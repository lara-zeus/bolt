<x-filament::widget>
    <x-filament::card>
        <div class="text-center font-semibold">
            {{ __('any changes in the values of these items will affect the responses for the forms in') }}
            <span class="text-primary-600">
                {{ \LaraZeus\Bolt\Models\Field::whereJsonContains('options->dataSource', "$record->id")->count() }}
            </span>
            {{ __('field') }}
        </div>
    </x-filament::card>
</x-filament::widget>
