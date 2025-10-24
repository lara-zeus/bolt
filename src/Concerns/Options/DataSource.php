<?php

namespace LaraZeus\Bolt\Concerns\Options;

use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Facades\Bolt;

trait DataSource
{
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
            ->toBase()
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
                    ->createOptionAction(fn (Action $action) => $action->hidden(auth()->user()->cannot('create', BoltPlugin::getModel('Collection'))))
                    ->required()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->live(onBlur: true)
                            ->label(__('zeus-bolt::forms.options.collections.label'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        Repeater::make('values')
                            ->grid([
                                'default' => 1,
                                'md' => 2,
                                'lg' => 3,
                            ])
                            ->label(__('zeus-bolt::forms.options.collections.values'))
                            ->columnSpan(2)
                            ->columns(1)
                            ->schema([
                                TextInput::make('itemValue')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, Get $get, string $operation) {
                                        $set('itemKey', $get('itemValue'));
                                    })
                                    ->required()
                                    ->label(__('zeus-bolt::forms.options.collections.value'))
                                    ->hint(__('zeus-bolt::forms.options.collections.value_hint')),

                                TextInput::make('itemKey')
                                    ->live(onBlur: true)
                                    ->required()
                                    ->label(__('zeus-bolt::forms.options.collections.key'))
                                    ->hint(__('zeus-bolt::forms.options.collections.key_hint')),
                                Toggle::make('itemIsDefault')
                                    ->label(__('zeus-bolt::forms.options.collections.is_default')),
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
                    ->label(__('zeus-bolt::forms.options.data_source.label')),
            ])
            ->columnSpanFull()
            ->columns(1);
    }
}
