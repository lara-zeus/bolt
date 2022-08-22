<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class Checkbox extends FieldsContract
{
    public $disabled = false;

    public function __construct()
    {
        $this->definition = [
            'type' => 'TextInput',
            'title' => 'Text Input',
            'icon' => 'fa-text-width',
            'order' => 1,
        ];
    }

    public static function getOptions()
    {
        return [
            Select::make('options.dateType')->required()->options([
                'email'=>'email',
                'numeric'=>'numeric',
                'tel'=>'tel',
                'url'=>'url',
            ]),
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
