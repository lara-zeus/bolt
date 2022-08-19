<?php

namespace LaraZeus\Bolt\Fields;

interface Fields
{
    public function showResponse($field, $ans): string;

    public function exportResponse($values);
}
