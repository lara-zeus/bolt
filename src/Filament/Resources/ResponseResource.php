<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Forms\Components\ViewField;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;
use LaraZeus\Bolt\Models\Response;

class ResponseResource extends BoltResource
{
    protected static ?string $model = Response::class;

    protected static ?string $navigationIcon = 'clarity-data-cluster-line';

    protected static ?int $navigationSort = 2;

    protected static ?string $slug = 'responses';

    protected static function getNavigationBadge(): ?string
    {
        return (string)Response::query()->count();
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('Bolt');
    }

    public static function getLabel(): string
    {
        return __('Entries');
    }

    public static function getPluralLabel(): string
    {
        return __('Entries');
    }

    protected static function getNavigationLabel(): string
    {
        return __('Entries');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ViewField::make('response')->view('zeus-bolt::filament.resources.response-resource.components.view-responses')
                    ->label('')
                    ->columnSpan(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        $mainColumns = [
            TextColumn::make('user.name')->label(__('User')),
            TextColumn::make('status')->label(__('Status')),
            TextColumn::make('notes')->label(__('Notes')),
            TextColumn::make('created_at')->label(__('Created Date')),
        ];

        if (!request()->filled('form_id')) {
            TextColumn::make('form.name')->label(__('form'));
        }

        return $table
            ->columns($mainColumns)
            ->filters([
                SelectFilter::make('form')->relationship('form', 'name')->default(request('form_id', null)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'brows' => Pages\BrowseResponses::route('/brows'),
            'index' => Pages\ListResponses::route('/'),
            'view' => Pages\ViewResponse::route('/{record}'),
        ];
    }
}
