<?php

use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\HtmlString;
use LaraZeus\Bolt\Fields\Classes\CheckboxList;
use LaraZeus\Bolt\Fields\Classes\DatePicker;
use LaraZeus\Bolt\Fields\Classes\FileUpload;
use LaraZeus\Bolt\Fields\Classes\Paragraph;
use LaraZeus\Bolt\Fields\Classes\Radio;
use LaraZeus\Bolt\Fields\Classes\RichEditor;
use LaraZeus\Bolt\Fields\Classes\Select;
use LaraZeus\Bolt\Fields\Classes\Textarea;
use LaraZeus\Bolt\Fields\Classes\TextInput;
use LaraZeus\Bolt\Fields\Classes\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\Bolt\Livewire\ShowEntry;
use LaraZeus\Bolt\Models\Collection;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\FieldResponse;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;
use LaraZeus\Bolt\Models\Section;

use function Pest\Livewire\livewire;

const XSS_PAYLOAD = '<img src=x onerror=alert(1)>';

function fieldWith(array $options = []): Field
{
    return new Field(['name' => 'Test Field', 'options' => $options]);
}

function responseOf(string $value): FieldResponse
{
    return new FieldResponse(['response' => $value]);
}

dataset('plainTextFields', [
    'TextInput' => TextInput::class,
    'DatePicker' => DatePicker::class,
    'Toggle' => Toggle::class,
]);

it('escapes a respondent payload for field types that store plain text', function (string $fieldClass) {
    $rendered = (new $fieldClass)->getResponse(fieldWith(), responseOf(XSS_PAYLOAD));

    expect($rendered)
        ->not->toContain('<img')
        ->toContain('&lt;img');
})->with('plainTextFields');

it('escapes a respondent payload in the textarea field', function () {
    $rendered = (new Textarea)->getResponse(fieldWith(), responseOf(XSS_PAYLOAD));

    expect($rendered)
        ->not->toContain('<img')
        ->toContain('&lt;img');
});

it('keeps legitimate angle brackets in a textarea response', function () {
    // strip_tags() used to swallow everything between `<` and the next `>`.
    $rendered = (new Textarea)->getResponse(fieldWith(), responseOf('5 < 10 and 20 > 15'));

    expect($rendered)->toBe('5 &lt; 10 and 20 &gt; 15');
});

it('turns newlines into line breaks in a textarea response', function () {
    $rendered = (new Textarea)->getResponse(fieldWith(), responseOf("first\nsecond"));

    expect($rendered)->toContain('<br');
});

it('sanitizes rather than escapes the rich editor, so authored markup survives', function () {
    $rendered = (new RichEditor)->getResponse(
        fieldWith(),
        responseOf('<p>hello <strong>world</strong></p><script>alert(1)</script>')
    );

    expect($rendered)
        ->toContain('<strong>world</strong>')
        ->not->toContain('<script');
});

it('strips event handler attributes from the rich editor', function () {
    $rendered = (new RichEditor)->getResponse(fieldWith(), responseOf('<p onclick="alert(1)">hi</p>'));

    expect($rendered)->not->toContain('onclick');
});

it('strips javascript uri schemes from the rich editor', function () {
    $rendered = (new RichEditor)->getResponse(fieldWith(), responseOf('<a href="javascript:alert(1)">click</a>'));

    expect($rendered)->not->toContain('javascript:');
});

dataset('collectionBackedFields', [
    'Select' => Select::class,
    'Radio' => Radio::class,
    'CheckboxList' => CheckboxList::class,
]);

it('escapes collection item labels rendered for a response', function (string $fieldClass) {
    $collection = Collection::create([
        'name' => 'Test Collection',
        'values' => [
            ['itemKey' => 'one', 'itemValue' => XSS_PAYLOAD],
        ],
    ]);

    $rendered = (new $fieldClass)->getResponse(
        fieldWith(['dataSource' => (string) $collection->id]),
        responseOf('one')
    );

    expect($rendered)
        ->not->toContain('<img')
        ->toContain('&lt;img');
})->with('collectionBackedFields');

