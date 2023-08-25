<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Field as FilamentField;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\FieldResponse;

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

    public function getResponse(Field $field, FieldResponse $resp): string
    {
        $responseValue = (filled($resp->response) && Bolt::isJson($resp->response)) ? json_decode($resp->response) : [$resp->response];

        return view('zeus::filament.fields.file-upload')
            ->with('resp', $resp)
            ->with('responseValue', $responseValue)
            ->with('field', $field)
            ->render();
    }

    public function appendFilamentComponentsOptions(FilamentField $component, Field $zeusField): FilamentField
    {
        parent::appendFilamentComponentsOptions($component, $zeusField);

        // @phpstan-ignore-next-line
        $component->disk(BoltPlugin::get()->getUploadDisk())
            ->directory(BoltPlugin::get()->getUploadDirectory());

        if (isset($zeusField->options['allow_multiple']) && $zeusField->options['allow_multiple']) {
            // @phpstan-ignore-next-line
            $component = $component->multiple();
        }

        return $component;
    }
}
