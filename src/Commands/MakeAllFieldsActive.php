<?php

namespace LaraZeus\Bolt\Commands;

use Illuminate\Console\Command;

class MakeAllFieldsActive extends Command
{
    protected $signature = 'bolt:activate-fields';

    protected $description = 'Make All Bolt Fields Active by default';

    public function handle(): void
    {
        $fields = config('zeus-bolt.models.Field')::query()->get();
        foreach ($fields as $field) {
            $options = $field->options;
            if (! isset($options['is_active'])) {
                $options['is_active'] = 1;
            }
            $field->update(['options' => $options]);
        }
        $this->output->success('All old fields has been updated to be active by default!');
    }
}
