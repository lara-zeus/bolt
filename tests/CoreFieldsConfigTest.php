<?php

use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Cache;
use LaraZeus\Bolt\Facades\Collectors;
use LaraZeus\Bolt\Fields\Classes\Select as SelectField;
use LaraZeus\Bolt\Fields\Classes\TextInput as TextInputField;
use LaraZeus\Bolt\Fields\Classes\Toggle as ToggleField;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages\EditForm;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Section;
use LaraZeus\Bolt\Tests\Fields\DummyField;

use function Pest\Livewire\livewire;

function assertTypePickerFieldOnEditForm(Closure $assertions, string $fieldType = TextInputField::class): void
{
    $section = Section::factory()->create(['form_id' => Form::factory()->create()->getKey()]);

    $field = Field::factory()->create([
        'section_id' => $section->getKey(),
        'type' => '\\' . ltrim($fieldType, '\\'),
    ]);

    livewire(EditForm::class, ['record' => $section->form->getRouteKey()])
        ->assertSuccessful()
        ->assertSchemaComponentExists(
            // Repeaters bound to a relationship key their items `record-{id}`.
            "sections.record-{$section->getKey()}.fields.record-{$field->getKey()}.type",
            checkComponentUsing: function (Select $picker) use ($assertions): bool {
                $assertions($picker);

                return true;
            },
        );
}

/**
 * Point the 'collectors' config at this package's tests/Fields directory, so DummyField
 * is discovered the way an app's own fields are. Bolt resolves that path with base_path(),
 * which testbench puts inside vendor, so it has to be given relative to there.
 */
function useTestsDirectoryAsCollectorsPath(): void
{
    $stepsUpToRoot = str_repeat('../', substr_count(trim(base_path(), DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR) + 1);

    config()->set('zeus-bolt.collectors.fields.path', $stepsUpToRoot . ltrim(__DIR__ . '/Fields', DIRECTORY_SEPARATOR));
    config()->set('zeus-bolt.collectors.fields.namespace', 'LaraZeus\\Bolt\\Tests\\Fields\\');
}

beforeEach(function () {
    Cache::flush();

    $this->autoDiscoveredFields = Collectors::collectClasses(
        __DIR__ . '/../src/Fields/Classes',
        'LaraZeus\\Bolt\\Fields\\Classes\\'
    );
});

it('offers every auto-discovered core field when coreFields is null', function () {
    config()->set('zeus-bolt.coreFields', null);

    assertTypePickerFieldOnEditForm(fn (Select $picker) => expect(array_keys($picker->getOptions()))
        ->toBe($this->autoDiscoveredFields->sortBy('sort')->pluck('class')->toArray()));
});

it('offers only the configured core fields, ordered by their sort property', function () {
    config()->set('zeus-bolt.coreFields', [
        DummyField::class,
        TextInputField::class,
        SelectField::class,
    ]);

    assertTypePickerFieldOnEditForm(fn (Select $picker) => expect(array_keys($picker->getOptions()))->toBe([
        '\\' . TextInputField::class,
        '\\' . SelectField::class,
        '\\' . DummyField::class,
    ]));
});

it('defaults to the first field it offers', function () {
    config()->set('zeus-bolt.coreFields', [
        ToggleField::class,
        SelectField::class,
    ]);

    // Select sorts ahead of Toggle, so it becomes the default even though it is listed second.
    assertTypePickerFieldOnEditForm(fn (Select $picker) => expect($picker->getDefaultState())
        ->toBe('\\' . SelectField::class));
});

it('offers your own collectors fields when coreFields is null', function () {
    useTestsDirectoryAsCollectorsPath();
    config()->set('zeus-bolt.coreFields', null);

    assertTypePickerFieldOnEditForm(fn (Select $picker) => expect(array_keys($picker->getOptions()))
        ->toContain('\\' . DummyField::class));
});

it('ignores the collectors fields once coreFields is set', function () {
    useTestsDirectoryAsCollectorsPath();
    config()->set('zeus-bolt.coreFields', [TextInputField::class]);

    assertTypePickerFieldOnEditForm(fn (Select $picker) => expect(array_keys($picker->getOptions()))
        ->toBe(['\\' . TextInputField::class]));
});

it('offers no fields at all when coreFields is an empty array', function () {
    useTestsDirectoryAsCollectorsPath();
    config()->set('zeus-bolt.coreFields', []);

    assertTypePickerFieldOnEditForm(fn (Select $picker) => expect($picker->getOptions())->toBeEmpty());
});

it('still labels a saved field whose type coreFields no longer offers', function () {
    config()->set('zeus-bolt.coreFields', [TextInputField::class]);

    // Toggle is gone from the picker, but the item already using it must not render blank.
    assertTypePickerFieldOnEditForm(
        fn (Select $picker) => expect(array_keys($picker->getOptions()))->toBe(['\\' . TextInputField::class])
            ->and($picker->getOptionLabel())->toContain((new ToggleField)->title()),
        ToggleField::class,
    );
});
