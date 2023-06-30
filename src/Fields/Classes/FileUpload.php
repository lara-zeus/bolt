<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Bolt\Fields\FieldsContract;

class FileUpload extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\FileUpload::class;

    public int $sort = 11;

    public function title(): string
    {
        return __('File Upload');
    }

    public static function getOptions(): array
    {
        return [
            \Filament\Forms\Components\Toggle::make('options.allow_multiple')->label(__('Allow Multiple')),
            self::required(),
            self::htmlID(),
            self::visibility(),
        ];
    }

    public function getResponse($field, $resp): string
    {
        return view('zeus::filament.fields.file-upload')
            ->with('resp', $resp)
            ->with('field', $field)
            ->render();
    }

    public function appendFilamentComponentsOptions($component, $zeusField)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField);

        $component->disk(config('zeus-bolt.uploads.disk'))
            ->directory(config('zeus-bolt.uploads.directory'));

        if (isset($zeusField->options['allow_multiple']) && $zeusField->options['allow_multiple']) {
            $component = $component->multiple();
        }

        return $component;
    }
}
