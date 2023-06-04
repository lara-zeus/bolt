<?php

namespace LaraZeus\Bolt\Fields;

interface Fields
{
    public function title() :string;

    public static function getOptions(): array;

    public function getResponse($field, $resp): string;
}
