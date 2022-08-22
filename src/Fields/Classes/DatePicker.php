<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class DatePicker extends FieldsContract
{
    public $disabled = false;

    public function __construct()
    {
        $this->definition = [
            'type' => '\Filament\Forms\Components\DatePicker',
            'title' => __('Date Picker'),
            'order' => 8,
        ];
    }

    public static function getOptions()
    {
        return [
            Toggle::make('options.is_required')->label(__('Is Required')),
        ];
    }
}