it('escapes every core field type that does not deliberately render html', function () {
    // guards new field types: anything added to Fields/Classes must either escape,
    // sanitize, or be listed here with a reason.
    $deliberatelyRendersHtml = [
        FileUpload::class,   // returns a rendered blade view of download links
        RichEditor::class,   // stores authored html, sanitized instead of escaped
    ];

    $unescaped = collect(scandir(__DIR__ . '/../src/Fields/Classes'))
        ->filter(fn (string $file) => str_ends_with($file, '.php'))
        ->map(fn (string $file) => 'LaraZeus\\Bolt\\Fields\\Classes\\' . basename($file, '.php'))
        ->reject(fn (string $class) => in_array($class, $deliberatelyRendersHtml, true))
        ->filter(function (string $class) {
            $instance = new $class;

            return $instance instanceof FieldsContract
                && str_contains(
                    $instance->getResponse(fieldWith(['dataSource' => '0']), responseOf(XSS_PAYLOAD)),
                    '<img'
                );
        });

    expect($unescaped)->toBeEmpty();
});

it('leaves an empty rich editor response untouched when sanitizing html', function () {
    expect((new RichEditor)->getResponse(fieldWith(), responseOf('')))->toBe('');
});

it('sanitizes html in the paragraph field description', function () {
    $entry = (new Paragraph)->appendFilamentComponentsOptions(
        TextEntry::make('paragraph'),
        new Field([
            'name' => 'Notice',
            'description' => '<p>Read <em>carefully</em></p><script>alert(1)</script><img src=x onerror=alert(1)>',
            'options' => [],
        ])
    );

    $state = $entry->getState();

    expect($state)->toBeInstanceOf(HtmlString::class)
        ->and($state->toHtml())
        ->toContain('<em>carefully</em>')
        ->not->toContain('<script')
        ->not->toContain('onerror');
});

it('sanitizes html in the form confirmation message view', function () {
    $form = Form::factory()->make([
        'options' => [
            'confirmation-message' => '<p>Thank <strong>you</strong>!</p><script>alert(1)</script><a href="javascript:alert(1)">link</a>',
        ],
    ]);

    $rendered = view('zeus::themes.zeus.bolt.submitted', [
        'zeusForm' => $form,
        'extensionData' => ['response' => new Response],
    ])->render();

    expect($rendered)
        ->toContain('<strong>you</strong>')
        ->not->toContain('<script')
        ->not->toContain('javascript:');
});

function entryWithResponseValue(string $value, string $notes = ''): Response
{
    $form = Form::factory()->create();
    $section = Section::factory()->create(['form_id' => $form->id]);
    $field = Field::factory()->create([
        'section_id' => $section->id,
        'type' => TextInput::class,
        'options' => ['htmlId' => 'test-field'],
    ]);

    $response = Response::factory()->create([
        'form_id' => $form->id,
        'user_id' => auth()->id(),
        'notes' => $notes,
    ]);

    FieldResponse::create([
        'response' => $value,
        'response_id' => $response->id,
        'form_id' => $form->id,
        'field_id' => $field->id,
    ]);

    return $response;
}

it('does not render a respondent payload as markup on the entry page', function () {
    $response = entryWithResponseValue(XSS_PAYLOAD);

    livewire(ShowEntry::class, ['responseID' => $response->id])
        ->assertSuccessful()
        ->assertDontSee(XSS_PAYLOAD, escape: false)
        ->assertSee('&lt;img', escape: false);
});

it('does not render a payload in the response notes as markup', function () {
    $response = entryWithResponseValue('plain answer', XSS_PAYLOAD);

    livewire(ShowEntry::class, ['responseID' => $response->id])
        ->assertSuccessful()
        ->assertDontSee(XSS_PAYLOAD, escape: false);
});
