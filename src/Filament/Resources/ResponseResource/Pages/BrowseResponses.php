<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Concerns\EntriesAction;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use LaraZeus\Bolt\Models\FormsStatus;

class BrowseResponses extends Page implements Tables\Contracts\HasTable
{
    use InteractsWithTable;
    use EntriesAction;

    protected static string $resource = ResponseResource::class;

    protected static string $view = 'zeus::filament.resources.response-resource.pages.browse-responses';

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    public int $form_id = 0;

    protected $queryString = [
        'form_id',
    ];

    public function mount(): void
    {
        $this->form_id = request('form_id', 0);
        $this->form = BoltPlugin::getModel('Form')::findOrFail($this->form_id);
    }

    public function getTableRecordsPerPage(): int
    {
        return 1;
    }

    public function getTitle(): string
    {
        return __('Browse Entries');
    }

    public function table(Table $table): Table
    {
        return $table
            ->paginated([1])
            ->recordClasses('bg-gray-100')
            ->query(BoltPlugin::getModel('Response')::query()->where('form_id', $this->form_id))
            ->columns([
                Tables\Columns\ViewColumn::make('response')
                    ->label(__('Browse Entries'))
                    ->view('zeus::filament.resources.response-resource.pages.show-entry'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(FormsStatus::query()->pluck('label', 'key'))
                    ->label(__('Status')),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return $this->getEntriesActions();
    }

    public function getBreadcrumbs(): array
    {
        $breadcrumb = $this->getBreadcrumb();

        return [
            FormResource::getUrl() => FormResource::getBreadcrumb(),
            FormResource::getUrl('view', ['record' => $this->form->slug]) => $this->form->name,
            ...(filled($breadcrumb) ? [$breadcrumb] : []),
        ];
    }
}
