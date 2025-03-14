<?php

namespace LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages;

use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;

class CreateCollection extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = CollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
