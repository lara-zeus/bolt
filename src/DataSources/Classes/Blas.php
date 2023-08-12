<?php

namespace LaraZeus\Bolt\DataSources\Classes;

use App\Models\Bla;
use LaraZeus\Bolt\DataSources\DataSourceContract;

class Blas extends DataSourceContract
{
    public function title(): string{
        return 'Blas';
    }

    public static function getValuesUsing(): string{
        return 'name';
    }

    public static function getKeysUsing(): string{
        return 'code';
    }

    public function getModel(): string{
        return Bla::class;
    }
}
