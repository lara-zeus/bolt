<?php

namespace LaraZeus\Bolt\DataSources;

use Illuminate\Contracts\Support\Arrayable;
use LaraZeus\Bolt\Contracts\DataSource;

abstract class DataSourceContract implements Arrayable, DataSource
{
    public bool $disabled = false;

    public function getSort(): int
    {
        return 1;
    }

    public function toArray(): array
    {
        return [
            'getValuesUsing' => $this->getValuesUsing(),
            'getKeysUsing' => $this->getKeysUsing(),
            'getModel' => $this->getModel(),
            'title' => $this->title(),
            'sort' => $this->getSort(),
            'class' => '\\' . get_called_class(),
        ];
    }
}
