<?php

namespace LaraZeus\Bolt\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Facades\Collectors;

class BoltService 
{
    public function availableFields(): Collection 
    {
        if (app()->isLocal()) {
            Cache::forget('bolt.fields');
        }

        return Cache::remember('bolt.fields', Carbon::parse('1 month'), function () {
            $coreFields = Collectors::collectClasses(__DIR__ . '/../Fields/Classes', 'LaraZeus\\Bolt\\Fields\\Classes\\');
            $appFields = Collectors::collectClasses(base_path(config('zeus-bolt.collectors.fields.path')), config('zeus-bolt.collectors.fields.namespace'));

            $fields = collect();

            if ($coreFields->isNotEmpty()) {
                $fields = $fields->merge($coreFields);
            }

            if ($appFields->isNotEmpty()) {
                $fields = $fields->merge($appFields);
            }

            if (Bolt::hasPro()) {
                $boltProFields = Collectors::collectClasses(
                    base_path('vendor/lara-zeus/bolt-pro/src/Fields'),
                    'LaraZeus\\BoltPro\\Fields\\'
                );

                if ($boltProFields->isNotEmpty()) {
                    $fields = $fields->merge($boltProFields);
                }
            }

            return $fields->sortBy('sort');
        });
    }
}
