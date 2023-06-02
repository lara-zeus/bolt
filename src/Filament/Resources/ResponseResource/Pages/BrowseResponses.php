<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Resources\Pages\Page;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;

class BrowseResponses extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $resource = ResponseResource::class;

    protected static string $view = 'zeus-bolt::filament.resources.response-resource.pages.browse-responses';

    protected static ?string $navigationIcon = 'heroicon-o-eye';

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
        return config('zeus-bolt.models.Response')::query()->where('form_id', request('form_id'));
    }

    protected function getViewData(): array
    {
        $form = $this->getModel()::query();
        if (request()->filled('form_id')) {
            $form = $form->where('form_id', request('form_id'));
        }

        return [
            'rows' => $form->paginate(1),
        ];
    }
}
