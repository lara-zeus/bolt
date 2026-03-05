<x-filament-widgets::widget>
    <x-filament::section>
        <div class="text-center font-semibold">
            {{ __('Any changes in the values of these items will affect the responses for the forms in') }}
            <span class="text-primary-600">
                {{ \LaraZeus\Bolt\Models\Field::whereJsonContains('options->dataSource', "$record->id")->count() }}
            </span>
            {{ __('field(s)') }}
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
