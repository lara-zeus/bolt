<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use Filament\Pages\Actions\Action;
use LaraZeus\Bolt\Models\FormsStatus;

class ViewResponse extends ViewRecord
{
    protected static string $resource = ResponseResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('set-status')
                ->label(__('Set Status'))
                ->action(function (array $data): void {
                    $this->record->status = $data['status'];
                    $this->record->save();
                })
                ->form([
                    Select::make('status')
                        ->label(__('status'))
                        ->options(FormsStatus::query()->pluck('label', 'key'))
                        ->required(),
                ]),
        ];
    }
}
