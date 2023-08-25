<?php

namespace LaraZeus\Bolt\Contracts;

use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\FieldResponse;

interface Fields
{
    public function title(): string;

    public static function getOptions(): array;

    public function getResponse(Field $field, FieldResponse $resp): string;
}
