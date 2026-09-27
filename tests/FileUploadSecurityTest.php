<?php

use Filament\Actions\Testing\TestAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use LaraZeus\Bolt\Enums\FileUploadType;
use LaraZeus\Bolt\Fields\Classes\FileUpload;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages\CreateForm;
use LaraZeus\Bolt\Livewire\FillForms;
use LaraZeus\Bolt\Models\Form;
use Livewire\Features\SupportTesting\Testable;

use function Pest\Livewire\livewire;

/**
 * Extensions no form should ever store: the web server may execute them,
 * or the browser renders them as markup on our own origin.
 */
const BOLT_DANGEROUS_EXTENSIONS = [
    'php', 'phtml', 'phar', 'php3', 'php4', 'php5', 'phps', 'pht', 'inc',
    'htaccess', 'cgi', 'pl', 'py', 'rb', 'sh', 'bash', 'exe', 'bat', 'dll', 'so',
    'jsp', 'asp', 'aspx', 'cfm',
    'svg', 'svgz', 'html', 'htm', 'xhtml', 'shtml', 'xml', 'xsl', 'js', 'mjs', 'swf',
];

/** A real one pixel png. */
const BOLT_PNG_CONTENTS = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

const BOLT_PDF_CONTENTS = "%PDF-1.4\n1 0 obj<<>>endobj\ntrailer<<>>\n%%EOF";

beforeEach(fn () => Storage::fake(config('zeus-bolt.uploadDisk')));

/** The admin's form builder with one section holding a single `file upload` field. */
function uploadFormBuilder(): Testable
{
    return livewire(CreateForm::class)->fillForm([
        'name' => 'Upload form',
        'slug' => 'upload-form',
        'sections' => [[
            'name' => 'Section',
            'fields' => [['name' => 'Attachment', 'type' => '\\' . FileUpload::class]],
        ]],
    ]);
}

/** The slide over an admin opens from the field's cog button. */
function uploadFieldOptions(): TestAction
{
    return TestAction::make('fields options')->schemaComponent('sections.0.fields')->arguments(['item' => 0]);
}

/**
 * Builds a form with a `file upload` field the way an admin does: filling the builder,
 * setting the field's options in its slide over when there are any, then creating it.
 */
function createUploadFormViaAdmin(array $fieldOptions = []): Form
{
    $undoRepeaterFake = Repeater::fake();

    $builder = uploadFormBuilder();

    if (filled($fieldOptions)) {
        $builder->callAction(uploadFieldOptions(), data: ['options' => $fieldOptions])->assertHasNoFormErrors();
    }

    $builder->call('create')->assertHasNoFormErrors();

    $undoRepeaterFake();

    return Form::query()->where('slug', 'upload-form')->firstOrFail();
}

/** A visitor attaching a file to the form and submitting it. */
function submitUpload(Form $form, UploadedFile $file): Testable
{
    return livewire(FillForms::class, ['slug' => $form->slug])
        ->fillForm(['zeusData.' . $form->fields->first()->id => $file])
        ->call('store');
}

function assertUploadAccepted(Testable $submission): void
{
    $submission->assertHasNoErrors()->assertSet('sent', true);

    expect(Storage::disk(config('zeus-bolt.uploadDisk'))->allFiles(config('zeus-bolt.uploadDirectory')))->toHaveCount(1);
}

function assertUploadRejected(Testable $submission): void
{
    $submission->assertHasErrors()->assertSet('sent', false);

    expect(Storage::disk(config('zeus-bolt.uploadDisk'))->allFiles())->toBeEmpty();
}

function png(string $name = 'photo.png'): UploadedFile
{
    return UploadedFile::fake()->createWithContent($name, base64_decode(BOLT_PNG_CONTENTS));
}

function pdf(string $name = 'report.pdf'): UploadedFile
{
    return UploadedFile::fake()->createWithContent($name, BOLT_PDF_CONTENTS);
}

it('ships with nothing executable or renderable on the allow list', function () {
    expect(array_intersect(BOLT_DANGEROUS_EXTENSIONS, FileUploadType::extensionsFor(FileUploadType::cases())))->toBeEmpty();
});

