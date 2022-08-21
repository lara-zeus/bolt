<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Resources\Pages\EditRecord;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;

class EditForm extends EditRecord
{
    protected static string $resource = FormResource::class;

    /*protected function beforeSave(): void
    {
        dd($this->data);
    }*/

    protected function getHeaderWidgets() : array
    {
        return [
            BetaNote::class,
        ];
    }
}
