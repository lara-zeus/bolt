<?php

namespace LaraZeus\Bolt\Concerns;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Guava\FilamentIconPicker\Forms\IconPicker;
use Illuminate\Support\Str;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Models\Category;

trait Schemata
{
    public static function getMainFormSchema(): array
    {
        return [
            Hidden::make('user_id')->default(auth()->user()->id ?? null),

            Tabs::make('form-tabs')
                ->tabs(static::getTabsSchema())
                ->columnSpan(2),
            Section::make()
                ->schema([
                    Placeholder::make('section-title-placeholder')
                        ->label(__('Sections'))
                        ->helperText(__('sections are here to group the fields, and you can display it as pages from the Form options. if you have one section, it wont show in the form')),
                ]),

            Repeater::make('sections')
                ->label('')
                ->schema(static::getSectionsSchema())
                ->relationship()
                ->orderColumn('ordering')
                ->addActionLabel(__('Add Section'))
                ->cloneable()
                ->collapsible()
                ->collapsed(fn (string $operation) => $operation === 'edit')
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
                        ->hintIcon('heroicon-s-language')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->label(__('Form Name'))
                        ->afterStateUpdated(function (Set $set, $state, $context) {
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
                        ->hintIcon('heroicon-s-language')
                        ->label(__('Form Description'))
                        ->helperText(__('shown under the title of the form and used in SEO')),
                    RichEditor::make('details')
                        ->hint(__('Translatable'))
                        ->hintIcon('heroicon-s-language')
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
                        ->live(),
                    Toggle::make('options.one-entry-per-user')
                        ->label(__('One Entry Per User'))
                        ->helperText(__('to check if the user already submitted an entry in this form'))
                        ->visible(function (Get $get) {
                            return $get('options.require-login');
                        }),

                    Radio::make('options.show-as')
                        ->label(__('Show the form as'))
                        ->live()
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
                        ->searchable()
                        ->preload()
                        ->relationship('category', 'name')
                        ->helperText(__('optional, organize your forms into categories'))
                        ->createOptionForm([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->label(__('Name'))
                                ->afterStateUpdated(function (Set $set, $state, $context) {
                                    if ($context === 'edit') {
                                        return;
                                    }
                                    $set('slug', Str::slug($state));
                                }),
                            TextInput::make('slug')->required()->maxLength(255)->label(__('slug')),
                        ])
                        ->getOptionLabelFromRecordUsing(fn (Category $record) => "{$record->name}"),
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
                        ]),
                ]),

            Tabs\Tab::make('extensions-tab')
                ->label(__('Extensions'))
                ->visible(BoltPlugin::get()->getExtensions() !== null)
                ->schema([
                    Select::make('extensions')
                        ->label(__('Extensions'))
                        ->preload()
                        ->options(function () {
                            // @phpstan-ignore-next-line
                            return collect(BoltPlugin::get()->getExtensions())
                                ->mapWithKeys(function (string $item): array {
                                    if (class_exists($item)) {
                                        return [$item => (new $item)->label()];
                                    }

                                    return [$item => $item];
                                });
                        }),
                ]),

            Tabs\Tab::make('embed-tab')
                ->label(__('Embed'))
                ->visible(fn (
                    string $operation
                ): bool => class_exists(\LaraZeus\Sky\SkyServiceProvider::class) && $operation === 'edit')
                ->schema([
                    TextInput::make('form_embed')
                        ->label(__('to embed the form in any post or page'))
                        ->dehydrated(false)
                        ->disabled()
                        ->formatStateUsing(function (Get $get) {
                            return '<bolt>' . $get('slug') . '</bolt>';
                        }),
                ]),

