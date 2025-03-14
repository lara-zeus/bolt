<?php

namespace LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages;

use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Widgets\EditCollectionWarning;

class EditCollection extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = CollectionResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            EditCollectionWarning::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
