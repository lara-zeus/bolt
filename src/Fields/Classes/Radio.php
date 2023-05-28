<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class Radio extends FieldsContract
{
    public string $renderClass = '\Filament\Forms\Components\Radio';

    public int $sort = 4;

    public function title()
    {
        return __('Radio');
    }

    public static function getOptions()
    {
        return [
            Select::make('options.dataSource')->required()->options(config('zeus-bolt.models.Collection')::pluck('name', 'id'))->label(__('Data Source'))->columnSpan(2),
            Toggle::make('options.is_required')->label(__('Is Required')),
            Toggle::make('options.is_inline')->label(__('Is inline')),
        ];
    }

    public function getResponse($field, $resp): string
    {
        if (! empty($resp->response)) {
            $col = config('zeus-bolt.models.Collection')::find($field->options['dataSource']);

            return collect($col->values)->where('itemKey', $resp->response)->first()['itemValue'];
        }

        return '';
    }

    public function appendFilamentComponentsOptions($component, $zeusField)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField);

        $component = $component->options(collect(config('zeus-bolt.models.Collection')::find($zeusField->options['dataSource'])->values)->pluck('itemValue', 'itemKey'));
        if (isset($zeusField->options['is_inline']) && $zeusField->options['is_inline']) {
            $component->inline();
        }

        return $component;
    }
}
