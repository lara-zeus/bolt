<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class Radio extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\Radio::class;

    public int $sort = 4;

    public function title(): string
    {
        return __('Radio');
    }

    public static function getOptions(): array
    {
        return [
            self::dataSource(),
            Toggle::make('options.is_inline')->label(__('Is inline')),
            self::required(),
            self::htmlID(),
            self::visibility(),
        ];
    }

    public function getResponse($field, $resp): string
    {
        return $this->getCollectionsValuesForResponse($field, $resp);
    }

    public function appendFilamentComponentsOptions($component, $zeusField)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField);

        $options = FieldsContract::getFieldCollectionItemsList($zeusField);

        $component = $component
            ->options($options->pluck('itemValue', 'itemKey'))
            ->default($options->where('itemIsDefault', true)->pluck('itemKey'));

        if (isset($zeusField->options['is_inline']) && $zeusField->options['is_inline']) {
            $component->inline();
        }

        return $component;
    }
}
