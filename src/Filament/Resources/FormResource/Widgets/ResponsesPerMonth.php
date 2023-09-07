<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Widgets;

use Filament\Widgets\ChartWidget;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;

class ResponsesPerMonth extends ChartWidget
{
    public Form $record;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '300px';

    protected function getType(): string
    {
        return 'line';
    }

    public function getHeading(): string
    {
        return __('Responses Count');
    }

    protected function getData(): array
    {
        $dataset = [];

        for ($m = 1; $m <= 12; $m++) {
            $month = date('m', mktime(0, 0, 0, $m, 1, (int) now()->format('Y')));
            $dataset[] = BoltPlugin::getModel('Response')::query()
                ->where('form_id', $this->record->id)
                ->whereYear('created_at', '=', now()->format('Y'))
                ->whereMonth('created_at', '=', $month)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => __('entries per month'),
                    'data' => $dataset,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
