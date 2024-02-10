<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Enums\Resources;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Widgets\EditCollectionWarning;

class CollectionResource extends BoltResource
{
    protected static ?string $navigationIcon = 'clarity-folder-open-outline-badged';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModel(): string
    {
        return BoltPlugin::getModel('Collection');
    }

    public static function getNavigationBadge(): ?string
    {
        if (! BoltPlugin::getNavigationBadgesVisibility(Resources::CollectionResource)) {
            return null;
        }

        return (string) BoltPlugin::getModel('Collection')::query()->count();
    }

    public static function getModelLabel(): string
    {
        return __('Collection');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Collections');
    }

    public static function getNavigationLabel(): string
    {
        return __('Collections');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                                if ($operation === 'create') {
                                    $set('itemKey', $get('itemValue'));
                                }
                            })
                            ->required()->label(__('Value'))->hint(__('what the user will see')),
                        TextInput::make('itemKey')
                            ->live(onBlur: true)
                            ->required()->label(__('Key'))->hint(__('what store in the form')),
                        Toggle::make('itemIsDefault')->label(__('selected by default')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Collections Name'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('values-list')
                    ->badge()
                    ->separator(',')
                    ->label(__('Collections Values'))
                    ->searchable(['values'])
                    ->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollections::route('/'),
            'create' => Pages\CreateCollection::route('/create'),
            'edit' => Pages\EditCollection::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            EditCollectionWarning::class,
        ];
    }
}
