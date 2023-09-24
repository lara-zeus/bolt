<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use LaraZeus\Bolt\BoltPlugin;

class BoltResource extends Resource
{
    use Translatable;

    public static function canViewAny(): bool
    {
        return !in_array(static::class, BoltPlugin::get()->getHiddenResources())
            && parent::canViewAny();
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::query()->count();
    }

    public static function getNavigationGroup(): ?string
    {
        return BoltPlugin::get()->getNavigationGroupLabel();
    }
}
