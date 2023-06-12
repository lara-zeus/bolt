<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Pages\Actions\Action;
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

    protected function getActions(): array
    {
        return [
            Action::make('brows')
                ->size('sm')
                ->visible(request()->filled('form_id'))
                ->label(__('Brows Entries'))
                ->url(fn (): string => 'responses/brows?form_id=' . request('form_id')),
            Action::make('report')
                ->size('sm')
                ->visible(request()->filled('form_id'))
                ->label(__('Entries Report'))
                ->url(fn (): string => 'responses/report?form_id=' . request('form_id')),
        ];
    }
}
