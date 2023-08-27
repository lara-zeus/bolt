<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\ColorPicker as ColorPickerAlias;
use LaraZeus\Bolt\Fields\FieldsContract;

class ColorPicker extends FieldsContract
{
    public string $renderClass = ColorPickerAlias::class;

    public int $sort = 9;

    public function title(): string
    {
        return __('Color Picker');
    }

    public static function getOptions(): array
    {
        return [
            \Filament\Forms\Components\Select::make('options.colorType')
                ->label(__('Color Type'))
                ->options([
                    'hsl' => 'hsl',
                    'rgb' => 'rgb',
                    'rgba' => 'rgba',
                ]),
            self::htmlID(),
            self::required(),
            self::columnSpanFull(),
            self::htmlID(),
            self::visibility(),
        ];
    }

    // @phpstan-ignore-next-line
    public function appendFilamentComponentsOptions($component, $zeusField)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField);

        if (! empty($zeusField['options']['colorType'])) {
            call_user_func([$component, $zeusField['options']['colorType']]);
        }

        return $component;
    }
}
