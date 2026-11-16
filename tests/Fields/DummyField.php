<?php

namespace LaraZeus\Bolt\Tests\Fields;

use Filament\Forms\Components\TextInput;
use LaraZeus\Bolt\Fields\FieldsContract;

class DummyField extends FieldsContract
{
    public string $renderClass = TextInput::class;

    public int $sort = 99;

    public function icon(): string
    {
        return 'tabler-test-pipe';
    }

    public static function getOptions(?array $sections = null, ?array $field = null): array
    {
        return [];
    }

    public static function getOptionsHidden(): array
    {
        return [];
    }
}
