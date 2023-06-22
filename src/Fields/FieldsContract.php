<?php

namespace LaraZeus\Bolt\Fields;

use Illuminate\Contracts\Support\Arrayable;
use LaraZeus\Bolt\Contracts\Fields;
use LaraZeus\Bolt\Facades\Bolt;

abstract class FieldsContract implements Fields, Arrayable
{
    public bool $disabled = false;

    public string $renderClass;

    public string $code;

    public int $sort;

    public function toArray(): array
    {
        return [
            'disabled' => $this->disabled,
            'class' => '\\' . get_called_class(),
            'renderClass' => $this->renderClass,
            'hasOptions' => $this->hasOptions(),
            'code' => $this->getCode(),
            'sort' => $this->sort,
            'title' => $this->title(),
        ];
    }

    public function getCode(): string
    {
        return class_basename($this);
    }

    public function title(): string
    {
        return __(class_basename($this));
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
            ->id($zeusField->options['htmlId'] ?? str()->random(6))
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

    public function getCollectionsValuesForResponse($field, $resp): string
    {
        $items = $resp->response;

        if (empty($items)) {
            return $items;
        }

        if (Bolt::jsJson($resp->response)) {
            $items = json_decode($resp->response);
        } else {
            $items = [$items];
        }

        $options = config('zeus-bolt.models.Collection')::find($field->options['dataSource']);
        if ($options === null) {
            return $items;
        }

        $options = collect($options->values);

        if (is_array($items)) {
            $options = $options->whereIn('itemKey', $items)->pluck('itemValue')->join(', ');
        } else {
            $options = $options->where('itemKey', $items)->pluck('itemValue');
        }

        if (is_countable($options) && $options->isNotEmpty()) {
            $options = $options->join(' - ');
        }

        if (empty($options)) {
            $options = implode('-', $items);
        }

        return $options;
    }
}
