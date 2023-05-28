<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Select as FilamentSelect;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class Select extends FieldsContract
{
    public string $renderClass = '\Filament\Forms\Components\Select';

    public int $sort = 2;

    public function title()
    {
        return __('Select Menu');
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
        if (empty($resp->response)) {
            return '';
        }

        $collection = config('zeus-bolt.models.Collection')::find($field->options['dataSource']);
        if ($collection === null) {
            return $resp->response;
        }

        $getResponFromCollection = collect($collection->values)->where('itemKey', $resp->response)->first();

        if ($getResponFromCollection === null) {
            return $resp->response;
        }

        if (! isset($getResponFromCollection['itemValue'])) {
            return $resp->response;
        }

        return $getResponFromCollection['itemValue'];
    }

    public function appendFilamentComponentsOptions($component, $zeusField)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField);

        return $component->options(collect(config('zeus-bolt.models.Collection')::find($zeusField->options['dataSource'])->values)->pluck('itemValue', 'itemKey'));
    }
}
