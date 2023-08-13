<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use LaraZeus\Bolt\Models\Form;

class FormOverview extends BaseWidget
{
    public Form $record;

    protected function getStats(): array
    {
        return [
            Stat::make('fields', $this->record->fields()->count())->label(__('Fields')),
            Stat::make('responses', $this->record->responses()->count())->label(__('Responses')),
            Stat::make('fields_responses', $this->record->fieldsResponses()->count())->label(__('Fields Responses')),
        ];
    }
}
