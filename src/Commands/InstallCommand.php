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
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-bolt-migrations']);

        $this->info('publishing assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-assets']);

        $this->info('running migrations...');
        $this->callSilent('migrate');

        $this->output->success('Zeus Bolt has been Installed successfully');
    }
}
