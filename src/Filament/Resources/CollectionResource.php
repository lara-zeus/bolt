<?php

namespace LaraZeus\Bolt\Filament\Resources;

use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages\CreateCollection;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages\EditCollection;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages\ListCollections;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Widgets\EditCollectionWarning;

class CollectionResource extends BoltResource
{
    protected static string | BackedEnum | null $navigationIcon = 'tabler-brand-databricks';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModel(): string
    {
        return BoltPlugin::getModel('Collection');
    }

    public static function getNavigationBadge(): ?string
    {
        if (! BoltPlugin::getNavigationBadgesVisibility(self::class)) {
            return null;
        }

        return (string) BoltPlugin::getModel('Collection')::query()->count();
    }

    public static function getModelLabel(): string
    {
        return __('zeus-bolt::collection.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('zeus-bolt::collection.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('zeus-bolt::collection.navigation_label');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->live(onBlur: true)
                    ->label(__('zeus-bolt::collection.name'))
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),

                Repeater::make('values')
                    ->grid([
                        'default' => 1,
                        'md' => 2,
                        'lg' => 3,
                    ])
                    ->label(__('zeus-bolt::collection.values'))
                    ->columnSpan(2)
                    ->columns(1)
                    ->schema([
                        TextInput::make('itemValue')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get, string $operation) {
                                if ($operation === 'create') {
                                    $set('itemKey', $get('itemValue'));
                                }
                            })
                            ->required()
                            ->label(__('zeus-bolt::collection.value'))
                            ->hint(__('zeus-bolt::collection.value_help')),

                        TextInput::make('itemKey')
                            ->live(onBlur: true)
                            ->required()
                            ->label(__('zeus-bolt::collection.key'))
                            ->hint(__('zeus-bolt::collection.key_help')),

                        Toggle::make('itemIsDefault')
                            ->label(__('zeus-bolt::collection.default')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('zeus-bolt::collection.name'))
                    ->forceSearchCaseInsensitive()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('values-list')
                    ->badge()
                    ->separator(',')
                    ->label(__('zeus-bolt::collection.values'))
                    ->searchable(['values'])
                    ->toggleable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCollections::route('/'),
            'create' => CreateCollection::route('/create'),
            'edit' => EditCollection::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            EditCollectionWarning::class,
        ];
    }
}
