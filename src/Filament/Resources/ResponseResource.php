<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Tables\Filters\SelectFilter;
use LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;
use LaraZeus\Bolt\Filament\Resources\ResponseResource\RelationManagers\FieldsResponsesRelationManager;
use LaraZeus\Bolt\Http\Livewire\Admin\Entries;
use LaraZeus\Bolt\Models\Response;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ResponseResource extends Resource
{
    protected static ?string $model = Response::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 2;

    protected static function getNavigationGroup() : ?string
    {
        return __('Bolt');
    }

    protected static function shouldRegisterNavigation() : bool
    {
        return true; //todo
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('form_id')
                    ->required(),
                Forms\Components\TextInput::make('user_id')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('form_id'),
                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('notes'),
            ])
            ->filters([
                SelectFilter::make('form')->relationship('form', 'name')
                ->default(request('form_id', null))
            ]);
    }

    public static function getRelations(): array
    {
        return [
            FieldsResponsesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        //
        return [
            'index' => Pages\BrowseResponses::route('/'),
            //'index' => Pages\ListResponses::route('/'),
            'create' => Pages\CreateResponse::route('/create'),
            'edit' => Pages\EditResponse::route('/{record}/edit'),
        ];
    }
}
