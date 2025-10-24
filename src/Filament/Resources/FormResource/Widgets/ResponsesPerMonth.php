<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Models\Form;

class ResponsesPerMonth extends ChartWidget
{
    public Form $record;

    protected int | string | array $columnSpan = 'full';

    protected ?string $maxHeight = '300px';

    public ?string $filter = 'per_day';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'per_day' => __('zeus-bolt::forms.widgets.per_day'),
            'per_month' => __('zeus-bolt::forms.widgets.per_month'),
            'per_year' => __('zeus-bolt::forms.widgets.per_year'),
        ];
    }

    public function getHeading(): string
    {
        return __('zeus-bolt::forms.widgets.responses_count');
    }

    protected function getData(): array
    {
        $data = Trend::model(BoltPlugin::getModel('Response'))
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            );

        $data = match ($this->filter) {
            'per_day' => $data->perDay(),
            'per_month' => $data->perMonth(),
            default => $data->perYear()
        };

        $label = __('zeus-bolt::forms.widgets.' . $this->filter);

        $data = $data->count();

        return [
            'datasets' => [
                [
                    'label' => $label,
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
