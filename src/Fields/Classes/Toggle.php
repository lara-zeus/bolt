<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Bolt\Fields\FieldsContract;

class Toggle extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\Toggle::class;

    public int $sort = 5;

    public function title(): string
    {
        return __('Toggle');
    }

    public static function getOptions(): array
    {
        return [
            self::htmlID(),
            self::required(),
            self::columnSpanFull(),
            self::visibility(),
        ];
    }
}
