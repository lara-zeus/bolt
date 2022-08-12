<?php

namespace LaraZeus\Bolt\Classes\Fields;

interface Fields
{
    public function showResponse($field,$ans): string;

    public function exportResponse($values);
}
