<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Accordion\Forms\Accordions;
use LaraZeus\Bolt\Fields\FieldsContract;

class Paragraph extends FieldsContract
{
    public string $renderClass = Placeholder::class;

    public int $sort = 10;

    public function title(): string
    {
        return __('Paragraph');
    }

    public function icon(): string
    {
        return 'tabler-text-recognition';
    }

    public function description(): string
    {
        return __('display a paragraph in your form');
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
                            self::columnSpanFull(),
                            self::hiddenLabel(),
                            self::hintOptions(),
                        ]),
                    self::visibility($sections),
                ]),
        ];
    }

    public static function getOptionsHidden(): array
    {
        return [
            self::hiddenHintOptions(),
            self::hiddenColumnSpanFull(),
            self::hiddenHiddenLabel(),
            self::hiddenVisibility(),
        ];
    }

    // @phpstan-ignore-next-line
    public function appendFilamentComponentsOptions($component, $zeusField, bool $hasVisibility = false)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField, $hasVisibility);

        return $component
            ->helperText('')
            ->content(new HtmlString($zeusField->description));
    }
}
