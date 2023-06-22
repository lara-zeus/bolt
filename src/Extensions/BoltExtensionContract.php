<?php

namespace LaraZeus\Bolt\Extensions;

use LaraZeus\Bolt\Contracts\BoltExtension;

abstract class BoltExtensionContract implements BoltExtension
{
    public function preShow($form, $data, $action = 'create')
    {
        return true;
    }

    public function show($form, $data, string $action = 'create'): string
    {
        return '';
    }

    public function preStore($form, $data, string $action = 'create'): bool
    {
        return true;
    }

    public function postStore($form, $data, string $action = 'create'): void
    {
    }
}
