<?php

namespace LaraZeus\Bolt\Concerns;

use Filament\Forms\Components\Hidden;

trait HasHiddenOptions
{
    public static function hiddenVisibility(): array
    {
        return [
            Hidden::make('options.visibility.active')->default(false),
            Hidden::make('options.visibility.fieldID'),
            Hidden::make('options.visibility.values'),
        ];
    }

    public static function hiddenRequired(): array
    {
        return [
            Hidden::make('options.is_required')->default(false),
        ];
    }

    public static function hiddenIsActive(): array
    {
        return [
            Hidden::make('options.is_active')
                ->formatStateUsing(fn ($record) => $record->options['is_active'] ?? true)
                ->default(true),
        ];
    }

    public static function hiddenHintOptions(): array
    {
        return [
            Hidden::make('options.hint.text'),
            Hidden::make('options.hint.icon'),
            Hidden::make('options.hint.color'),
            Hidden::make('options.hint.icon-tooltip'),
        ];
    }

    public static function hiddenColumnSpanFull(): array
    {
        return [
            Hidden::make('options.column_span_full')->default(false),
        ];
    }

    public static function hiddenHiddenLabel(): array
    {
        return [
            Hidden::make('options.hidden_label')->default(false),
        ];
    }

    public static function hiddenDataSource(): array
    {
        return [
            Hidden::make('options.dataSource'),
        ];
    }

    public static function hiddenHtmlID(): array
    {
        return [
            Hidden::make('options.htmlId')->default(str()->random(6)),
        ];
    }
}
