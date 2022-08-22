<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select as FilamentSelect;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\Bolt\Models\Collection;

class MultiSelect extends FieldsContract
{
    public $disabled = false;

    public function __construct()
    {
        $this->definition = [
            'type' => 'MultiSelect',
            'title' => 'Select Menu',
            'icon' => 'fa-check',
            'settings_view' => 'list-values',
            'order' => 3,
        ];
    }

    public static function getOptions()
    {
        return [
            FilamentSelect::make('options.dataSource')->required()->options(Collection::pluck('name', 'id'))->label(__('Data Source'))
                /*->createOptionForm([
                    TextInput::make('name')->label(__('Collections Name'))->required()->maxLength(255)->columnSpan(2),
                    Repeater::make('values')
                        ->label(__('Collections Values'))
                        ->schema([
                            TextInput::make('itemKey')->required()->label(__('Key')),
                            TextInput::make('itemValue')->required()->label(__('Value')),
                            Toggle::make('itemIsDefault')->label(__('selected by default')),
                        ])->columnSpan(2)->columns(3),
                ])*/
                ->columnSpan(2),
            Toggle::make('options.is_required')->label(__('Is Required')),
        ];
    }
}
