<?php

namespace LaraZeus\Bolt\Filament\Exports;

use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\Response;

class ResponseExporter extends Exporter
{
    protected static ?string $model = Response::class;

    protected ?Model $record;

    public static function getColumns(): array
    {
        $record = \Livewire\Livewire::current()->getRecord();
        $getUserModel = config('auth.providers.users.model')::getUserFullNameAttribute();
        $mainColumns = [
            ExportColumn::make('user.' . $getUserModel)
                ->label(__('Name'))
                ->default(__('guest')),

            ExportColumn::make('status')
                ->label(__('status')),

            ExportColumn::make('notes')
                ->label(__('notes')),
        ];

        /**
         * @var Field $field.
         */
        foreach ($record->fields->sortBy('ordering') as $field) {
            $getFieldTableColumn = (new $field->type)->ExportColumn($field);

            if ($getFieldTableColumn !== null) {
                $mainColumns[] = $getFieldTableColumn;
            }
        }

        $mainColumns[] = ExportColumn::make('created_at')
            ->label(__('created at'));

        return $mainColumns;
    }

    /*public static function getOptionsFormComponents(): array
    {
        return [
            TextInput::make('descriptionLimit')
                ->label('Limit the length of the description column content')
                ->integer(),
        ];
    }*/

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your response export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
