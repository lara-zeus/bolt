<?php

namespace LaraZeus\Bolt\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use LaraZeus\Bolt\BoltServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use LaraZeus\Bolt\Tests\Models\User;

class TestCase extends Orchestra
{
    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'LaraZeus\Bolt\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );

        $this->actingAs(
            User::create(['email' => 'admin@domain.com', 'name' => 'Admin'])
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            LivewireServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,

            BoltServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('name');
        });
        /*
        $migration = include __DIR__.'/../database/migrations/create_Bolt_table.php.stub';
        $migration->up();
        */
    }

    protected function setUpDatabase($app): void
    {
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('name');
        });
    }
}
