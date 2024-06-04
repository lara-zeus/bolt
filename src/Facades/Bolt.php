<?php

namespace LaraZeus\Bolt\Facades;

use Filament\Forms\Components\Placeholder;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Bolt\Contracts\OptionSetContract;
use LaraZeus\Bolt\Fields\FieldsContract;

class Bolt extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bolt';
    }

    public static function availableFields(): Collection
    {
        if (app()->isLocal()) {
            Cache::forget('bolt.fields');
        }

        return Cache::remember('bolt.fields', Carbon::parse('1 month'), function () {
            $coreFields = Collectors::collectClasses(__DIR__ . '/../Fields/Classes', 'LaraZeus\\Bolt\\Fields\\Classes\\');
            $appFields = Collectors::collectClasses(base_path(config('zeus-bolt.collectors.fields.path')), config('zeus-bolt.collectors.fields.namespace'));

            $fields = collect();

            if ($coreFields->isNotEmpty()) {
                $fields = $fields->merge($coreFields);
            }

            if ($appFields->isNotEmpty()) {
                $fields = $fields->merge($appFields);
            }

            if (static::hasPro()) {
                $boltProFields = Collectors::collectClasses(
                    base_path('vendor/lara-zeus/bolt-pro/src/Fields'),
                    'LaraZeus\\BoltPro\\Fields\\'
                );

                if ($boltProFields->isNotEmpty()) {
                    $fields = $fields->merge($boltProFields);
                }
            }

            return $fields->sortBy('sort');
        });
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

    public static function renderHook(string $hook): Placeholder
    {
        $hookRendered = FilamentView::renderHook($hook);

        return Placeholder::make('placeholder-' . $hook)
            ->label('')
            ->content($hookRendered)
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

        /*if (is_int($string)) {
            return false;
        }*/

        json_decode($string);

        if (json_last_error()) {
            return false;
        }

        return true;
    }

    public static function hasPro(): bool
    {
        return class_exists(\LaraZeus\BoltPro\BoltProServiceProvider::class);
    }

    public static function getOptionSets(FieldsContract $field): Collection
    {
        return Collectors::collectClasses(
            base_path(config('zeus-bolt.collectors.optionSets.path')),
            config('zeus-bolt.collectors.optionSets.namespace')
        )
            ->filter(fn (OptionSetContract $optionSet) => $optionSet::isVisible($field))
            ->map(
                fn (OptionSetContract $optionSet) => Accordion::make($optionSet::getSlug($field))
                    ->label(__($optionSet::getLabel($field)))
                    ->columns()
                    ->icon($optionSet::getIcon($field))
                    ->schema($optionSet::getSchema($field))
            );
    }
}
