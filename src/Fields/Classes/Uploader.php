<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Bolt\Fields\FieldsContract;

class Uploader extends FieldsContract
{
    public $disabled = false;

    public function __construct()
    {
        $this->definition = [
            'type' => 'uploader',
            'title' => 'FileUpload',
            'icon' => 'fa-cloud-upload',
            'settings_view' => 'file-upload',
            'order' => 7,
        ];
    }

    public function showResponse($field, $ans): string
    {
        $out = '<a class="show-for-print" target="_blank" href="'.$ans->response.'">'.$ans->response.'</a>';
        $out .= '<a class="hide-for-print" target="_blank" href="'.$ans->response.'">'.trans('Crud.show').'</a>';

        return $out;
    }
}
