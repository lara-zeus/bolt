<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput as TextInputAlias;
use Filament\Forms\Get;
use LaraZeus\Bolt\Fields\FieldsContract;

class TextInput extends FieldsContract
{
    public string $renderClass = TextInputAlias::class;

    public int $sort = 1;

    public function title(): string
    {
        return __('Text Input');
    }

    public static function getOptions(?array $sections = null): array
    {
        return [
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
                ->live(),

            TextInputAlias::make('options.prefix')
                ->label(__('prefix')),

            TextInputAlias::make('options.suffix')
                ->label(__('suffix')),

            TextInputAlias::make('options.minValue')
                ->visible(fn (Get $get): bool => $get('options.dateType') === 'numeric')
                ->label(__('min value')),

            TextInputAlias::make('options.maxValue')
                ->visible(fn (Get $get): bool => $get('options.dateType') === 'numeric')
                ->label(__('max value')),

            self::htmlID(),
            self::hintOptions(),
            self::required(),
            self::columnSpanFull(),
            self::visibility('field', $sections),
        ];
    }

    public static function getOptionsHidden(): array
    {
        return [
            Hidden::make('options.dateType'),
            Hidden::make('options.prefix'),
            Hidden::make('options.suffix'),
            Hidden::make('options.minValue'),
            Hidden::make('options.maxValue'),

            Hidden::make('options.htmlId')->default(str()->random(6)),

            Hidden::make('options.hint.text'),
            Hidden::make('options.hint.icon'),
            Hidden::make('options.hint.color'),

            Hidden::make('options.is_required')->default(false),
            Hidden::make('options.column_span_full')->default(false),

            Hidden::make('options.visibility.active'),
            Hidden::make('options.visibility.fieldID'),
            Hidden::make('options.visibility.values'),
        ];
    }

    // @phpstan-ignore-next-line
    public function appendFilamentComponentsOptions($component, $zeusField)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField);

        if (! empty($zeusField['options']['dateType'])) {
            call_user_func([$component, $zeusField['options']['dateType']]);
        }

        return $component;
    }
}
