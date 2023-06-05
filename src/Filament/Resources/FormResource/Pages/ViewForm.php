<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use LaraZeus\Bolt\Filament\Resources\FormResource;

class ViewForm extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = FormResource::class;

    protected function getFormSchema(): array
    {
        return FormResource::getMainFormSchemaForView();
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
