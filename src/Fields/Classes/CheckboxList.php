<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class CheckboxList extends FieldsContract
{
    public string $renderClass = '\Filament\Forms\Components\CheckboxList';

    public int $sort = 6;

    public function title()
    {
        return __('Checkbox List');
    }

    public static function getOptions()
    {
        return [
            Select::make('options.dataSource')->required()->options(config('zeus-bolt.models.Collection')::pluck('name', 'id'))->label(__('Data Source'))->columnSpan(2),
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

        return $component->options(collect(config('zeus-bolt.models.Collection')::find($zeusField->options['dataSource'])->values)->pluck('itemValue', 'itemKey'));
    }
}
