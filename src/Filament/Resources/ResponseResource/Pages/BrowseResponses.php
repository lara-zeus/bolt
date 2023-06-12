<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\Action;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use Closure;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\Bolt\Models\FormsStatus;
use LaraZeus\Bolt\Models\Response;

class BrowseResponses extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    use ResponseResource\EntriesAction;

    protected static string $resource = ResponseResource::class;

    protected static string $view = 'zeus-bolt::filament.resources.response-resource.pages.browse-responses';

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    public int $form_id = 0;

    protected $queryString = [
        'form_id',
    ];

    public function mount(): void
    {
        $this->form_id = request('form_id', 0);
    }

    protected function getTableRecordsPerPage(): int
    {
        return 1;
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [1];
    }

    protected function getTableRecordClassesUsing(): ?Closure
    {
        return fn(Model $record) => 'bg-gray-100';
    }

    protected function getTitle(): string
    {
        return __('Browse Entries');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\ViewColumn::make('response')
                ->label(__('Browse Entries'))
                ->view('zeus-bolt::themes.zeus.show-entry')
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BetaNote::class,
        ];
    }

    protected function getTableQuery(): Builder
    {
        return config('zeus-bolt.models.Response')::query()->where('form_id', $this->form_id);
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('form')
                ->relationship('form', 'name')
                ->default($this->form_id),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('set-status')
                ->label(__('Set Status'))
                ->icon('heroicon-o-tag')
                ->action(function (array $data, Response $record): void {
                    $record->status = $data['status'];
                    $record->notes = $data['notes'];
                    $record->save();
                })
                ->form([
                    Select::make('status')
                        ->label(__('status'))
                        ->default(fn(Response $record) => $record->status)
                        ->options(FormsStatus::query()->pluck('label', 'key'))
                        ->required(),
                    Textarea::make('notes')
                        ->default(fn(Response $record) => $record->notes)
                        ->label(__('Notes')),
                ]),
        ];
    }

    protected function getActions(): array
    {
        return $this->getEntriesActions();
    }
}
