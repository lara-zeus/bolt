<?php

namespace LaraZeus\Bolt\Filament\Resources;

use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Filament\Resources\CategoryResource\Pages\CreateCategory;
use LaraZeus\Bolt\Filament\Resources\CategoryResource\Pages\EditCategory;
use LaraZeus\Bolt\Filament\Resources\CategoryResource\Pages\ListCategories;
use LaraZeus\Bolt\Models\Category;

class CategoryResource extends BoltResource
{
    protected static string | BackedEnum | null $navigationIcon = 'tabler-tags-filled';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModel(): string
    {
        return BoltPlugin::getModel('Category');
    }

    public static function getNavigationBadge(): ?string
    {
        if (! BoltPlugin::getNavigationBadgesVisibility(self::class)) {
            return null;
        }

        return (string) BoltPlugin::getModel('Category')::query()->count();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->columns()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->label(__('zeus-bolt::category.name'))
                            ->afterStateUpdated(function (Set $set, $state, $context) {
                                if ($context === 'edit') {
                                    return;
                                }
                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->label(__('zeus-bolt::category.slug')),

                        TextInput::make('ordering')
                            ->required()
                            ->numeric()
                            ->label(__('zeus-bolt::category.ordering')),

                        Toggle::make('is_active')
                            ->label(__('zeus-bolt::category.is_active'))
                            ->default(1),

                        Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpan(['sm' => 2])
                            ->label(__('zeus-bolt::category.description')),

                        FileUpload::make('logo')
                            ->disk(config('zeus-bolt.uploadDisk'))
                            ->directory(config('zeus-bolt.uploadDirectory'))
                            ->visibility(config('zeus-bolt.uploadVisibility'))
                            ->columnSpan(['sm' => 2])
                            ->label(__('zeus-bolt::category.logo')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->disk(config('zeus-bolt.uploadDisk'))
                    ->visibility(config('zeus-bolt.uploadVisibility'))
                    ->toggleable()
                    ->label(__('zeus-bolt::category.logo')),
                TextColumn::make('name')
                    ->label(__('zeus-bolt::category.name'))
                    ->forceSearchCaseInsensitive()
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('forms_count')
                    ->counts('forms')
                    ->label(__('zeus-bolt::category.forms'))
                    ->toggleable()
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable()
                    ->toggleable()
                    ->label(__('zeus-bolt::category.is_active')),
            ])
            ->reorderable('ordering')
            ->defaultSort('id', 'description')
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                    ForceDeleteAction::make(),
                    RestoreAction::make(),
                ]),
            ])
            ->filters([
                TrashedFilter::make(),
                Filter::make('is_active')
                    ->label(__('zeus-bolt::category.is_active'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
                Filter::make('not_active')
                    ->label(__('zeus-bolt::category.not_active'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_active', false)),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
                ForceDeleteBulkAction::make(),
                RestoreBulkAction::make(),
            ]);
    }

    /** @phpstan-return Builder<Category> */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('zeus-bolt::category.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('zeus-bolt::category.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('zeus-bolt::category.navigation_label');
    }
}
