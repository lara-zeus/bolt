<?php

namespace LaraZeus\Bolt\DataSources;

use Illuminate\Contracts\Support\Arrayable;
use RuntimeException;

class DataSourceData implements Arrayable
{
    public function __construct(
        protected string $title,
        protected DataSourceEnumContract | string $class,
        protected bool $disabled = false,
        protected int $sort = 1,
    ) {
        $this->class($class);
    }

    public static function make(): static
    {
        return new self(...func_get_args());
    }

    public function title(string $title): DataSourceData
    {
        $this->title = $title;

        return $this;
    }

    public function class(string | DataSourceEnumContract $class): DataSourceData
    {
        if (
            is_string($class) &&
            (! enum_exists($class) || ! is_a($class, DataSourceEnumContract::class, allow_string: true))
        ) {
            throw new RuntimeException("Enum Class $class must implements " . DataSourceEnumContract::class);
        }

        $this->class = $class;

        return $this;
    }

    public function disabled(bool $disabled): DataSourceData
    {
        $this->disabled = $disabled;

        return $this;
    }

    public function sort(int $sort): DataSourceData
    {
        $this->sort = $sort;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'class' => $this->class,
            'disabled' => $this->disabled,
            'sort' => $this->sort,
        ];
    }
}
