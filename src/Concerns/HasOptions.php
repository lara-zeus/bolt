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
                Toggle::make('conditional_visibility')
                    ->reactive()
                    ->dehydrated(false)
                    ->label(__('Conditional Visibility')),

                Select::make('options.visibility.fieldIDs')
                    ->label(__('show when the field:'))
                    ->reactive()
                    ->visible(fn (Closure $get): bool => ! empty($get('conditional_visibility')))
                    ->label(function ($livewire, $record) {
                        return $livewire->record
                            ->fields()
                            ->where('fields.id', '!=', $record->id ?? null)
                            ->whereNotNull('fields.options->dataSource')
                            ->where('fields.options', '!=', $record->id ?? null)
                            ->get()
                            ->pluck('name', 'id');
                    }),

                Select::make('options.visibility.values')
                    ->label(__('show when the field:'))
                    ->reactive()
                    ->visible(fn (Closure $get): bool => ! empty($get('options.visibility.fieldIDs')))
                    ->options(function (Closure $get, $livewire) {
                        if ($get('options.visibility.fieldIDs') === null) {
                            return [];
                        }
                        $getRelated = $livewire->getRecord()->fields()
                            ->where('fields.id', $get('options.visibility.fieldIDs'))
                            ->first();

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
