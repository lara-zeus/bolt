<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages;
use LaraZeus\Bolt\Models\Collection;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class CollectionResource extends Resource
{
    protected static ?string $model = Collection::class;

    protected static ?string $navigationIcon = 'clarity-list-line';

    protected static ?int $navigationSort = 3;

    protected static function getNavigationGroup() : ?string
    {
        return __('Bolt');
    }

    public static function getLabel() : string
    {
        return __('zeus-bolt::common.collections.label');
    }

    public static function getPluralLabel() : string
    {
        return __('zeus-bolt::common.collections.plural');
    }

    protected static function getNavigationLabel() : string
    {
        return __('zeus-bolt::common.collections.nav_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label(__('zeus-bolt::common.collections.name'))->required()->maxLength(255)->columnSpan(2),

                Forms\Components\Repeater::make('values')
                    ->label(__('zeus-bolt::common.collections.values'))
                    ->schema([
                        TextInput::make('itemKey')->required(),
                        TextInput::make('itemValue')->required(),
                        Toggle::make('itemIsDefault'),
                    ])->columnSpan(2)->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollections::route('/'),
            'create' => Pages\CreateCollection::route('/create'),
            'edit' => Pages\EditCollection::route('/{record}/edit'),
        ];
    }
}
