<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class TimePicker extends FieldsContract
{
    public $renderClass = '\Filament\Forms\Components\TimePicker';

    public $sort = 8;

    public function title()
    {
        return __('Time Picker');
    }

    public static function getOptions()
    {
        return [
            Toggle::make('options.is_required')->label(__('Is Required')),
        ];
    }
}
