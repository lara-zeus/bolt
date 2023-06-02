<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;

class ListForms extends ListRecords
{
    use ListRecords\Concerns\Translatable;

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
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make('create'),
            Action::make('view')
                ->label(__('View'))
                ->icon('heroicon-o-external-link')
                ->tooltip(__('view all forms'))
                ->color('warning')
                ->url(fn () => route('bolt.forms.list'))
                ->openUrlInNewTab(),
        ];
    }

    protected function getTableReorderColumn(): ?string
    {
        return 'ordering';
    }
}
