<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Guava\FilamentIconPicker\Forms\IconPicker;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Accordion\Forms\Accordions;
use LaraZeus\Bolt\Fields\FieldsContract;

class Toggle extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\Toggle::class;

    public int $sort = 5;

    public function title(): string
    {
        return __('Toggle');
    }

    public function icon(): string
    {
        return 'tabler-toggle-left';
    }

    public static function getOptions(?array $sections = null): array
    {
        return [
            Accordions::make('check-list-options')
                ->accordions([
                    Accordion::make('general-options')
                        ->label(__('General Options'))
                        ->icon('iconpark-checklist-o')
                        ->schema([
                            Grid::make()
                                ->columns()
                                ->schema([
                                    IconPicker::make('options.on-icon')
                                        ->columns([
                                            'default' => 1,
                                            'lg' => 3,
                                            '2xl' => 5,
                                        ])
                                        ->label(__('On Icon')),

                                    IconPicker::make('options.off-icon')
                                        ->columns([
                                            'default' => 1,
                                            'lg' => 3,
                                            '2xl' => 5,
                                        ])
                                        ->label(__('Off Icon')),
                                ]),
                            self::required(),
                            self::columnSpanFull(),
                            self::htmlID(),
                        ]),
                    self::hintOptions(),
                    self::visibility($sections),
                ]),
        ];
    }

    public static function getOptionsHidden(): array
    {
        return [
            self::hiddenVisibility(),
            self::hiddenHtmlID(),
            self::hiddenHintOptions(),
            self::hiddenRequired(),
            self::hiddenColumnSpanFull(),
            Hidden::make('options.on-icon'),
            Hidden::make('options.off-icon'),
        ];
    }

    // @phpstan-ignore-next-line
    public function appendFilamentComponentsOptions($component, $zeusField, bool $hasVisibility = false)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField, $hasVisibility);

        if (optional($zeusField->options)['on-icon']) {
            $component = $component->onIcon($zeusField->options['on-icon']);
        }

        if (optional($zeusField->options)['off-icon']) {
            $component = $component->offIcon($zeusField->options['off-icon']);
        }

        return $component->live();
    }
}
