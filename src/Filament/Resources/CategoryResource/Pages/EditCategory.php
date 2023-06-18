<?php

namespace LaraZeus\Bolt\Filament\Resources\CategoryResource\Pages;

use Filament\Resources\Pages\EditRecord;
use LaraZeus\Bolt\Filament\Resources\CategoryResource;

class EditCategory extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = CategoryResource::class;
}
