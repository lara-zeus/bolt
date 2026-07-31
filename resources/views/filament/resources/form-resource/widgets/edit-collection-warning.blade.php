<x-filament-widgets::widget>
    <x-filament::section>
        <div class="text-center font-semibold">
            {{ __('zeus-bolt::messages.collection_warning_1') }}
            <span class="text-primary-600">
                {{ \LaraZeus\Bolt\Models\Field::whereJsonContains('options->dataSource', "$record->id")->count() }}
            </span>
            {{ __('zeus-bolt::messages.collection_warning_2') }}
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
