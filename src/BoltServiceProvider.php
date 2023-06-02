<?php

namespace LaraZeus\Bolt;

use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use LaraZeus\Bolt\Console\PublishCommand;
use LaraZeus\Bolt\Filament\Resources\CategoryResource;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use LaraZeus\Bolt\Http\Livewire\FillForms;
use LaraZeus\Bolt\Http\Livewire\ListEntries;
use LaraZeus\Bolt\Http\Livewire\ListForms;
use LaraZeus\Bolt\Http\Livewire\Submitted;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;

class BoltServiceProvider extends PluginServiceProvider
{
    public static string $name = 'zeus-bolt';

    protected function getResources(): array
    {
        return [
            CollectionResource::class,
            FormResource::class,
            ResponseResource::class,
            CategoryResource::class,
        ];
    }

    public function boot()
    {
        View::share('bolt-theme', 'zeus-bolt::themes.' . config('zeus-bolt.theme', 'zeus'));

        App::singleton('bolt-theme', function () {
            return 'zeus-bolt::themes.' . config('zeus-bolt.theme', 'zeus');
        });

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

        return parent::boot();
    }

    public function configurePackage(Package $package): void
    {
        parent::configurePackage($package);
        $package
            ->hasConfigFile()
            ->hasMigrations([
                'create_categories_table',
                'create_collections_table',
                'create_forms_table',
                'create_sections_table',
                'create_fields_table',
                'create_responses_table',
                'create_field_responses_table',
                'add_fields_to_sections_table',
            ])
            ->hasTranslations()
            ->hasCommand(PublishCommand::class)
            ->hasRoute('web');
    }
}
