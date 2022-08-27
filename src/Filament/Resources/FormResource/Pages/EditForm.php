<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions\Action;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;
use LaraZeus\Bolt\Models\Form as ZeusForm;

class EditForm extends EditRecord
{
    protected static string $resource = FormResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('entries')
                ->label(__('Entries'))
                ->icon('clarity-data-cluster-line')
                ->tooltip(__('view all entries'))
                ->url(fn() => url('admin/responses?form_id=' . $this->record->id)),

            Action::make('open')
                ->label(__('Open'))
                ->icon('heroicon-o-external-link')
                ->tooltip(__('open form'))
                ->color('warning')
                ->url(fn() => route('bolt.user.form.show', $this->record))
                ->openUrlInNewTab(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BetaNote::class,
        ];
    }
}
