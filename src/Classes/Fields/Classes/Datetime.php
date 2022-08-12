<?php

namespace LaraZeus\Bolt\Classes\Fields\Classes;

use LaraZeus\Bolt\Classes\Fields\FieldsContract;

class Datetime extends FieldsContract
{
    public $disabled = false;

    public function __construct()
    {
        $this->definition = [
            'type' => 'datetime',
            'title' => 'DateTime',
            'icon' => 'fa-calendar',
            'settings_view' => 'date-time',
            'order' => 6,
        ];
    }
}
