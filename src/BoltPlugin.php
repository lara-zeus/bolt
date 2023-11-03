<?php

namespace LaraZeus\Bolt;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use LaraZeus\Bolt\Filament\Resources\CategoryResource;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;

final class BoltPlugin implements Plugin
{
    use Configuration;
    use EvaluatesClosures;

    public function getId(): string
    {
        return 'zeus-bolt';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->discoverWidgets(in: base_path('vendor/lara-zeus/bolt/src/Filament/Resources/FormResource/Widgets'), for: 'LaraZeus\\Bolt\\Filament\\Resources\\FormResource\\Widgets')
            ->resources([
                CollectionResource::class,
                FormResource::class,
                ResponseResource::class,
                CategoryResource::class,
            ]);

        if(class_exists(\LaraZeus\BoltPro\BoltProServiceProvider::class)){
            $panel
                ->discoverWidgets(in: base_path('vendor/lara-zeus/bolt-pro/src/Widgets'), for: 'LaraZeus\\BoltPro\\Widgets');
        }
    }

    public static function make(): static
    {
        return new self();
    }

    public static function get(): static
    {
        // @phpstan-ignore-next-line
        return filament('zeus-bolt');
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
