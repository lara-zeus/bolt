<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use LaraZeus\Bolt\Models\Form;

class FormOverview extends BaseWidget
{
    public Form $record;

    protected function getCards(): array
    {
        return [
            Card::make('fields', $this->record->fields()->count())->label(__('Fields')),
            Card::make('responses', $this->record->responses()->count())->label(__('Responses')),
            Card::make('fields_responses', $this->record->fieldsResponses()->count())->label(__('Fields Responses')),
        ];
    }
}
