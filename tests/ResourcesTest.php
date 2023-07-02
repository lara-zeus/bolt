<?php

use LaraZeus\Bolt\Filament\Resources\CategoryResource;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages\ListForms;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

it('can render Category List', function () {
    get(CategoryResource::getUrl())
        ->assertSuccessful();
});

/*it('can list posts', function () {
    $forms = \LaraZeus\Bolt\Models\Form::factory()->count(10)->create();

    livewire(ListForms::class)
        ->assertCanSeeTableRecords($forms);
});*/

/*it('can render Collection List', function () {
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
});*/
