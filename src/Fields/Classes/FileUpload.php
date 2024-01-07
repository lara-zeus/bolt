<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Hidden;
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

    public static function getOptions(?array $sections = null): array
    {
        return [
            \Filament\Forms\Components\Toggle::make('options.allow_multiple')->label(__('Allow Multiple')),
            self::htmlID(),
            self::hintOptions(),
            self::required(),
            self::columnSpanFull(),
            self::visibility('field', $sections),
        ];
    }

    public static function getOptionsHidden(): array
    {
        return [
            Hidden::make('options.htmlId')->default(str()->random(6)),

            Hidden::make('options.hint.text'),
            Hidden::make('options.hint.icon'),
            Hidden::make('options.hint.color'),

            Hidden::make('options.is_required')->default(false),
            Hidden::make('options.allow_multiple')->default(false),
            Hidden::make('options.column_span_full')->default(false),

            Hidden::make('options.visibility.active'),
            Hidden::make('options.visibility.fieldID'),
            Hidden::make('options.visibility.values'),
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

    // @phpstan-ignore-next-line
    public function appendFilamentComponentsOptions($component, $zeusField)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField);

        $component->disk(config('zeus-bolt.uploadDisk'))
            ->directory(config('zeus-bolt.uploadDirectory'));

        if (isset($zeusField->options['allow_multiple']) && $zeusField->options['allow_multiple']) {
            $component = $component->multiple();
        }

        return $component;
    }
}
