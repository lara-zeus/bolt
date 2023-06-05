<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class FileUpload extends FieldsContract
{
    public string $renderClass = '\Filament\Forms\Components\FileUpload';

    public int $sort = 11;

    public function title(): string
    {
        return __('File Upload');
    }

    public static function getOptions(): array
    {
        return [
            Toggle::make('options.is_required')->label(__('Is Required')),
            Toggle::make('options.is_multiple')->label(__('Allow Multiple')),
            \Filament\Forms\Components\TextInput::make('options.htmlId')
                ->default(str()->random(6))
                ->label(__('HTML ID')),
        ];
    }

    public function getResponse($field, $resp): string
    {
        return view('zeus-bolt::filament.fields.file-upload')
            ->with('resp', $resp)
            ->with('field', $field)
            ->render();
    }

    public function appendFilamentComponentsOptions($component, $zeusField)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField);

        $component->disk(config('zeus-bolt.uploads.disk'))
            ->directory(config('zeus-bolt.uploads.directory'));

        return $component;
    }
}
