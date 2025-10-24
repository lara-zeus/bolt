<?php

namespace LaraZeus\Bolt\Concerns\Schema;

use Exception;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use LaraZeus\Bolt\Facades\Bolt;
use Throwable;

trait Fields
{
    /**
     * @throws Exception
     */
    public static function getFieldsSchema(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->lazy()
                ->label(__('zeus-bolt::forms.fields.name')),
            Select::make('type')
                ->required()
                ->searchable()
                ->preload()
                ->getSearchResultsUsing(fn (string $search) => Bolt::availableFields()
                    ->filter(fn ($q) => str($q['title'])->contains($search, ignoreCase: true))
                    ->mapWithKeys(fn ($field) => [$field['class'] => static::getFieldsTypesOptions($field)])
                    ->toArray())
                ->allowHtml()
                ->extraAttributes(['class' => 'field-type'])
                ->options(fn (): array => Bolt::availableFields()
                    ->mapWithKeys(fn ($field) => [$field['class'] => static::getFieldsTypesOptions($field)])
                    ->toArray())
                ->live()
                ->default('\LaraZeus\Bolt\Fields\Classes\TextInput')
                ->label(__('zeus-bolt::forms.fields.type')),

            Hidden::make('description'),
            Group::make()
                ->schema(function (Get $get) {
                    $class = $get('type');
                    if (class_exists($class)) {
                        $newClass = (new $class);
                        if ($newClass->hasOptions()) {
                            // @phpstan-ignore-next-line
                            return collect($newClass->getOptionsHidden())->flatten()->toArray();
                        }
                    }

                    return [];
                }),
        ];
    }

    /**
     * @throws Throwable
     */
    public static function getFieldsTypesOptions(array $field): string
    {
        return
            view('zeus::filament.fields.types')
                ->with('field', $field)
                ->render();
    }
}
