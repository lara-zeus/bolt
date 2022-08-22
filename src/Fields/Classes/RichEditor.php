<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class RichEditor extends FieldsContract
{
    public $disabled = false;

    public function __construct()
    {
        $this->definition = [
            'type' => '\Filament\Forms\Components\RichEditor',
            'title' => __('Rich Editor'),
            'order' => 10,
        ];
    }

    public static function getOptions()
    {
        return [
            Toggle::make('options.is_required')->label(__('Is Required')),
        ];
    }
}
