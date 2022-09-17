<?php

namespace LaraZeus\Bolt\Fields;

use Illuminate\Contracts\Support\Arrayable;

abstract class FieldsContract implements Fields, Arrayable
{
    public $disabled = false;

    public $renderClass;

    public $code;

    public $sort;

    public function toArray()
    {
        return [
            'disabled' => $this->disabled,
            'class' => $this->getClass(),
            'renderClass' => $this->renderClass,
            'hasOptions' => $this->hasOptions(),
            'code' => $this->getCode(),
            'sort' => $this->sort,
            'title' => $this->title(),
        ];
    }

    public function getCode()
    {
        return class_basename($this);
    }

    public function title()
    {
        return __(class_basename($this));
    }

    public function getClass()
    {
        return '\\' . get_called_class();
    }

    public function hasOptions(): bool
    {
        return method_exists(get_called_class(), 'getOptions');
    }

    public function getResponse($field, $resp): string
    {
        return $resp->response;
    }
}
