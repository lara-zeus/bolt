<?php

namespace LaraZeus\Bolt\Tests;

use ArchTech\SEO\SEOServiceProvider;
use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Codeat3\BladeClarityIcons\BladeClarityIconsServiceProvider;
use Codeat3\BladeIconpark\BladeIconparkServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\SpatieLaravelTranslatablePluginServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaraZeus\Bolt\BoltServiceProvider;
use LaraZeus\Bolt\Tests\Models\User;
use LaraZeus\Core\CoreServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;

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
            BladeCaptureDirectiveServiceProvider::class,
            FormsServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            FilamentServiceProvider::class,
            NotificationsServiceProvider::class,
            LivewireServiceProvider::class,
            CoreServiceProvider::class,
            SEOServiceProvider::class,
            BoltServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            BladeClarityIconsServiceProvider::class,
            BladeIconparkServiceProvider::class,
            SpatieLaravelTranslatablePluginServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }
}