describe('an admin setting up the field', function () {
    it('picks from the file types, shown with their labels and icons', function () {
        $undoRepeaterFake = Repeater::fake();

        uploadFormBuilder()
            ->mountAction(uploadFieldOptions())
            ->assertMountedActionModalSee(['Image', 'Video', 'Audio', 'Document'])
            ->assertFormFieldExists('options.accepted_file_types', fn (ToggleButtons $field): bool => $field->isMultiple()
                && $field->getIcon('image') === FileUploadType::Image->getIcon());

        $undoRepeaterFake();
    });

    it('does not see a type a developer left without extensions', function () {
        config()->set('zeus-bolt.uploadFileTypes.video', []);
        $undoRepeaterFake = Repeater::fake();

        uploadFormBuilder()
            ->mountAction(uploadFieldOptions())
            ->assertMountedActionModalSee(['Image', 'Audio', 'Document'])
            ->assertMountedActionModalDontSee('Video');

        $undoRepeaterFake();
    });

    it('cannot save a hidden type by posting it anyway', function () {
        config()->set('zeus-bolt.uploadFileTypes.video', []);
        $undoRepeaterFake = Repeater::fake();

        uploadFormBuilder()
            ->callAction(uploadFieldOptions(), data: ['options' => ['accepted_file_types' => ['video']]])
            ->assertHasFormErrors(['options.accepted_file_types.0']);

        $undoRepeaterFake();
    });

    it('cannot set a max size over five digits', function () {
        $undoRepeaterFake = Repeater::fake();

        uploadFormBuilder()
            ->callAction(uploadFieldOptions(), data: ['options' => ['max_size' => 100000]])
            ->assertHasFormErrors(['options.max_size']);

        $undoRepeaterFake();
    });

    it('saves the picked types and max size on the field', function () {
        $form = createUploadFormViaAdmin(['accepted_file_types' => ['image', 'document'], 'max_size' => 2, 'max_size_unit' => 'mb']);

        expect($form->fields->first()->options)
            ->accepted_file_types->toBe(['image', 'document'])
            ->max_size->toEqual(2)
            ->max_size_unit->toBe('mb');
    });
});

describe('a visitor uploading to the field', function () {
    it('can upload a file of a picked type', function (array $picked, UploadedFile $file) {
        assertUploadAccepted(submitUpload(createUploadFormViaAdmin(['accepted_file_types' => $picked]), $file));
    })->with([
        'image picked' => fn () => [['image'], png()],
        'document picked' => fn () => [['document'], pdf()],
        'image of several picked' => fn () => [['image', 'document'], png()],
        'document of several picked' => fn () => [['image', 'document'], pdf()],
    ]);

    it('cannot upload a file of a type the admin did not pick', function () {
        assertUploadRejected(submitUpload(createUploadFormViaAdmin(['accepted_file_types' => ['image']]), pdf()));
    });

    it('can upload any allowed type when the admin picked none', function (UploadedFile $file) {
        assertUploadAccepted(submitUpload(createUploadFormViaAdmin(), $file));
    })->with([
        'an image' => fn () => png(),
        'a document' => fn () => pdf(),
    ]);

    /**
     * Livewire's test uploads report the mime type of the fake file instead of sniffing its
     * content, so the pdf content's real type is set here as the server would detect it.
     */
    it('cannot upload a file renamed to look like a picked type', function () {
        $form = createUploadFormViaAdmin(['accepted_file_types' => ['image']]);

        assertUploadRejected(submitUpload($form, pdf('report.png')->mimeType('application/pdf')));
    });

    /** The regression test for the reported issue. */
    it('cannot upload a web shell', function () {
        assertUploadRejected(submitUpload(
            createUploadFormViaAdmin(),
            UploadedFile::fake()->createWithContent('shell.php', '<?php system($_GET["c"]); ?>'),
        ));
    });

    /** Picks can only narrow the config, so a field left with no types accepts nothing. */
    it('cannot upload anything once a developer empties the only picked type', function () {
        $form = createUploadFormViaAdmin(['accepted_file_types' => ['image']]);

        config()->set('zeus-bolt.uploadFileTypes.image', []);

        assertUploadRejected(submitUpload($form, png()));
    });

    it('can upload extensions however a developer writes them', function () {
        config()->set('zeus-bolt.uploadFileTypes.image', ['.PNG']);

        assertUploadAccepted(submitUpload(createUploadFormViaAdmin(['accepted_file_types' => ['image']]), png()));
    });
});

describe('the max size a visitor can upload', function () {
    it('is the one the admin set, in either kilobytes or megabytes', function (int $maxSize, string $unit, int $fileKilobytes, bool $isAccepted) {
        $form = createUploadFormViaAdmin(['max_size' => $maxSize, 'max_size_unit' => $unit]);

        $submission = submitUpload($form, UploadedFile::fake()->create('photo.png', $fileKilobytes));

        $isAccepted ? assertUploadAccepted($submission) : assertUploadRejected($submission);
    })->with([
        'under kilobytes' => [100, 'kb', 50, true],
        'over kilobytes' => [100, 'kb', 150, false],
        'under megabytes' => [1, 'mb', 1000, true],
        'over megabytes' => [1, 'mb', 1100, false],
    ]);

    it('is the configured one when the admin set none', function () {
        config()->set('zeus-bolt.uploadMaxSize', 100);

        assertUploadRejected(submitUpload(createUploadFormViaAdmin(), UploadedFile::fake()->create('photo.png', 150)));
    });

    it('is the admin one over the configured one', function () {
        config()->set('zeus-bolt.uploadMaxSize', 100);

        $form = createUploadFormViaAdmin(['max_size' => 1, 'max_size_unit' => 'mb']);

        assertUploadAccepted(submitUpload($form, UploadedFile::fake()->create('photo.png', 150)));
    });

    it('is left to livewire when neither the admin nor the config set one', function () {
        assertUploadAccepted(submitUpload(createUploadFormViaAdmin(), UploadedFile::fake()->create('photo.png', 5000)));
    });
});
