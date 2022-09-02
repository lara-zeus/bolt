<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\Bolt\Models\Collection;

class CheckboxList extends FieldsContract
{
    public $renderClass = '\Filament\Forms\Components\CheckboxList';

    public $sort = 6;

    public function title()
    {
        return __('Checkbox List');
    }

    public static function getOptions()
    {
        return [
            Select::make('options.dataSource')->required()->options(Collection::pluck('name', 'id'))->label(__('Data Source'))->columnSpan(2),
            Toggle::make('options.is_required')->label(__('Is Required')),
            \Filament\Forms\Components\TextInput::make('options.columns')->numeric()->required()->default(1),
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
