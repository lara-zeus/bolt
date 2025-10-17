<?php

namespace LaraZeus\Bolt\DataSources;

use Illuminate\Contracts\Support\Htmlable;

interface DataSourceEnumContract
{
    public function getDataSourceLabel(): string | Htmlable | null;

    public static function toDataSourceData(): DataSourceData;
}
