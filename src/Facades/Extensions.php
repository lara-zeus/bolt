<?php

namespace LaraZeus\Bolt\Facades;

use Illuminate\Support\Facades\Facade;
use LaraZeus\Bolt\Contracts\Extension;

class Extensions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bolt';
    }

    public static function init($form, $hook, $data = null, $action = 'create'): null | Extension | array | string
    {
        if ($form->extensions !== null) {
            if (class_exists($form->extensions)) {
                return (new $form->extensions())->{$hook}($form, $data, $action);
            }
        }

        return null;
    }
}
