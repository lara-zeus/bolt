<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Forms\Components\ViewField;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;
use LaraZeus\Bolt\Models\FormsStatus;

class ResponseResource extends BoltResource
{
    public static function getModel(): string
    {
        return config('zeus-bolt.models.Response');
    }

    protected static ?string $navigationIcon = 'clarity-data-cluster-line';

    protected static ?int $navigationSort = 2;

    protected static ?string $slug = 'responses';

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
                        ImageColumn::make('user.avatar')
                            ->label(__('Avatar')),
                        TextColumn::make('user.name')
                            ->label(__('User Name'))
                            ->searchable(),
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
                TextColumn::make('form.name')
                    ->label(__('form'))
                    ->searchable()
                    ->visible(! request()->filled('form_id')),
                Stack::make([
                    BadgeColumn::make('status')
                        ->label(__('status'))
                        ->enum(config('zeus-bolt.models.FormsStatus')::pluck('label', 'key')->toArray())
                        ->colors(config('zeus-bolt.models.FormsStatus')::pluck('key', 'color')->toArray())
                        ->icons(config('zeus-bolt.models.FormsStatus')::pluck('key', 'icon')->toArray())
                        ->grow(false)
                        ->searchable('status'),
                    TextColumn::make('notes')->label(__('Notes'))->searchable(),
                    TextColumn::make('created_at')->label(__('Created Date'))->dateTime()->sortable()->searchable(),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->defaultSort('created_at', 'description')
            ->filters([
                SelectFilter::make('status')
                    ->options(FormsStatus::query()->pluck('label', 'key'))
                    ->label(__('Status')),
                SelectFilter::make('form')
                    ->relationship('form', 'name')
                    ->default(request('form_id', null)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'brows' => Pages\BrowseResponses::route('/brows'),
            'report' => Pages\ReportResponses::route('/report'),
            'index' => Pages\ListResponses::route('/'),
            'view' => Pages\ViewResponse::route('/{record}'),
        ];
    }
}
