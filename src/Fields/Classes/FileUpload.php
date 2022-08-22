<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class FileUpload extends FieldsContract
{
    public $disabled = false;

    public function __construct()
    {
        $this->definition = [
            'type' => '\Filament\Forms\Components\FileUpload',
            'title' => __('File Upload'),
            'order' => 11,
        ];
    }

    public static function getOptions()
    {
        return [
            Toggle::make('options.is_required')->label(__('Is Required')),
            Toggle::make('options.is_multiple')->label(__('Allow Multiple')),
        ];
    }
}
