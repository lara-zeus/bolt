<?php

use Illuminate\Support\Facades\Storage;
use LaraZeus\Bolt\Fields\Classes\FileUpload;
use LaraZeus\Bolt\Models\Field;
use Livewire\Features\SupportFileUploads\FileUploadConfiguration;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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

/** The filament component bolt builds for a `file upload` field. */
function boltFileUploadComponent(array $options = []): Filament\Forms\Components\FileUpload
{
    return (new FileUpload)->appendFilamentComponentsOptions(
        Filament\Forms\Components\FileUpload::make('test'),
        new Field(['name' => 'Test Field', 'options' => $options]),
    );
}

describe('the allow list bolt applies', function () {
    it('ships with nothing executable or renderable on it', function () {
        expect(array_intersect(BOLT_DANGEROUS_EXTENSIONS, config('zeus-bolt.uploadAcceptedFileTypes')))->toBeEmpty();
    });

    it('normalises entries however they are written', function () {
        config()->set('zeus-bolt.uploadAcceptedFileTypes', ['.PNG', 'Jpg']);

        expect(boltFileUploadComponent()->getAcceptedFileTypes())
            ->toContain('image/png')
            ->toContain('image/jpeg');
    });

    it('accepts nothing when the allow list is empty or missing', function (mixed $configured) {
        config()->set('zeus-bolt.uploadAcceptedFileTypes', $configured);

        expect(boltFileUploadComponent()->getAcceptedFileTypes())->toBeEmpty()
            ->and(FileUpload::getAllowedExtensionOptions())->toBeEmpty();
    })->with([
        'emptied deliberately' => [[]],
        'missing entirely' => [null],
    ]);

    /**
     * The field editor stores whatever these options are keyed by, and that key is what
     * the per field allow list is intersected against. Keyed by position, a saved field
     * would resolve to nothing.
     */
    it('offers each extension to the field editor keyed by itself', function () {
        config()->set('zeus-bolt.uploadAcceptedFileTypes', ['.PNG', 'pdf']);

        expect(FileUpload::getAllowedExtensionOptions())->toBe(['png' => 'png', 'pdf' => 'pdf']);
    });
});

describe('a single field', function () {
    beforeEach(fn () => config()->set('zeus-bolt.uploadAcceptedFileTypes', ['jpg', 'png', 'pdf']));

    it('narrows the accepted types', function () {
        expect(boltFileUploadComponent(['accepted_file_types' => ['pdf']])->getAcceptedFileTypes())
            ->toContain('application/pdf')
            ->not->toContain('image/jpeg');
    });

    it('cannot widen them, and picks outside the allow list are dropped', function () {
        expect(boltFileUploadComponent(['accepted_file_types' => ['php', 'exe']])->getAcceptedFileTypes())->toBeEmpty();
    });

    /** What the field editor saves has to be what the allow list is intersected against. */
    it('resolves a pick taken straight from the field editor options', function () {
        $picked = array_key_first(FileUpload::getAllowedExtensionOptions());

        expect(boltFileUploadComponent(['accepted_file_types' => [$picked]])->getAcceptedFileTypes())
            ->not->toBeEmpty();
    });

    it('falls back to the whole allow list when it picks nothing', function () {
        expect(boltFileUploadComponent()->getAcceptedFileTypes())->toContain('image/jpeg', 'application/pdf');
    });

    it('sets its own max size in either kilobytes or megabytes', function (int $size, ?string $unit, int $expected) {
        expect(boltFileUploadComponent(['max_size' => $size, 'max_size_unit' => $unit])->getMaxSize())->toBe($expected);
    })->with([
        'kilobytes' => [500, 'kb', 500],
        'megabytes' => [5, 'mb', 5120],
        'no unit means kilobytes' => [500, null, 500],
    ]);

    /** Setting a size is optional; livewire's own limit governs when nothing is set anywhere. */
    it('leaves the size to livewire when neither it nor the config sets one', function (array $options) {
        expect(config('zeus-bolt.uploadMaxSize'))->toBeNull()
            ->and(boltFileUploadComponent($options)->getMaxSize())->toBeNull();
    })->with([
        'nothing set' => [[]],
        'set to zero' => [['max_size' => 0]],
        'left empty' => [['max_size' => null, 'max_size_unit' => 'mb']],
    ]);

    it('takes the configured size when it sets none of its own', function () {
        config()->set('zeus-bolt.uploadMaxSize', 5000);

        expect(boltFileUploadComponent()->getMaxSize())->toBe(5000)
            ->and(boltFileUploadComponent(['max_size' => 0])->getMaxSize())->toBe(5000);
    });

    it('overrides the configured size with its own', function (int $size, ?string $unit, int $expected) {
        config()->set('zeus-bolt.uploadMaxSize', 5000);

        expect(boltFileUploadComponent(['max_size' => $size, 'max_size_unit' => $unit])->getMaxSize())->toBe($expected);
    })->with([
        'lower' => [1000, 'kb', 1000],
        'higher' => [50, 'mb', 51200],
    ]);
});

/** The regression test for the reported issue: a web shell must not survive our rules. */
it('rejects an uploaded web shell', function () {
    Storage::fake(FileUploadConfiguration::disk());
    Storage::disk(FileUploadConfiguration::disk())->put(
        FileUploadConfiguration::path('shell.php', withS3Root: false),
        '<?php system($_GET["c"]); ?>',
    );

    $error = null;
    $fail = function (string $message) use (&$error): void {
        $error ??= $message;
    };

    foreach (boltFileUploadComponent()->getValidationRules() as $rule) {
        if ($rule instanceof Closure) {
            $rule('test', [TemporaryUploadedFile::createFromLivewire('/shell.php')], $fail);
        }
    }

    expect($error)->not->toBeNull();
});
