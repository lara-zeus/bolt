<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Columns\Column;
use Illuminate\Support\Facades\Storage;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Accordion\Forms\Accordions;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\FieldResponse;
use Symfony\Component\Mime\MimeTypes;

class FileUpload extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\FileUpload::class;

    public int $sort = 11;

    public function icon(): string
    {
        return 'tabler-cloud-upload';
    }

    public static function getOptions(?array $sections = null): array
    {
        return [
            Accordions::make('check-list-options')
                ->accordions([
                    Accordion::make('general-options')
                        ->label(__('zeus-bolt::forms.fields.options.general'))
                        ->icon('tabler-settings')
                        ->schema([
                            Toggle::make('options.allow_multiple')
                                ->label(__('zeus-bolt::forms.fields.options.allow_multiple')),
                            Select::make('options.accepted_file_types')
                                ->label(__('zeus-bolt::forms.fields.options.accepted_file_types'))
                                ->helperText(__('zeus-bolt::forms.fields.options.accepted_file_types_helper'))
                                ->multiple()
                                ->options(fn (): array => self::getAllowedExtensionOptions()),
                            Grid::make()
                                ->schema([
                                    TextInput::make('options.max_size')
                                        ->label(__('zeus-bolt::forms.fields.options.max_size'))
                                        ->helperText(__('zeus-bolt::forms.fields.options.max_size_helper'))
                                        ->numeric()
                                        ->minValue(1),
                                    ToggleButtons::make('options.max_size_unit')
                                        ->label(__('zeus-bolt::forms.fields.options.max_size_unit'))
                                        ->options([
                                            'kb' => __('zeus-bolt::forms.fields.options.max_size_units.kb'),
                                            'mb' => __('zeus-bolt::forms.fields.options.max_size_units.mb'),
                                        ])
                                        ->default('kb')
                                        ->grouped(),
                                ]),
                            self::isActive(),
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
            self::hiddenIsActive(),
            ...Bolt::getHiddenCustomSchema('field', resolve(static::class)) ?? [],
            self::hiddenHtmlID(),
            self::hiddenHintOptions(),
            self::hiddenRequired(),
            self::hiddenColumnSpanFull(),
            self::hiddenHiddenLabel(),
            self::hiddenVisibility(),
            Hidden::make('options.allow_multiple')->default(false),
            Hidden::make('options.accepted_file_types')->default([]),
            Hidden::make('options.max_size')->default(null),
            Hidden::make('options.max_size_unit')->default('kb'),
        ];
    }

    /**
     * The extensions this application allows to be uploaded.
     *
     * @return array<int, string>
     */
    protected static function defaultAllowedExtensions(): array
    {
        $extensions = config('zeus-bolt.uploadAcceptedFileTypes');

        if (! is_array($extensions)) {
            return [];
        }

        return array_values(array_unique(array_map(
            fn (string $extension): string => strtolower(ltrim($extension, '.')),
            $extensions
        )));
    }

    /**
     * The allow list as select options, keyed by extension so a field stores the
     * extension itself rather than its position in the list.
     *
     * @return array<string, string>
     */
    public static function getAllowedExtensionOptions(): array
    {
        $allowedExtensions = self::defaultAllowedExtensions();

        return array_combine($allowedExtensions, $allowedExtensions);
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

    public function TableColumn(Field $field): ?Column
    {
        return null;
    }

    // @phpstan-ignore-next-line
    public function appendFilamentComponentsOptions($component, $zeusField, bool $hasVisibility = false)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField, $hasVisibility);

        $allowedExtensions = self::getFieldAllowedExtensions($zeusField);

        $component->disk(config('zeus-bolt.uploadDisk'))
            ->directory(config('zeus-bolt.uploadDirectory'))
            ->visibility(config('zeus-bolt.uploadVisibility'))
            ->acceptedFileTypes(self::getMimeTypesForExtensions($allowedExtensions))
            ->rules(['extensions:' . implode(',', $allowedExtensions)]);

        /** An unset max size means no cap of ours; livewire still applies its own. */
        if (($maxSizeInKilobytes = self::getFieldMaxSizeInKilobytes($zeusField)) > 0) {
            $component->maxSize($maxSizeInKilobytes);
        }

        if (isset($zeusField->options['allow_multiple']) && $zeusField->options['allow_multiple']) {
            $component = $component->multiple();
        }

        return $component;
    }

    /**
     * The extensions picked for one field, intersected with the allow list so it can only narrow.
     *
     * @return array<int, string>
     */
    protected static function getFieldAllowedExtensions(Field $zeusField): array
    {
        $configAllowedExtensions = self::defaultAllowedExtensions();
        $fieldSelectedExtensions = $zeusField->options['accepted_file_types'] ?? [];

        if (! is_array($fieldSelectedExtensions) || blank($fieldSelectedExtensions)) {
            return $configAllowedExtensions;
        }

        return array_values(array_intersect($configAllowedExtensions, array_map(
            fn (string $extension): string => strtolower(ltrim($extension, '.')),
            $fieldSelectedExtensions
        )));
    }

    /**
     * The max size in kilobytes for one field: its own if it sets one, otherwise the
     * configured default, otherwise zero to let livewire's limit govern the upload.
     */
    protected static function getFieldMaxSizeInKilobytes(Field $zeusField): int
    {
        $fieldSelectedMaxSize = self::convertToKilobytes(
            (int) ($zeusField->options['max_size'] ?? 0),
            $zeusField->options['max_size_unit'] ?? null,
        );

        return ($fieldSelectedMaxSize > 0) ? $fieldSelectedMaxSize : (int) config('zeus-bolt.uploadMaxSize');
    }

    protected static function convertToKilobytes(int $size, ?string $unit): int
    {
        return ($unit === 'mb') ? $size * 1024 : $size;
    }

    /**
     * The mime types Filament validates the uploaded content against.
     *
     * @param  array<int, string>  $extensions
     * @return array<int, string>
     */
    protected static function getMimeTypesForExtensions(array $extensions): array
    {
        $mimeTypes = MimeTypes::getDefault();

        return array_values(array_unique(array_merge(
            ...array_map(fn (string $extension): array => $mimeTypes->getMimeTypes($extension), $extensions)
        )));
    }
}
