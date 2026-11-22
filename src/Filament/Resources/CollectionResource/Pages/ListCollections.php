<?php

namespace LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;

class ListCollections extends ListRecords
{
    use Translatable;

    protected static string $resource = CollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
