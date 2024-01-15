<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Accordion\Forms\Accordions;
use LaraZeus\Bolt\Fields\FieldsContract;

class RichEditor extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\RichEditor::class;

    public int $sort = 7;

    public function title(): string
    {
        return __('Rich Editor');
    }

    public function icon(): string
    {
        return 'tabler-cursor-text';
    }

    public function description(): string
    {
        return __('Text editor with styling');
    }

    public static function getOptions(?array $sections = null): array
    {
        return [
            Accordions::make('check-list-options')
                ->accordions([
                    Accordion::make('general-options')
                        ->label(__('General Options'))
                        ->icon('iconpark-checklist-o')
                        ->schema([
                            self::required(),
                            self::columnSpanFull(),
                            self::htmlID(),
                        ]),
                    self::hintOptions(),
                    self::visibility($sections),
                ]),
        ];
    }

    public static function getOptionsHidden(): array
    {
        return [
            self::hiddenVisibility(),
            self::hiddenHtmlID(),
            self::hiddenHintOptions(),
            self::hiddenRequired(),
            self::hiddenColumnSpanFull(),
        ];
    }
}
