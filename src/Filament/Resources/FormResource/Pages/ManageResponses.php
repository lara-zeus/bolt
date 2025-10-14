<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Filament\Actions\SetResponseStatus;
use LaraZeus\Bolt\Filament\Exports\ResponseExporter;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

/**
 * @property Form $record.
 */
class ManageResponses extends ManageRelatedRecords
{
    protected static string $resource = FormResource::class;

    protected static string $relationship = 'responses';

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    public function table(Table $table): Table
    {
        // todo refactor with v4
        $userModel = BoltPlugin::getModel('User') ?? config('auth.providers.users.model');
        $getUserModel = $userModel::getBoltUserFullNameAttribute();

        $mainColumns = [
            ImageColumn::make('user.avatar')
                ->sortable(false)
                ->searchable(false)
                ->label(__('Avatar'))
                ->circular()
                ->toggleable(),

            TextColumn::make('user.' . $getUserModel)
                ->label(__('Name'))
                ->toggleable()
                ->sortable()
                ->default(__('guest'))
                ->searchable(),

            TextColumn::make('status')
                ->toggleable()
                ->sortable()
                ->badge()
                ->label(__('status'))
                ->formatStateUsing(fn ($state) => __(str($state)->title()->toString()))
                ->colors(BoltPlugin::getModel('FormsStatus')::pluck('key', 'color')->toArray())
                ->icons(BoltPlugin::getModel('FormsStatus')::pluck('key', 'icon')->toArray())
                ->grow(false)
                ->searchable('status'),

            TextColumn::make('notes')
                ->label(__('notes'))
                ->sortable()
                ->searchable()
                ->toggleable(),
        ];

        /**
         * @var Field $field.
         */
        foreach ($this->record->fields->sortBy('ordering') as $field) {
            $getFieldTableColumn = (new $field->type)->TableColumn($field);

            if ($getFieldTableColumn !== null) {
                $mainColumns[] = $getFieldTableColumn;
            }
        }

        $mainColumns[] = TextColumn::make('created_at')
            ->sortable()
            ->searchable()
            ->dateTime()
            ->label(__('created at'))
            ->toggleable();

        return $table
            ->query(
                BoltPlugin::getModel('Response')::query()
                    ->where('form_id', $this->record->id)
                    ->with(['fieldsResponses'])
                    ->withoutGlobalScopes([
                        SoftDeletingScope::class,
                    ])
            )
            ->columns($mainColumns)
            ->actions([
                SetResponseStatus::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('status')
                    ->options(BoltPlugin::getModel('FormsStatus')::query()->pluck('label', 'key'))
                    ->label(__('Status')),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                ExportBulkAction::make()
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->queue(),
                    ])
                    ->label(__('Export Responses')),
                // disabled for now due to issue with queues
                /*Tables\Actions\ExportBulkAction::make()
                    ->label(__('Export Responses'))
                    ->exporter(ResponseExporter::class),*/
            ])
            ->recordUrl(
                fn (Response $record): string => FormResource::getUrl('viewResponse', [
                    'record' => $record->form->slug,
                    'responseID' => $record,
                ]),
            );
    }

    public static function getNavigationLabel(): string
    {
        return __('Entries Report');
    }

    public function getTitle(): string
    {
        return __('Entries Report');
    }
}
