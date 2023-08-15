<?php

namespace LaraZeus\Bolt\Facades;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;
use LaraZeus\Bolt\Models\Form;

class Bolt extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bolt';
    }

    public static function availableFields()
    {
        if (app()->isLocal()) {
            Cache::forget('bolt.fields');
        }

        return Cache::remember('bolt.fields', Carbon::parse('1 month'), function () {
            $coreFields = Collectors::collectClasses(__DIR__.'/../Fields/Classes', 'LaraZeus\\Bolt\\Fields\\Classes\\');
            $appFields = Collectors::collectClasses(app_path('Zeus/Fields'), 'App\\Zeus\\Fields\\');

            $fields = collect();

            if (!$coreFields->isEmpty()) {
                $fields = $fields->merge($coreFields);
            }

            if (!$appFields->isEmpty()) {
                $fields = $fields->merge($appFields);
            }

            return $fields->sortBy('sort');
        });
    }

    public static function availableDataSource()
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

    public static function prepareFieldsAndSectionToRender(Form $zeusForm): array
    {
        $sections = [];
        $zeusSections = $zeusForm->sections()->orderBy('ordering')->get();

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

            $fields[] = static::renderHook('zeus-form-section.before');

            foreach ($section->fields()->orderBy('ordering')->get() as $zeusField) {
                $fields[] = static::renderHook('zeus-form-field.before');

                $fieldClass = new $zeusField->type;
                $component = $fieldClass->renderClass::make('zeusData.'.$zeusField->id);

                $fields[] = $fieldClass->appendFilamentComponentsOptions($component, $zeusField);

                $fields[] = static::renderHook('zeus-form-field.after');
            }

            $fields[] = static::renderHook('zeus-form-section.after');

            $sectionId = $section->name.'-'.$section->id;
            if (optional($zeusForm->options)['show-as'] === 'tabs') {
                $sections[] = Tabs\Tab::make($section->name)
                    ->id($sectionId)
                    ->icon($section->icon ?? null)
                    ->schema([
                        Fieldset::make()->columns($section->columns)->schema($fields),
                    ]);
            } elseif (optional($zeusForm->options)['show-as'] === 'wizard') {
                $sections[] = Wizard\Step::make($section->name)
                    ->id($sectionId)
                    ->description($section->description)
                    ->icon($section->icon ?? null)
                    ->schema([
                        Section::make()->columns($section->columns)->schema($fields),
                    ]);
            } else {
                $sections[] = Section::make($section->name)
                    ->id($sectionId)
                    ->schema($fields)
                    ->aside()
                    ->aside(fn() => $section->aside)
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

    public static function renderHook($hook): Placeholder
    {
        $hookRendered = \Filament\Support\Facades\FilamentView::renderHook($hook);

        return Placeholder::make('placeholder-'.$hook)
            ->label('')
            ->content($hookRendered)
            ->visible(filled($hookRendered->toHtml()));
    }

    public static function renderHookBlade($hook)
    {
        if (!empty(\Filament\Support\Facades\FilamentView::renderHook($hook)->toHtml())) {
            return \Filament\Support\Facades\FilamentView::renderHook($hook);
        }
    }

    public static function isJson($string): bool
    {
        if ($string === '') {
            return false;
        }

        if (is_int($string)) {
            return false;
        }

        json_decode($string);

        if (json_last_error()) {
            return false;
        }

        return true;
    }
}
