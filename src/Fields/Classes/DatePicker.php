<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class DatePicker extends FieldsContract
{
    public string $renderClass = '\Filament\Forms\Components\DatePicker';

    public int $sort = 8;

    public function title()
    {
        return __('Date Picker');
    }

    public static function getOptions()
    {
        return [
            Toggle::make('options.is_required')->label(__('Is Required')),
        ];
    }
}
