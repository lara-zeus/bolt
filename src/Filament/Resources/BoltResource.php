<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Widgets\EditCollectionWarning;

class BoltResource extends Resource
{
    use Translatable;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::query()->count();
    }

    public static function getNavigationGroup(): ?string
    {
        return BoltPlugin::get()->getNavigationGroupLabel();
    }

    public static function getWidgets(): array
    {
        return [
            EditCollectionWarning::class,
        ];
    }
}
