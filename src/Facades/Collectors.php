<?php

namespace LaraZeus\Bolt\Facades;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use LaraZeus\Bolt\Contracts\DataSourceEnum;
use Symfony\Component\Finder\Finder;

class Collectors
{
    public static function collectClasses(string $path, string $namespace): Collection
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

    protected static function buildClasses(array $classes): array
    {
        $allClasses = [];
        foreach ($classes as $class) {
            if (enum_exists($class)) {
                if (is_a($class, DataSourceEnum::class, allow_string: true)) {
                    $dataSourceData = $class::toDataSourceData()->toArray();
                    if ($dataSourceData['disabled']) {
                        continue;
                    }
                    $allClasses[str($class)->explode('\\')->last()] = $dataSourceData;
                }

                continue;
            }

            $getClass = new $class;
            if (! $getClass->disabled) {
                $allClasses[str($class)->explode('\\')->last()] = $getClass->toArray();
            }
        }

        return $allClasses;
    }

    public static function loadClasses(string $path, string $namespace): array
    {
        $classes = [];
        $path = array_unique(Arr::wrap($path));

        foreach ((new Finder)->in($path)->files() as $className) {
            $classes[] = $namespace . $className->getFilenameWithoutExtension();
        }

        return $classes;
    }
}
