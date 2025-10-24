<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\FormOverview;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\ResponsesPerFields;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\ResponsesPerMonth;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\ResponsesPerStatus;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\BoltPro\Widgets\ResponsesCharts;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\ViewRecord\Concerns\Translatable;

/**
 * @property Form $record.
 */
class ViewForm extends ViewRecord
{
    use Translatable;

    protected static string $resource = FormResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('zeus-bolt::forms.view_form');
    }

    public static function getNavigationLabel(): string
    {
        return __('zeus-bolt::forms.view_form');
    }

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            Action::make('open')
                ->label(__('zeus-bolt::forms.actions.open'))
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->tooltip(__('zeus-bolt::forms.actions.open_tooltip'))
                ->color('warning')
                ->url(fn () => route(BoltPlugin::get()->getRouteNamePrefix() . 'bolt.form.show', $this->record))
                ->visible(fn (Form $record) => $record->extensions === null)
                ->openUrlInNewTab(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        $widgets = [
            FormOverview::class,
            ResponsesPerMonth::class,
            ResponsesPerStatus::class,
            ResponsesPerFields::class,
        ];

        if (Bolt::hasPro()) {
            // @phpstan-ignore-next-line
            $widgets[] = ResponsesCharts::class;
        }

        return $widgets;
    }
}
