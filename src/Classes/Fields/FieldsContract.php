<?php

namespace LaraZeus\Bolt\Classes\Fields;

abstract class FieldsContract implements Fields
{
    public $definition = [];
    public $disabled   = false;

    public function showResponse($field, $ans) : string
    {
        return $ans->response;
    }

    public function exportResponse($response)
    {
        return $response->response;
    }

    public function apiResponse($response)
    {
        return $response->response;
    }
}
