<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Select;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\Bolt\Models\Collection;

class Toggle extends FieldsContract
{
    public $renderClass = '\Filament\Forms\Components\Toggle';

    public $sort = 5;

    public function title()
    {
        return __('Toggle');
    }

    public static function getOptions()
    {
        return [
            \Filament\Forms\Components\Toggle::make('options.is_required')->label(__('Is Required')),
        ];
    }
}
