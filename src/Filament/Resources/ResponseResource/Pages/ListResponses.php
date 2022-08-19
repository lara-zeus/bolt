<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;

class ListResponses extends ListRecords
{
    protected static string $resource = ResponseResource::class;

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [1];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->simplePaginate($this->getTableRecordsPerPage());
    }
}
