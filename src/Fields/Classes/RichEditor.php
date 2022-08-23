<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class RichEditor extends FieldsContract
{
    public $renderClass = '\Filament\Forms\Components\RichEditor';
    public $sort = 10;

    public function title()
    {
        return __('Rich Editor');
    }

    public static function getOptions()
    {
        return [
            Toggle::make('options.is_required')->label(__('Is Required')),
        ];
    }
}
