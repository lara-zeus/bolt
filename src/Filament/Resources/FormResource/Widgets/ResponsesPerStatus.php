<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Widgets;

use Filament\Widgets\ChartWidget;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Models\Form;

class ResponsesPerStatus extends ChartWidget
{
    public Form $record;

    protected ?string $maxHeight = '300px';

    protected ?array $options = [
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
        return __('zeus-bolt::forms.widgets.responses_status');
    }

    protected function getData(): array
    {
        $dataset = [];
        $statuses = BoltPlugin::getEnum('FormsStatus');

        $form = BoltPlugin::getModel('Form')::query()
            ->with(['responses'])
            ->where('id', $this->record->id)
            ->first();

        foreach ($statuses::cases() as $status) {
            $dataset[] = $form->responses
                ->where('status', $status->name)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => __('zeus-bolt::forms.widgets.entries_per_month_desc'),
                    'data' => $dataset,
                    'backgroundColor' => $statuses::getChartColors(),
                    'borderColor' => '#ffffff',
                ],
            ],

            'labels' => collect($statuses::cases())->map(fn ($item) => $item->getLabel())->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
