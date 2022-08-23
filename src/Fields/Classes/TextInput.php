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
            Select::make('options.dateType')->required()->options([
                'text' => 'text',
                'email' => 'email',
                'numeric' => 'numeric',
                'tel' => 'tel',
                'url' => 'url',
            ])->default('text'),

            Toggle::make('options.is_required')->label(__('Is Required')),

            \Filament\Forms\Components\TextInput::make('options.prefix'),
            \Filament\Forms\Components\TextInput::make('options.suffix'),

            \Filament\Forms\Components\TextInput::make('options.minLength'),
            \Filament\Forms\Components\TextInput::make('options.maxLength'),

            \Filament\Forms\Components\TextInput::make('options.minValue'),
            \Filament\Forms\Components\TextInput::make('options.maxValue'),

            \Filament\Forms\Components\TextInput::make('options.length'),
        ];
    }
}
