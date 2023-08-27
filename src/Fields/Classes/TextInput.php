<?php

namespace LaraZeus\Bolt\Fields\Classes;

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

    public static function getOptions(): array
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

            self::required(),
            self::columnSpanFull(),
            self::htmlID(),
            self::visibility(),
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
