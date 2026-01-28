<?php

namespace LaraZeus\Bolt\Facades;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Contracts\CustomFormSchema;
use LaraZeus\Bolt\Contracts\CustomSchema;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\BoltPro\BoltProServiceProvider;

class Bolt extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bolt';
    }

    public static function availableDataSource(): Collection
    {
        if (app()->isLocal()) {
            Cache::forget('bolt.dataSources');
        }

        return Cache::remember('bolt.dataSources', Carbon::parse('1 month'), function () {
            return Collectors::collectClasses(
                base_path(config('zeus-bolt.collectors.dataSources.path')),
                config('zeus-bolt.collectors.dataSources.namespace')
            )
                ->sortBy('sort');
        });
    }

    public static function renderHook(string $hook): TextEntry
    {
        $hookRendered = FilamentView::renderHook($hook);

        return TextEntry::make('placeholder-' . $hook)
            ->label('')
            ->state($hookRendered)
            ->visible(filled($hookRendered->toHtml()));
    }

    public static function renderHookBlade(string $hook): ?Htmlable
    {
        $hookRendered = FilamentView::renderHook($hook);

        if (filled($hookRendered->toHtml())) {
            return $hookRendered;
        }

        return null;
    }

    public static function isJson(string $string): bool
    {
        if ($string === '') {
            return false;
        }

        json_decode($string, true);

        if (json_last_error()) {
            return false;
        }

        return true;
    }

    public static function hasPro(): bool
    {
        return class_exists(BoltProServiceProvider::class);
    }

    public static function getCustomSchema(string $hook, ?FieldsContract $field = null): Tab | Accordion | null
    {
        $class = BoltPlugin::getSchema($hook);
        if ($class !== null) {
            $getClass = new $class;
            if ($hook === 'form' && $getClass instanceof CustomFormSchema) {
                return $getClass->make();
            }

            if ($getClass instanceof CustomSchema) {
                return $getClass->make($field);
            }
        }

        return null;
    }

    public static function getHiddenCustomSchema(string $hook, ?FieldsContract $field = null): ?array
    {
        $class = BoltPlugin::getSchema($hook);
        if ($class !== null) {
            $getClass = new $class;
            if ($getClass instanceof CustomSchema) {
                return $getClass->hidden($field);
            }
        }

        return null;
    }
}
