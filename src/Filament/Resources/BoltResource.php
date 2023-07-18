<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Widgets\EditCollectionWarning;

class BoltResource extends Resource
{
    use Translatable;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::query()->count();
    }

    public static function getTranslatableLocales(): array
    {
        return config('zeus-bolt.translatable_Locales');
    }

    public static function getNavigationGroup(): ?string
    {
        return __(config('zeus-bolt.navigation_group_label', 'Bolt'));
    }

    public static function getWidgets(): array
    {
        return [
            EditCollectionWarning::class,
        ];
    }
}
