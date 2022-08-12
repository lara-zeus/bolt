<?php

namespace LaraZeus\Bolt\Classes\Fields\Classes;

use LaraZeus\Bolt\Classes\Fields\FieldsContract;

class Text extends FieldsContract
{
    public $disabled = false;

    public function __construct()
    {
        $this->definition = [
            'type' => 'text',
            'title' => 'Text',
            'icon' => 'fa-text-width',
            'order' => 1,
        ];
    }
}
