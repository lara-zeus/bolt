<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;

class BrowseResponses extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $resource = ResponseResource::class;

    protected static string $view = 'zeus-bolt::filament.resources.response-resource.pages.browse-responses';

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    protected function getTitle(): string
    {
        return __('Browse Entries');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BetaNote::class,
        ];
    }

    protected function getTableQuery(): Builder
    {
        return config('zeus-bolt.models.Response')::query()->where('form_id', request('form_id')); //tableFilters.form.value
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('form')->relationship('form', 'name')->default(request('form_id', null)),
        ];
    }

    protected function getViewData(): array
    {
        $form = $this->getModel()::query();
        if (request()->filled('form_id')) {
            $form = $form->where('form_id', request('form_id'));
        }
        //dump($form->count());
        return [
            'rows' => $form->paginate(1),
        ];
    }

    protected function getActions(): array
    {
        return [
            Action::make('list')
                ->size('sm')
                ->visible(request()->filled('form_id'))
                ->label(__('List Entries'))
                ->url(fn(): string => ResponseResource::getUrl() . '?form_id=' . request('form_id')),
            Action::make('report')
                ->size('sm')
                ->visible(request()->filled('form_id'))
                ->label(__('Entries Report'))
                ->url(fn(): string => ResponseResource::getUrl('report') . '?form_id=' . request('form_id')),
        ];
    }
}
