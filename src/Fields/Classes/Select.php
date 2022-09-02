<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Select as FilamentSelect;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\Bolt\Models\Collection;

class Select extends FieldsContract
{
    public $renderClass = '\Filament\Forms\Components\Select';

    public $sort = 2;

    public function title()
    {
        return __('Select Menu');
    }

    public static function getOptions()
    {
        return [
            FilamentSelect::make('options.dataSource')->required()->options(Collection::pluck('name', 'id'))->label(__('Data Source'))->columnSpan(2),
            Toggle::make('options.is_required')->label(__('Is Required')),
        ];
    }

    public function getResponse($field, $resp): string
    {
        if (!empty($resp->response)) {
            $col = Collection::find($field->options['dataSource']);

            return collect($col->values)->where('itemKey', $resp->response)->first()['itemValue'];
        }

        return '';
    }
}
