<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use LaraZeus\Bolt\Filament\Resources\SectionResource\Pages;
use LaraZeus\Bolt\Filament\Resources\SectionResource\RelationManagers\FieldsRelationManager;
use LaraZeus\Bolt\Models\Section;

class SectionResource extends Resource
{
    protected static ?string $model = Section::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationGroup() : ?string
    {
        return __('Bolt');
    }

    protected static function shouldRegisterNavigation() : bool
    {
        return false;
    }

    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                TextInput::make('form_id')->required(),
                TextInput::make('name')->maxLength(255),
                TextInput::make('ordering')->required(),
            ]);
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('form_id'),
                TextColumn::make('name'),
                TextColumn::make('ordering'),
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations() : array
    {
        return [
            FieldsRelationManager::class,
        ];
    }

    public static function getPages() : array
    {
        return [
            'index'  => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit'   => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
