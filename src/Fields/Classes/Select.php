<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Bolt\Fields\FieldsContract;

class Select extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\Select::class;

    public int $sort = 2;

    public function title(): string
    {
        return __('Select Menu');
    }

    public static function getOptions(): array
    {
        return [
            \Filament\Forms\Components\Select::make('options.dataSource')
                ->required()
                ->options(config('zeus-bolt.models.Collection')::pluck('name', 'id'))
                ->label(__('Data Source')),
            \Filament\Forms\Components\Toggle::make('options.is_required')
                ->label(__('Is Required')),
            \Filament\Forms\Components\Toggle::make('options.allow_multiple')
                ->label(__('Allow Multiple')),
            \Filament\Forms\Components\TextInput::make('options.htmlId')
                ->default(str()->random(6))
                ->label(__('HTML ID')),
        ];
    }

    public function getResponse($field, $resp): string
    {
        return $this->getCollectionsValuesForResponse($field, $resp);
    }

    public function appendFilamentComponentsOptions($component, $zeusField)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField);

        $options = collect(optional(config('zeus-bolt.models.Collection')::find($zeusField->options['dataSource']))->values);

        $component = $component
            ->searchable()
            ->options($options->pluck('itemValue', 'itemKey'))
            ->default($options->where('itemIsDefault', true)->pluck('itemKey'));

        if (isset($zeusField->options['allow_multiple']) && $zeusField->options['allow_multiple']) {
            $component = $component->multiple();
        }

        return $component;
    }
}
