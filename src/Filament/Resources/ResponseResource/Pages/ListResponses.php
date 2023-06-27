<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ViewAction;
use LaraZeus\Bolt\Filament\Actions\SetResponseStatus;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;

class ListResponses extends ListRecords
{
    use \LaraZeus\Bolt\Concerns\EntriesAction;

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
            SetResponseStatus::make(),
        ];
    }

    protected function getActions(): array
    {
        return $this->getEntriesActions();
    }
}
