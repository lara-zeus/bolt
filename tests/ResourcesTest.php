<?php

use LaraZeus\Bolt\Filament\Resources\CategoryResource;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use function Pest\Laravel\get;

it('can render Category List', function () {
    get(CategoryResource::getUrl())
        ->assertSuccessful();
});

it('can render Collection List', function () {
    get(CollectionResource::getUrl())
        ->assertSuccessful();
});

it('can render Form List', function () {
    get(FormResource::getUrl())
        ->assertSuccessful();
});

it('can render Response List', function () {
    get(ResponseResource::getUrl())
        ->assertSuccessful();
});
