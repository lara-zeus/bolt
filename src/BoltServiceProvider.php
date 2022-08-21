<?php

namespace LaraZeus\Bolt;

use Filament\PluginServiceProvider;
use LaraZeus\Bolt\Console\PublishCommand;
use LaraZeus\Bolt\Filament\Resources\CategoryResource;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use LaraZeus\Bolt\Http\Livewire\Admin\CreateCollection;
use LaraZeus\Bolt\Http\Livewire\Admin\CreateForms;
use LaraZeus\Bolt\Http\Livewire\Admin\Fields;
use LaraZeus\Bolt\Http\Livewire\Admin\Section;
use LaraZeus\Bolt\Http\Livewire\User\FillForms;
use LaraZeus\Bolt\Http\Livewire\User\ListEntries;
use LaraZeus\Bolt\Http\Livewire\User\ListForms;
use LaraZeus\Bolt\Http\Livewire\User\Submitted;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;

class BoltServiceProvider extends PluginServiceProvider
{
    public static string $name = 'zeus-bolt';

    protected array $styles = [
        'zeus-bolt-styles' => __DIR__.'/../resources/dist/app.css',
    ];

    /*protected function getStyles() : array
    {
        return [
            'zeus-bolt-styles' => 'https://demo.test/vendor/zeus-bolt/app.css',
        ];
    }*/

    protected array $beforeCoreScripts = [
        //'zeus-bolt-popperjs' => 'https://unpkg.com/@popperjs/core@2',
        //'zeus-bolt-tippy' => 'https://unpkg.com/tippy.js@6',
        //'zeus-bolt-sortable' => 'https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js',
    ];

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
        Livewire::component('bolt.create-section', Section::class);
        Livewire::component('bolt.create-field', Fields::class);
        Livewire::component('bolt.submitted', Submitted::class);
        Livewire::component('bolt.create-forms', CreateForms::class);
        Livewire::component('bolt.fill-form', FillForms::class);
        Livewire::component('bolt.list-forms', ListForms::class);
        Livewire::component('bolt.manage-entries', ListEntries::class);
        Livewire::component('forms.create-collection', CreateCollection::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/seeders' => database_path('seeders'),
            ], 'zeus-bolt-seeder');

            $this->publishes([
                __DIR__.'/../database/factories' => database_path('factories'),
            ], 'zeus-bolt-factories');
        }

        seo()
            ->site(config('app.name', 'Laravel'))
            ->title(config('zeus-bolt.site_title'))
            ->description(config('zeus-bolt.site_description'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="'.asset('favicon/favicon.ico').'">')
            ->rawTag('<meta name="theme-color" content="'.config('zeus-bolt.site_color').'" />')
            ->withUrl()
            ->twitter();

        return parent::boot();
    }

    public function configurePackage(Package $package): void
    {
        parent::configurePackage($package);
        $package
            ->hasConfigFile()
            ->hasMigrations([
                'create_collections_table',
                'create_forms_table',
                'create_sections_table',
                'create_fields_table',
                'create_responses_table',
                'create_field_responses_table',
                'create_categories_table',
            ])
            ->hasTranslations()
            ->hasCommand(PublishCommand::class)
            ->hasRoute('web');
    }
}
