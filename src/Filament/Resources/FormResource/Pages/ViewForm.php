<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use LaraZeus\Bolt\Concerns\EntriesAction;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;

class ViewForm extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;
    use EntriesAction;

    protected static string $resource = FormResource::class;

    /*protected function getFormSchema(): array
    {
        return FormResource::getMainFormSchemaForView();
    }*/

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->getRecord())
            ->schema([
                TextEntry::make('name'),
                TextEntry::make('slug'),

                IconEntry::make('status')
                    ->icon(fn (string $state): string => match ($state) {
                        'draft' => 'heroicon-o-pencil',
                        'reviewing' => 'heroicon-o-clock',
                        'published' => 'heroicon-o-check-circle',
                    }),

            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            EditAction::make(),

            ActionGroup::make([
                Action::make('brows')
                    ->icon('heroicon-o-eye')
                    ->label(__('Brows Entries'))
                    ->url(fn (): string => ResponseResource::getUrl('brows') . '?form_id=' . $this->record->id),
                Action::make('list')
                    ->icon('heroicon-o-bars-4')
                    ->label(__('List Entries'))
                    ->url(fn (): string => ResponseResource::getUrl() . '?form_id=' . $this->record->id),
                Action::make('report')
                    ->icon('heroicon-o-document-chart-bar')
                    ->label(__('Entries Report'))
                    ->url(fn (): string => ResponseResource::getUrl('report') . '?form_id=' . $this->record->id),
            ])
                ->button()
                ->color('info')
                ->label(__('Entries'))
                ->tooltip(__('view all entries'))
                ->icon('clarity-data-cluster-line'),

            Action::make('view')
                ->label(__('View'))
                ->icon('heroicon-o-arrow-top-right-on-square')
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
