<?php

namespace LaraZeus\Bolt\Concerns;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
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
                    ->url(fn(): string => ResponseResource::getUrl('brows').'?form_id='.request('form_id')),
                Action::make('list')
                    ->icon('heroicon-o-bars-4')
                    ->visible($this->form_id !== 0)
                    ->label(__('List Entries'))
                    ->url(fn(): string => ResponseResource::getUrl().'?form_id='.$this->form_id),
                Action::make('report')
                    ->icon('heroicon-o-document-chart-bar')
                    ->visible($this->form_id !== 0)
                    ->label(__('Entries Report'))
                    ->url(fn(): string => ResponseResource::getUrl('report').'?form_id='.$this->form_id),
            ])
                ->tooltip(__('View Mode'))
                ->icon('heroicon-o-cog'),
        ];
    }
}
