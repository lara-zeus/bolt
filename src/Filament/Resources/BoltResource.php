<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Resources\Resource;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;

class BoltResource extends Resource
{
    use Translatable;

    public static function canViewAny(): bool
    {
        return ! in_array(static::class, BoltPlugin::get()->getHiddenResources(), true)
            && parent::canViewAny();
    }

    public static function getNavigationGroup(): ?string
    {
        return BoltPlugin::get()->getNavigationGroupLabel();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return BoltPlugin::get()->getGlobalAttributes(static::class);
    }
}
