<?php

namespace LaraZeus\Bolt\Filament\Resources\CategoryResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use LaraZeus\Bolt\Filament\Resources\CategoryResource;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            BetaNote::class,
        ];
    }
}
