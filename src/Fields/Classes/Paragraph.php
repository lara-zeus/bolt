<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\HtmlString;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Accordion\Forms\Accordions;
use LaraZeus\Bolt\Fields\FieldsContract;

class Paragraph extends FieldsContract
{
    public string $renderClass = TextEntry::class;

    public int $sort = 10;

    public function icon(): string
    {
        return 'tabler-text-recognition';
    }

    public static function getOptions(?array $sections = null, ?array $field = null): array
    {
        return [
            Accordions::make('check-list-options')
                ->accordions([
                    Accordion::make('general-options')
                        ->label(__('zeus-bolt::forms.fields.options.general'))
                        ->icon('tabler-settings')
                        ->schema([
                            self::isActive(),
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
            self::hiddenIsActive(),
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
            ->belowContent('')
            ->state(new HtmlString($zeusField->description));
    }
}
