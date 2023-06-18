<?php

namespace LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages;

use Filament\Resources\Pages\EditRecord;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Widgets\EditCollectionWarning;

class EditCollection extends EditRecord
{
    protected static string $resource = CollectionResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            EditCollectionWarning::class,
        ];
    }
}
