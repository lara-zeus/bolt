<?php

namespace LaraZeus\Bolt;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use LaraZeus\Bolt\Filament\Resources\CategoryResource;
use LaraZeus\Bolt\Filament\Resources\CollectionResource;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Core\Concerns\CanGloballySearch;

final class BoltPlugin implements Plugin
{
    use CanGloballySearch;
    use Configuration;
    use EvaluatesClosures;

    public array $defaultGloballySearchableAttributes = [
        CategoryResource::class => ['name', 'slug'],
        CollectionResource::class => ['name', 'values'],
        FormResource::class => ['name', 'slug'],
    ];

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
                CategoryResource::class,
            ]);
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
