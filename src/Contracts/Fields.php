<?php

namespace LaraZeus\Bolt\Contracts;

interface Fields
{
    public function title(): string;

    public static function getOptions(): array;

    public function getResponse($field, $resp): string;
}
