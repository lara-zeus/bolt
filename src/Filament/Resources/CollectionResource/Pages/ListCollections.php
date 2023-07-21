<?php

namespace LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;

class ListCollections extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = CollectionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
