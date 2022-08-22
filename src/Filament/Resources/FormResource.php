<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Forms\Components\Card;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages;
use LaraZeus\Bolt\Filament\Resources\FormResource\RelationManagers\ResponsesRelationManager;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;
use LaraZeus\Bolt\Models\Form as ZeusForm;

class FormResource extends Resource
{
    protected static ?string $model = ZeusForm::class;
    protected static ?string $navigationIcon = 'clarity-form-line';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name','slug'];
    }

    protected static function getNavigationBadge(): ?string
    {
        return (string) ZeusForm::query()->count();
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('Bolt');
    }

    public static function getLabel(): string
    {
        return __('Form');
    }

    public static function getPluralLabel(): string
    {
        return __('Forms');
    }

    protected static function getNavigationLabel(): string
    {
        return __('Forms');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        ViewField::make('')->view('zeus-bolt::filament.resources.form-resource.components.fields-options')->columnSpan(5),
                        TextInput::make('name')->required()->maxLength(255)->columnSpan(2)->reactive()
                            ->label(__('Form Name'))
                            ->afterStateUpdated(function (\Closure $set, $state, $context) {
                                if ($context === 'edit') {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')->required()->maxLength(255)->columnSpan(2)->rules(['alpha_dash'])->unique(ignoreRecord: true)->label(__('Form Slug')),
                        TextInput::make('ordering')->required()->columnSpan(1)->label(__('Form Order')),
                    ])->columns(5),

                Hidden::make('user_id')->required()->default(auth()->user()->id), //todo
                Hidden::make('layout')->default(1), //todo

                Card::make()
                    ->schema([
                        Placeholder::make('Sections-title')->label(__('Sections title'))->helperText(__('sections are here to group the fields, and you can display it as pages from the Form options. if you have one section, it wont show in the form')),
                    ]),

                Repeater::make('sections')
                    ->label('')
                    ->schema([
                        TextInput::make('name')->required()->lazy()->label(__('Section Name')),
                        Placeholder::make('Fields')->label(__('Section Fields')),
                        Repeater::make('fields')
                            ->schema([
                                TextInput::make('name')->required()->lazy()->label(__('Field Name')),
                                Select::make('type')->required()->options(Bolt::availableFields()->pluck('title', 'type'))->reactive()->default('Select')->label(__('Field Type')),
                                Fieldset::make('Options')
                                    ->label(__('Field Options'))
                                    ->schema(function (\Closure $get) {
                                        $classNmae = '\LaraZeus\Bolt\Fields\Classes\\'.$get('type') ?? 'TextInput';

                                        return $classNmae::getOptions();
                                    }),
                            ])
                            ->relationship()
                            ->label('')
                            ->orderable('ordering')
                            ->cloneable()
                            ->collapsible()
                            ->grid([
                                'default' => 1,
                                'md'      => 2,
                            ])
                            ->label('')
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                            ->createItemButtonLabel(__('Add field')),
                    ])
                    ->relationship()
                    ->orderable('ordering')
                    ->createItemButtonLabel(__('Add Section'))
                    ->cloneable()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable()->label(__('Form Name')),
                TextColumn::make('category.name')->label(__('Category'))->sortable(),
                TextColumn::make('ordering')->label(__('Ordering'))->sortable(),
                BooleanColumn::make('is_active')->label(__('Is Active'))->sortable(),
                TextColumn::make('start_date')->dateTime()->searchable()->sortable()->label(__('Start Date')),
                TextColumn::make('end_date')->dateTime()->searchable()->sortable()->label(__('End Date')),
            ])
            ->appendActions([
                Action::make('entries')
                    ->label(__('Entries'))
                    ->icon('clarity-data-cluster-line')
                    ->tooltip(__('view all entries'))
                    ->url(fn (ZeusForm $record): string => url('admin/responses?form_id='.$record->id)),

                Action::make('open')
                    ->label(__('Open'))
                    ->icon('heroicon-o-external-link')
                    ->tooltip(__('open form'))
                    ->url(fn (ZeusForm $record): string => route('bolt.user.form.show', $record))
                    ->openUrlInNewTab(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ResponsesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit'   => Pages\EditForm::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            BetaNote::class,
        ];
    }
}
