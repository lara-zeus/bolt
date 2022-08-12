<?php

namespace LaraZeus\Bolt\Filament\Resources;

use LaraZeus\Bolt\Filament\Resources\FieldResource\Pages;
use LaraZeus\Bolt\Models\Field;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class FieldResource extends Resource
{
    protected static ?string $model = Field::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationGroup() : ?string
    {
        return __('Bolt');
    }

    protected static function shouldRegisterNavigation() : bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('form_id')
                    ->required(),
                Forms\Components\TextInput::make('section_id')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('layout_position')
                    ->required(),
                Forms\Components\TextInput::make('ordering')
                    ->required(),
                Forms\Components\TextInput::make('html_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('html_name')
                    ->maxLength(255),
                Forms\Components\Textarea::make('options')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('rules')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('form_id'),
                Tables\Columns\TextColumn::make('section_id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('layout_position'),
                Tables\Columns\TextColumn::make('ordering'),
                Tables\Columns\TextColumn::make('html_id'),
                Tables\Columns\TextColumn::make('html_name'),
                Tables\Columns\TextColumn::make('options'),
                Tables\Columns\TextColumn::make('rules'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListFields::route('/'),
            'create' => Pages\CreateField::route('/create'),
            'edit' => Pages\EditField::route('/{record}/edit'),
        ];
    }
}
