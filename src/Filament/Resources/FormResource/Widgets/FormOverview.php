<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use LaraZeus\Bolt\Models\Form;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FormOverview extends BaseWidget
{
    public Form $record;

    protected function getCards(): array
    {
        return [
            Stat::make('fields', $this->record->fields()->count())->label(__('Fields')),
            Stat::make('responses', $this->record->responses()->count())->label(__('Responses')),
            Stat::make('fields_responses', $this->record->fieldsResponses()->count())->label(__('Fields Responses')),
        ];
    }
}
