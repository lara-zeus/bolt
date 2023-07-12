<?php

namespace LaraZeus\Bolt\Concerns;

use Closure;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Guava\FilamentIconPicker\Forms\IconPicker;
use Illuminate\Support\Str;
use LaraZeus\Bolt\Facades\Bolt;

trait Schemata
{
    public static function getMainFormSchemaForView(): array
    {
        return [
            Hidden::make('user_id')->default(auth()->user()->id ?? null),

            Card::make()
                ->schema([
                    TextInput::make('name')
                        ->maxLength(255)
                        ->reactive()
                        ->label(__('Form Name')),
                ]),
        ];
    }

    public static function getMainFormSchema(): array
    {
        return [
            Hidden::make('user_id')->default(auth()->user()->id ?? null),

            Tabs::make('form-tabs')
                ->tabs(static::getTabsSchema())
                ->columnSpan(2),
            Card::make()
                ->schema([
                    Placeholder::make('section-title-placeholder')
                        ->label(__('Sections'))
                        ->helperText(__('sections are here to group the fields, and you can display it as pages from the Form options. if you have one section, it wont show in the form')),
                ]),

            Repeater::make('sections')
                ->label('')
                ->schema(static::getSectionsSchema())
                ->relationship()
                ->orderable('ordering')
                ->createItemButtonLabel(__('Add Section'))
                ->cloneable()
                ->collapsible()
                ->collapsed()
                ->minItems(1)
                ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                ->columnSpan(2),
        ];
    }

    public static function getTabsSchema(): array
    {
        return [
            Tabs\Tab::make('title-slug-tab')
                ->label(__('Title & Slug'))
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->hint(__('Translatable'))
                        ->hintIcon('heroicon-s-translate')
                        ->required()
                        ->maxLength(255)
                        ->reactive()
                        ->label(__('Form Name'))
                        ->afterStateUpdated(function (Closure $set, $state, $context) {
                            if ($context === 'edit') {
                                return;
                            }
                            $set('slug', Str::slug($state));
                        }),
                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->rules(['alpha_dash'])
                        ->unique(ignoreRecord: true)
                        ->label(__('Form Slug')),
                ]),
            Tabs\Tab::make('text-details-tab')
                ->label(__('Text & Details'))
                ->schema([
                    Textarea::make('description')
                        ->hint(__('Translatable'))
                        ->hintIcon('heroicon-s-translate')
                        ->label(__('Form Description'))
                        ->helperText(__('shown under the title of the form and used in SEO')),
                    RichEditor::make('details')
                        ->hint(__('Translatable'))
                        ->hintIcon('heroicon-s-translate')
                        ->label(__('Form Details'))
                        ->helperText(__('a highlighted section above the form, to show some instructions or more details')),
                    RichEditor::make('options.confirmation-message')
                        ->label(__('Confirmation Message'))
                        ->helperText(__('optional, show a massage whenever any one submit a new entry')),
                ]),
            Tabs\Tab::make('display-access-tab')
                ->label(__('Display & Access'))
                ->columns(2)
                ->schema([
                    Toggle::make('is_active')
                        ->label(__('Is Active'))
                        ->default(1)
                        ->helperText(__('Activate the form and let users start submissions')),
                    Toggle::make('options.require-login')
                        ->label(__('require Login'))
                        ->helperText(__('User must be logged in or create an account before can submit a new entry'))
                        ->reactive(),
                    Toggle::make('options.one-entry-per-user')
                        ->label(__('One Entry Per User'))
                        ->helperText(__('to check if the user already submitted an entry in this form'))
                        ->visible(function (Closure $get) {
                            return $get('options.require-login');
                        }),

                    Radio::make('options.show-as')
                        ->label(__('Show the form as'))
                        ->reactive()
                        ->default('page')
                        ->descriptions([
                            'page' => __('show all sections on one page'),
                            'wizard' => __('separate each section in steps'),
                            'tabs' => __('Show the Form as Tabs'),
                        ])
                        ->options([
                            'page' => __('Show on one page'),
                            'wizard' => __('Show As Wizard'),
                            'tabs' => __('Show As Tabs'),
                        ]),
                    TextInput::make('ordering')
                        ->label(__('ordering'))
                        ->default(1),
                ]),
            Tabs\Tab::make('advanced-tab')
                ->label(__('Advanced'))
                ->schema([
                    Select::make('category_id')
                        ->label(__('Category'))
                        ->helperText(__('optional, organize your forms into categories'))
                        ->options(config('zeus-bolt.models.Category')::pluck('name', 'id')),
                    Grid::make()
                        ->columns(2)
                        ->schema([
                            Placeholder::make('form-dates')
                                ->label(__('Form Dates'))
                                ->content(__('optional, specify when the form will be active and receiving new entries'))
                                ->columnSpan(2),
                            DateTimePicker::make('start_date')
                                ->requiredWith('end_date')
                                ->label(__('Start Date')),
                            DateTimePicker::make('end_date')
                                ->requiredWith('start_date')
                                ->label(__('End Date')),
                        ]),
                    Grid::make()
                        ->columns(2)
                        ->schema([
                            TextInput::make('options.emails-notification')
                                ->label(__('Emails Notifications'))
                                ->helperText(__('optional, enter the emails (comma separated) you want to receive notification when ever you got a new entry')),
                            /*TextInput::make('options.web-hook')
                                ->label(__('enter webHook URL'))
                                ->helperText(__('Send the form data to a webHook')),*/
                        ]),
                ]),

