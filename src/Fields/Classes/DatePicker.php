<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Bolt\Fields\FieldsContract;

class DatePicker extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\DatePicker::class;

    public int $sort = 6;

    public function title(): string
    {
        return __('Date Picker');
    }

    public static function getOptions(?array $sections = null): array
    {
        return [
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
            self::hiddenHtmlID(),
            self::hiddenHintOptions(),
            self::hiddenRequired(),
            self::hiddenColumnSpanFull(),
            self::hiddenVisibility(),
        ];
    }
}
