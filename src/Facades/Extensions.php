<?php

namespace LaraZeus\Bolt\Facades;

use LaraZeus\Bolt\Contracts\Extension;
use LaraZeus\Bolt\Models\Form;

class Extensions
{
    public static function init(Form $form, string $hook, ?array $data = null, string $action = 'create'): null | Extension | array | string
    {
        if ($form->extensions !== null) {
            if (class_exists($form->extensions)) {
                return (new $form->extensions)->{$hook}($form, $data, $action);
            }
        }

        return null;
    }
}
