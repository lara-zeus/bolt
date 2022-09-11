<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Resources\Pages\Page;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use LaraZeus\Bolt\Models\Response;

class BrowseResponses extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $resource = ResponseResource::class;

    protected static string $view = 'zeus-bolt::filament.resources.response-resource.pages.browse-responses';

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    protected static ?string $title = 'Entries';

    protected function getHeaderWidgets(): array
    {
        return [
            BetaNote::class,
        ];
    }

    protected function getTableQuery(): Builder
    {
        return Response::query()->where('form_id', request('form_id'));
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\ViewColumn::make('response')
                ->view('zeus-bolt::filament.resources.response-resource.components.view-responses')
                ->label(''),
        ];
    }

    protected function getViewData(): array
    {
        $form = $this->getModel()::query();
        if (request()->filled('form_id')) {
            $form = $form->where('form_id', request('form_id'));
        }
        $form = $form->paginate(1);

        return [
            'rows' => $form,
        ];
    }
}
