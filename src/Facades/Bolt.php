<?php

namespace LaraZeus\Bolt\Facades;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class Bolt extends Facade
{
    protected static function getFacadeAccessor() : string
    {
        return 'bolt';
    }

    public static function availableFields()
    {
        if (app()->isLocal()) {
            Cache::forget('bolt.fields');
        }

        return Cache::remember('bolt.fields', Carbon::parse('1 month'), function () {
            $appFields  = Bolt::appFields();
            $coreFields = Bolt::coreFields();

            $fields = collect();

            if (!$coreFields->isEmpty()) {
                $fields = $fields->merge($coreFields);
            }

            if (!$appFields->isEmpty()) {
                $fields = $fields->merge($appFields);
            }

            return $fields->sortBy('order');
        });
    }

    public static function coreFields()
    {
        $path = __DIR__ . '/../Fields/Classes';
        if (!is_dir($path)) {
            return collect();
        }
        $classes   = Bolt::loadClasses($path, 'LaraZeus\\Bolt\\Fields\\Classes\\');
        $allFields = Bolt::setFields($classes, true);

        return collect($allFields);
    }

    public static function appFields()
    {
        $path = app_path('Zeus/Fields');
        if (!is_dir($path)) {
            return collect();
        }
        $classes   = Bolt::loadClasses($path, 'App\\Zeus\\Fields\\');
        $allFields = Bolt::setFields($classes, false);

        return collect($allFields);
    }

    protected static function setFields($classes, $isZeus)
    {
        $allFields = [];
        foreach ($classes as $class) {
            $fieldClass = new $class();
            if (!$fieldClass->disabled) {
                $fieldClass->definition['isZeus'] = $isZeus;
                $allFields[]                      = $fieldClass->definition;
            }
        }

        return $allFields;
    }

    public static function loadClasses($path, $namespace)
    {
        $classes = [];
        $path    = array_unique(Arr::wrap($path));

        foreach (( new Finder() )->in($path)->files() as $className) {
            $classes[] = $namespace . $className->getFilenameWithoutExtension();
        }

        return $classes;
    }

    public static function availableValidation()
    {
        $rules = [
            'accepted',
            'active_url',
            'after:date', //YYYY-MM-DD
            'before:date', //YYYY-MM-DD
            'alpha',
            'alpha_dash',
            'alpha_num',
            'array',
            'between:text', //1,10
            'confirmed',
            'date',
            'date_format:dateFormat', //YYYY-MM-DD
            //'different:fieldname',
            'digits:text', //value
            'digits_between:maxMin', //min,max
            'boolean',
            'email',
            //'exists:table,column',
            'image',
            'in:text', //foo,bar,...
            'not_in:text', //foo,bar,...
            'integer',
            'numeric',
            'ip',
            'max:text', //value
            'min:text', //value
            'mimes:text', //jpeg,png
            'regex:text', //[0-9]
            'required',
            //'required_if:field,value',
            //'required_with:foo,bar,...',
            //'required_with_all:foo,bar,...',
            //'required_without:foo,bar,...',
            //'required_without_all:foo,bar,...',
            //'same:field',
            'size:text', //value
            'timezone',
            //'unique:table,column,except,idColumn',
            'url',
        ];

        return collect($rules)
            ->mapWithKeys(function ($item) {
                $rule = (Str::contains($item, ':')) ? explode(':', $item)[0] : $item;
                return [$rule => str_replace('_', ' ', $rule)];
            })
            /*->transform(function ($item) {
                return [
                    'rule' => $item,
                    'label' => str_replace(
                        '_',
                        ' ',
                        (Str::contains($item, ':'))
                            ? explode(':', $item)[0]
                            : $item),
                ];
            })*/
            ->toArray();
    }

}
