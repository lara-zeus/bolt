<?php

namespace LaraZeus\Bolt\DataSources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use LaraZeus\Bolt\Contracts\DataSource;

abstract class DataSourceContract implements Arrayable, DataSource
{
    public bool $disabled = false;

    public function getSort(): int
    {
        return 1;
    }

    public function getQuery(): Builder | Collection
    {
        return resolve($this->getModel())->query();
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
