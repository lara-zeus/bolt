<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Bolt\Fields\FieldsContract;

class TextInput extends FieldsContract
{
    public $disabled = false;

    public function __construct()
    {
        $this->definition = [
            'type' => 'TextInput',
            'title' => 'Text Input',
            'icon' => 'fa-text-width',
            'order' => 1,
        ];
    }
}
