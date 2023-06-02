<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;
use Closure;

class TextInput extends FieldsContract
{
    public string $renderClass = '\Filament\Forms\Components\TextInput';

    public int $sort = 1;

    public function title()
    {
        return __('Text Input');
    }

    public static function getOptions()
    {
        return [
            Select::make('options.dateType')
                ->label(__('Date type'))
                ->required()
                ->options([
                    'text' => __('text'),
                    'email' => __('email'),
                    'numeric' => __('numeric'),
                    'tel' => __('tel'),
                    'url' => __('url'),
                ])
                ->default('text')
                ->reactive(),

            Toggle::make('options.is_required')->label(__('Is Required')),

            \Filament\Forms\Components\TextInput::make('options.prefix')->label(__('prefix')),
            \Filament\Forms\Components\TextInput::make('options.suffix')->label(__('suffix')),
            \Filament\Forms\Components\TextInput::make('options.minValue')->visible(fn (Closure $get): bool => $get('options.dateType') === 'numeric'),
            \Filament\Forms\Components\TextInput::make('options.maxValue')->visible(fn (Closure $get): bool => $get('options.dateType') === 'numeric'),
        ];
    }
}
