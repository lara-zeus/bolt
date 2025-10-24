<?php

namespace LaraZeus\Bolt\Concerns;

use Exception;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ViewField;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Concerns\Schema\Fields;
use LaraZeus\Bolt\Concerns\Schema\Sections;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Models\Category;
use LaraZeus\BoltPro\Actions\SectionMarkAction;

trait Schemata
{
    use Fields;
    use Sections;

    protected static function getVisibleFields(array $sections, array $arguments): array
    {
        // @phpstan-ignore-next-line
        return collect($sections)
            ->map(function (array $sections) use ($arguments) {
                // @phpstan-ignore-next-line
                $sections['fields'] = collect($sections['fields'])
                    ->reject(function ($item, $key) use ($arguments) {
                        return $key === $arguments['item'] ||
                            ! (
                                isset($item['options']['dataSource']) ||
                                $item['type'] === '\LaraZeus\Bolt\Fields\Classes\Toggle'
                            );
                    })->all();

                return $sections;
            })->all();
    }

    /**
     * @throws Exception
     */
    public static function getMainFormSchema(): array
    {
        return [
            Hidden::make('user_id')->default(auth()->user()->id ?? null),

            Tabs::make('form-tabs')
                ->tabs(static::getTabsSchema())
                ->columnSpan(2),

            Repeater::make('sections')
                ->hiddenLabel()
                ->schema(static::getSectionsSchema())
                ->relationship()
                ->orderColumn('ordering')
                ->addActionLabel(__('zeus-bolt::forms.section.options.add'))
                ->cloneable()
                ->collapsible()
                ->collapsed(fn (string $operation) => $operation === 'edit')
                ->minItems(1)
                ->extraItemActions([
                    // @phpstan-ignore-next-line
                    Bolt::hasPro() ? SectionMarkAction::make('marks') : null,

                    Action::make('options')
                        ->label(__('zeus-bolt::forms.section.options.title'))
                        ->slideOver()
                        ->color('warning')
                        ->tooltip(__('zeus-bolt::forms.section.options.more'))
                        ->icon('heroicon-m-cog')
                        ->modalIcon('heroicon-m-cog')
                        ->modalHeading(
                            fn (array $arguments, Repeater $component) => optional(optional($component->getState())[optional($arguments)['item']])['name'] ?? ''
                        )
                        ->modalDescription(__('zeus-bolt::forms.section.options.title'))
                        ->fillForm(fn (
                            array $arguments,
                            Repeater $component
                        ) => $component->getItemState($arguments['item']))
                        ->schema(function (array $arguments, Get $get) {
                            $formOptions = $get('options');
                            $allSections = $get('sections');
                            unset($allSections[$arguments['item']]);

                            $allSections = self::getVisibleFields($allSections, $arguments);

                            return static::sectionOptionsFormSchema($formOptions, $allSections);
                        })
                        ->action(function (array $data, array $arguments, Repeater $component): void {
                            $state = $component->getState();
                            $state[$arguments['item']] = array_merge($state[$arguments['item']], $data);
                            $component->state($state);
                        }),
                ])
                ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                ->columnSpan(2),
        ];
    }

    public static function getTabsSchema(): array
    {
        $tabs = [
            Tab::make('title-slug-tab')
                ->label(__('zeus-bolt::forms.options.tabs.title.label'))
                ->columns()
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->label(__('zeus-bolt::forms.options.tabs.title.name'))
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
                        ->unique()
                        ->label(__('zeus-bolt::forms.options.tabs.title.slug')),

                    Select::make('category_id')
                        ->label(__('zeus-bolt::forms.options.tabs.title.category.label'))
                        ->searchable()
                        ->preload()
                        ->relationship(
                            'category',
                            'name',
                            modifyQueryUsing: function (Builder $query) {
                                if (Filament::getTenant() === null) {
                                    return $query;
                                }

                                return BoltPlugin::getModel('Category')::query()->whereBelongsTo(Filament::getTenant());
                            },
                        )
                        ->belowContent(__('zeus-bolt::forms.options.tabs.title.category.hint'))
                        ->createOptionForm([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->label(__('zeus-bolt::forms.options.tabs.title.category.name'))
                                ->afterStateUpdated(function (Set $set, $state, $context) {
                                    if ($context === 'edit') {
                                        return;
                                    }
                                    $set('slug', Str::slug($state));
                                }),
                            TextInput::make('slug')
                                ->required()
                                ->maxLength(255)
                                ->label(__('zeus-bolt::forms.options.tabs.title.category.slug')),
                        ])
                        ->createOptionAction(fn (Action $action) => $action->hidden(auth()->user()->cannot(
                            'create',
                            BoltPlugin::getModel('Category')
                        )))
                        ->getOptionLabelFromRecordUsing(fn (Category $record) => $record->name),
                ]),

            Tab::make('text-details-tab')
                ->label(__('zeus-bolt::forms.options.tabs.details.label'))
                ->schema([
                    Textarea::make('description')
                        ->label(__('zeus-bolt::forms.options.tabs.details.description'))
                        ->belowContent(__('zeus-bolt::forms.options.tabs.details.description_help')),
                    RichEditor::make('details')
                        ->label(__('zeus-bolt::forms.options.tabs.details.details'))
                        ->belowContent(__('zeus-bolt::forms.options.tabs.details.details_help'))
                        ->dehydrateStateUsing(fn ($state) => filled(strip_tags($state)) ? $state : null),
                    RichEditor::make('options.confirmation-message')
                        ->label(__('zeus-bolt::forms.options.tabs.details.confirmation_message'))
                        ->belowContent(__('zeus-bolt::forms.options.tabs.details.confirmation_message_help'))
                        ->dehydrateStateUsing(fn ($state) => filled(strip_tags($state)) ? $state : null),
                ]),

