<?php

namespace LaraZeus\Bolt\Concerns\Schema;

use Exception;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Collection;
use LaraZeus\Bolt\BoltPlugin;
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
                ->getSearchResultsUsing(fn (string $search) => static::getFilteredAvailableFields()
                    ->filter(fn ($q) => str($q['title'])->contains($search, ignoreCase: true))
                    ->mapWithKeys(fn ($field) => [$field['class'] => static::getFieldsTypesOptions($field)])
                    ->toArray())
                ->allowHtml()
                ->extraAttributes(['class' => 'field-type'])
                ->options(fn (): array => static::getFilteredAvailableFields()
                    ->mapWithKeys(fn ($field) => [$field['class'] => static::getFieldsTypesOptions($field)])
                    ->toArray())
                ->getOptionLabelUsing(function (string $value) {
                    $field = Bolt::availableFields()->firstWhere('class', $value);

                    return $field ? static::getFieldsTypesOptions($field) : $value;
                })
                ->live()
                ->default(fn () => static::getDefaultFieldType())
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

    public static function getDefaultFieldType(): string
    {
        $default = BoltPlugin::get()->getDefaultField();

        if ($default !== null) {
            return '\\' . ltrim($default, '\\');
        }

        $filtered = static::getFilteredAvailableFields();

        return $filtered->first()['class'] ?? '\\' . \LaraZeus\Bolt\Fields\Classes\TextInput::class;
    }

    public static function getFilteredAvailableFields(): Collection
    {
        $allFields = Bolt::availableFields();
        $allowedFields = BoltPlugin::get()->getAllowedFields();

        if ($allowedFields === null) {
            return $allFields;
        }

        $normalized = array_map(fn (string $class) => '\\' . ltrim($class, '\\'), $allowedFields);

        return $allFields->filter(fn (array $field) => in_array($field['class'], $normalized));
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
