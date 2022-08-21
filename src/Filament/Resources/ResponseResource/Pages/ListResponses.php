<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Resources\Pages\ListRecords;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;

class ListResponses extends ListRecords
{
    protected static string $resource = ResponseResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            BetaNote::class,
        ];
    }
}
