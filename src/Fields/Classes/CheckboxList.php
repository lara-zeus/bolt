<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\Bolt\Models\Collection;

class CheckboxList extends FieldsContract
{
    public $disabled = false;

    public function __construct()
    {
        $this->definition = [
            'type' => '\Filament\Forms\Components\CheckboxList',
            'title' => __('Checkbox List'),
            'order' => 6,
        ];
    }

    public static function getOptions()
    {
        return [
            Select::make('options.dataSource')->required()->options(Collection::pluck('name', 'id'))->label(__('Data Source'))->columnSpan(2),
            Toggle::make('options.is_required')->label(__('Is Required')),
            \Filament\Forms\Components\TextInput::make('options.columns')->numeric()->required()->default(1),
        ];
    }
}
