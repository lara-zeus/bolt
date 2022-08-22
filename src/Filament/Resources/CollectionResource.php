<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;
use LaraZeus\Bolt\Models\Collection;

class CollectionResource extends Resource
{
    protected static ?string $model = Collection::class;
    protected static ?string $navigationIcon = 'clarity-tags-line';
    protected static ?int $navigationSort = 3;

    protected static function getNavigationBadge(): ?string
    {
        return (string) Collection::query()->count();
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('Bolt');
    }

    public static function getLabel(): string
    {
        return __('Collection');
    }

    public static function getPluralLabel(): string
    {
        return __('Collections');
    }

    protected static function getNavigationLabel(): string
    {
        return __('Collections');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label(__('Collections Name'))->required()->maxLength(255)->columnSpan(2),
                Forms\Components\Repeater::make('values')
                    ->label(__('Collections Values'))
                    ->schema([
                        TextInput::make('itemKey')->required()->label(__('Key')),
                        TextInput::make('itemValue')->required()->label(__('Value')),
                        Toggle::make('itemIsDefault')->label(__('selected by default')),
                    ])->columnSpan(2)->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('Name')),
                Tables\Columns\TextColumn::make('values-list')->html()->label(__('Values')),
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
            BetaNote::class,
        ];
    }
}
