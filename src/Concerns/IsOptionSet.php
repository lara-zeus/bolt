<?php

namespace LaraZeus\Bolt\Concerns;

use Illuminate\Support\Str;
use LaraZeus\Bolt\Fields\FieldsContract;

/**
 * Trait IsOptionSet
 *
 * Contains sane defaults where possible for OptionSetContract.
 */
trait IsOptionSet
{
    abstract public static function getLabel(?FieldsContract $field = null): string;

    abstract public static function getSchema(?FieldsContract $field = null): array;

    public static function getSlug(?FieldsContract $field = null): string
    {
        return Str::slug(static::getLabel($field));
    }

    public static function getIcon(?FieldsContract $field = null): string
    {
        return 'iconpark-cylinder-o';
    }

    public static function isVisible(?FieldsContract $field = null): bool
    {
        return true;
    }
}
