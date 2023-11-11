<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\FieldResponse;

class CheckboxList extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\CheckboxList::class;

    public int $sort = 3;

    public function title(): string
    {
        return __('Checkbox List');
    }

    public static function getOptions(): array
    {
        return [
            self::dataSource(),
            self::htmlID(),
            self::hintOptions(),
            self::required(),
            self::columnSpanFull(),
            self::visibility(),
        ];
    }

    public function getResponse(Field $field, FieldResponse $resp): string
    {
        return $this->getCollectionsValuesForResponse($field, $resp);
    }

    // @phpstan-ignore-next-line
    public function appendFilamentComponentsOptions($component, $zeusField)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField);

        $options = FieldsContract::getFieldCollectionItemsList($zeusField);

        $component = $component->options($options);

        if (request()->filled($zeusField->options['htmlId'])) {
            $component = $component->default(request($zeusField->options['htmlId']));

        //todo set default items for datasources
        } elseif ($selected = $options->where('itemIsDefault', true)->pluck('itemKey')->isNotEmpty()) {
            $component = $component->default($selected);
        }

        return $component->live();
    }
}
