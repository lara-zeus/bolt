<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea as TextareaAlias;
use Filament\Forms\Components\TextInput;
use LaraZeus\Bolt\Fields\FieldsContract;

class Textarea extends FieldsContract
{
    public string $renderClass = TextareaAlias::class;

    public int $sort = 8;

    public function title(): string
    {
        return __('Textarea');
    }

    public static function getOptions(?array $sections = null): array
    {
        return [
            TextInput::make('options.rows')
                ->label(__('rows')),

            TextInput::make('options.cols')
                ->label(__('cols')),

            TextInput::make('options.minLength')
                ->label(__('min length')),

            TextInput::make('options.maxLength')
                ->label(__('max length')),

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
            Hidden::make('options.htmlId')->default(str()->random(6)),

            Hidden::make('options.rows'),
            Hidden::make('options.cols'),
            Hidden::make('options.minLength'),
            Hidden::make('options.maxLength'),

            Hidden::make('options.hint.text'),
            Hidden::make('options.hint.icon'),
            Hidden::make('options.hint.color'),

            Hidden::make('options.is_required')->default(false),
            Hidden::make('options.column_span_full')->default(false),

            Hidden::make('options.visibility.active'),
            Hidden::make('options.visibility.fieldID'),
            Hidden::make('options.visibility.values'),
        ];
    }

    // @phpstan-ignore-next-line
    public function appendFilamentComponentsOptions($component, $zeusField)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField);

        if (filled($zeusField['options']['maxLength'])) {
            $component->maxLength($zeusField['options']['maxLength']);
        }
        if (filled($zeusField['options']['maxLength'])) {
            $component->maxLength($zeusField['options']['maxLength']);
        }
        if (filled($zeusField['options']['rows'])) {
            $component->rows($zeusField['options']['rows']);
        }
        if (filled($zeusField['options']['cols'])) {
            $component->cols($zeusField['options']['cols']);
        }

        return $component;
    }
}
