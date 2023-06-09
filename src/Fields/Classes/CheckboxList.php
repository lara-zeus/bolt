<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class CheckboxList extends FieldsContract
{
    public string $renderClass = '\Filament\Forms\Components\CheckboxList';

    public int $sort = 6;

    public function title(): string
    {
        return __('Checkbox List');
    }

    public static function getOptions(): array
    {
        return [
            Select::make('options.dataSource')->required()->options(config('zeus-bolt.models.Collection')::pluck('name', 'id'))->label(__('Data Source'))->columnSpan(2),
            Toggle::make('options.is_required')->label(__('Is Required')),
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

        return $component
            ->options($options->pluck('itemValue', 'itemKey'))
            ->default($options->where('itemIsDefault', true)->pluck('itemKey'));
    }
}
