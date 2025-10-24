<?php

namespace LaraZeus\Bolt\Concerns\Options;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Bolt\Fields\FieldsContract;
use Livewire\Component as Livewire;

trait Visibility
{
    public static function visibility(?array $getFields = []): Accordion
    {
        if (filled($getFields)) {
            $getFields = collect($getFields)
                ->pluck('fields')
                ->mapWithKeys(function (array $item) {
                    return $item;
                });
        }

        return Accordion::make('visibility-options')
            ->label(__('zeus-bolt::forms.options.conditional_visibility.title'))
            ->icon('tabler-eye-cog')
            ->visible(fn (Livewire $livewire) => str($livewire->getName())
                ->replace('-form', '')
                ->explode('.')
                ->last() === 'edit')
            ->schema([
                Toggle::make('options.visibility.active')
                    ->live()
                    ->label(__('zeus-bolt::forms.options.conditional_visibility.label')),

                Select::make('options.visibility.fieldID')
                    ->label(__('zeus-bolt::forms.options.conditional_visibility.field'))
                    ->live()
                    ->searchable(false)
                    ->visible(fn (Get $get): bool => ! empty($get('options.visibility.active')))
                    ->required(fn (Get $get): bool => ! empty($get('options.visibility.active')))
                    ->options(optional($getFields)->pluck('name', 'id')),

                Select::make('options.visibility.values')
                    ->label(__('zeus-bolt::forms.options.conditional_visibility.values'))
                    ->live()
                    ->searchable(false)
                    ->required(fn (Get $get): bool => ! empty($get('options.visibility.fieldID')))
                    ->visible(fn (Get $get): bool => ! empty($get('options.visibility.fieldID')))
                    ->options(function (Get $get) use ($getFields) {
                        $getRelated = $getFields->where('id', $get('options.visibility.fieldID'))->first();

                        if ($get('options.visibility.fieldID') === null) {
                            return [];
                        }

                        if ($getRelated['type'] === '\LaraZeus\Bolt\Fields\Classes\Toggle') {
                            return [
                                'true' => __('zeus-bolt::forms.options.checked'),
                                'false' => __('zeus-bolt::forms.options.not_checked'),
                            ];
                        }

                        if (! isset($getRelated['options']['dataSource'])) {
                            return [];
                        }

                        return FieldsContract::getFieldCollectionItemsList($getRelated);
                    }),
            ]);
    }
}
