<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Resources\Pages\Page;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\Bolt\Models\Response;

class BrowseResponses extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $resource = ResponseResource::class;
    protected static string $view = 'zeus-bolt::filament.resources.response-resource.pages.browse-responses';
    protected static ?string $navigationIcon = 'heroicon-o-eye';
    protected static ?string $title = 'Responses';

    protected function getTableQuery(): Builder
    {
        return Response::query()->where('form_id',request('form_id'));
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('title')
        ];
    }

    protected function getViewData() : array
    {
        return [
            'rows'   => $this->getModel()::where('user_id', auth()->user()->id)->simplePaginate(1),
            'fields' => $this->fields(),
        ];
    }

    public function fields()
    {
        return collect([
            [
                'id'       => 'form.name',
                'label'    => 'Form Name',
                'sortable' => true,
                'inShow'   => false,
            ],
            [
                'id'     => 'user.name',
                'label'  => 'user',
                'inShow' => false,
            ],
            [
                'id'       => 'status',
                'label'    => 'status',
                'sortable' => true,
                'inShow'   => true,
            ],
            [
                'id'     => 'notes',
                'label'  => 'notes',
                'inShow' => true,
            ],
        ]);
    }
}
