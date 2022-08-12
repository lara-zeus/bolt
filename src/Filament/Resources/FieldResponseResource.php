<?php

namespace LaraZeus\Bolt\Filament\Resources;

use LaraZeus\Bolt\Filament\Resources\FieldResponseResource\Pages;
use LaraZeus\Bolt\Models\FieldResponse;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class FieldResponseResource extends Resource
{
    protected static ?string $model = FieldResponse::class;

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
                Forms\Components\TextInput::make('field_id')
                    ->required(),
                Forms\Components\TextInput::make('response_id')
                    ->required(),
                Forms\Components\Textarea::make('response')
                    ->required()
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('form_id'),
                Tables\Columns\TextColumn::make('field_id'),
                Tables\Columns\TextColumn::make('response_id'),
                Tables\Columns\TextColumn::make('response'),
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
            'index' => Pages\ListFieldResponses::route('/'),
            'create' => Pages\CreateFieldResponse::route('/create'),
            'edit' => Pages\EditFieldResponse::route('/{record}/edit'),
        ];
    }
}
