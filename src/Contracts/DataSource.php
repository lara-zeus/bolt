<?php

namespace LaraZeus\Bolt\Contracts;

interface DataSource
{
    public function title(): string;

    public static function getValuesUsing(): string;

    public static function getKeysUsing(): string;

    public function getModel(): string;
}
