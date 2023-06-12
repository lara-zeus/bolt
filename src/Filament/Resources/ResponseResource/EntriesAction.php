<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource;

use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\ActionGroup;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;

trait EntriesAction
{
    public function getEntriesActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('brows')
                    ->icon('heroicon-o-eye')
                    ->visible($this->form_id !== 0)
                    ->label(__('Brows Entries'))
                    ->url(fn(): string => ResponseResource::getUrl('brows') . '?form_id=' . request('form_id')),
                Action::make('list')
                    ->icon('heroicon-o-view-list')
                    ->visible($this->form_id !== 0)
                    ->label(__('List Entries'))
                    ->url(fn(): string => ResponseResource::getUrl() . '?form_id=' . $this->form_id),
                Action::make('report')
                    ->icon('heroicon-o-document-report')
                    ->visible($this->form_id !== 0)
                    ->label(__('Entries Report'))
                    ->url(fn(): string => ResponseResource::getUrl('report') . '?form_id=' . $this->form_id),
            ]),
        ];
    }
}