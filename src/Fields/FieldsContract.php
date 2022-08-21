<?php

namespace LaraZeus\Bolt\Fields;

use Filament\Forms\Components\Placeholder;

abstract class FieldsContract implements Fields
{
    public $definition = [];
    public $disabled = false;

    public function showResponse($field, $ans): string
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

    public static function getOptions()
    {
        return [
            Placeholder::make('No options available')
        ];
    }
}
