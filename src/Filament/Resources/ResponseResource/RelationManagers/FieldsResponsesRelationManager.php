<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class FieldsResponsesRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'fieldsResponses';

    protected static ?string $recordTitleAttribute = 'response_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ]);
    }
}
