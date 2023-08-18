<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Widgets;

use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;
use Filament\Widgets\PieChartWidget;
use LaraZeus\Bolt\Models\FormsStatus;

class ResponsesPerStatus extends PieChartWidget
{
    public Form $record;

    protected int | string | array $columnSpan = [
        'sm' => 1,
    ];

    protected static ?string $maxHeight = '300px';

    public function getHeading(): string
    {
        return __('Responses Status');
    }

    protected function getData(): array
    {
        $dataset = [];
        $statuses = BoltPlugin::getModel('FormsStatus')::get();
        foreach ($statuses as $status) {
            $dataset[] = Response::query()
                ->where('form_id', $this->record->id)
                ->where('status', $status->key)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => __('entries per month'),
                    'data' => $dataset,
                    'backgroundColor' => $statuses->pluck('chartColor'),
                    'borderColor' => '#ffffff',
                ],
            ],

            'labels' => $statuses->pluck('label'),
        ];
    }
}
