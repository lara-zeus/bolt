<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use LaraZeus\Bolt\Models\FormsStatus;
use LaraZeus\Bolt\Models\Response;

class ListResponses extends ListRecords
{
    use ResponseResource\EntriesAction;

    protected static string $resource = ResponseResource::class;

    public int $form_id = 0;

    protected $queryString = [
        'form_id',
    ];

    public function mount(): void
    {
        $this->form_id = request('form_id', 0);
    }

    protected function getTableActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('set-status')
                ->label(__('Set Status'))
                ->icon('heroicon-o-tag')
                ->action(function (array $data, Response $record): void {
                    $record->status = $data['status'];
                    $record->notes = $data['notes'];
                    $record->save();
                })
                ->form([
                    Select::make('status')
                        ->label(__('status'))
                        ->default(fn (Response $record) => $record->status)
                        ->options(FormsStatus::query()->pluck('label', 'key'))
                        ->required(),
                    Textarea::make('notes')
                        ->default(fn (Response $record) => $record->notes)
                        ->label(__('Notes')),
                ]),
        ];
    }

    protected function getActions(): array
    {
        return $this->getEntriesActions();
    }
}
