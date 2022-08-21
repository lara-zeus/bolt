<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;

class CreateForm extends CreateRecord
{
    protected static string $resource = FormResource::class;

    public function mount(): void
    {
        parent::mount();

        // todo @by atm: this is ugly, redo
        $unsetFieldsData = [
            'start_date' => null,
            'end_date' => null,
            'details' => null,
            'is_active' => false,
            'options' => [
                'requireLogin' => false,
                'oneEntryPerUser' => false,
                'sectionsToPages' => false,
            ],
        ];

        $this->form->fill(array_merge($this->form->getLivewire()->data, $unsetFieldsData));
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BetaNote::class,
        ];
    }
}
