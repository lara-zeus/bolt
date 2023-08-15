<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\TextInput;
use LaraZeus\Bolt\Fields\FieldsContract;
use Filament\Forms\Components\Textarea as TextareaAlias;

class Textarea extends FieldsContract
{
    public string $renderClass = TextareaAlias::class;

    public int $sort = 8;

    public function title(): string
    {
        return __('Textarea');
    }

    public static function getOptions(): array
    {
        return [
            TextInput::make('options.rows')
                ->label(__('rows')),

            TextInput::make('options.cols')
                ->label(__('cols')),

            TextInput::make('options.minLength')
                ->label(__('min minLength')),

            TextInput::make('options.maxLength')
                ->label(__('max maxLength')),


            self::required(),
            self::htmlID(),
            self::visibility(),
        ];
    }

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
