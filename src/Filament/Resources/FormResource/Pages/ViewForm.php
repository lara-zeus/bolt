<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\EditAction;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ViewRecord;
use LaraZeus\Bolt\Filament\Resources\FormResource;

class ViewForm extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = FormResource::class;

    protected function getFormSchema(): array
    {
        return FormResource::getMainFormSchemaForView();
    }

    protected function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
            EditAction::make(),
            Action::make('entries')
                ->label(__('Entries'))
                ->icon('clarity-data-cluster-line')
                ->tooltip(__('view all entries'))
                ->color('secondary')
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

    protected function getHeaderWidgets(): array
    {
        return [
            FormResource\Widgets\FormOverview::class,
            FormResource\Widgets\ResponsesPerMonth::class,
            FormResource\Widgets\ResponsesPerStatus::class,
            FormResource\Widgets\ResponsesPerFields::class,
        ];
    }
}
