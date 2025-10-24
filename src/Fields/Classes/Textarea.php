<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea as TextareaAlias;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Accordion\Forms\Accordions;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\FieldResponse;
use LaraZeus\Bolt\Models\Response;
use LaraZeus\BoltPro\Facades\GradeOptions;

class Textarea extends FieldsContract
{
    public string $renderClass = TextareaAlias::class;

    public int $sort = 8;

    public function icon(): string
    {
        return 'tabler-text-size';
    }

    public static function getOptions(?array $sections = null, ?array $field = null): array
    {
        return [
            Accordions::make('check-list-options')
                ->columns()
                ->accordions([
                    Accordion::make('general-options')
                        ->label(__('zeus-bolt::forms.fields.options.general'))
                        ->icon('tabler-settings')
                        ->schema([
                            TextInput::make('options.rows')
                                ->label(__('zeus-bolt::forms.fields.options.rows')),

                            TextInput::make('options.cols')
                                ->label(__('zeus-bolt::forms.fields.options.cols')),

                            TextInput::make('options.minLength')
                                ->label(__('zeus-bolt::forms.fields.options.min_length')),

                            TextInput::make('options.maxLength')
                                ->label(__('zeus-bolt::forms.fields.options.max_length')),

                            self::isActive(),
                            self::required(),
                            self::columnSpanFull(),
                            self::hiddenLabel(),
                            self::htmlID(),
                        ]),
                    self::hintOptions(),
                    self::visibility($sections),
                    // @phpstan-ignore-next-line
                    ...Bolt::hasPro() ? GradeOptions::schema($field) : [],
                    Bolt::getCustomSchema('field', resolve(static::class)) ?? [],
                ]),
        ];
    }

    public static function getOptionsHidden(): array
    {
        return [
            self::hiddenIsActive(),
            // @phpstan-ignore-next-line
            Bolt::hasPro() ? GradeOptions::hidden() : [],
            ...Bolt::getHiddenCustomSchema('field', resolve(static::class)) ?? [],
            self::hiddenVisibility(),
            self::hiddenHtmlID(),
            self::hiddenHintOptions(),
            self::hiddenRequired(),
            self::hiddenColumnSpanFull(),
            self::hiddenHiddenLabel(),
            Hidden::make('options.rows'),
            Hidden::make('options.cols'),
            Hidden::make('options.minLength'),
            Hidden::make('options.maxLength'),
        ];
    }

    // @phpstan-ignore-next-line
    public function appendFilamentComponentsOptions($component, $zeusField, bool $hasVisibility = false)
    {
        parent::appendFilamentComponentsOptions($component, $zeusField, $hasVisibility);

        if (filled($zeusField['options']['maxLength'])) {
            $component->maxLength($zeusField['options']['maxLength']);
        }
        if (filled($zeusField['options']['maxLength'])) {
            $component->maxLength($zeusField['options']['maxLength']);
        }
        if (filled($zeusField['options']['rows'])) {
            $component->rows($zeusField['options']['rows']);
        }
        if (filled($zeusField['options']['cols'])) {
            $component->cols($zeusField['options']['cols']);
        }

        return $component;
    }

    public function getResponse(Field $field, FieldResponse $resp): string
    {
        return nl2br(strip_tags($resp->response));
    }

    public function TableColumn(Field $field): ?Column
    {
        return TextColumn::make('zeusData.' . $field->id)
            ->sortable(false)
            ->label($field->name)
            ->searchable(query: function (Builder $query, string $search): Builder {
                return $query
                    ->whereHas('fieldsResponses', function ($query) use ($search) {
                        $query->where('response', 'like', '%' . $search . '%');
                    });
            })
            ->getStateUsing(fn (Response $record) => $this->getFieldResponseValue($record, $field))
            ->html()
            ->limit(50)
            ->toggleable();
    }
}
