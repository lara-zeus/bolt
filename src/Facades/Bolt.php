<?php

namespace LaraZeus\Bolt\Facades;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Wizard;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;
use LaraZeus\Bolt\Models\Form;

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
            $appFields = Collectors::collectClasses(app_path('Zeus/Fields'), 'App\\Zeus\\Fields\\');

            if (class_exists(\LaraZeus\BoltPro\BoltProServiceProvider::class)) {
                $boltProFields = Collectors::collectClasses(base_path('vendor/lara-zeus/bolt-pro/src/Fields'), 'LaraZeus\\BoltPro\\Fields\\');
            }

            $fields = collect();

            if ($coreFields->isNotEmpty()) {
                $fields = $fields->merge($coreFields);
            }

            if ($appFields->isNotEmpty()) {
                $fields = $fields->merge($appFields);
            }

            if (class_exists(\LaraZeus\BoltPro\BoltProServiceProvider::class) && $boltProFields->isNotEmpty()) {
                $fields = $fields->merge($boltProFields);
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
                app_path('Zeus/DataSources'),
                'App\\Zeus\\DataSources\\'
            )
                ->sortBy('sort');
        });
    }

    public static function prepareFieldsAndSectionToRender(Form $zeusForm, bool $inline = false): array
    {
        $sections = [];
        $zeusSections = $zeusForm->sections->sortBy('ordering');

        $getExtComponent = Extensions::init($zeusForm, 'formComponents');
        if ($getExtComponent !== null) {
            $sections[] = Section::make('extensions')
                ->heading(function () use ($zeusForm) {
                    $class = $zeusForm->extensions;
                    if (class_exists($class)) {
                        return (new $class)->label();
                    }

                    return __('Extension');
                })
                ->schema($getExtComponent);
        }

        foreach ($zeusSections as $section) {
            $fields = [];

            if (! $inline) {
                $fields[] = static::renderHook('zeus-form-section.before');
            }

            foreach ($section->fields->sortBy('ordering') as $zeusField) {
                if (! $inline) {
                    $fields[] = static::renderHook('zeus-form-field.before');
                }

                $fieldClass = new $zeusField->type;
                $component = $fieldClass->renderClass::make('zeusData.' . $zeusField->id);

                $fields[] = $fieldClass->appendFilamentComponentsOptions($component, $zeusField);

                if (! $inline) {
                    $fields[] = static::renderHook('zeus-form-field.after');
                }
            }

            if (! $inline) {
                $fields[] = static::renderHook('zeus-form-section.after');
            }

            $sectionId = $section->name . '-' . $section->id;
            if (optional($zeusForm->options)['show-as'] === 'tabs') {
                $sections[] = Tabs\Tab::make($section->name)
                    ->id($sectionId)
                    ->icon($section->icon ?? null)
                    ->schema([
                        Grid::make()->columns($section->columns)->schema($fields),
                    ]);
            } elseif (optional($zeusForm->options)['show-as'] === 'wizard') {
                $sections[] = Wizard\Step::make($section->name)
                    ->id($sectionId)
                    ->description($section->description)
                    ->icon($section->icon ?? null)
                    ->schema([
                        Grid::make()->columns($section->columns)->schema($fields),
                    ]);
            } else {
                $sections[] = Section::make($section->name)
                    ->id($sectionId)
                    ->icon($section->icon ?? null)
                    ->schema($fields)
                    ->collapsible()
                    ->aside(fn () => $section->aside)
                    ->description($section->description)
                    ->columns($section->columns);
            }
        }

        if (optional($zeusForm->options)['show-as'] === 'tabs') {
            return [Tabs::make('tabs')->tabs($sections)];
        }

        if (optional($zeusForm->options)['show-as'] === 'wizard') {
            return [Wizard::make($sections)];
        }

        return $sections;
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
}
