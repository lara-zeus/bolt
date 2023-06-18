<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\Bolt\Filament\Resources\FormResource;

class EditForm extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = FormResource::class;

    protected function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
            Action::make('entries')
                ->label(__('Entries'))
                ->icon('clarity-data-cluster-line')
                ->tooltip(__('view all entries'))
                ->url(fn () => url('admin/responses?form_id=' . $this->record->id)),

            Action::make('view')
                ->label(__('View'))
                ->icon('heroicon-o-external-link')
                ->tooltip(__('view form'))
                ->color('warning')
                ->url(fn () => route('bolt.form.show', $this->record))
                ->openUrlInNewTab(),
        ];
    }
}
