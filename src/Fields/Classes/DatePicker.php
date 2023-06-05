<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class DatePicker extends FieldsContract
{
    public string $renderClass = '\Filament\Forms\Components\DatePicker';

    public int $sort = 8;

    public function title(): string
    {
        return __('Date Picker');
    }

    public static function getOptions(): array
    {
        return [
            Toggle::make('options.is_required')->label(__('Is Required')),
            \Filament\Forms\Components\TextInput::make('options.htmlId')
                ->default(str()->random(6))
                ->label(__('HTML ID')),
        ];
    }
}
