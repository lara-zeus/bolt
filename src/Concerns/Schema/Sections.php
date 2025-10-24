<?php

namespace LaraZeus\Bolt\Concerns\Schema;

use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Enums\FontWeight;
use Guava\IconPicker\Forms\Components\IconPicker;
use Illuminate\Support\Str;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Accordion\Forms\Accordions;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\BoltPro\Actions\FieldMarkAction;

trait Sections
{
    /**
     * @throws Exception
     */
    public static function getSectionsSchema(): array
    {
        return [
            TextInput::make('name')
                ->columnSpanFull()
                ->required()
                ->lazy()
                ->label(__('zeus-bolt::forms.section.name')),

            Text::make(__('zeus-bolt::forms.section.fields'))
                ->weight(FontWeight::SemiBold),

            Repeater::make('fields')
                ->defaultItems(1)
                ->minItems(1)
                ->orderColumn('ordering')
                ->relationship()
                ->cloneable()
                ->collapsible()
                ->hiddenLabel()
                ->cloneAction(fn (Action $action) => $action->action(function (Repeater $component, $arguments) {
                    $items = $component->getState();
                    $originalItem = $items[$arguments['item']];
                    $clonedItem = array_merge($originalItem, [
                        'name' => $originalItem['name'] . ' new',
                        'options' => array_merge($originalItem['options'], [
                            'htmlId' => $originalItem['options']['htmlId'] . Str::random(2),
                        ]),
                    ]);

                    $items[] = $clonedItem;
                    $component->state($items);

                    return $items;
                }))
                ->collapsed(fn (string $operation) => $operation === 'edit')
                ->grid([
                    'default' => 1,
                    'md' => 2,
                    'xl' => 3,
                    '2xl' => 3,
                ])
                ->extraItemActions([
                    // @phpstan-ignore-next-line
                    Bolt::hasPro() ? FieldMarkAction::make('marks') : null,

                    Action::make('fields options')
                        ->slideOver()
                        ->color('warning')
                        ->tooltip('more field options')
                        ->icon('heroicon-m-cog')
                        ->modalIcon('heroicon-m-cog')
                        ->modalDescription(__('zeus-bolt::forms.fields.settings'))
                        ->fillForm(
                            fn (array $arguments, Repeater $component) => $component->getItemState($arguments['item'])
                        )
                        ->schema(function (Get $get, array $arguments, Repeater $component) {
                            $allSections = self::getVisibleFields($get('../../sections'), $arguments);

                            return [
                                Textarea::make('description')
                                    ->label(__('zeus-bolt::forms.fields.description')),
                                Group::make()
                                    ->schema(function (Get $get) use ($allSections, $component, $arguments) {
                                        $class = $get('type');
                                        if (class_exists($class)) {
                                            $newClass = (new $class);
                                            if ($newClass->hasOptions()) {
                                                return $newClass->getOptions(
                                                    $allSections,
                                                    $component->getState()[$arguments['item']]
                                                );
                                            }
                                        }

                                        return [];
                                    }),
                            ];
                        })
                        ->action(function (array $data, array $arguments, Repeater $component): void {
                            $state = $component->getState();
                            $state[$arguments['item']] = array_merge($state[$arguments['item']], $data);
                            $component->state($state);
                        }),
                ])
                ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                ->addActionLabel(__('zeus-bolt::forms.fields.add'))
                ->schema(static::getFieldsSchema()),

            Hidden::make('compact')->default(0)->nullable(),
            Hidden::make('aside')->default(0)->nullable(),
            Hidden::make('borderless')->default(0)->nullable(),
            Hidden::make('icon')->nullable(),
            Hidden::make('columns')->default(1)->nullable(),
            Hidden::make('description')->nullable(),
            Hidden::make('options.visibility.active')->default(0)->nullable(),
            Hidden::make('options.visibility.fieldID')->nullable(),
            Hidden::make('options.visibility.values')->nullable(),
            ...Bolt::getHiddenCustomSchema('section') ?? [],
        ];
    }

    protected static function sectionOptionsFormSchema(array $formOptions, array $allSections): array
    {
        return [
            TextInput::make('description')
                ->hidden(fn (Get $get) => $get('borderless') === true)
                ->nullable()
                ->live()
                ->visible($formOptions['show-as'] !== 'tabs')
                ->label(__('zeus-bolt::forms.section.description')),

            Accordions::make('section-options')
                ->accordions(fn () => array_filter([
                    Accordion::make('visual-options')
                        ->label(__('zeus-bolt::forms.section.options.visual_options'))
                        ->columns()
                        ->icon('tabler-list-details')
                        ->schema([
                            Select::make('columns')
                                ->options(fn (): array => array_combine(range(1, 12), range(1, 12)))
                                ->required()
                                ->default(1)
                                ->hint(__('zeus-bolt::forms.section.options.columns_hint'))
                                ->label(__('zeus-bolt::forms.section.options.columns_label')),
                            IconPicker::make('icon')
                                ->columns([
                                    'default' => 1,
                                    'lg' => 3,
                                    '2xl' => 5,
                                ])
                                ->visible(fn (Get $get) => $formOptions['show-as'] === 'page' && $get('borderless') === false)
                                ->label(__('zeus-bolt::forms.section.options.icon')),
                            Toggle::make('aside')
                                ->default(false)
                                ->visible(fn (
                                    Get $get
                                ) => $formOptions['show-as'] === 'page' && $get('borderless') === false)
                                ->label(__('zeus-bolt::forms.section.options.aside')),
                            Toggle::make('borderless')
                                ->live()
                                ->default(false)
                                ->visible($formOptions['show-as'] === 'page')
                                ->label(__('zeus-bolt::forms.section.options.borderless'))
                                ->belowContent(__('zeus-bolt::forms.section.options.borderless_help')),
                            Toggle::make('compact')
                                ->default(false)
                                ->visible(fn (
                                    Get $get
                                ) => $formOptions['show-as'] === 'page' && $get('borderless') === false)
                                ->label(__('zeus-bolt::forms.section.options.compact')),
                        ]),
                    self::visibility($allSections),
                    Bolt::getCustomSchema('section') ?? [],
                ])),
        ];
    }
}
