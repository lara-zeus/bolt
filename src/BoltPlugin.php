<?php

namespace LaraZeus\Bolt;

use Filament\Contracts\Plugin;
use Filament\Panel;
use LaraZeus\Bolt\Filament\Resources\CategoryResource;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;

class BoltPlugin implements Plugin
{
    public function getId(): string
    {
        return 'zeus-bolt';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                CollectionResource::class,
                FormResource::class,
                ResponseResource::class,
                CategoryResource::class,
            ]);
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
