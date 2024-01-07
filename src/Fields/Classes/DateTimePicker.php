<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Hidden;
use LaraZeus\Bolt\Fields\FieldsContract;

class DateTimePicker extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\DateTimePicker::class;

    public int $sort = 5;

    public function title(): string
    {
        return __('Date Time Picker');
    }

    public static function getOptionsHidden(): array
    {
        return [
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
}
