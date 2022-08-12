<?php

namespace LaraZeus\Bolt\Http\Livewire\User;

use LaraZeus\Bolt\Models\FieldResponse;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;
use Livewire\Component;

class FillForms extends Component
{
    public $form;
    public $slug;
    public $response;
    public $fieldResponse;
    public $rules;

    public $validationAttributes = [];

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->form = Form::with(['sections', 'fields'])->whereSlug($slug)->firstOrFail();
        $this->response = Response::make([
            'form_id' => $this->form->id,
            'user_id' => (auth()->check()) ? auth()->user()->id : 0,
            'status' => 'NEW',
            'notes' => '',
        ]);

        foreach ($this->form->fields as $field) {
            $this->fieldResponse[$field->id] = FieldResponse::make([
                'form_id' => $this->form->id,
                'field_id' => $field->id,
                'response_id' => $this->response->id,
                'response' => '',
            ]);
        }

        $rules = $validationAttributes = [];
        foreach ($this->form->fields as $field) {
            $rules['fieldResponse.'.$field->id.'.response'] = $field->rules;
            $validationAttributes['fieldResponse.'.$field->id.'.response'] = $field->name;
        }

        $rules['response.form_id'] = 'sometimes';
        $rules['response.status'] = 'sometimes';
        $rules['response.notes'] = 'sometimes';
        $rules['response.user_id'] = 'sometimes';

        $rules['fieldResponse.*.user_id'] = 'sometimes';
        $rules['fieldResponse.*.form_id'] = 'sometimes';
        $rules['fieldResponse.*.field_id'] = 'sometimes';
        $rules['fieldResponse.*.response_id'] = 'sometimes';
        $rules['fieldResponse.*.response'] = 'sometimes';

        $this->rules = $rules;
        $this->validationAttributes = $validationAttributes;
    }

    public function resetAll()
    {
        $this->reset();
    }

    public function store()
    {
        $this->validate();
        $this->response->save();
        foreach ($this->fieldResponse as $fld => $item) {
            $item['response_id'] = $this->response->id;
            FieldResponse::create($item);
        }

        return redirect()->route('bolt.user.submitted',['slug'=>$this->form->slug]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('zeus-bolt::forms.fill-forms')->layout('zeus::components.app', ['withoutSideNav' => true]);
    }
}
