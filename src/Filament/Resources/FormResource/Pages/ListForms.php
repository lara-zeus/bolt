<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\CreateAction;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use Filament\Resources\Pages\ListRecords;

class ListForms extends ListRecords
{
    protected static string $resource = FormResource::class;

    protected function getActions(): array
    {
        return [
            /*Action::make('create')
                ->label('create')
                ->icon('heroicon-o-plus')
                ->tooltip('Create New Form')
                ->url(fn() : string => url('admin/forms/create')),*/
            Action::make('create-zeus')
                ->label('create form')
                ->icon('heroicon-o-plus')
                ->tooltip('Create New Form')
                ->url(fn() : string => route('admin.zeus.form.create')),
        ];
    }

}