            Tabs\Tab::make('design')
                ->label(__('Design'))
                ->visible(fn (): bool => class_exists(\LaraZeus\BoltPro\BoltProServiceProvider::class) && config('zeus-bolt.allow_design'))
                ->schema([
                    ViewField::make('options.primary_color')
                        ->view('zeus::filament.components.color-picker'),
                    FileUpload::make('options.logo')
                        ->disk(config('zeus-bolt.uploadDisk'))
                        ->directory(config('zeus-bolt.uploadDisk'))
                        ->image()
                        ->imageEditor()
                        ->label(__('Logo')),
                    FileUpload::make('options.cover')
                        ->disk(config('zeus-bolt.uploadDisk'))
                        ->directory(config('zeus-bolt.uploadDisk'))
                        ->image()
                        ->imageEditor()
                        ->label(__('Cover')),
                ]),
        ];
    }

    public static function getSectionsSchema(): array
    {
        return [
            Grid::make()
                ->columns()
                ->schema([
                    Tabs::make('section-tab')
                        ->columnSpan(2)
                        ->tabs([
                            Tabs\Tab::make('section-info-tab')
                                ->label(__('Section Info'))
                                ->schema([
                                    TextInput::make('name')
                                        ->hint(__('Translatable'))
                                        ->hintIcon('heroicon-s-language')
                                        ->required()
                                        ->lazy()
                                        ->label(__('Section Name')),
                                    TextInput::make('description')
                                        ->nullable()
                                        ->visible(fn (Get $get) => $get('../../options.show-as') !== 'tabs')
                                        ->label(__('Section Description')),
                                ]),
                            Tabs\Tab::make('section-details-tab')
                                ->label(__('Section Details'))
                                ->columns(2)
                                ->schema([
                                    Select::make('columns')
                                        ->options(fn (): array => array_combine(range(1, 12), range(1, 12)))
                                        ->required()
                                        ->default(1)
                                        ->hint(__('fields per row'))
                                        ->label(__('Section Columns')),
                                    IconPicker::make('icon')
                                        ->columns([
                                            'default' => 1,
                                            'lg' => 3,
                                            '2xl' => 5,
                                        ])
                                        ->label(__('Section icon')),

                                    Toggle::make('aside')
                                        ->inline(false)
                                        ->visible(fn (Get $get) => $get('../../options.show-as') === 'page')
                                        ->label(__('show as aside')),

                                    Toggle::make('compact')
                                        ->inline(false)
                                        ->visible(fn (Get $get) => $get('../../options.show-as') === 'page')
                                        ->label(__('compact section')),
                                    self::visibility(),
                                ]),
                        ]),
                ]),
            Placeholder::make('section-fields-placeholder')
                ->label(__('Section Fields')),
            Repeater::make('fields')
                ->relationship()
                ->orderColumn('ordering')
                ->cloneable()
                ->minItems(1)
                ->collapsible()
                ->collapsed(fn (string $operation) => $operation === 'edit')
                ->grid([
                    'default' => 1,
                    'md' => 2,
                    'xl' => 3,
                    '2xl' => 3,
                ])
                ->label('')
                ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                ->addActionLabel(__('Add field'))
                ->schema(static::getFieldsSchema()),
        ];
    }

    public static function getFieldsSchema(): array
    {
        return [
            Tabs::make('fields-tab')
                ->tabs([
                    Tabs\Tab::make('type-text-tab')
                        ->icon('heroicon-o-bars-3-bottom-left')
                        ->label(__('Type & title'))
                        ->schema([
                            TextInput::make('name')
                                ->hint(__('Translatable'))
                                ->hintIcon('heroicon-s-language')
                                ->required()
                                ->lazy()
                                ->label(__('Field Name')),
                            Textarea::make('description')
                                ->label(__('Field Description')),
                            Select::make('type')
                                ->required()
                                ->options(Bolt::availableFields()->pluck('title', 'class'))
                                ->live()
                                ->default('\LaraZeus\Bolt\Fields\Classes\TextInput')
                                ->label(__('Field Type')),
                        ]),
                    Tabs\Tab::make('options-tab')
                        ->visible(function (Get $get) {
                            $class = $get('type');
                            if (class_exists($class)) {
                                return (new $class)->hasOptions();
                            }

                            return false;
                        })
                        ->label(__('Options'))
                        ->icon('heroicon-o-cog')
                        ->schema([
                            Grid::make()
                                ->columns([
                                    'default' => 1,
                                    'lg' => 2,
                                ])
                                ->label(__('Field Options'))
                                ->schema(function (Get $get) {
                                    $class = $get('type');
                                    if (class_exists($class)) {
                                        $newClass = (new $class);
                                        if ($newClass->hasOptions()) {
                                            return $newClass->getOptions();
                                        }
                                    }

                                    return [];
                                })
                                ->columns(1),
                        ]),
                ]),
        ];
    }
}
