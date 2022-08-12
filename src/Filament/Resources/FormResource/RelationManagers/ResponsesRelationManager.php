<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\RelationManagers;

use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;

class ResponsesRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'responses';
    protected static ?string $recordTitleAttribute = 'form_id';

    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                TextColumn::make('user_id'),
                TextColumn::make('status'),
                TextColumn::make('notes'),
            ]);
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id'),
                TextColumn::make('status'),
            ])
            ->filters([
                //
            ]);
    }
}
