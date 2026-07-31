<?php

use Filament\Forms\Components\Repeater;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages\CreateForm;
use LaraZeus\Bolt\Livewire\FillForms;
use LaraZeus\Bolt\Models\Form;

use function Pest\Livewire\livewire;

function createFormViaAdmin(string $fieldType): Form
{
    $slug = fake()->unique()->slug();

    $undoRepeaterFake = Repeater::fake();

    livewire(CreateForm::class)
        ->fillForm([
            'name' => fake()->words(3, true),
            'user_id' => auth()->id(),
            'ordering' => 1,
            'description' => fake()->sentence(),
            'slug' => $slug,
            'is_active' => true,
            'start_date' => null,
            'end_date' => null,
            'sections' => [
                [
                    'name' => 'Test Section',
                    'columns' => 2,
                    'aside' => 0,
                    'borderless' => 0,
                    'compact' => 0,
                    'fields' => [
                        [
                            'name' => 'Test Field',
                            'type' => $fieldType,
                        ],
                    ],
                ],
            ],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $undoRepeaterFake();

    return Form::query()->where('slug', $slug)->firstOrFail();
}

dataset('allFields', function () {
    $directory = __DIR__ . '/../src/Fields/Classes';

    return collect(scandir($directory))
        ->filter(fn (string $file) => str_ends_with($file, '.php'))
        ->mapWithKeys(fn (string $file) => [
            basename($file, '.php') => '\\LaraZeus\\Bolt\\Fields\\Classes\\' . basename($file, '.php'),
        ])
        ->toArray();
});

it('can render field with default options on fill form page', function (string $fieldClass) {
    $form = createFormViaAdmin($fieldClass);

    livewire(FillForms::class, ['slug' => $form->slug])
        ->assertFormExists()
        ->assertSuccessful();
})->with('allFields');
