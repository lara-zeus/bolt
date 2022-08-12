<?php

namespace LaraZeus\Bolt\Classes;

use LaraZeus\Bolt\Models\Collection;

class Builder
{
  /*  public $lang = '';
    public $fieldTitle = '';
    public $fieldDesc = '';
    public $require = '';
    public $requireClass = '';
    public $validations = '';
    public $defaultValues = [];
    public $options = [];
    public $id = '';
    public $parent_id = '';*/

/*    public function __construct($field)
    {
        $this->fieldObj  = $field;
        $this->id   = $field->id;
        $this->fieldType = $field->type;
        $this->parent_id = $field->parent_id;
        $this->options   = json_decode($field->options);

        $this->require       = ( isset($this->options->isRequire) && !empty($this->options->isRequire) ) ? 'required' : '';
        $this->requireClass  = ( isset($this->options->isRequire) && !empty($this->options->isRequire) ) ? '<span class="text-alert">*</span>' : '';
        $this->validations   = ( isset($this->options->validations) && !empty($this->options->validations) ) ? $this->options->validations : '';
        $this->defaultValues = ( isset($this->options->defaultValues) && !empty($this->options->defaultValues) ) ? (array) $this->options->defaultValues : [];
    }*/

    /**
     * main field Render
     *
     * @return string
     */
    /*public function fieldRender($field, $dataSet = [], $urlValues = null)
    {
        $out = '';

        if ($field->type !== 'paragraph') {
            // todo make class
            $out .= '<input type="hidden" name="field_id[]" value="' . $field->id . '">';
            $out .= '<div>';
        } else {
            $out .= "<div class='callout'>";
        }

        $renderClass = 'LaraZeus\Core\\Classes\\Fields\\Classes\\' . ucfirst($field->type);
        if (class_exists($renderClass)) {
            $out .= ( new $renderClass() )->showInForm($field,$dataSet, $urlValues);
        }

        $out .= '</div><hr>';

        return $out;
    }*/

    public function getData($field)
    {
        $listVars = [];

        if ($field->type === 'customList') {
            $listVars = Collection::find($field->options['dataSource']);
        }

        return $listVars;
    }
}
