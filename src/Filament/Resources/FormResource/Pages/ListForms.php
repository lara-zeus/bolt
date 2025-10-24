<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\BoltPro\Actions\PresetAction;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;

class ListForms extends ListRecords
{
    use Translatable;

    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [
            LocaleSwitcher::make(),
            CreateAction::make('create'),
            Action::make('open')
                ->label(__('zeus-bolt::forms.actions.open'))
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->tooltip(__('zeus-bolt::forms.actions.open_tooltip_all'))
                ->color('warning')
                ->url(fn () => route(BoltPlugin::get()->getRouteNamePrefix() . 'bolt.forms.list'))
                ->openUrlInNewTab(),
        ];

        if (Bolt::hasPro()) {
            // @phpstan-ignore-next-line
            $actions[] = PresetAction::make('new from preset')
                ->visible(config('zeus-bolt.show_presets'));
        }

        return $actions;
    }
}
