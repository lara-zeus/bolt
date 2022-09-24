<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Forms\Components\ViewField;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
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
        return (string) Response::query()->count();
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
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    Stack::make([
                        ImageColumn::make('user.avatar')->label(__('User avatar')),
                        TextColumn::make('user.name')->label(__('User Name'))->searchable(),
                        TextColumn::make('user.email')
                            ->searchable()
                            ->label(__('User Email'))
                            ->wrap()
                            ->extraAttributes(['class' => 'text-gray-400'])
                            ->size('sm')
                            ->weight('medium')
                            ->icon('heroicon-s-mail'),
                    ]),
                ]),
                TextColumn::make('form.name')->label(__('form'))->searchable()->visible(! request()->filled('form_id')),
                Panel::make([
                    Stack::make([
                        TextColumn::make('status')->label(__('Status'))->searchable(),
                        TextColumn::make('notes')->label(__('Notes'))->searchable(),
                        TextColumn::make('created_at')->label(__('Created Date'))->dateTime()->sortable()->searchable(),
                    ]),
                ])->collapsible(),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->defaultSort('created_at', 'desc')
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
