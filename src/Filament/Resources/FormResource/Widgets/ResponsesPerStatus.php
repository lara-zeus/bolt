<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Widgets;

use Filament\Widgets\ChartWidget;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Models\Form;

class ResponsesPerStatus extends ChartWidget
{
    public Form $record;

    protected static ?string $maxHeight = '300px';

    protected static ?array $options = [
        'scales' => [
            'y' => [
                'grid' => [
                    'display' => false,
                ],
                'ticks' => [
                    'display' => false,
                ],
            ],
            'x' => [
                'grid' => [
                    'display' => false,
                ],
                'ticks' => [
                    'display' => false,
                ],
            ],
        ],
    ];

    protected int | string | array $columnSpan = [
        'lg' => 1,
        'md' => 2,
    ];

    public function getHeading(): string
    {
        return __('Responses Status');
    }

    protected function getData(): array
    {
        $dataset = [];
        $statuses = BoltPlugin::getModel('FormsStatus')::get();

        $form = BoltPlugin::getModel('Form')::query()
            ->with(['responses'])
            ->where('id', $this->record->id)
            ->first();

        foreach ($statuses as $status) {
            $dataset[] = $form->responses
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

    protected function getType(): string
    {
        return 'pie';
    }
}
