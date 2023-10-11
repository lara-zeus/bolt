<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ViewRecord;
use LaraZeus\Bolt\Concerns\EntriesAction;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Models\Form;

/**
 * @property Form $record.
 */
class ViewForm extends ViewRecord
{
    use EntriesAction;
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            EditAction::make(),
            ...$this->getEntriesActions($this->record->id),
            Action::make('open')
                ->label(__('Open'))
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->tooltip(__('open form'))
                ->color('warning')
                ->url(fn () => route('bolt.form.show', $this->record))
                ->openUrlInNewTab(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        $widgets = [
            FormResource\Widgets\FormOverview::class,
            FormResource\Widgets\ResponsesPerMonth::class,
            FormResource\Widgets\ResponsesPerStatus::class,
            FormResource\Widgets\ResponsesPerFields::class,
        ];

        if (class_exists(\LaraZeus\BoltPro\BoltProServiceProvider::class)) {
            //@phpstan-ignore-next-line
            $widgets[] = \LaraZeus\BoltPro\Widgets\ResponsesPerCollection::class;
        }

        return $widgets;
    }
}
