<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Widgets\EditCollectionWarning;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;

class BoltResource extends Resource
{
    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return config('zeus-bolt.translatable_Locales');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __(config('zeus-bolt.navigation_group_label', 'Bolt'));
    }

    public static function getWidgets(): array
    {
        return [
            BetaNote::class,
            EditCollectionWarning::class,
        ];
    }
}
