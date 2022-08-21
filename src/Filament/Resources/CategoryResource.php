<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use LaraZeus\Bolt\Filament\Resources\CategoryResource\Pages;
use LaraZeus\Bolt\Models\Category;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->label(__('name'))
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug')->required()->maxLength(255)->label(__('slug')),
                TextInput::make('ordering')->required()->numeric()->label(__('ordering')),
                Toggle::make('is_active')->label(__('is_active')),
                Textarea::make('desc')->maxLength(65535)->columnSpan(['sm' => 2])->label(__('desc')),

                FileUpload::make('logo')
                    ->disk(config('zeus-bolt.uploads.disk', 'public'))
                    ->directory(config('zeus-bolt.uploads.dir', 'logos'))
                    ->columnSpan(['sm' => 2])
                    ->label(__('logo')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('name'))->sortable()->searchable(),
                TextColumn::make('desc')->label(__('desc')),
                TextColumn::make('ordering')->sortable()->label(__('ordering')),
                BooleanColumn::make('is_active')->sortable()->label(__('is_active')),
                ImageColumn::make('logo')->disk(config('zeus-bolt.uploads.disk', 'public'))->label(__('logo')),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('Category');
    }

    public static function getPluralLabel(): string
    {
        return __('Categories');
    }

    protected static function getNavigationLabel(): string
    {
        return __('Categories');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('Bolt');
    }
}
