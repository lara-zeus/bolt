<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use LaraZeus\Bolt\Concerns\EntriesAction;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Models\Form;

class ViewForm extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;
    use EntriesAction;

    protected static string $resource = FormResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->getRecord())
            ->schema([
                Section::make()->schema([
                    TextEntry::make('name'),
                    TextEntry::make('slug')
                        ->url(fn (Form $record) => route('bolt.form.show', ['slug' => $record->slug]))
                        ->openUrlInNewTab(),
                    TextEntry::make('description'),
                    IconEntry::make('is_active')
                        ->icon(fn (string $state): string => match ($state) {
                            '1' => 'clarity-check-circle-line',
                            '0' => 'clarity-times-circle-solid',
                            default => 'clarity-check-circle-line',
                        })
                        ->color(fn (string $state): string => match ($state) {
                            '0' => 'warning',
                            '1' => 'success',
                            default => 'gray',
                        }),

                    TextEntry::make('start_date')->dateTime(),
                    TextEntry::make('end_date')->dateTime(),
                ])
                    ->columns(2),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            EditAction::make(),
            ...$this->getEntriesActions($this->record->id),
            Action::make('view')
                ->label(__('View'))
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->tooltip(__('view form'))
                ->color('warning')
                ->url(fn () => route('bolt.form.show', $this->record))
                ->openUrlInNewTab(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            FormResource\Widgets\FormOverview::class,
            FormResource\Widgets\ResponsesPerMonth::class,
            FormResource\Widgets\ResponsesPerStatus::class,
            FormResource\Widgets\ResponsesPerFields::class,
        ];
    }
}
