<?php

namespace LaraZeus\Bolt\Concerns;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Facades\Bolt;

trait HasHiddenOptions
{
    public static function hiddenVisibility(): array
    {
        return [
            Hidden::make('options.visibility.active'),
            Hidden::make('options.visibility.fieldID'),
            Hidden::make('options.visibility.values'),
        ];
    }

    public static function hiddenRequired(): array
    {
        return [
            Hidden::make('options.is_required')->default(false),
        ];
    }

    public static function hiddenHintOptions(): array
    {
        return [
            Hidden::make('options.hint.text'),
            Hidden::make('options.hint.icon'),
            Hidden::make('options.hint.color'),
            Hidden::make('options.hint.icon-tooltip'),
        ];
    }

    public static function hiddenColumnSpanFull(): array
    {
        return [
            Hidden::make('options.column_span_full')->default(false),
        ];
    }

    public static function hiddenDataSource(): array
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

    public static function hiddenHtmlID(): array
    {
        return [
            Hidden::make('options.htmlId')->default(str()->random(6)),
        ];
    }
}
