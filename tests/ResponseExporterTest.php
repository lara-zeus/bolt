<?php

use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Facades\DB;
use LaraZeus\Bolt\Fields\Classes\TextInput;
use LaraZeus\Bolt\Fields\Classes\Toggle;
use LaraZeus\Bolt\Filament\Exports\ResponseExporter;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\FieldResponse;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;
use LaraZeus\Bolt\Models\Section;
use LaraZeus\Bolt\Tests\Models\User;

beforeEach(function () {
    config()->set('zeus-bolt.models.User', User::class);
});

it('returns an empty array from getColumns when no Livewire component is active', function () {
    expect(ResponseExporter::getColumns())->toBe([]);
});

it('resolves and caches form columns via export_form_id option', function () {
    $form = Form::factory()->create();
    $section = Section::factory()->create(['form_id' => $form->id]);

    Field::factory()->create([
        'section_id' => $section->id,
        'name' => 'Second Field',
        'type' => TextInput::class,
        'ordering' => 2,
        'options' => ['htmlId' => 'second-field'],
    ]);

    Field::factory()->create([
        'section_id' => $section->id,
        'name' => 'First Field',
        'type' => TextInput::class,
        'ordering' => 1,
        'options' => ['htmlId' => 'first-field'],
    ]);

    $exporter = new ResponseExporter(
        export: new Export,
        columnMap: [],
        options: ['export_form_id' => $form->id],
    );

    DB::flushQueryLog();
    DB::enableQueryLog();

    $columns = $exporter->getCachedColumns();
    $queriesAfterFirstCall = count(DB::getQueryLog());

    $cachedColumns = $exporter->getCachedColumns();
    $queriesAfterSecondCall = count(DB::getQueryLog());

    DB::disableQueryLog();

    expect(array_keys($columns))->toBe([
        'user.name',
        'status',
        'notes',
        'zeusData.first-field',
        'zeusData.second-field',
        'created_at',
    ]);

    expect($cachedColumns)->toBe($columns);
    expect($queriesAfterFirstCall)->toBeGreaterThan(0);
    expect($queriesAfterSecondCall)->toBe($queriesAfterFirstCall);
});

it('resolves form columns for soft-deleted forms in queued exports', function () {
    $form = Form::factory()->create();
    $section = Section::factory()->create(['form_id' => $form->id]);
    Field::factory()->create([
        'section_id' => $section->id,
        'name' => 'Archived Field',
        'type' => TextInput::class,
        'ordering' => 1,
        'options' => ['htmlId' => 'archived-field'],
    ]);

    $form->delete();

    $exporter = new ResponseExporter(
        export: new Export,
        columnMap: [],
        options: ['export_form_id' => $form->id],
    );

    $columns = $exporter->getCachedColumns();

    expect(array_keys($columns))->toContain('user.name', 'status', 'notes', 'created_at');
});

it('returns an empty array from getCachedColumns when export_form_id does not exist', function () {
    $exporter = new ResponseExporter(
        export: new Export,
        columnMap: [],
        options: ['export_form_id' => 999999],
    );

    expect($exporter->getCachedColumns())->toBe([]);
});

/**
 * Builds a form with one text field and one toggle, stores a response, and returns
 * the row exactly as the export job writes it to the CSV/XLSX file.
 *
 * @return array<string, mixed>
 */
function exportRowFor(string $answer, string $notes = '', string $userName = 'Ali'): array
{
    $user = User::factory()->create(['name' => $userName]);

    $form = Form::factory()->create();
    $section = Section::factory()->create(['form_id' => $form->id]);
    $textField = Field::factory()->create([
        'section_id' => $section->id,
        'name' => 'Answer',
        'type' => TextInput::class,
        'ordering' => 1,
        'options' => ['htmlId' => 'answer'],
    ]);
    $toggleField = Field::factory()->create([
        'section_id' => $section->id,
        'name' => 'Agree',
        'type' => Toggle::class,
        'ordering' => 2,
        'options' => ['htmlId' => 'agree'],
    ]);

    $response = Response::factory()->create([
        'form_id' => $form->id,
        'user_id' => $user->id,
        'notes' => $notes,
    ]);

    foreach ([[$textField, $answer], [$toggleField, '1']] as [$field, $value]) {
        FieldResponse::create([
            'response' => $value,
            'response_id' => $response->id,
            'form_id' => $form->id,
            'field_id' => $field->id,
        ]);
    }

    $columnMap = [
        'user.name' => 'Name',
        'notes' => 'Notes',
        'zeusData.answer' => 'Answer',
        'zeusData.agree' => 'Agree',
    ];

    $exporter = new ResponseExporter(
        export: new Export,
        columnMap: $columnMap,
        options: ['export_form_id' => $form->id],
    );

    return array_combine(array_keys($columnMap), $exporter($response->fresh()));
}

dataset('formulaLikeValues', [
    'equals' => '=SUM(A1:A2)',
    'plus' => '+1+1',
    'minus' => '-2+3',
    'at' => '@SUM(A1)',
    'tab' => "\t=1+1",
    'carriage return' => "\r=1+1",
]);

it('exports a formula-like answer as plain text', function (string $value) {
    expect(exportRowFor($value)['zeusData.answer'])->toBe("'" . $value);
})->with('formulaLikeValues');

it('exports a formula-like user name and notes as plain text', function (string $value) {
    $row = exportRowFor('plain', notes: $value, userName: $value);

    expect($row['user.name'])->toBe("'" . $value)
        ->and($row['notes'])->toBe("'" . $value);
})->with('formulaLikeValues');

it('leaves ordinary values, signed numbers and non-leading formula characters untouched', function (string $value) {
    expect(exportRowFor($value)['zeusData.answer'])->toBe($value);
})->with([
    'text' => 'just an answer',
    'arabic' => 'مرحبا',
    'negative number' => '-5',
    'positive number' => '+42',
    'decimal' => '-3.14',
    'email' => 'ali@example.com',
    'equals inside' => '1+1=2',
]);

it('keeps the toggle column readable', function () {
    expect(exportRowFor('plain')['zeusData.agree'])->toBe(__('zeus-bolt::forms.fields.options.yes'));
});

it('applies the plain text handling to every export column', function () {
    $form = Form::factory()->create();
    $section = Section::factory()->create(['form_id' => $form->id]);
    Field::factory()->create([
        'section_id' => $section->id,
        'type' => TextInput::class,
        'options' => ['htmlId' => 'any'],
    ]);

    foreach (ResponseExporter::getFormColumns($form) as $column) {
        expect($column->shouldPreventFormulaInjection())->toBeTrue("{$column->getName()} is not handled");
    }
});
