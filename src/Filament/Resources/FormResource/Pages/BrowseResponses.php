<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Filament\Actions\SetResponseStatus;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Models\Form;

/**
 * @property Form $record.
 */
class BrowseResponses extends ManageRelatedRecords
{
    protected static string $resource = FormResource::class;

    protected static string $relationship = 'responses';

    protected static string $view = 'zeus::filament.resources.response-resource.pages.browse-responses';

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    public function table(Table $table): Table
    {
        return $table
            ->paginated([1])
            ->recordClasses('!bg-gray-50')
            ->query(BoltPlugin::getModel('Response')::query()->where('form_id', $this->record->id))
            ->columns([
                ViewColumn::make('response')
                    ->label(__('Browse Entries'))
                    ->view('zeus::filament.resources.response-resource.pages.browse-entry'),
            ])
            ->actions([
                SetResponseStatus::make(),
            ], position: ActionsPosition::AfterContent)
            ->filters([
                SelectFilter::make('status')
                    ->options(BoltPlugin::getModel('FormsStatus')::query()->pluck('label', 'key'))
                    ->label(__('Status')),
            ]);
    }

    public static function getNavigationLabel(): string
    {
        return __('Browse Entries');
    }

    public function getTitle(): string
    {
        return __('Browse Entries');
    }
}
