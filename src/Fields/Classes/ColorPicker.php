<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\ColorPicker as ColorPickerAlias;
use Filament\Forms\Components\Hidden;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Accordion\Forms\Accordions;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Fields\FieldsContract;

class ColorPicker extends FieldsContract
{
    public string $renderClass = ColorPickerAlias::class;

    public int $sort = 9;

    public function title(): string
    {
        return __('Color Picker');
    }

    public function icon(): string
    {
        return 'tabler-color-picker';
    }

    public function description(): string
    {
        return __('pick a color with rgb, rgba or hsl');
    }

    public static function getOptions(?array $sections = null): array
    {
        return [
            Accordions::make('check-list-options')
                ->accordions([
                    Accordion::make('general-options')
                        ->label(__('General Options'))
                        ->icon('tabler-settings')
                        ->schema([
                            \Filament\Forms\Components\Select::make('options.colorType')
                                ->label(__('Color Type'))
                                ->options([
                                    'hsl' => 'hsl',
                                    'rgb' => 'rgb',
                                    'rgba' => 'rgba',
                                ]),
                            self::required(),
                            self::columnSpanFull(),
                            self::hiddenLabel(),
                            self::htmlID(),
                        ]),
                    self::hintOptions(),
                    self::visibility($sections),
                    Bolt::getCustomSchema('field', resolve(static::class)) ?? [],
                ]),
        ];
    }

    public static function getOptionsHidden(): array
    {
        return [
            ...Bolt::getHiddenCustomSchema('field', resolve(static::class)) ?? [],
            Hidden::make('options.colorType'),
            self::hiddenHtmlID(),
            self::hiddenHintOptions(),
            self::hiddenRequired(),
            self::hiddenColumnSpanFull(),
            self::hiddenHiddenLabel(),
            self::hiddenVisibility(),
        ];
    }

    // @phpstan-ignore-next-line
    public function appendFilamentComponentsOptions($component, $zeusField, bool $hasVisibility = false)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField, $hasVisibility);

        if (! empty($zeusField['options']['colorType'])) {
            call_user_func([$component, $zeusField['options']['colorType']]);
        }

        return $component;
    }
}
