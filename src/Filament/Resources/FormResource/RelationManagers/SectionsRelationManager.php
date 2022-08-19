<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;

class SectionsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'sections';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->maxLength(255),
                TextInput::make('ordering')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('ordering'),
            ])
            ->filters([
                //
            ]);
    }
}
