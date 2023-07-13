<?php

namespace LaraZeus\Bolt\Concerns;

use Closure;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

trait HasOptions
{
    public static function visibility(): Grid
    {
        return Grid::make()
            ->schema([
                Toggle::make('options.visibility.active')
                    ->reactive()
                    ->label(__('Conditional Visibility')),

                Select::make('options.visibility.fieldID')
                    ->label(__('show when the field:'))
                    ->reactive()
                    ->visible(fn (Closure $get): bool => ! empty($get('options.visibility.active')))
                    ->required(fn (Closure $get): bool => ! empty($get('options.visibility.active')))
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
                    ->label(__('show when the field:'))
                    ->reactive()
                    ->required(fn (Closure $get): bool => ! empty($get('options.visibility.fieldID')))
                    ->visible(fn (Closure $get): bool => ! empty($get('options.visibility.fieldID')))
                    ->options(function (Closure $get, $livewire) {
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

                        return FieldsContract::getFieldCollectionItemsList($getRelated)
                            ->pluck('itemValue', 'itemKey');
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

    public static function dataSource(): Grid
    {
        return Grid::make()
            ->schema([
                Select::make('options.dataSource')
                    ->required()
                    ->options(config('zeus-bolt.models.Collection')::pluck('name', 'id'))
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
