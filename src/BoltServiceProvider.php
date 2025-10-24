<?php

namespace LaraZeus\Bolt;

use LaraZeus\Bolt\Commands\InstallCommand;
use LaraZeus\Bolt\Commands\MakeAllFieldsActive;
use LaraZeus\Bolt\Commands\PublishCommand;
use LaraZeus\Bolt\Commands\ZeusDatasourceCommand;
use LaraZeus\Bolt\Commands\ZeusFieldCommand;
use LaraZeus\Bolt\Livewire\FillForms;
use LaraZeus\Bolt\Livewire\ListEntries;
use LaraZeus\Bolt\Livewire\ListForms;
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
            ->hasConfigFile()
            ->hasCommands($this->getCommands())
            ->hasRoute('web');
    }

    public function packageBooted(): void
    {
        CoreServiceProvider::setThemePath('bolt');

        Livewire::component('bolt.fill-form', FillForms::class);
        Livewire::component('bolt.list-forms', ListForms::class);
        Livewire::component('bolt.list-entries', ListEntries::class);
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            PublishCommand::class,
            ZeusFieldCommand::class,
            ZeusDatasourceCommand::class,
            InstallCommand::class,
            MakeAllFieldsActive::class,
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
            'alter_tables_constraints',
        ];
    }
}
