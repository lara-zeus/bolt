<?php

namespace LaraZeus\Bolt\Contracts;

use Filament\Schemas\Components\Tabs\Tab;

interface CustomFormSchema
{
    public function make(): Tab;
}
