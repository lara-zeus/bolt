<?php

namespace LaraZeus\Bolt\Contracts;

use Illuminate\Contracts\Support\Htmlable;
use LaraZeus\Bolt\DataSources\DataSourceData;

interface DataSourceEnum
{
    public function getDataSourceLabel(): string | Htmlable | null;

    public static function toDataSourceData(): DataSourceData;
}
