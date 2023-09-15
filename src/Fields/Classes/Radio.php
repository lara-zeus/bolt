<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\FieldResponse;

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
            self::htmlID(),
            self::hintOptions(),
            Toggle::make('options.is_inline')->label(__('Is inline')),
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

        if (isset($zeusField->options['is_inline']) && $zeusField->options['is_inline']) {
            $component->inline();
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
