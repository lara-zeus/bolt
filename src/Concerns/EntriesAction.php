<?php

namespace LaraZeus\Bolt\Concerns;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;

/**
 * @property int $form_id.
 */
trait EntriesAction
{
    public function getEntriesActions(int $formId = null): array
    {
        $formId = $formId ?? $this->form_id;

        return [
            ActionGroup::make([
                Action::make('brows')
                    ->icon('heroicon-o-eye')
                    ->visible($formId !== 0)
                    ->label(__('Brows Entries'))
                    ->url(fn (): string => ResponseResource::getUrl('brows') . '?form_id=' . $formId),
                Action::make('list')
                    ->icon('heroicon-o-bars-4')
                    ->visible($formId !== 0)
                    ->label(__('List Entries'))
                    ->url(fn (): string => ResponseResource::getUrl() . '?form_id=' . $formId),
                Action::make('report')
                    ->icon('heroicon-o-document-chart-bar')
                    ->visible($formId !== 0)
                    ->label(__('Entries Report'))
                    ->url(fn (): string => ResponseResource::getUrl('report') . '?form_id=' . $formId),
            ])
                ->button()
                ->color('info')
                ->label(__('Entries'))
                ->tooltip(__('view all entries'))
                ->icon('clarity-data-cluster-line')
                ->tooltip(__('view all entries')),
        ];
    }
}
