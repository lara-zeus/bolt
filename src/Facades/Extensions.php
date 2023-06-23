<?php

namespace LaraZeus\Bolt\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;
use LaraZeus\Bolt\Contracts\BoltExtension;

class Extensions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bolt';
    }

    public static function init($form, $hook, $data = null, $action = 'create') : null| Extension
    {
        if ($form->extensions !== null) {
            foreach ($form->extensions as $extension) {
                if (class_exists($extension)) {
                    return (new $extension())->{$hook}($form, $data, $action);
                }
            }
        }
    }
}
