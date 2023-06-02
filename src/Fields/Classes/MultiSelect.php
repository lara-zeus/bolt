<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Select as FilamentSelect;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class MultiSelect extends FieldsContract
{
    public bool $disabled = true;

    public string $renderClass = '\Filament\Forms\Components\MultiSelect';

    public int $sort = 3;

    public function title()
    {
        return __('Multi Select Menu');
    }

    public static function getOptions()
    {
        return [
            FilamentSelect::make('options.dataSource')->required()->options(config('zeus-bolt.models.Collection')::pluck('name', 'id'))->label(__('Data Source'))->columnSpan(2),
            Toggle::make('options.is_required')->label(__('Is Required')),
        ];
    }

    public function getResponse($field, $resp): string
    {
        if (! empty($resp->response)) {
            return collect(config('zeus-bolt.models.Collection')::find($field->options['dataSource'])->values)->where('itemKey', $resp->response)->first()['itemValue'];
        }

        return '';
    }

    public function appendFilamentComponentsOptions($component, $zeusField)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField);

        return $component
            ->preload()
            ->options(collect(config('zeus-bolt.models.Collection')::find($zeusField->options['dataSource'])->values)->pluck('itemValue', 'itemKey')->toArray());
    }
}
