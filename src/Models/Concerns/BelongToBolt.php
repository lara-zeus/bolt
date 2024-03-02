<?php

namespace LaraZeus\Bolt\Models\Concerns;

trait BelongToBolt
{
    public static function getBoltUserFullNameAttribute(): string
    {
        return 'name';
    }
}
