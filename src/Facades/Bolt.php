<?php

namespace LaraZeus\Bolt\Facades;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;
use Symfony\Component\Finder\Finder;

class Bolt extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bolt';
    }

    public static function availableFields()
    {
        if (app()->isLocal()) {
            Cache::forget('bolt.fields');
        }

        return Cache::remember('bolt.fields', Carbon::parse('1 month'), function () {
            $coreFields = Bolt::collectFields(__DIR__.'/../Fields/Classes','LaraZeus\\Bolt\\Fields\\Classes\\');
            $appFields = Bolt::collectFields(app_path('Zeus/Fields'), 'App\\Zeus\\Fields\\');

            $fields = collect();

            if (! $coreFields->isEmpty()) {
                $fields = $fields->merge($coreFields);
            }

            if (! $appFields->isEmpty()) {
                $fields = $fields->merge($appFields);
            }

            return $fields->sortBy('sort');
        });
    }

    public static function collectFields($path, $namespace)
    {
        if (! is_dir($path)) {
            return collect();
        }
        $classes = Bolt::loadClasses($path, $namespace);
        $allFields = Bolt::setFields($classes);

        return collect($allFields);
    }

    protected static function setFields($classes)
    {
        $allFields = [];
        foreach ($classes as $class) {
            $fieldClass = new $class();
            if (! $fieldClass->disabled) {
                $allFields[] = $fieldClass->toArray();
            }
        }
        return $allFields;
    }

    public static function loadClasses($path, $namespace)
    {
        $classes = [];
        $path = array_unique(Arr::wrap($path));

        foreach (( new Finder() )->in($path)->files() as $className) {
            $classes[] = $namespace.$className->getFilenameWithoutExtension();
        }

        return $classes;
    }
}
