<?php

namespace LaraZeus\Bolt\Concerns;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Guava\FilamentIconPicker\Forms\IconPicker;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Fields\FieldsContract;

trait HasOptions
{
    public static function visibility($type = 'field'): Grid
    {
        return Grid::make()
            ->schema([
                Toggle::make('options.visibility.active')
                    ->live()
                    ->label(__('Conditional Visibility')),

                Select::make('options.visibility.fieldID')
                    ->label(__('show when the field:'))
                    ->live()
                    ->visible(fn (Get $get): bool => ! empty($get('options.visibility.active')))
                    ->required(fn (Get $get): bool => ! empty($get('options.visibility.active')))
                    ->options(function ($livewire, $record) use ($type) {
                        if ($record === null) {
                            return [];
                        }

                        return $livewire->record
                            ->fields()
                            ->when($type === 'field', function ($query) use ($record) {
                                return $query->where('fields.id', '!=', $record->id);
                            })
                            ->when($type === 'section', function ($query) use ($record) {
                                return $query->where('section_id', '!=', $record->id);
                            })
                            ->where(function ($query) {
                                $query->whereNotNull('fields.options->dataSource');
                                $query->orWhere('type', '\LaraZeus\Bolt\Fields\Classes\Toggle');
                            })
                            ->get()
                            ->pluck('name', 'id');
                    }),

                Select::make('options.visibility.values')
                    ->label(__('has the value:'))
                    ->live()
                    ->required(fn (Get $get): bool => ! empty($get('options.visibility.fieldID')))
                    ->visible(fn (Get $get): bool => ! empty($get('options.visibility.fieldID')))
                    ->options(function (Get $get, $livewire) {
                        if ($get('options.visibility.fieldID') === null) {
                            return [];
                        }
                        $getRelated = $livewire->getRecord()->fields()
                            ->where('fields.id', $get('options.visibility.fieldID'))
                            ->first();

                        if ($getRelated->type === '\LaraZeus\Bolt\Fields\Classes\Toggle') {
                            return [
                                'true' => __('checked'),
                                'false' => __('not checked'),
                            ];
                        }

                        if (! isset($getRelated->options['dataSource'])) {
                            return [];
                        }

                        return FieldsContract::getFieldCollectionItemsList($getRelated);
                    }),
            ])
            ->columns(1);
    }

    public static function required(): Grid
    {
        return Grid::make()
            ->schema([
                Toggle::make('options.is_required')->label(__('Is Required')),
            ])
            ->columns(1);
    }

    public static function hintOptions(): Grid
    {
        return Grid::make()
            ->schema([
                TextInput::make('options.hint.text')
                    ->label(__('Hint Text')),
                IconPicker::make('options.hint.icon')
                    ->columns([
                        'default' => 1,
                        'lg' => 3,
                        '2xl' => 5,
                    ])
                    ->label(__('Hint Icon')),
                ColorPicker::make('options.hint.color')->label(__('Hint Color')),
            ])
            ->columns(1);
    }

    public static function columnSpanFull(): Grid
    {
        return Grid::make()
            ->schema([
                Toggle::make('options.column_span_full')
                    ->helperText(__('show this field in full width row'))
                    ->label(__('Full Width')),
            ])
            ->columns(1);
    }

    public static function dataSource(): Grid
    {
        $dataSources = BoltPlugin::getModel('Collection')::get()
            ->mapWithKeys(function ($item, $key) {
                return [
                    $key => [
                        'title' => $item['name'],
                        'class' => $item['id'],
                    ],
                ];
            })
            ->merge(
                Bolt::availableDataSource()
                    ->mapWithKeys(function ($item, $key) {
                        return [
                            $key => [
                                'title' => $item['title'],
                                'class' => $item['class'],
                            ],
                        ];
                    })
            )
            ->pluck('title', 'class');

        return Grid::make()
            ->schema([
                Select::make('options.dataSource')
                    ->required()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->live(onBlur: true)
                            ->label(__('Collections Name'))->required()->maxLength(255)->columnSpan(2),
                        Repeater::make('values')
                            ->grid([
                                'default' => 1,
                                'md' => 2,
                                'lg' => 3,
                            ])
                            ->label(__('Collections Values'))
                            ->columnSpan(2)
                            ->columns(1)
                            ->schema([
                                TextInput::make('itemValue')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, Get $get, string $operation) {
                                        $set('itemKey', $get('itemValue'));
                                    })
                                    ->required()->label(__('Value'))->hint(__('what the user will see')),
                                TextInput::make('itemKey')
                                    ->live(onBlur: true)
                                    ->required()->label(__('Key'))->hint(__('what store in the form')),
                                Toggle::make('itemIsDefault')->label(__('selected by default')),
                            ]),
                    ])
                    ->createOptionUsing(function (array $data) {
                        $collectionModel = BoltPlugin::getModel('Collection');
                        $collection = new $collectionModel;
                        $collection->fill($data);
                        $collection->save();

                        return $collection->id;
                    })
                    ->options($dataSources)
                    ->label(__('Data Source')),
            ])
            ->columns(1);
    }

    public static function htmlID(): Grid
    {
        return Grid::make()
            ->schema([
                TextInput::make('options.htmlId')
                    ->required()
                    ->default(str()->random(6))
                    ->label(__('HTML ID')),
            ])
            ->columns(1);
    }
}
