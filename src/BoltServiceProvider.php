<?php

namespace LaraZeus\Bolt;

use Filament\PluginServiceProvider;
use LaraZeus\Bolt\Commands\PublishCommand;
use LaraZeus\Bolt\Commands\ZeusFieldCommand;
use LaraZeus\Bolt\Filament\Resources\CategoryResource;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use LaraZeus\Bolt\Http\Livewire\FillForms;
use LaraZeus\Bolt\Http\Livewire\ListEntries;
use LaraZeus\Bolt\Http\Livewire\ListForms;
use LaraZeus\Bolt\Http\Livewire\Submitted;
use LaraZeus\Core\CoreServiceProvider;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;

class BoltServiceProvider extends PluginServiceProvider
{
    public static string $name = 'zeus-bolt';

    protected array $resources = [
        CollectionResource::class,
        FormResource::class,
        ResponseResource::class,
        CategoryResource::class,
    ];

    public function bootingPackage(): void
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

    public function packageConfigured(Package $package): void
    {
        $package
            ->hasMigrations([
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
            ])
            ->hasViews('zeus')
            ->hasCommands([
                PublishCommand::class,
                ZeusFieldCommand::class,
            ])
            ->hasRoute('web');
    }
}
