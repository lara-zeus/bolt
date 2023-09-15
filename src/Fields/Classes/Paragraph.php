<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Placeholder;
use LaraZeus\Bolt\Fields\FieldsContract;

class Paragraph extends FieldsContract
{
    public string $renderClass = Placeholder::class;

    public int $sort = 10;

    public function title(): string
    {
        return __('Paragraph');
    }

    public static function getOptions(): array
    {
        return [
            self::hintOptions(),
            self::columnSpanFull(),
        ];
    }
}
