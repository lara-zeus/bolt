<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class FileUpload extends FieldsContract
{
    public $renderClass = '\Filament\Forms\Components\FileUpload';

    public $sort = 11;

    public function title()
    {
        return __('File Upload');
    }

    public static function getOptions()
    {
        return [
            Toggle::make('options.is_required')->label(__('Is Required')),
            Toggle::make('options.is_multiple')->label(__('Allow Multiple')),
        ];
    }

    public function getResponse($field, $resp): string
    {
        return view('zeus-bolt::fields.file-upload')
            ->with('resp', $resp)
            ->with('field', $field)
            ->render();
    }
}
