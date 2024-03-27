<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Filament\Resources\FormResource;

class CreateForm extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = FormResource::class;

    public function areFormActionsSticky(): bool
    {
        return BoltPlugin::get()->isFormActionsAreSticky();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
