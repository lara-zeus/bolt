<?php

namespace LaraZeus\Bolt\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
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
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaraZeus\Bolt\BoltServiceProvider;
use LaraZeus\Bolt\Tests\Models\User;
use LaraZeus\Core\CoreServiceProvider;
use LaraZeus\SEO\SEOServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use secondnetwork\TablerIcons\BladeTablerIconsServiceProvider;

#[WithMigration]
class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::create(['email' => 'admin@domain.com', 'name' => 'Admin', 'password' => 'password'])
        );
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
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
            FilamentIconPickerServiceProvider::class,
        ];
    }
}
