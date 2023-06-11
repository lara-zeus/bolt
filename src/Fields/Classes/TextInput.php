<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class TextInput extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\TextInput::class;

    public int $sort = 1;

    public function title(): string
    {
        return __('Text Input');
    }

    public static function getOptions(): array
    {
        return [
            Select::make('options.dateType')
                ->label(__('Date type'))
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
                ->reactive(),

            \Filament\Forms\Components\TextInput::make('options.prefix')->label(__('prefix')),
            \Filament\Forms\Components\TextInput::make('options.suffix')->label(__('suffix')),
            \Filament\Forms\Components\TextInput::make('options.minValue')->visible(fn (Closure $get): bool => $get('options.dateType') === 'numeric')->label(__('min value')),
            \Filament\Forms\Components\TextInput::make('options.maxValue')->visible(fn (Closure $get): bool => $get('options.dateType') === 'numeric')->label(__('max value')),
            \Filament\Forms\Components\TextInput::make('options.htmlId')
                ->default(str()->random(6))
                ->label(__('HTML ID')),

            Toggle::make('options.is_required')->label(__('Is Required')),
        ];
    }

    public function appendFilamentComponentsOptions($component, $zeusField)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField);

        if (! empty($zeusField['options']['dateType'])) {
            call_user_func([$component, $zeusField['options']['dateType']]);
        }

        return $component;
    }
}
