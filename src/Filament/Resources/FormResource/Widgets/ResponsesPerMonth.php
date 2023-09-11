<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Widgets;

use Flowframe\Trend\Trend;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Models\Form;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class ResponsesPerMonth extends ChartWidget
{
    public Form $record;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '300px';

    public ?string $filter = 'per_day';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'per_day' => 'Per Day',
            'per_month' => 'Per month',
            'per_year' => 'Per year',
        ];
    }

    public function getHeading(): string
    {
        return __('Responses Count');
    }

    protected function getData(): array
    {
        $label = null;
        $data = [];

        if ($this->filter == 'per_day') {
            $label = __("Per day");
            $data = Trend::model(BoltPlugin::getModel('Response'))
                ->between(
                    start: now()->startOfYear(),
                    end: now()->endOfYear(),
                )
                ->perDay()
                ->count();
        } elseif ($this->filter == 'per_month') {
            $label = __("Per month");
            $data = Trend::model(BoltPlugin::getModel('Response'))
                ->between(
                    start: now()->startOfYear(),
                    end: now()->endOfYear(),
                )
                ->perMonth()
                ->count();
        } elseif ($this->filter == 'per_year') {
            $label = __("Per year");
            $data = Trend::model(BoltPlugin::getModel('Response'))
                ->between(
                    start: now()->startOfYear(),
                    end: now()->endOfYear(),
                )
                ->perYear()
                ->count();
        }


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