            Tabs\Tab::make('extensions-tab')
                ->label(__('Extensions'))
                ->visible(config('zeus-bolt.extensions') !== null)
                ->schema([
                    Select::make('extensions')
                        ->label(__('Extensions'))
                        ->preload()
                        ->options(function () {
                            return collect(config('zeus-bolt.extensions'))
                                ->mapWithKeys(function ($item): array {
                                    if (class_exists($item)) {
                                        return [$item => (new $item)->label()];
                                    }

                                    return [$item => $item];
                                });
                        }),
                ]),
        ];
    }

    public static function getSectionsSchema(): array
    {
        return [
            Grid::make()
                ->columns(2)
                ->schema([
                    Tabs::make('section-tab')
                        ->columnSpan(2)
                        ->tabs([
                            Tabs\Tab::make('section-info-tab')
                                ->label(__('Section Info'))
                                ->schema([
                                    TextInput::make('name')
                                        ->required()
                                        ->lazy()
                                        ->label(__('Section Name')),
                                ]),
                            Tabs\Tab::make('section-details-tab')
                                ->label(__('Section Details'))
                                ->columns(2)
                                ->schema([
                                    TextInput::make('description')
                                        ->nullable()
                                        ->visible(fn (Closure $get) => $get('../../options.show-as') !== 'tabs')
                                        ->label(__('Section Description')),

                                    TextInput::make('columns')
                                        ->required()
                                        ->default(1)
                                        ->minValue(1)
                                        ->maxValue(12)
                                        ->hint(__('From 1-12'))
                                        ->label(__('Section Columns')),

                                    IconPicker::make('icon')
                                        ->visible(fn (Closure $get) => $get('../../options.show-as') === 'wizard' || $get('../../options.show-as') === 'tabs')
                                        ->label(__('Section icon')),

                                    Toggle::make('aside')
                                        ->visible(fn (Closure $get) => $get('../../options.show-as') !== 'wizard' && $get('../../options.show-as') !== 'tabs')
                                        ->label(__('show as aside')),
                                ]),
                        ]),
                ]),
            Placeholder::make('section-fields-placeholder')
                ->label(__('Section Fields')),
            Repeater::make('fields')
                ->relationship()
                ->label('')
                ->orderable('ordering')
                ->cloneable()
                ->minItems(1)
                ->collapsible()
                ->collapsed()
                ->grid([
                    'default' => 1,
                    'md' => 2,
                    'xl' => 3,
                    '2xl' => 4,
                ])
                ->label('')
                ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                ->createItemButtonLabel(__('Add field'))
                ->schema(static::getFieldsSchema()),
        ];
    }

    public static function getFieldsSchema(): array
    {
        return [
            Tabs::make('fields-tab')
                ->tabs([
                    Tabs\Tab::make('type-text-tab')
                        ->icon('heroicon-o-menu-alt-2')
                        ->label(__('Type & title'))
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->lazy()
                                ->label(__('Field Name')),
                            Textarea::make('description')
                                ->label(__('Field Description')),
                            Select::make('type')
                                ->required()
                                ->options(Bolt::availableFields()->pluck('title', 'class'))
                                ->reactive()
                                ->default('\LaraZeus\Bolt\Fields\Classes\TextInput')
                                ->label(__('Field Type')),
                        ]),
                    Tabs\Tab::make('options-tab')
                        ->label(__('Options'))
                        ->icon('heroicon-o-cog')
                        ->schema([
                            Grid::make()
                                ->columns([
                                    'default' => 1,
                                    'lg' => 2,
                                ])
                                ->label(__('Field Options'))
                                ->visible(function (Closure $get) {
                                    $class = $get('type');
                                    if (class_exists($class)) {
                                        return (new $class)->hasOptions();
                                    }

                                    return false;
                                })
                                ->schema(function (Closure $get) {
                                    return $get('type')::getOptions();
                                })
                                ->columns(1),
                        ]),
                ]),
        ];
    }
}
