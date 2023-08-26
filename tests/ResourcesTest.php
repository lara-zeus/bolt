<?php

use LaraZeus\Bolt\Filament\Resources\CategoryResource;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use LaraZeus\Bolt\Models\Form;

use function Pest\Laravel\get;

it('can test', function () {
    expect(true)->toBeTrue();
});

it('can render Category List', function () {
    get(CategoryResource::getUrl('index'))->assertSuccessful();

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
    $form = Form::factory()->create();
    get(ResponseResource::getUrl('index', ['form_id' => $form->id]))
        ->assertSuccessful();
});
