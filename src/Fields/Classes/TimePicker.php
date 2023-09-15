<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Bolt\Fields\FieldsContract;

class TimePicker extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\TimePicker::class;

    public int $sort = 8;

    public function title(): string
    {
        return __('Time Picker');
    }

    public static function getOptions(): array
    {
        return [
            self::htmlID(),
            self::hintOptions(),
            self::required(),
            self::columnSpanFull(),
            self::visibility(),
        ];
    }
}
