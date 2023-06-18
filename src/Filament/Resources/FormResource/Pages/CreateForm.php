<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\Bolt\Filament\Resources\FormResource;

class CreateForm extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = FormResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
