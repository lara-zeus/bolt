<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Bolt\Fields\FieldsContract;

class CheckboxList extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\CheckboxList::class;

    public int $sort = 6;

    public function title(): string
    {
        return __('Checkbox List');
    }

    public static function getOptions(): array
    {
        return [
            self::dataSource(),
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

        return $component
            ->options($options->pluck('itemValue', 'itemKey'))
            ->default($options->where('itemIsDefault', true)->pluck('itemKey'));
    }
}
