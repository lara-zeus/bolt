<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput as TextInputAlias;
use Filament\Forms\Get;
use Filament\Support\Colors\Color;
use Guava\FilamentIconPicker\Forms\IconPicker;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Accordion\Forms\Accordions;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Fields\FieldsContract;

class TextInput extends FieldsContract
{
    public string $renderClass = TextInputAlias::class;

    public int $sort = 1;

    public function title(): string
    {
        return __('Text Input');
    }

    public function icon(): string
    {
        return 'tabler-input-search';
    }

    public function description(): string
    {
        return __('text input');
    }

    public static function getOptions(?array $sections = null, ?array $field = null): array
    {
        return [
            Accordions::make('options')
                ->accordions([
                    Accordion::make('validation-options')
                        ->label(__('Validation Options'))
                        ->icon('tabler-input-check')
                        ->columns()
                        ->schema([
                            Select::make('options.dateType')
                                ->label(__('Data type'))
                                ->required()
                                ->options([
                                    'string' => __('text'),
                                    'email' => __('email'),
                                    'numeric' => __('numeric'),
                                    'password' => __('password'),
                                    'tel' => __('tel'),
                                    'url' => __('url'),
                                    'activeUrl' => __('active url'),
                                    'alpha' => __('alpha'),
                                    'alphaDash' => __('alpha dash'),
                                    'alphaNum' => __('alpha num'),
                                    'ip' => __('ip'),
                                    'ipv4' => __('ip v4'),
                                    'ipv6' => __('ip v6'),
                                    'macAddress' => __('mac address'),
                                ])
                                ->default('string')
                                ->columnSpanFull()
                                ->live(),

                            TextInputAlias::make('options.minValue')
                                ->visible(fn (Get $get): bool => $get('options.dateType') === 'numeric')
                                ->label(__('min value')),

                            TextInputAlias::make('options.maxValue')
                                ->visible(fn (Get $get): bool => $get('options.dateType') === 'numeric')
                                ->label(__('max value')),

                            self::required(),
                        ]),

                    Accordion::make('visual-options')
                        ->label(__('Visual Options'))
                        ->columns()
                        ->icon('tabler-float-center')
                        ->schema([
                            TextInputAlias::make('options.prefix')
                                ->label(__('prefix')),
                            TextInputAlias::make('options.suffix')
                                ->label(__('suffix')),

                            IconPicker::make('options.prefix-icon')
                                ->columns([
                                    'default' => 1,
                                    'lg' => 3,
                                    '2xl' => 5,
                                ])
                                ->label(__('Prefix Icon')),
                            IconPicker::make('options.suffix-icon')
                                ->columns([
                                    'default' => 1,
                                    'lg' => 3,
                                    '2xl' => 5,
                                ])
                                ->label(__('Suffix Icon')),

                            ColorPicker::make('options.prefix-icon-color')
                                ->label(__('Prefix Icon Color')),
                            ColorPicker::make('options.suffix-icon-color')
                                ->label(__('Suffix Icon Color')),

                            self::columnSpanFull(),
                            self::hiddenLabel(),
                            self::htmlID(),
                        ]),
                    self::hintOptions(),
                    self::visibility($sections),
                    // @phpstan-ignore-next-line
                    ...Bolt::hasPro() ? \LaraZeus\BoltPro\Facades\GradeOptions::schema($field) : [],
                    Bolt::getCustomSchema('field', resolve(static::class)) ?? [],
                ]),
        ];
    }

    public static function getOptionsHidden(): array
    {
        return [
            // @phpstan-ignore-next-line
            Bolt::hasPro() ? \LaraZeus\BoltPro\Facades\GradeOptions::hidden() : [],
            ...Bolt::getHiddenCustomSchema('field', resolve(static::class)) ?? [],
            self::hiddenVisibility(),
            self::hiddenHtmlID(),
            self::hiddenHintOptions(),
            self::hiddenRequired(),
            self::hiddenColumnSpanFull(),
            self::hiddenHiddenLabel(),

            Hidden::make('options.dateType'),

            Hidden::make('options.minValue'),
            Hidden::make('options.maxValue'),

            Hidden::make('options.suffix'),
            Hidden::make('options.suffix-icon'),
            Hidden::make('options.suffix-icon-color'),

            Hidden::make('options.prefix'),
            Hidden::make('options.prefix-icon'),
            Hidden::make('options.prefix-icon-color'),
        ];
    }

    // @phpstan-ignore-next-line
    public function appendFilamentComponentsOptions($component, $zeusField, bool $hasVisibility = false)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField, $hasVisibility);

        if (! empty($zeusField['options']['dateType'])) {
            call_user_func([$component, optional($zeusField['options'])['dateType'] ?? 'string']);
        }

        if (isset($zeusField->options['prefix']) && $zeusField->options['prefix'] !== null) {
            $component = $component
                ->prefixIcon($zeusField->options['prefix-icon'] ?? null)
                ->prefixIconColor(Color::hex($zeusField->options['prefix-icon-color'] ?? '#000000'))
                ->prefix($zeusField->options['prefix']);
        }

        if (isset($zeusField->options['suffix']) && $zeusField->options['suffix'] !== null) {
            $component = $component
                ->suffixIcon($zeusField->options['suffix-icon'] ?? null)
                ->suffixIconColor(Color::hex($zeusField->options['suffix-icon-color'] ?? '#000000'))
                ->suffix($zeusField->options['suffix']);
        }

        return $component;
    }
}
