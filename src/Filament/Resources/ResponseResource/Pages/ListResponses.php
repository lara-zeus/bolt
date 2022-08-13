<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

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
