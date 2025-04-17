<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Storage;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Accordion\Forms\Accordions;
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

    public function icon(): string
    {
        return 'tabler-cloud-upload';
    }

    public function description(): string
    {
        return __('single or multiple file uploader');
    }

    public static function getOptions(?array $sections = null): array
    {
        return [
            Accordions::make('check-list-options')
                ->accordions([
                    Accordion::make('general-options')
                        ->label(__('General Options'))
                        ->icon('tabler-settings')
                        ->schema([
                            \Filament\Forms\Components\Toggle::make('options.allow_multiple')->label(__('Allow Multiple')),
                            self::required(),
                            self::columnSpanFull(),
                            self::hiddenLabel(),
                            self::htmlID(),
                        ]),
                    self::hintOptions(),
                    self::visibility($sections),
                    Bolt::getCustomSchema('field', resolve(static::class)) ?? [],
                ]),
        ];
    }

    public static function getOptionsHidden(): array
    {
        return [
            ...Bolt::getHiddenCustomSchema('field', resolve(static::class)) ?? [],
            self::hiddenHtmlID(),
            self::hiddenHintOptions(),
            self::hiddenRequired(),
            self::hiddenColumnSpanFull(),
            self::hiddenHiddenLabel(),
            self::hiddenVisibility(),
            Hidden::make('options.allow_multiple')->default(false),
        ];
    }

    public function getResponse(Field $field, FieldResponse $resp): string
    {
        $responseValue = filled($resp->response) ? Bolt::isJson($resp->response) ? json_decode($resp->response) : [$resp->response] : [];

        $disk = Storage::disk(config('zeus-bolt.uploadDisk'));

        $getUrl = fn ($file) => config('zeus-bolt.uploadVisibility') === 'private'
            ? $disk->temporaryUrl($file, now()->addDay())
            : $disk->url($file);

        return view('zeus::filament.fields.file-upload')
            ->with('resp', $resp)
            ->with('responseValue', $responseValue)
            ->with('field', $field)
            ->with('getUrl', $getUrl)
            ->render();
    }

    public function TableColumn(Field $field): ?\Filament\Tables\Columns\Column
    {
        return null;
    }

    // @phpstan-ignore-next-line
    public function appendFilamentComponentsOptions($component, $zeusField, bool $hasVisibility = false)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField, $hasVisibility);

        $component->disk(config('zeus-bolt.uploadDisk'))
            ->directory(config('zeus-bolt.uploadDirectory'))
            ->visibility(config('zeus-bolt.uploadVisibility'));

        if (isset($zeusField->options['allow_multiple']) && $zeusField->options['allow_multiple']) {
            $component = $component->multiple();
        }

        return $component;
    }
}
