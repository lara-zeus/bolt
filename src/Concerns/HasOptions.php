<?php

namespace LaraZeus\Bolt\Concerns;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Fields\FieldsContract;

trait HasOptions
{
    public static function visibility(): Grid
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
                    ->options(function ($livewire, $record) {
                        if ($record === null) {
                            return [];
                        }

                        return $livewire->record
                            ->fields()
                            ->where('fields.id', '!=', $record->id ?? null)
                            ->where('fields.options', '!=', $record->id ?? null)
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

    public static function columnSpanFull(): Grid
    {
        return Grid::make()
            ->schema([
                Toggle::make('options.column_span_full')->label('Column Span Full')->translateLabel(),
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
                    ->default(str()->random(6))
                    ->label(__('HTML ID')),
            ])
            ->columns(1);
    }
}
