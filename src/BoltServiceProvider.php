<?php

namespace LaraZeus\Bolt;

use LaraZeus\Bolt\Commands\PublishCommand;
use LaraZeus\Bolt\Commands\ZeusFieldCommand;
use LaraZeus\Bolt\Livewire\FillForms;
use LaraZeus\Bolt\Livewire\ListEntries;
use LaraZeus\Bolt\Livewire\ListForms;
use LaraZeus\Bolt\Livewire\Submitted;
use LaraZeus\Core\CoreServiceProvider;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BoltServiceProvider extends PackageServiceProvider
{
    public static string $name = 'zeus-bolt';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews('zeus')
            ->hasMigrations($this->getMigrations())
            ->hasTranslations()
            ->hasCommands($this->getCommands())
            ->hasRoute('web');
    }

    public function packageBooted(): void
    {
        CoreServiceProvider::setThemePath('bolt');

        Livewire::component('bolt.submitted', Submitted::class);
        Livewire::component('bolt.fill-form', FillForms::class);
        Livewire::component('bolt.list-forms', ListForms::class);
        Livewire::component('bolt.list-entries', ListEntries::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../database/seeders' => database_path('seeders'),
            ], 'zeus-bolt-seeder');

            $this->publishes([
                __DIR__ . '/../database/factories' => database_path('factories'),
            ], 'zeus-bolt-factories');
        }
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            PublishCommand::class,
            ZeusFieldCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_categories_table',
            'create_collections_table',
            'create_forms_table',
            'create_sections_table',
            'create_fields_table',
            'create_responses_table',
            'create_field_responses_table',
            'add_extensions_to_forms',
            'add_extension_item_responses',
            'alter_tables_constraints',
        ];
    }
}
