<?php

namespace LaraZeus\Bolt\Filament\Resources\CategoryResource\Pages;

use Filament\Resources\Pages\EditRecord;
use LaraZeus\Bolt\Filament\Resources\CategoryResource;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            BetaNote::class,
        ];
    }
}
