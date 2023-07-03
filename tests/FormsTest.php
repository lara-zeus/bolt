<?php

use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages\ListForms;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Section;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

it('can render Form List', function () {
    get(FormResource::getUrl())->assertSuccessful();
});

it('can list Form', function () {
    $forms = Form::factory()->count(10)->create();

    livewire(ListForms::class)->assertCanSeeTableRecords($forms);
});

it('can render create form page', function () {
    $this->get(FormResource::getUrl('create'))->assertSuccessful();
});

it('can create', function () {
    $newData = Form::factory()
        ->has(Section::factory()->count(1))
        //->make()
        ->create()

    ;

    livewire(FormResource\Pages\CreateForm::class)
        ->fillForm([
            'name' => $newData->name,
            'user_id' => $newData->user->getKey(),
            'ordering' => $newData->ordering,
            'description' => $newData->description,
            'slug' => $newData->slug,
            'is_active' => $newData->is_active,
            'category_id' => $newData->category_id,
            'start_date' => $newData->start_date,
            'end_date' => $newData->end_date,
            'sections' => [
                'name'=>$newData->sections->first()->name,
            ],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    /*$this->assertDatabaseHas(Form::class, [
        'name' => json_encode($newData->name),
        'description' => json_encode($newData->description),
        'user_id' => $newData->user->getKey(),
        'ordering' => $newData->ordering,
        'slug' => $newData->slug,
        'is_active' => $newData->is_active,
        'category_id' => $newData->category_id,
        'start_date' => $newData->start_date,
        'end_date' => $newData->end_date,
    ]);*/
});
