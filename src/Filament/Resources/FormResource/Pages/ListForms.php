<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;

class ListForms extends ListRecords
{
    protected static string $resource = FormResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            BetaNote::class,
        ];
    }

    protected function getActions(): array
    {
        return [
            CreateAction::make('create'),
            /*Action::make('create-zeus')
                ->label('create form')
                ->icon('heroicon-o-plus')
                ->tooltip('Create New Form')
                ->url(fn (): string => route('admin.form.create')),*/
        ];
    }
}
