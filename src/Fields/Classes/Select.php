<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class Select extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\Select::class;

    public int $sort = 2;

    public function title(): string
    {
        return __('Select Menu');
    }

    public static function getOptions(): array
    {
        return [
            self::dataSource(),
            self::required(),
            self::columnSpanFull(),
            Toggle::make('options.allow_multiple')->label(__('Allow Multiple')),
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
            ->searchable()
            ->preload()
            ->options($options);

        if (isset($zeusField->options['allow_multiple']) && $zeusField->options['allow_multiple']) {
            $component = $component->multiple();
        }

        if (request()->filled($zeusField->options['htmlId'])) {
            $component = $component->default(request($zeusField->options['htmlId']));
            //todo set default items for datasources
        } elseif ($selected = $options->where('itemIsDefault', true)->pluck('itemKey')->isNotEmpty()) {
            $component = $component->default($selected);
        }

        return $component;
    }
}
