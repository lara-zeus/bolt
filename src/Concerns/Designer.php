<?php

namespace LaraZeus\Bolt\Concerns;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Facades\Extensions;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Section as ZeusSection;

trait Designer
{
    public static function ui(Form $zeusForm, bool $inline = false): array
    {
        $sections = self::drawExt($zeusForm);

        foreach ($zeusForm->sections->sortBy('ordering') as $section) {
            $sections[] = self::drawSections(
                $zeusForm,
                $section,
                self::drawFields($section, $inline)
            );
        }

        if (optional($zeusForm->options)['show-as'] === 'tabs') {
            return [Tabs::make('tabs')->tabs($sections)];
        }

        if (optional($zeusForm->options)['show-as'] === 'wizard') {
            return [Wizard::make($sections)];
        }

        return $sections;
    }

    private static function drawExt(Form $zeusForm): Section | array
    {
        $getExtComponent = Extensions::init($zeusForm, 'formComponents');

        if ($getExtComponent === null) {
            return [];
        }

        return Section::make('extensions')
            ->heading(function () use ($zeusForm) {
                $class = $zeusForm->extensions;
                if (class_exists($class)) {
                    return (new $class)->label();
                }

                return __('Extension');
            })
            ->schema($getExtComponent);
    }

    private static function drawFields(ZeusSection $section, bool $inline): array
    {
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

            $fields[] = $fieldClass->appendFilamentComponentsOptions($component, $zeusField);

            if (! $inline) {
                $fields[] = Bolt::renderHook('zeus-form-field.after');
            }
        }

        if (! $inline) {
            $fields[] = Bolt::renderHook('zeus-form-section.after');
        }

        return $fields;
    }

    private static function drawSections(Form $zeusForm, \LaraZeus\Bolt\Models\Section $section, array $fields): Tab | Step | Section
    {
        $component = Section::make($section->name)
            ->description($section->description)
            ->aside(fn () => $section->aside)
            ->compact(fn () => $section->compact)
            ->collapsible();

        if (optional($zeusForm->options)['show-as'] === 'tabs') {
            $component = Tab::make($section->name)
                ->icon($section->icon ?? null);
        }

        if (optional($zeusForm->options)['show-as'] === 'wizard') {
            $component = Step::make($section->name)
                ->description($section->description)
                ->icon($section->icon ?? null);
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

            return $relatedFieldValues === $get('zeusData.' . $relatedField);
        });

        return $component
            ->id(str($section->name)->slug() . '-' . $section->id)
            ->schema($fields)
            ->columns($section->columns);
    }
}
