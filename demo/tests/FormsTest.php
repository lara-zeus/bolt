<?php

use LaraZeus\Bolt\Fields\Classes\TextInput;
use LaraZeus\Bolt\Filament\Resources\CategoryResource;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages\EditForm;
use LaraZeus\Bolt\Livewire\FillForms;
use LaraZeus\Bolt\Livewire\ListForms;
use LaraZeus\Bolt\Models\Category;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Section;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

it('can render Form List', function () {
    get(FormResource::getUrl())->assertSuccessful();
});

it('can render list Forms', function () {
    get('/bolt')->assertSuccessful();
});

it('can render show Form', function () {
    $form = Form::factory()->create();
    get('bolt/' . $form->slug)->assertSuccessful();
});

it('the form can be rendered', function () {
    $form = Form::factory()->create();
    livewire(FillForms::class, ['slug' => $form->slug])
        ->assertFormExists();
});

it('see ended form date', function () {
    $form = Form::factory()->create();

    $form->update([
        'start_date' => now()->subDays(6),
        'end_date' => now()->subDay(),
    ]);

    livewire(FillForms::class, ['slug' => $form->slug])
        ->assertSee(__('Date Not Available'));
});

it('see form date is valid', function () {
    $form = Form::factory()->create();

    $form->update([
        'start_date' => now()->subDays(2),
        'end_date' => now()->addDays(5),
    ]);

    livewire(FillForms::class, ['slug' => $form->slug])
        ->assertDontSee(__('Date Not Available'));
});

it('see form require login for logged in user', function () {
    $form = Form::factory()->create();

    $form->update([
        'options' => ['require-login' => true],
    ]);

    livewire(FillForms::class, ['slug' => $form->slug])
        ->assertDontSee(__('Login Required'));
});

it('see form require login for guest user', function () {
    auth()->logout();
    $form = Form::factory()->create();

    $form->update([
        'options' => ['require-login' => true],
    ]);

    livewire(FillForms::class, ['slug' => $form->slug])
        ->assertSee(__('Login Required'));
});

it('see form when not require login', function () {
    $form = Form::factory()->create();

    $form->update([
        'options' => ['require-login' => false],
    ]);

    livewire(FillForms::class, ['slug' => $form->slug])
        ->assertDontSee(__('Login Required'));
});

it('see form when not require login for guest', function () {
    auth()->logout();
    $form = Form::factory()->create();

    $form->update([
        'options' => ['require-login' => false],
    ]);

    livewire(FillForms::class, ['slug' => $form->slug])
        ->assertDontSee(__('Login Required'));
});

it('can list Form', function () {
    livewire(ListForms::class)->assertOk();
});

it('can render create form page', function () {
    get(FormResource::getUrl('create'))->assertSuccessful();
});

it('can create', function () {
    $newData = Form::factory()->make();
    $htmlID = str()->random(6);

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
                    'borderless' => 0,
                    'fields' => [
                        [
                            'name' => 'sdf',
                            'type' => TextInput::class,
                            'options' => [
                                'dateType' => 'string',
                                'htmlId' => $htmlID,
                                'prefix' => null,
                                'suffix' => null,
                                'is_required' => null,
                                'visibility' => [
                                    'active' => null,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Form::class, [
        'name' => json_encode([
            'en' => $newData->name,
        ]),
        'description' => json_encode([
            'en' => $newData->description,
        ]),
        'user_id' => $newData->user->getKey(),
        'ordering' => $newData->ordering,
        'slug' => $newData->slug,
        'is_active' => $newData->is_active,
        'category_id' => $newData->category_id,
        'start_date' => $newData->start_date,
        'end_date' => $newData->end_date,
    ]);

    assertDatabaseHas(Section::class, [
        'name' => json_encode([
            'en' => 'sdf',
        ]),
        'columns' => 2,
        'aside' => 0,
        'borderless' => 0,
    ]);

    assertDatabaseHas(Field::class, [
        'name' => json_encode([
            'en' => 'sdf',
        ]),
        'type' => TextInput::class,
        'options' => json_encode([
            'dateType' => 'string',
            'prefix' => null,
            'suffix' => null,
            'is_required' => null,
            'htmlId' => $htmlID,
            'visibility' => [
                'active' => null,
            ],
        ]),
    ]);
})->skip();

it('can not edit', function () {
    get(CategoryResource::getUrl('edit', [
        'record' => Category::factory()->create(),
    ]))->assertSuccessful();
});

it('can retrieve data', function () {
    $post = Form::factory()->create();

    livewire(EditForm::class, [
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

it('can save', function () {
    $form = Form::factory()->create();
    $newData = Form::factory()->make();
    $htmlID = str()->random(6);

    livewire(EditForm::class, [
        'record' => $form->getRouteKey(),
    ])
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
                    'borderless' => 0,
                    'compact' => 0,
                    'fields' => [
                        [
                            'name' => 'sdf',
                            'type' => TextInput::class,
                            'options' => [
                                'dateType' => 'string',
                                'htmlId' => $htmlID,
                                'prefix' => null,
                                'suffix' => null,
                                'is_required' => null,
                                'visibility' => [
                                    'active' => null,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    // @phpstan-ignore-next-line
    expect($form->refresh())
        ->user_id->toBe($newData->user->getKey())
        ->name->toBe($newData->name)
        ->description->toBe($newData->description)
        ->slug->toBe($newData->slug);
});
