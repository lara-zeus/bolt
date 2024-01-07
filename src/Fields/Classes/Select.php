<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\FieldResponse;

class Select extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\Select::class;

    public int $sort = 2;

    public function title(): string
    {
        return __('Select Menu');
    }

    public static function getOptions(?array $sections = null): array
    {
        return [
            self::dataSource(),
            self::htmlID(),
            self::hintOptions(),
            Toggle::make('options.allow_multiple')->label(__('Allow Multiple')),
            self::required(),
            self::columnSpanFull(),
            self::visibility('field', $sections),
        ];
    }

    public static function getOptionsHidden(): array
    {
        return [
            Hidden::make('options.dataSource'),

            Hidden::make('options.htmlId')->default(str()->random(6)),

            Hidden::make('options.hint.text'),
            Hidden::make('options.hint.icon'),
            Hidden::make('options.hint.color'),

            Hidden::make('options.is_required')->default(false),
            Hidden::make('options.allow_multiple')->default(false),
            Hidden::make('options.column_span_full')->default(false),

            Hidden::make('options.visibility.active'),
            Hidden::make('options.visibility.fieldID'),
            Hidden::make('options.visibility.values'),
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

        return $component->live();
    }
}
