<?php

namespace LaraZeus\Bolt\Filament\Resources\CategoryResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\Bolt\Filament\Resources\CategoryResource;

class EditCategory extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
