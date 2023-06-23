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

    public static function init($form, $hook, $data = null, $action = 'create'): null|Extension|array
    {
        if ($form->extensions !== null) {
            foreach ($form->extensions as $extension) {
                if (class_exists($extension)) {
                    return (new $extension())->{$hook}($form, $data, $action);
                }
            }
        }

        return null;
    }
}
