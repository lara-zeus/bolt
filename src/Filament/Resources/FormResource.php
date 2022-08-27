<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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

    public static function getGloballySearchableAttributes() : array
    {
        return [ 'name', 'slug' ];
    }

    protected static function getNavigationBadge() : ?string
    {
        return (string) ZeusForm::query()->count();
    }

    protected static function getNavigationGroup() : ?string
    {
        return __('Bolt');
    }

    public static function getLabel() : string
    {
        return __('Form');
    }

    public static function getPluralLabel() : string
    {
        return __('Forms');
    }

    protected static function getNavigationLabel() : string
    {
        return __('Forms');
    }

    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                Tabs::make('Name')
                    ->tabs([
                        Tabs\Tab::make('form-options')->label(__('Form Options'))
                            ->schema([
                                TextInput::make('name')->required()->maxLength(255)->columnSpan(2)->reactive()
                                    ->label(__('Form Name'))
                                    ->afterStateUpdated(function (\Closure $set, $state, $context) {
                                        if ($context === 'edit') {
                                            return;
                                        }
                                        $set('slug', Str::slug($state));
                                    }),
                                TextInput::make('slug')->required()->maxLength(255)->columnSpan(2)->rules([ 'alpha_dash' ])->unique(ignoreRecord: true)->label(__('Form Slug')),
                                TextInput::make('ordering')->required()->columnSpan(1)->label(__('Form Order')),
                            ])->columns(5),
                        Tabs\Tab::make('Options')
                            ->schema([
                                Select::make('category_id')
                                    ->label(__('Category'))
                                    ->helperText(__('optional, organize your forms into categories'))
                                    ->options(\LaraZeus\Bolt\Models\Category::pluck('name', 'id')),
                                Grid::make()->schema([
                                    Placeholder::make('form-dates')->label('Form Dates')->content(__('optional, specify when the form will be active and receiving new entries'))->columnSpan(2),
                                    DateTimePicker::make('start_date')->label(__('Start Date')),
                                    DateTimePicker::make('end_date')->label(__('End Date')),
                                ])->columns(2),
                                Grid::make()->schema([
                                    TextInput::make('options.emails-notification')
                                        ->label(__('Emails Notifications'))
                                        ->helperText(__('optional, enter the emails you want to receive notification when ever you got a new entry')),
                                    TextInput::make('options.web-hook')
                                        ->label(__('enter webHook URL'))
                                        ->helperText(__('Send the form data to a webHook')),
                                ])->columns(2),
                            ]),
                        Tabs\Tab::make('Text')
                            ->schema([
                                Textarea::make('desc')->label(__('Form Description'))->helperText(__('shown under the title of the form and used in SEO')),
                                RichEditor::make('details')->label(__('Form Details'))->helperText(__('a highlighted section above the form, to show some instructions or more details')),
                                RichEditor::make('options.confirmation-message')->label(__('Confirmation Message'))->helperText(__('optional, show a massage whenever any one submit a new entery')),
                            ]),
                        Tabs\Tab::make('Settings')
                            ->schema([
                                Toggle::make('is_active')->label(__('is_active'))->helperText(__('Activate the form and let users start submissions')),
                                Toggle::make('options.require-login')->label(__('require Login'))->helperText(__('User must be logged in or create an account before can submit a new entry')),
                                Toggle::make('options.one-entry-per-user')->label(__('One Entry Per User'))->helperText(__('to check if the user already submitted an entry in this form')),
                                Toggle::make('options.sections-to-pages')->label(__('Sections To Pages'))->helperText(__('instead of showing all section in one page, separate them in multiple pages with next and previous buttons')),
                            ])->columns(2),
                    ])->columnSpan(2),

                Hidden::make('user_id')->default(auth()->user()->id ?? null),
                Hidden::make('layout')->default(1),

                Card::make()
                    ->schema([
                        Placeholder::make('Sections-title')->label(__('Sections'))->helperText(__('sections are here to group the fields, and you can display it as pages from the Form options. if you have one section, it wont show in the form')),
                    ]),

                Repeater::make('sections')
                    ->label('')
                    ->schema([
                        TextInput::make('name')->required()->lazy()->label(__('Section Name')),
                        Placeholder::make('Fields')->label(__('Section Fields')),
                        Repeater::make('fields')
                            ->schema([
                                TextInput::make('name')->required()->lazy()->label(__('Field Name')),
                                Select::make('type')
                                    ->required()
                                    ->options(Bolt::availableFields()->pluck('title', 'class'))
                                    ->reactive()
                                    ->default('\LaraZeus\Bolt\Fields\Classes\TextInput')
                                    ->label(__('Field Type')),
                                Fieldset::make('Options')
                                    ->label(__('Field Options'))
                                    ->visible(function (\Closure $get) {
                                        $class = $get('type');
                                        return ( new $class )->hasOptions();
                                    })
                                    ->schema(function (\Closure $get) {
                                        return $get('type')::getOptions();
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
                            ->itemLabel(fn(array $state) : ?string => $state['name'] ?? null)
                            ->createItemButtonLabel(__('Add field')),
                    ])
                    ->relationship()
                    ->orderable('ordering')
                    ->createItemButtonLabel(__('Add Section'))
                    ->cloneable()
                    ->collapsible()
                    ->itemLabel(fn(array $state) : ?string => $state['name'] ?? null)
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table) : Table
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
                    ->url(fn(ZeusForm $record) : string => url('admin/responses?form_id=' . $record->id)),

                Action::make('open')
                    ->label(__('Open'))
                    ->icon('heroicon-o-external-link')
                    ->tooltip(__('open form'))
                    ->url(fn(ZeusForm $record) : string => route('bolt.user.form.show', $record))
                    ->openUrlInNewTab(),
            ]);
    }

    public static function getRelations() : array
    {
        return [
            ResponsesRelationManager::class,
        ];
    }

    public static function getPages() : array
    {
        return [
            'index'  => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit'   => Pages\EditForm::route('/{record}/edit'),
        ];
    }

    public static function getWidgets() : array
    {
        return [
            BetaNote::class,
        ];
    }
}
