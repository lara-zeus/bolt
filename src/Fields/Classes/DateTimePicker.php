<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class DateTimePicker extends FieldsContract
{
    public $disabled = false;

    public function __construct()
    {
        $this->definition = [
            'type' => 'DateTimePicker',
            'title' => 'Date Time',
            'icon' => 'fa-calendar',
            'settings_view' => 'date-time',
            'order' => 6,
        ];
    }

    public static function getOptions()
    {
        return [
            Select::make('options.dateType')->required()->options([
                'date'=>'date',
                'datetime'=>'datetime',
                'time'=>'time',
            ]),
            Toggle::make('options.is_required')->label(__('Is Required')),
            Toggle::make('options.is_searchable')->label(__('Is Searchable')),

        ];
    }
}
