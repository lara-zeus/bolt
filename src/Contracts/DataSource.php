<?php

namespace LaraZeus\Bolt\Contracts;

interface DataSource
{
    public function title(): string;

    public function getSort(): int;

    public function getValuesUsing(): string;

    public function getKeysUsing(): string;

    public function getModel(): string;
}
