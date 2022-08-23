<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class Checkbox extends FieldsContract
{
    public $renderClass = '\Filament\Forms\Components\Checkbox';

    public $sort = 5;

    public function title()
    {
        return __('Checkboxs');
    }

    public static function getOptions()
    {
        return [
            Toggle::make('options.is_required')->label(__('Is Required')),
        ];
    }
}
