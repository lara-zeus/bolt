<?php

namespace LaraZeus\Bolt\Tests;

use ArchTech\SEO\SEOServiceProvider;
use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Codeat3\BladeClarityIcons\BladeClarityIconsServiceProvider;
use Codeat3\BladeIconpark\BladeIconparkServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\SpatieLaravelTranslatablePluginServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Guava\FilamentIconPicker\FilamentIconPickerServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaraZeus\Bolt\BoltServiceProvider;
use LaraZeus\Bolt\Tests\Models\User;
use LaraZeus\Core\CoreServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use RyanChandler\TablerIcons\BladeTablerIconsServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->actingAs(
            User::create(['email' => 'admin@domain.com', 'name' => 'Admin', 'password' => 'password'])
        );

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'LaraZeus\\Bolt\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SpatieLaravelTranslatablePluginServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            BladeTablerIconsServiceProvider::class,

            AdminPanelProvider::class,
            CoreServiceProvider::class,
            BoltServiceProvider::class,
            SEOServiceProvider::class,
            BladeClarityIconsServiceProvider::class,
            BladeIconparkServiceProvider::class,
            FilamentIconPickerServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_skeleton_table.php.stub';
        $migration->up();
        */
    }
}
