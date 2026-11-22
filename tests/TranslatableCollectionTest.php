<?php

use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use LaraZeus\Bolt\Fields\Classes\CheckboxList;
use LaraZeus\Bolt\Fields\Classes\Radio;
use LaraZeus\Bolt\Fields\Classes\Select;
use LaraZeus\Bolt\Filament\Exports\ResponseExporter;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages\CreateCollection;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages\EditCollection;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages\ListCollections;
use LaraZeus\Bolt\Livewire\FillForms;
use LaraZeus\Bolt\Livewire\ShowEntry;
use LaraZeus\Bolt\Models\Collection;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\FieldResponse;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;
use LaraZeus\Bolt\Models\Section;
use LaraZeus\Bolt\Tests\Models\User;

use function Pest\Livewire\livewire;

beforeEach(function () {
    config()->set('zeus-bolt.models.User', User::class);
    config()->set('app.locale', 'en');
    config()->set('app.fallback_locale', 'en');
    app()->setLocale('en');
    filament('spatie-translatable')->defaultLocales(['en', 'ar']);
    Cache::flush();
});

function insertLegacyCollection(string $name, array $values): int
{
    return DB::table(config('zeus-bolt.table-prefix') . 'collections')->insertGetId([
        'name' => $name,
        'values' => json_encode($values, JSON_THROW_ON_ERROR),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

function createCollectionBackedForm(int $collectionId, string $fieldType = Select::class, string $htmlId = 'color-field'): array
{
    $form = Form::factory()->create([
        'is_active' => 1,
        'start_date' => null,
        'end_date' => null,
        'options' => [
            'require-login' => false,
            'one-entry-per-user' => false,
        ],
    ]);

    $section = Section::factory()->create(['form_id' => $form->id]);

    $field = Field::factory()->create([
        'section_id' => $section->id,
        'name' => 'Color',
        'type' => $fieldType,
        'ordering' => 1,
        'options' => [
            'dataSource' => (string) $collectionId,
            'htmlId' => $htmlId,
            'is_active' => 1,
            'is_required' => false,
        ],
    ]);

    return [$form, $field];
}

function createResponseForField(Form $form, Field $field, string $storedResponse): array
{
    $response = Response::factory()->create([
        'form_id' => $form->id,
        'user_id' => auth()->id(),
    ]);

    $fieldResponse = FieldResponse::create([
        'response' => $storedResponse,
        'response_id' => $response->id,
        'form_id' => $form->id,
        'field_id' => $field->id,
    ]);

    return [$response, $fieldResponse];
}

describe('legacy unmigrated collection rows', function () {
    it('reads plain string name, flat JSON values as SupportCollection, and values_list without migration', function () {
        $items = [
            ['itemKey' => 'red', 'itemValue' => 'Red', 'itemIsDefault' => false],
            ['itemKey' => 'blue', 'itemValue' => 'Blue', 'itemIsDefault' => false],
        ];

        $id = insertLegacyCollection('Legacy Colors', $items);
        $collection = Collection::query()->findOrFail($id);

        expect($collection->name)->toBe('Legacy Colors')
            ->and($collection->values)->toBeInstanceOf(SupportCollection::class)
            ->and($collection->values->all())->toBe($items)
            ->and($collection->values_list)->toBe('Red,Blue')
            ->and($collection->getTranslations('name'))->toBe(['en' => 'Legacy Colors'])
            ->and($collection->getTranslations('values'))->toBe(['en' => $items])
            ->and($collection->getTranslations('name', ['en']))->toBe(['en' => 'Legacy Colors'])
            ->and($collection->getTranslations('name', ['ar']))->toBe([])
            ->and($collection->getTranslations('values', ['en']))->toBe(['en' => $items])
            ->and($collection->getTranslations('values', ['ar']))->toBe([]);

        app()->setLocale('ar');

        expect($collection->name)->toBe('Legacy Colors')
            ->and($collection->values)->toBeInstanceOf(SupportCollection::class)
            ->and($collection->values->all())->toBe($items);
    });

    it('renders FillForms with Select, Radio, and CheckboxList backed by a legacy collection', function (string $fieldClass) {
        $id = insertLegacyCollection('Legacy Colors', [
            ['itemKey' => 'red', 'itemValue' => 'Crimson Red', 'itemIsDefault' => false],
            ['itemKey' => 'blue', 'itemValue' => 'Ocean Blue', 'itemIsDefault' => false],
        ]);

        [$form, $field] = createCollectionBackedForm($id, $fieldClass);

        livewire(FillForms::class, ['slug' => $form->slug])
            ->assertSuccessful()
            ->assertFormExists()
            ->assertFormFieldExists('zeusData.' . $field->id, function ($component): bool {
                return $component->getOptions() === [
                    'red' => 'Crimson Red',
                    'blue' => 'Ocean Blue',
                ];
            });
    })->with([
        'Select' => Select::class,
        'Radio' => Radio::class,
        'CheckboxList' => CheckboxList::class,
    ]);

    it('shows and exports responses backed by a legacy collection', function () {
        $id = insertLegacyCollection('Legacy Colors', [
            ['itemKey' => 'red', 'itemValue' => 'Crimson Red', 'itemIsDefault' => false],
            ['itemKey' => 'blue', 'itemValue' => 'Ocean Blue', 'itemIsDefault' => false],
        ]);

        [$form, $field] = createCollectionBackedForm($id, Select::class, 'legacy-color');
        [$response, $fieldResponse] = createResponseForField($form, $field, 'red');

        expect((new Select)->getCollectionsValuesForResponse($field, $fieldResponse))
            ->toBe('Crimson Red');

        livewire(ShowEntry::class, ['responseID' => $response->id])
            ->assertSuccessful()
            ->assertSee('Crimson Red');

        $exporter = new ResponseExporter(
            export: new Export,
            columnMap: ['zeusData.legacy-color' => 'Color'],
            options: ['export_form_id' => $form->id],
        );

        $exported = $exporter($response);

        expect($exported)->toBe(['red']);
    });

    it('upgrades legacy row to Spatie JSON format on EditCollection save in default locale without data loss', function () {
        $items = [
            ['itemKey' => 'red', 'itemValue' => 'Red', 'itemIsDefault' => false],
            ['itemKey' => 'blue', 'itemValue' => 'Blue', 'itemIsDefault' => false],
        ];

        $id = insertLegacyCollection('Legacy Colors', $items);
        $collection = Collection::query()->findOrFail($id);

        livewire(EditCollection::class, ['record' => $collection->getRouteKey()])
            ->assertSet('data.name', 'Legacy Colors')
            ->call('save')
            ->assertHasNoFormErrors();

        $raw = DB::table(config('zeus-bolt.table-prefix') . 'collections')->where('id', $id)->first();

        expect(json_decode($raw->name, true))->toBe(['en' => 'Legacy Colors'])
            ->and(json_decode($raw->values, true))->toBe(['en' => $items]);

        $fresh = Collection::query()->findOrFail($id);

        expect($fresh->name)->toBe('Legacy Colors')
            ->and($fresh->values->all())->toBe($items);
    });

    it('preserves original en legacy data when switching to ar and saving a translation in EditCollection', function () {
        $enItems = [
            ['itemKey' => 'red', 'itemValue' => 'Red', 'itemIsDefault' => false],
        ];
        $arItems = [
            ['itemKey' => 'red', 'itemValue' => 'أحمر', 'itemIsDefault' => false],
        ];

        $id = insertLegacyCollection('Legacy Colors', $enItems);
        $collection = Collection::query()->findOrFail($id);

        $component = livewire(EditCollection::class, ['record' => $collection->getRouteKey()])
            ->assertSet('activeLocale', 'en')
            ->assertSet('data.name', 'Legacy Colors')
            ->set('activeLocale', 'ar')
            ->set('data.name', 'ألوان قديمة');

        $component->call('mountAction', 'add', [], ['schemaComponent' => 'form.values'])
            ->callMountedAction();

        $row = array_key_last($component->get('data.values'));

        $component
            ->set("data.values.{$row}.itemValue", 'أحمر')
            ->set("data.values.{$row}.itemKey", 'red')
            ->set("data.values.{$row}.itemIsDefault", false)
            ->call('save')
            ->assertHasNoFormErrors();

        $raw = DB::table(config('zeus-bolt.table-prefix') . 'collections')->where('id', $id)->first();

        expect(json_decode($raw->name, true))->toEqual([
            'en' => 'Legacy Colors',
            'ar' => 'ألوان قديمة',
        ])->and(json_decode($raw->values, true))->toEqual([
            'en' => $enItems,
            'ar' => $arItems,
        ]);
    });

    it('preserves legacy en data when calling setTranslation programmatically for another locale', function () {
        $enItems = [
            ['itemKey' => 'yes', 'itemValue' => 'Yes', 'itemIsDefault' => false],
        ];
        $arItems = [
            ['itemKey' => 'yes', 'itemValue' => 'نعم', 'itemIsDefault' => false],
        ];

        $id = insertLegacyCollection('Legacy Yes/No', $enItems);
        $collection = Collection::query()->findOrFail($id);

        $collection->setTranslation('name', 'ar', 'نعم/لا');
        $collection->setTranslation('values', 'ar', $arItems);
        $collection->save();

        $raw = DB::table(config('zeus-bolt.table-prefix') . 'collections')->where('id', $id)->first();

        expect(json_decode($raw->name, true))->toBe([
            'en' => 'Legacy Yes/No',
            'ar' => 'نعم/لا',
        ])->and(json_decode($raw->values, true))->toBe([
            'en' => $enItems,
            'ar' => $arItems,
        ]);
    });
});

describe('new translatable collections', function () {
    it('supports creating collections with plain values, SupportCollection, empty array, and multi-locale arrays', function () {
        $plain = Collection::create([
            'name' => 'Plain Colors',
            'values' => [
                ['itemKey' => 'red', 'itemValue' => 'Red', 'itemIsDefault' => false],
            ],
        ]);

        expect($plain->name)->toBe('Plain Colors')
            ->and($plain->values)->toBeInstanceOf(SupportCollection::class)
            ->and($plain->values->all())->toBe([
                ['itemKey' => 'red', 'itemValue' => 'Red', 'itemIsDefault' => false],
            ]);

        $fromSupportCollection = Collection::create([
            'name' => 'Support Collection',
            'values' => collect([
                ['itemKey' => 'green', 'itemValue' => 'Green', 'itemIsDefault' => false],
            ]),
        ]);

        expect($fromSupportCollection->values)->toBeInstanceOf(SupportCollection::class)
            ->and($fromSupportCollection->values->all())->toBe([
                ['itemKey' => 'green', 'itemValue' => 'Green', 'itemIsDefault' => false],
            ]);

        $empty = Collection::create([
            'name' => 'Empty Collection',
            'values' => [],
        ]);

        expect($empty->values)->toBeInstanceOf(SupportCollection::class)
            ->and($empty->values->all())->toBe([])
            ->and($empty->values_list)->toBeNull();

        $multiLocale = Collection::create([
            'name' => ['en' => 'Colors', 'ar' => 'الألوان'],
            'values' => [
                'en' => [['itemKey' => 'red', 'itemValue' => 'Red', 'itemIsDefault' => false]],
                'ar' => [['itemKey' => 'red', 'itemValue' => 'أحمر', 'itemIsDefault' => false]],
            ],
        ]);

        expect($multiLocale->getTranslation('name', 'en'))->toBe('Colors')
            ->and($multiLocale->getTranslation('name', 'ar'))->toBe('الألوان')
            ->and($multiLocale->getTranslation('values', 'en'))->toBe([
                ['itemKey' => 'red', 'itemValue' => 'Red', 'itemIsDefault' => false],
            ])
            ->and($multiLocale->getTranslation('values', 'ar'))->toBe([
                ['itemKey' => 'red', 'itemValue' => 'أحمر', 'itemIsDefault' => false],
            ]);
    });

    it('creates a multi-locale collection via CreateCollection and lists it across locales in ListCollections', function () {
        $component = livewire(CreateCollection::class)
            ->assertSet('activeLocale', 'en');

        $enRow = array_key_first($component->get('data.values'));

        $component
            ->set('data.name', 'Sizes')
            ->set("data.values.{$enRow}.itemValue", 'Small')
            ->set("data.values.{$enRow}.itemKey", 'sm')
            ->set("data.values.{$enRow}.itemIsDefault", false)
            ->set('activeLocale', 'ar')
            ->set('data.name', 'المقاسات');

        $component->call('mountAction', 'add', [], ['schemaComponent' => 'form.values'])
            ->callMountedAction();

        $arRow = array_key_last($component->get('data.values'));

        $component
            ->set("data.values.{$arRow}.itemValue", 'صغير')
            ->set("data.values.{$arRow}.itemKey", 'sm')
            ->set("data.values.{$arRow}.itemIsDefault", false)
            ->call('create')
            ->assertHasNoFormErrors();

        $collection = Collection::query()->firstOrFail();

        expect($collection->getTranslations('name'))->toEqual([
            'en' => 'Sizes',
            'ar' => 'المقاسات',
        ])->and($collection->getTranslations('values'))->toEqual([
            'en' => [['itemValue' => 'Small', 'itemKey' => 'sm', 'itemIsDefault' => false]],
            'ar' => [['itemValue' => 'صغير', 'itemKey' => 'sm', 'itemIsDefault' => false]],
        ]);

        livewire(ListCollections::class)
            ->assertSet('activeLocale', 'en')
            ->assertSee('Sizes')
            ->assertSee('Small')
            ->set('activeLocale', 'ar')
            ->assertSee('المقاسات')
            ->assertSee('صغير')
            ->assertDontSee('Small');
    });

    it('renders FillForms in en vs ar with translated itemValue while storing itemKey', function () {
        $collection = Collection::create([
            'name' => ['en' => 'Colors', 'ar' => 'الألوان'],
            'values' => [
                'en' => [
                    ['itemKey' => 'red', 'itemValue' => 'Red', 'itemIsDefault' => false],
                    ['itemKey' => 'blue', 'itemValue' => 'Blue', 'itemIsDefault' => false],
                ],
                'ar' => [
                    ['itemKey' => 'red', 'itemValue' => 'أحمر', 'itemIsDefault' => false],
                    ['itemKey' => 'blue', 'itemValue' => 'أزرق', 'itemIsDefault' => false],
                ],
            ],
        ]);

        [$form, $field] = createCollectionBackedForm($collection->id, Select::class, 'translated-color');

        app()->setLocale('en');
        livewire(FillForms::class, ['slug' => $form->slug])
            ->assertSuccessful()
            ->assertFormFieldExists('zeusData.' . $field->id, function ($component): bool {
                return $component->getOptions() === [
                    'red' => 'Red',
                    'blue' => 'Blue',
                ];
            });

        app()->setLocale('ar');
        livewire(FillForms::class, ['slug' => $form->slug])
            ->assertSuccessful()
            ->assertFormFieldExists('zeusData.' . $field->id, function ($component): bool {
                return $component->getOptions() === [
                    'red' => 'أحمر',
                    'blue' => 'أزرق',
                ];
            })
            ->fillForm([
                'zeusData.' . $field->id => 'red',
            ])
            ->call('store')
            ->assertHasNoFormErrors();

        $savedFieldResponse = FieldResponse::query()->where('field_id', $field->id)->firstOrFail();

        expect($savedFieldResponse->response)->toBe('red');
    });

    it('returns locale-specific labels in getCollectionsValuesForResponse and ShowEntry without cross-locale cache leakage', function () {
        $collection = Collection::create([
            'name' => ['en' => 'Colors', 'ar' => 'الألوان'],
            'values' => [
                'en' => [['itemKey' => 'red', 'itemValue' => 'Red', 'itemIsDefault' => false]],
                'ar' => [['itemKey' => 'red', 'itemValue' => 'أحمر', 'itemIsDefault' => false]],
            ],
        ]);

        [$form, $field] = createCollectionBackedForm($collection->id, Select::class, 'cached-color');
        [$response, $fieldResponse] = createResponseForField($form, $field, 'red');

        $selectField = new Select;

        app()->setLocale('en');
        expect($selectField->getCollectionsValuesForResponse($field, $fieldResponse))->toBe('Red');

        livewire(ShowEntry::class, ['responseID' => $response->id])
            ->assertSuccessful()
            ->assertSee('Red');

        app()->setLocale('ar');
        expect($selectField->getCollectionsValuesForResponse($field, $fieldResponse))->toBe('أحمر');

        livewire(ShowEntry::class, ['responseID' => $response->id])
            ->assertSuccessful()
            ->assertSee('أحمر');
    });

    it('exports responses cleanly for translatable collections', function () {
        $collection = Collection::create([
            'name' => ['en' => 'Colors', 'ar' => 'الألوان'],
            'values' => [
                'en' => [['itemKey' => 'blue', 'itemValue' => 'Blue', 'itemIsDefault' => false]],
                'ar' => [['itemKey' => 'blue', 'itemValue' => 'أزرق', 'itemIsDefault' => false]],
            ],
        ]);

        [$form, $field] = createCollectionBackedForm($collection->id, Select::class, 'export-color');
        [$response] = createResponseForField($form, $field, 'blue');

        $exporter = new ResponseExporter(
            export: new Export,
            columnMap: ['zeusData.export-color' => 'Color'],
            options: ['export_form_id' => $form->id],
        );

        expect($exporter($response))->toBe(['blue']);
    });
});
