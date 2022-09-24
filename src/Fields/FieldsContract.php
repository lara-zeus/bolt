<?php

namespace LaraZeus\Bolt\Fields;

use Illuminate\Contracts\Support\Arrayable;

abstract class FieldsContract implements Fields, Arrayable
{
    public bool $disabled = false;

    public string $renderClass;

    public string $code;

    public int $sort;

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

    public function appendFilamentComponentsOptions($component, $zeusField)
    {
        $component
            ->label($zeusField->name)
            ->id($zeusField->html_id)
            ->helperText($zeusField->description);

        if (isset($zeusField->options['prefix']) && $zeusField->options['prefix'] !== null) {
            $component = $component->prefix($zeusField->options['prefix']);
        }

        if (isset($zeusField->options['suffix']) && $zeusField->options['suffix'] !== null) {
            $component = $component->suffix($zeusField->options['suffix']);
        }

        if (isset($zeusField->options['is_required']) && $zeusField->options['is_required']) {
            $component = $component->required();
        }

        return $component;
    }
}
