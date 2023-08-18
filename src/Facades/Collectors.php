<?php

namespace LaraZeus\Bolt\Facades;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Symfony\Component\Finder\Finder;

class Collectors
{
    public static function collectClasses($path, $namespace): Collection
    {
        if (! is_dir($path)) {
            return collect();
        }

        return collect(
            Collectors::buildClasses(
                Collectors::loadClasses($path, $namespace)
            )
        );
    }

    protected static function buildClasses($classes): array
    {
        $allClasses = [];
        foreach ($classes as $class) {
            $getClass = new $class();
            if (! $getClass->disabled) {
                $allClasses[] = $getClass->toArray();
            }
        }

        return $allClasses;
    }

    public static function loadClasses($path, $namespace): array
    {
        $classes = [];
        $path = array_unique(Arr::wrap($path));

        foreach ((new Finder())->in($path)->files() as $className) {
            $classes[] = $namespace . $className->getFilenameWithoutExtension();
        }

        return $classes;
    }
}
