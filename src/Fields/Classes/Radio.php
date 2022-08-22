<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\Bolt\Models\Collection;

class Radio extends FieldsContract
{
    public $disabled = false;

    public function __construct()
    {
        $this->definition = [
            'type' => '\Filament\Forms\Components\Radio',
            'title' => __('Radio'),
            'order' => 4,
        ];
    }

    public static function getOptions()
    {
        return [
            Select::make('options.dataSource')->required()->options(Collection::pluck('name', 'id'))->label(__('Data Source'))->columnSpan(2),
            Toggle::make('options.is_required')->label(__('Is Required')),
            Toggle::make('options.is_inline')->label(__('Is inline')),
        ];
    }
}
