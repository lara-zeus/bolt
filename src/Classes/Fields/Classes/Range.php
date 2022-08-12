<?php

namespace LaraZeus\Bolt\Classes\Fields\Classes;

use LaraZeus\Bolt\Classes\Fields\FieldsContract;

class Range extends FieldsContract
{
    public $disabled = true;

    public function __construct()
    {
        $this->definition = [
            'type' => 'range',
            'title' => 'Range',
            'icon' => 'fa-dot-circle-o',
            'settings_view' => 'range',
            'order' => 14,
        ];
    }

    public function showResponse($field, $ans): string
    {
        $options = $field->options;

        if (in_array($options->rangeType, ['badToGood', 'satisfaction'])) {
            return $this->getValues($options->rangeType)[$ans->response] ?? '';
        }

        return parent::showResponse($field, $ans);
    }

    public function exportResponse($response)
    {
        $field = Fields::find($response->field_id);

        $options = json_decode($field->options);

        if (in_array($options->rangeType, ['badToGood', 'satisfaction'])) {
            return $this->getValues($options->rangeType)[$response->response] ?? '';
        }

        return parent::exportResponse($response);
    }

    public function getValues($name, $start = 0, $end = 1): array
    {
        $numeric = array_combine(range($start, $end), range($start, $end));

        $badToGood = [
            'bad' => trans('Backend/App/Forms.bad'),
            'acceptable' => trans('Backend/App/Forms.acceptable'),
            'good' => trans('Backend/App/Forms.good'),
            'veryGood' => trans('Backend/App/Forms.veryGood'),
            'excellent' => trans('Backend/App/Forms.excellent'),
        ];

        $satisfaction = [
            'veryNotSatisfied' => trans('Backend/App/Forms.veryNotSatisfied'),
            'notSatisfied' => trans('Backend/App/Forms.notSatisfied'),
            'someSatisfied' => trans('Backend/App/Forms.someSatisfied'),
            'satisfied' => trans('Backend/App/Forms.satisfied'),
            'verySatisfied' => trans('Backend/App/Forms.verySatisfied'),
        ];

        $stars = array_combine(range(1, 5), range(1, 5));

        return $$name ?? [];
    }
}
