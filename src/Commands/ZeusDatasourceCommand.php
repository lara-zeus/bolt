<?php

namespace LaraZeus\Bolt\Commands;

use Illuminate\Console\Command;
use LaraZeus\Bolt\Concerns\CanManipulateFiles;

class ZeusDatasourceCommand extends Command
{
    use CanManipulateFiles;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:zeus-datasource {name : Datasource Name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create custom Datasource for zeus bolt';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $filamentPluginFullNamespace = $this->argument('name');

        $this->copyStubToApp('ZeusDataSources', 'app/Zeus/DataSources/' . $filamentPluginFullNamespace . '.php', [
            'namespace' => 'App\\Zeus\\DataSources',
            'class' => $filamentPluginFullNamespace,
        ]);

        $this->info('zeus datasource created successfully!');
    }
}
