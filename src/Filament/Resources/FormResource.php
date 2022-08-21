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
                            ->afterStateUpdated(function (\Closure $set, $state, $context) {
                                if ($context === 'edit') {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')->required()->maxLength(255)->columnSpan(2)->rules(['alpha_dash'])->unique(ignoreRecord: true),
                        TextInput::make('ordering')->required()->columnSpan(1),
                    ])->columns(5),

                Hidden::make('user_id')->required()->default(auth()->user()->id),
                Hidden::make('layout')->default(1),

                Card::make()
                    ->schema([
                        Placeholder::make('Sections-title')->helperText('sections are here to group the fields, and you can display it as pages from the Form options. if you have one section, it wont show in the form'),
                    ]),

                Repeater::make('sections')
                    ->label('')
                    ->schema([
                        TextInput::make('name')->required()->lazy(),
                        Placeholder::make('Fields'),
                        Repeater::make('fields')
                            ->schema([
                                TextInput::make('name')->required()->lazy(),
                                Select::make('type')->required()->options(Bolt::availableFields()->pluck('title', 'type'))->reactive()->default('Select'),
                                Fieldset::make('Options')
                                    ->label('Options')
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
                            ->createItemButtonLabel('Add field'),
                    ])
                    ->relationship()
                    ->orderable('ordering')
                    ->createItemButtonLabel('Add Section')
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
                TextColumn::make('name'),
                TextColumn::make('category.name'),
                TextColumn::make('ordering'),
                BooleanColumn::make('is_active'),
                TextColumn::make('start_date')->dateTime(),
                TextColumn::make('end_date')->dateTime(),
            ])
            ->appendActions([
                /*Action::make('edit-zeus')
                    ->icon('heroicon-o-pencil')
                    ->tooltip('edit Form')
                    ->url(fn(ZeusForm $record) : string => route('admin.form.edit', $record->id)),*/

                Action::make('entries')
                    ->icon('heroicon-o-external-link')
                    ->tooltip('View All Entries')
                    ->url(fn (ZeusForm $record): string => url('admin/responses?form_id='.$record->id)),

                Action::make('open')
                    ->icon('heroicon-o-external-link')
                    ->tooltip('Show the Form')
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
