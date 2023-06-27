<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Closure;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\Bolt\Filament\Actions\SetResponseStatus;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use LaraZeus\Bolt\Models\FormsStatus;

class BrowseResponses extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    use \LaraZeus\Bolt\Concerns\EntriesAction;

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
        return fn (Model $record) => 'bg-gray-100';
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
                ->view('zeus-bolt::filament.resources.response-resource.pages.show-entry'),
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
            SelectFilter::make('status')
                ->options(FormsStatus::query()->pluck('label', 'key'))
                ->label(__('Status')),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            SetResponseStatus::make(),
        ];
    }

    protected function getActions(): array
    {
        return $this->getEntriesActions();
    }
}
