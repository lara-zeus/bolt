<?php

namespace LaraZeus\Bolt\Facades;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Section as ZeusSection;

class Designer
{
    public static function ui(Form $zeusForm, bool $inline = false): array
    {
        $sections = self::drawExt($zeusForm);
        $hasSectionVisibility = $zeusForm->sections->pluck('options')->where('visibility.active', true)->isNotEmpty();

        foreach ($zeusForm->sections->sortBy('ordering') as $section) {
            $sections[] = self::drawSections(
                $zeusForm,
                $section,
                self::drawFields($section, $inline, $hasSectionVisibility),
            );
        }

        if (optional($zeusForm->options)['show-as'] === 'tabs') {
            return [Tabs::make('tabs')->live(condition: $hasSectionVisibility)->tabs($sections)];
        }

        if (optional($zeusForm->options)['show-as'] === 'wizard') {
            return [
                Wizard::make($sections)
                    ->live(condition: $hasSectionVisibility),
                // ->skippable() // todo still not working
            ];
        }

        return $sections;
    }

    private static function drawExt(Form $zeusForm): array
    {
        $getExtComponent = Extensions::init($zeusForm, 'formComponents');

        if ($getExtComponent === null) {
            return [];
        }

        return [
            Section::make('extensions')
                ->heading(function () use ($zeusForm) {
                    $class = $zeusForm->extensions;
                    if (class_exists($class)) {
                        return (new $class)->label();
                    }

                    return __('Extension');
                })
                ->schema($getExtComponent),
        ];
    }

    private static function drawFields(ZeusSection $section, bool $inline, bool $hasSectionVisibility = false): array
    {
        $hasVisibility = $hasSectionVisibility || $section->fields->pluck('options')->where('visibility.active', true)->isNotEmpty();

        $fields = [];

        if (! $inline) {
            $fields[] = Bolt::renderHook('zeus-form-section.before');
        }

        foreach ($section->fields->sortBy('ordering') as $zeusField) {
            if (! $inline) {
                $fields[] = Bolt::renderHook('zeus-form-field.before');
            }

            $fieldClass = new $zeusField->type;
            $component = $fieldClass->renderClass::make('zeusData.' . $zeusField->id);

            $fields[] = $fieldClass->appendFilamentComponentsOptions($component, $zeusField, $hasVisibility);

            if (! $inline) {
                $fields[] = Bolt::renderHook('zeus-form-field.after');
            }
        }

        if (! $inline) {
            $fields[] = Bolt::renderHook('zeus-form-section.after');
        }

        return $fields;
    }

    private static function drawSections(Form $zeusForm, ZeusSection $section, array $fields): Tab | Step | Section | Grid
    {
        if (optional($zeusForm->options)['show-as'] === 'tabs') {
            $component = Tab::make($section->name)
                ->icon($section->icon ?? null);
        } elseif (optional($zeusForm->options)['show-as'] === 'wizard') {
            $component = Step::make($section->name)
                ->description($section->description)
                ->icon($section->icon ?? null);
        } elseif ((bool) $section->borderless === true) {
            $component = Grid::make($section->name);
        } else {
            $component = Section::make($section->name)
                ->description($section->description)
                ->aside(fn () => $section->aside)
                ->compact(fn () => $section->compact)
                ->icon($section->icon ?? null)
                ->collapsible();
        }

        $component->visible(function ($record, Get $get) use ($section) {

            if (! isset($section->options['visibility']) || ! $section->options['visibility']['active']) {
                return true;
            }

            $relatedField = $section->options['visibility']['fieldID'];
            $relatedFieldValues = $section->options['visibility']['values'];

            if (empty($relatedField) || empty($relatedFieldValues)) {
                return true;
            }

            if (is_array($get('zeusData.' . $relatedField))) {
                return in_array($relatedFieldValues, $get('zeusData.' . $relatedField));
            }

            return $relatedFieldValues == $get('zeusData.' . $relatedField);
        });

        return $component
            ->schema($fields)
            ->columns($section->columns);
    }
}
