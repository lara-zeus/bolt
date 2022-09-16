<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class TextInput extends FieldsContract
{
    public $renderClass = '\Filament\Forms\Components\TextInput';

    public $sort = 1;

    public function title()
    {
        return __('Text Input');
    }

    public static function getOptions()
    {
        return [
            Select::make('options.dateType')
                ->required()
                ->options([
                    'text' => 'text',
                    'email' => 'email',
                    'numeric' => 'numeric',
                    'tel' => 'tel',
                    'url' => 'url',
                ])
                ->default('text')
                ->reactive(),

            Toggle::make('options.is_required')->label(__('Is Required')),

            \Filament\Forms\Components\TextInput::make('options.prefix'),
            \Filament\Forms\Components\TextInput::make('options.suffix'),

            //\Filament\Forms\Components\TextInput::make('options.minLength')->visible(fn(\Closure $get) :bool => $get('options.dateType') === 'numeric'),
            //\Filament\Forms\Components\TextInput::make('options.maxLength')->visible(fn(\Closure $get) :bool => $get('options.dateType') === 'numeric'),

            \Filament\Forms\Components\TextInput::make('options.minValue')->visible(fn (\Closure $get): bool => $get('options.dateType') === 'numeric'),
            \Filament\Forms\Components\TextInput::make('options.maxValue')->visible(fn (\Closure $get): bool => $get('options.dateType') === 'numeric'),

            \Filament\Forms\Components\TextInput::make('options.length')->hidden(fn (\Closure $get): bool => in_array($get('options.dateType'), ['email', 'url'])),
        ];
    }
}
