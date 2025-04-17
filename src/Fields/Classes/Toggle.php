<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Actions\Exports\ExportColumn;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Guava\FilamentIconPicker\Forms\IconPicker;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Accordion\Forms\Accordions;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\FieldResponse;
use LaraZeus\Bolt\Models\Response;

class Toggle extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\Toggle::class;

    public int $sort = 5;

    public function title(): string
    {
        return __('Toggle');
    }

    public function icon(): string
    {
        return 'tabler-toggle-left';
    }

    public function description(): string
    {
        return __('toggle');
    }

    public static function getOptions(?array $sections = null, ?array $field = null): array
    {
        return [
            Accordions::make('check-list-options')
                ->accordions([
                    Accordion::make('general-options')
                        ->label(__('General Options'))
                        ->icon('tabler-settings')
                        ->schema([
                            Grid::make()
                                ->columns()
                                ->schema([
                                    IconPicker::make('options.on-icon')
                                        ->columns([
                                            'default' => 1,
                                            'lg' => 3,
                                            '2xl' => 5,
                                        ])
                                        ->label(__('On Icon')),

                                    IconPicker::make('options.off-icon')
                                        ->columns([
                                            'default' => 1,
                                            'lg' => 3,
                                            '2xl' => 5,
                                        ])
                                        ->label(__('Off Icon')),

                                    ColorPicker::make('options.on-color')->hex(),
                                    ColorPicker::make('options.off-color')->hex(),

                                    \Filament\Forms\Components\Toggle::make('options.is-inline'),
                                ]),
                            self::required(),
                            self::columnSpanFull(),
                            self::hiddenLabel(),
                            self::htmlID(),
                        ]),
                    self::hintOptions(),
                    self::visibility($sections),
                    // @phpstan-ignore-next-line
                    ...Bolt::hasPro() ? \LaraZeus\BoltPro\Facades\GradeOptions::schema($field) : [],
                    Bolt::getCustomSchema('field', resolve(static::class)) ?? [],
                ]),
        ];
    }

    public static function getOptionsHidden(): array
    {
        return [
            // @phpstan-ignore-next-line
            Bolt::hasPro() ? \LaraZeus\BoltPro\Facades\GradeOptions::hidden() : [],
            ...Bolt::getHiddenCustomSchema('field', resolve(static::class)) ?? [],
            self::hiddenVisibility(),
            self::hiddenHtmlID(),
            self::hiddenHintOptions(),
            self::hiddenRequired(),
            self::hiddenColumnSpanFull(),
            self::hiddenHiddenLabel(),
            Hidden::make('options.on-icon'),
            Hidden::make('options.off-icon'),
            Hidden::make('options.on-color'),
            Hidden::make('options.off-color'),
            Hidden::make('options.is-inline'),
        ];
    }

    // @phpstan-ignore-next-line
    public function appendFilamentComponentsOptions($component, $zeusField, bool $hasVisibility = false)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField, $hasVisibility);

        if (optional($zeusField->options)['on-icon']) {
            $component = $component->onIcon($zeusField->options['on-icon']);
        }

        if (optional($zeusField->options)['off-icon']) {
            $component = $component->offIcon($zeusField->options['off-icon']);
        }

        if (optional($zeusField->options)['on-color']) {
            $component = $component->onColor(Color::hex($zeusField->options['on-color']));
        }

        if (optional($zeusField->options)['off-color']) {
            $component = $component->offColor(Color::hex($zeusField->options['off-color']));
        }

        if (isset($zeusField->options['is-inline'])) {
            $component = $component->inline($zeusField->options['is-inline']);
        }

        return $component->live();
    }

    public function TableColumn(Field $field): ?Column
    {
        return IconColumn::make('zeusData.' . $field->id)
            ->sortable(false)
            ->label($field->name)
            ->boolean()
            ->searchable(query: function (Builder $query, string $search): Builder {
                return $query
                    ->whereHas('fieldsResponses', function ($query) use ($search) {
                        $query->where('response', 'like', '%' . $search . '%');
                    });
            })
            ->getStateUsing(fn (Response $record) => (int) $this->getFieldResponseValue($record, $field))
            ->toggleable();
    }

    public function entry(Field $field, FieldResponse $resp): string
    {
        $response = (int) $resp->response;

        return ($response === 1) ? __('yes') : __('no');
    }

    public function ExportColumn(Field $field): ?ExportColumn
    {
        return ExportColumn::make('zeusData.' . $field->options['htmlId'])
            ->label($field->name)
            ->state(function (Response $record) use ($field) {
                /** @var ?Response $response */
                $response = $record->fieldsResponses()->where('field_id', $field->id)->first();
                $response = (int) $response->response;

                return ($response === 1) ? __('yes') : __('no');
            });
    }
}
