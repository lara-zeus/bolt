<?php

use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Facades\DB;
use LaraZeus\Bolt\Fields\Classes\TextInput;
use LaraZeus\Bolt\Filament\Exports\ResponseExporter;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\Form;
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
