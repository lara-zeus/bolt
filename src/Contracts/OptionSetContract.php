<?php

namespace LaraZeus\Bolt\Contracts;

use LaraZeus\Bolt\Fields\FieldsContract;

/**
 * Contract necessary for all arbitrary OptionSets.
 */
interface OptionSetContract
{
    public static function getLabel(?FieldsContract $field = null): string;

    public static function getSlug(?FieldsContract $field = null): string;

    public static function getIcon(?FieldsContract $field = null): string;

    public static function getSchema(?FieldsContract $field = null): array;

    public static function isVisible(?FieldsContract $field = null): bool;
}