            Tab::make('display-access-tab')
                ->label(__('zeus-bolt::forms.options.tabs.display.label'))
                ->columns()
                ->schema([
                    Grid::make()
                        ->columnSpan(1)
                        ->columns(1)
                        ->schema([
                            Toggle::make('is_active')
                                ->label(__('zeus-bolt::forms.options.tabs.display.is_active'))
                                ->default(1)
                                ->belowContent(__('zeus-bolt::forms.options.tabs.display.is_active_help')),
                            Toggle::make('options.require-login')
                                ->label(__('zeus-bolt::forms.options.tabs.display.require_login'))
                                ->belowContent(__('zeus-bolt::forms.options.tabs.display.require_login_help'))
                                ->live(),
                            Toggle::make('options.one-entry-per-user')
                                ->label(__('zeus-bolt::forms.options.tabs.display.one_entry_per_user'))
                                ->belowContent(__('zeus-bolt::forms.options.tabs.display.one_entry_per_user_help'))
                                ->visible(function (Get $get) {
                                    return $get('options.require-login');
                                }),
                        ]),
                    Grid::make()
                        ->columnSpan(1)
                        ->columns(1)
                        ->schema([
                            Radio::make('options.show-as')
                                ->label(__('zeus-bolt::forms.options.tabs.display.show_as.label'))
                                ->live()
                                ->default('page')
                                ->descriptions([
                                    'page' => __('zeus-bolt::forms.options.tabs.display.show_as.type_desc.page'),
                                    'wizard' => __('zeus-bolt::forms.options.tabs.display.show_as.type_desc.wizard'),
                                    'tabs' => __('zeus-bolt::forms.options.tabs.display.show_as.type_desc.tabs'),
                                ])
                                ->options([
                                    'page' => __('zeus-bolt::forms.options.tabs.display.show_as.type.page'),
                                    'wizard' => __('zeus-bolt::forms.options.tabs.display.show_as.type.wizard'),
                                    'tabs' => __('zeus-bolt::forms.options.tabs.display.show_as.type.tabs'),
                                ]),
                        ]),

                    TextInput::make('ordering')
                        ->numeric()
                        ->label(__('zeus-bolt::forms.options.tabs.display.ordering'))
                        ->default(1),
                ]),

            Tab::make('advanced-tab')
                ->label(__('zeus-bolt::forms.options.tabs.advanced.label'))
                ->schema([
                    Grid::make()
                        ->columnSpanFull()
                        ->columns()
                        ->schema([
                            TextEntry::make('form-dates')
                                ->label(__('zeus-bolt::forms.options.tabs.advanced.dates'))
                                ->state(__('zeus-bolt::forms.options.tabs.advanced.dates_help'))
                                ->columnSpanFull(),
                            DateTimePicker::make('start_date')
                                ->requiredWith('end_date')
                                ->label(__('zeus-bolt::forms.options.tabs.advanced.start_date')),
                            DateTimePicker::make('end_date')
                                ->requiredWith('start_date')
                                ->label(__('zeus-bolt::forms.options.tabs.advanced.end_date')),
                        ]),
                    Grid::make()
                        ->columnSpanFull()
                        ->columns()
                        ->schema([
                            TextInput::make('options.emails-notification')
                                ->label(__('zeus-bolt::forms.options.tabs.advanced.emails_notifications'))
                                ->belowContent(__('zeus-bolt::forms.options.tabs.advanced.emails_notifications_help')),
                        ]),
                ]),

            Tab::make('extensions-tab')
                ->label(__('zeus-bolt::forms.options.tabs.extensions.label'))
                ->visible(BoltPlugin::get()->getExtensions() !== null)
                ->schema([
                    Select::make('extensions')
                        ->label(__('zeus-bolt::forms.options.tabs.extensions.label'))
                        ->preload()
                        ->live()
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

            Tab::make('design')
                ->columns()
                ->label(__('zeus-bolt::forms.options.tabs.design.label'))
                ->visible(Bolt::hasPro() && config('zeus-bolt.allow_design'))
                ->schema([
                    ViewField::make('options.primary_color')
                        ->hiddenLabel()
                        ->columnSpanFull()
                        ->view('zeus::filament.components.color-picker'),
                    FileUpload::make('options.logo')
                        ->disk(config('zeus-bolt.uploadDisk'))
                        ->directory(config('zeus-bolt.uploadDirectory'))
                        ->visibility(config('zeus-bolt.uploadVisibility'))
                        ->image()
                        ->imageEditor()
                        ->label(__('zeus-bolt::forms.options.tabs.design.logo')),
                    FileUpload::make('options.cover')
                        ->disk(config('zeus-bolt.uploadDisk'))
                        ->directory(config('zeus-bolt.uploadDirectory'))
                        ->visibility(config('zeus-bolt.uploadVisibility'))
                        ->image()
                        ->imageEditor()
                        ->label(__('zeus-bolt::forms.options.tabs.design.cover')),
                ]),
        ];

        $customSchema = Bolt::getCustomSchema('form');

        if ($customSchema !== null) {
            $tabs[] = $customSchema;
        }

        return $tabs;
    }
}
