<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput as TextInputAlias;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Colors\Color;
use Guava\IconPicker\Forms\Components\IconPicker;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Accordion\Forms\Accordions;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\BoltPro\Facades\GradeOptions;

class TextInput extends FieldsContract
{
    public string $renderClass = TextInputAlias::class;

    public int $sort = 1;

    public function icon(): string
    {
        return 'tabler-input-search';
    }

    public static function getOptions(?array $sections = null, ?array $field = null): array
    {
        return [
            Accordions::make('options')
                ->accordions([
                    Accordion::make('validation-options')
                        ->label(__('zeus-bolt::forms.fields.options.validation_options'))
                        ->icon('tabler-input-check')
                        ->columns()
                        ->schema([
                            Select::make('options.dateType')
                                ->label(__('zeus-bolt::forms.fields.options.data_type'))
                                ->required()
                                ->options([
                                    'string' => __('zeus-bolt::forms.fields.options.data_type_types.string'),
                                    'email' => __('zeus-bolt::forms.fields.options.data_type_types.email'),
                                    'numeric' => __('zeus-bolt::forms.fields.options.data_type_types.numeric'),
                                    'password' => __('zeus-bolt::forms.fields.options.data_type_types.password'),
                                    'tel' => __('zeus-bolt::forms.fields.options.data_type_types.tel'),
                                    'url' => __('zeus-bolt::forms.fields.options.data_type_types.url'),
                                    'activeUrl' => __('zeus-bolt::forms.fields.options.data_type_types.activeUrl'),
                                    'alpha' => __('zeus-bolt::forms.fields.options.data_type_types.alpha'),
                                    'alphaDash' => __('zeus-bolt::forms.fields.options.data_type_types.alphaDash'),
                                    'alphaNum' => __('zeus-bolt::forms.fields.options.data_type_types.alphaNum'),
                                    'ip' => __('zeus-bolt::forms.fields.options.data_type_types.ip'),
                                    'ipv4' => __('zeus-bolt::forms.fields.options.data_type_types.ipv4'),
                                    'ipv6' => __('zeus-bolt::forms.fields.options.data_type_types.ipv6'),
                                    'macAddress' => __('zeus-bolt::forms.fields.options.data_type_types.macAddress'),
                                ])
                                ->default('string')
                                ->columnSpanFull()
                                ->live(),

                            TextInputAlias::make('options.minValue')
                                ->visible(fn (Get $get): bool => $get('options.dateType') === 'numeric')
                                ->label(__('zeus-bolt::forms.fields.options.min_value')),

                            TextInputAlias::make('options.maxValue')
                                ->visible(fn (Get $get): bool => $get('options.dateType') === 'numeric')
                                ->label(__('zeus-bolt::forms.fields.options.max_value')),

                            self::isActive(),
                            self::required(),
                        ]),

                    Accordion::make('visual-options')
                        ->label(__('zeus-bolt::forms.fields.options.visual_options'))
                        ->columns()
                        ->icon('tabler-float-center')
                        ->schema([
                            TextInputAlias::make('options.prefix')
                                ->label(__('zeus-bolt::forms.fields.options.prefix')),
                            TextInputAlias::make('options.suffix')
                                ->label(__('zeus-bolt::forms.fields.options.suffix')),

                            IconPicker::make('options.prefix-icon')
                                ->columns([
                                    'default' => 1,
                                    'lg' => 3,
                                    '2xl' => 5,
                                ])
                                ->label(__('zeus-bolt::forms.fields.options.prefix_icon')),
                            IconPicker::make('options.suffix-icon')
                                ->columns([
                                    'default' => 1,
                                    'lg' => 3,
                                    '2xl' => 5,
                                ])
                                ->label(__('zeus-bolt::forms.fields.options.suffix_icon')),

                            ColorPicker::make('options.prefix-icon-color')
                                ->label(__('zeus-bolt::forms.fields.options.prefix_icon_color')),
                            ColorPicker::make('options.suffix-icon-color')
                                ->label(__('zeus-bolt::forms.fields.options.suffix_icon_color')),

                            self::columnSpanFull(),
                            self::hiddenLabel(),
                            self::htmlID(),
                        ]),
                    self::hintOptions(),
                    self::visibility($sections),
                    // @phpstan-ignore-next-line
                    ...Bolt::hasPro() ? GradeOptions::schema($field) : [],
                    Bolt::getCustomSchema('field', resolve(static::class)) ?? [],
                ]),
        ];
    }

    public static function getOptionsHidden(): array
    {
        return [
            self::hiddenIsActive(),
            // @phpstan-ignore-next-line
            Bolt::hasPro() ? GradeOptions::hidden() : [],
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
                ->prefixIconColor(Color::generateV3Palette($zeusField->options['prefix-icon-color'] ?? '#000000'))
                ->prefix($zeusField->options['prefix']);
        }

        if (isset($zeusField->options['suffix']) && $zeusField->options['suffix'] !== null) {
            $component = $component
                ->suffixIcon($zeusField->options['suffix-icon'] ?? null)
                ->suffixIconColor(Color::generateV3Palette($zeusField->options['suffix-icon-color'] ?? '#000000'))
                ->suffix($zeusField->options['suffix']);
        }

        return $component;
    }
}
