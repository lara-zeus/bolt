<?php

namespace LaraZeus\Bolt\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'bolt:install';

    protected $description = 'install bolt';

    public function handle(): void
    {
        $this->info('publishing migrations...');
        $this->call('vendor:publish', ['--tag' => 'zeus-bolt-migrations']);
        $this->call('vendor:publish', ['--tag' => 'zeus-bolt-config']);

        $this->info('publishing assets...');
        $this->call('vendor:publish', ['--tag' => 'zeus-assets']);

        if ($this->confirm('Do you want to run the migration now?', true)) {
            $this->info('running migrations...');
            $this->call('migrate');
        }

        $this->output->success('Zeus Bolt has been Installed successfully, consider ⭐️ the package in filament site :)');
    }
}
