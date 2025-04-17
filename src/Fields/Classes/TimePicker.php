<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Accordion\Forms\Accordions;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Fields\FieldsContract;

class TimePicker extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\TimePicker::class;

    public int $sort = 8;

    public function title(): string
    {
        return __('Time Picker');
    }

    public function icon(): string
    {
        return 'tabler-clock-hour-8';
    }

    public function description(): string
    {
        return __('time picker');
    }

    public static function getOptions(?array $sections = null, ?array $field = null): array
    {
        return [
            Accordions::make('check-list-options')
                ->accordions([
                    Accordion::make('general-options')
                        ->label(__('General Options'))
                        ->icon('tabler-settings')
                        ->schema([
                            self::required(),
                            self::columnSpanFull(),
                            self::hiddenLabel(),
                            self::htmlID(),
                        ]),
                    self::hintOptions(),
                    self::visibility($sections),
                    // @phpstan-ignore-next-line
                    ...Bolt::hasPro() ? \LaraZeus\BoltPro\Facades\GradeOptions::schema($field) : [],
                    Bolt::getCustomSchema('field', resolve(static::class)) ?? [],
                ]),
        ];
    }

    public static function getOptionsHidden(): array
    {
        return [
            // @phpstan-ignore-next-line
            Bolt::hasPro() ? \LaraZeus\BoltPro\Facades\GradeOptions::hidden() : [],
            ...Bolt::getHiddenCustomSchema('field', resolve(static::class)) ?? [],
            self::hiddenVisibility(),
            self::hiddenHtmlID(),
            self::hiddenHintOptions(),
            self::hiddenRequired(),
            self::hiddenColumnSpanFull(),
            self::hiddenHiddenLabel(),
        ];
    }
}
