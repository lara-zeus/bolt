<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Widgets;

use Filament\Widgets\PieChartWidget;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\Bolt\Models\FieldResponse;

class ResponsesPerFields extends PieChartWidget
{
    public ?Model $record = null;

    protected int|string|array $columnSpan = [
        'sm' => 1,
    ];

    protected static ?string $maxHeight = '300px';

    protected function getHeading(): string
    {
        return __('Responses Status');
    }

    protected function getData(): array
    {
        if ($this->record === null) {
            return [];
        }

        $fields = $this->record->fields;
        foreach ($fields as $field) {
            $dataset[] = FieldResponse::query()
                ->where('form_id', $this->record->id)
                ->where('field_id', $field->id)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => __('entries per month'),
                    'data' => $dataset,
                ],
            ],

            'labels' => $fields->pluck('name'),
        ];
    }
}
