<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;
use LaraZeus\Bolt\Models\FormsStatus;

class ResponseResource extends BoltResource
{
    protected static ?string $navigationIcon = 'clarity-data-cluster-line';

    protected static ?int $navigationSort = 2;

    protected static ?string $slug = 'responses';

    protected static bool $shouldRegisterNavigation = false;

    public static function getModel(): string
    {
        return BoltPlugin::getModel('Response');
    }

    public static function getLabel(): string
    {
        return __('Entries');
    }

    public static function getPluralLabel(): string
    {
        return __('Entries');
    }

    public static function getNavigationLabel(): string
    {
        return __('Entries');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ViewField::make('response')
                    ->view('zeus::filament.resources.response-resource.components.view-responses')
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
                            ->icon('heroicon-s-envelope'),
                    ]),
                ]),
                TextColumn::make('form.name')
                    ->label(__('form'))
                    ->searchable()
                    ->visible(! request()->filled('form_id')),
                Stack::make([
                    TextColumn::make('status')
                        ->badge()
                        ->label(__('status'))
                        ->colors(BoltPlugin::getModel('FormsStatus')::pluck('key', 'color')->toArray())
                        ->icons(BoltPlugin::getModel('FormsStatus')::pluck('key', 'icon')->toArray())
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
                    ->attribute('form_id')
                    ->searchable()
                    ->preload()
                    ->options(BoltPlugin::getModel('Form')::pluck('name', 'id'))
                    //->relationship('form', 'name') // todo issue with multi lang
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
