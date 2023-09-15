<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Bolt\Fields\FieldsContract;

class RichEditor extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\RichEditor::class;

    public int $sort = 7;

    public function title(): string
    {
        return __('Rich Editor');
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
