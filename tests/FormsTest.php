<?php

use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages\ListForms;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Section;
use function Pest\Laravel\assertDatabaseHas;
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
    get(FormResource::getUrl('create'))->assertSuccessful();
});

it('can create', function () {
    $newData = Form::factory()->make();

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
                [
                    'name' => 'sdf',
                    'columns' => 2,
                    'aside' => 0,
                    'fields' =>
                        [
                            [
                                'name' => 'sdf',
                                'type' => \LaraZeus\Bolt\Fields\Classes\TextInput::class,
                                'options' => [
                                    'dateType' => 'string',
                                    'htmlId' => str()->random(6),
                                ],
                            ]
                        ],
                ]
            ],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    /*assertDatabaseHas(Form::class, [
        'name' => json_encode([
            'en' => $newData->name
        ]),
        'description' => json_encode([
            'en' => $newData->description
        ]),
        'user_id' => $newData->user->getKey(),
        'ordering' => $newData->ordering,
        'slug' => $newData->slug,
        'is_active' => $newData->is_active,
        'category_id' => $newData->category_id,
        'start_date' => $newData->start_date,
        'end_date' => $newData->end_date,
    ]);*/
});

it('can edit', function () {
    get(FormResource::getUrl('edit', [
        'record' => Form::factory()->create(),
    ]))->assertSuccessful();
});

it('can retrieve data', function () {
    $post = Form::factory()->create();

    livewire(FormResource\Pages\EditForm::class, [
        'record' => $post->getRouteKey(),
    ])
        ->assertFormSet([
            'name' => $post->name,
            'description' => $post->description,
            'user_id' => $post->user->getKey(),
            'ordering' => $post->ordering,
            'slug' => $post->slug,
            'is_active' => $post->is_active,
            'category_id' => $post->category_id,
            'start_date' => $post->start_date,
            'end_date' => $post->end_date,
        ]);
});