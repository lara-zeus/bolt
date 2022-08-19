<?php

namespace LaraZeus\Bolt\Http\Livewire\Admin;

use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use LaraZeus\Bolt\Models\Collection;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\Form;
use Livewire\Component;

class Fields extends Component
{
    use UsesBlankData;

    public $fields;
    public $sec;
    //public $fieldsModals = [];
    //public $fieldsModalsItems = [ 'settings' => false ];
    public $formId;
    public $allCollection;
    protected $listeners = ['addField', 'collectionSaved', 'sectionSaved' => 'store'];
    protected $validationAttributes
        = [
            'fields.*.*.type' => 'field type',
            'fields.*.*.name' => 'field name',
        ];

    public function addCollection($collectionId)
    {
        $this->emit('addCollection', $collectionId);
    }

    public function collectionSaved($collectionID, $fld)
    {
        $this->allCollection = Collection::orderBy('id', 'desc')->get();

        $this->fields[$this->sec][$fld]['options']['dataSource'] = $collectionID;
    }

    public function mount($formId, $sec)
    {
        $this->allCollection = Collection::orderBy('id', 'desc')->get();
        $this->formId = $formId;
        $this->sec = $sec;

        if ($formId === null) {
            $this->fields[$this->sec][] = $this->fieldData($this->sec);
        //$this->fieldsModals[$this->sec][] = $this->fieldsModalsItems;
        } else {
            $this->fields[$this->sec] = Form::find($formId)
                ->fields()
                ->where('section_id', $this->sec)
                ->orderBy('ordering')
                ->get()/*->mapWithKeys(function ($item, $key) {
                    return [$item['id'] => $item];
                })*/
;
            /*foreach ($this->fields[$this->sec] as $field) {
                $this->fieldsModals[$this->sec][$field['id']] = $this->fieldsModalsItems;
            }*/
        }
    }

    public function rules()
    {
        return [
            'fields.*.*.name'        => 'required',
            'fields.*.*.description' => 'sometimes',
            'fields.*.*.ordering'    => 'sometimes',
            'fields.*.*.section_id'  => 'required',
            'fields.*.*.type'        => 'required',

            'fields.*.*.rules'   => 'sometimes',
            'fields.*.*.options' => 'sometimes',
        ];
    }

    public function addField($index)
    {
        $this->fields[$index][] = $this->fieldData($index);
        //$this->fieldsModals[$this->sec][] = $this->fieldsModalsItems;
    }

    public function addRule($fld)
    {
        $this->fields[$this->sec][$fld]['rules'] = ['rule', 'options'];
    }

    /*public function openFieldModals($index, $type)
    {
        $this->fieldsModals[$this->sec][$index][$type] = true;
    }*/

    public function removeField($index)
    {
        unset($this->fields[$this->sec][$index]);
        //unset($this->fieldsModals[$this->sec][$index]);
    }

    public function orderField($sec, $fld)
    {
        $this->fields[$sec][$fld]['ordering'] = 3;
    }

    public function store($form, $section)
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            Notification::make()->title(__('validation error...'))->danger()->send();
            throw $e;
        }

        foreach ($this->fields[$this->sec] as $field) {
            $setField = Field::firstOrNew(['html_id' => $field['html_id']]);
            $setField->form_id = $form;
            $setField->section_id = $this->sec;
            $setField->name = $field['name'];
            $setField->description = $field['description'] ?? null;
            $setField->type = $field['type'];
            $setField->options = $field['options'];
            $setField->rules = $field['rules'];
            $setField->layout_position = $field['layout_position'] ?? 1;
            $setField->ordering = $field['ordering'];

            $setField->save();
        }

        Notification::make()->title(__('your form has been saved!'))->success()->send();

        return redirect()->route('admin.form.edit', ['formId' => $form]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('zeus-bolt::forms.create-field');
    }
}
