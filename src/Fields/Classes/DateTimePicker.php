<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class DateTimePicker extends FieldsContract
{
    public $disabled = false;

    public function __construct()
    {
        $this->definition = [
            'type' => '\Filament\Forms\Components\DateTimePicker',
            'title' => __('Date Time Picker'),
            'order' => 7,
        ];
    }

    public static function getOptions()
    {
        return [
            Toggle::make('options.is_required')->label(__('Is Required')),
        ];
    }
}
