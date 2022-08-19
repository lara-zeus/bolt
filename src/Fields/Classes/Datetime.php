<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Bolt\Fields\FieldsContract;

class Datetime extends FieldsContract
{
    public $disabled = false;

    public function __construct()
    {
        $this->definition = [
            'type' => 'DateTimePicker',
            'title' => 'DateTime',
            'icon' => 'fa-calendar',
            'settings_view' => 'date-time',
            'order' => 6,
        ];
    }
}
