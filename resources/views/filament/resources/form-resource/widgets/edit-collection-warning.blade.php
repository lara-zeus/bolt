<x-filament::widget>
    <x-filament::card>
        <div class="text-center font-semibold">
            any changes in the values of these items will affect the responses for the forms in
            <span class="text-primary-600">
                {{ \LaraZeus\Bolt\Models\Field::whereJsonContains('options->dataSource', "$record->id")->count() }}
            </span>
            field
        </div>
    </x-filament::card>
</x-filament::widget>
