<?php

namespace LaraZeus\Bolt\Http\Livewire\Admin;

use LaraZeus\Bolt\Models\Form;
use Livewire\Component;

class Section extends Component
{
    use UsesBlankData;

    public $sections;
    public $modals = [
        'SectionOptions' => false,
    ];
    public $formId;

    protected $listeners = ['formSaved' => 'store'];
    protected $validationAttributes = [
        'sections.*.name' => 'section name',
    ];

    public function mount($formId)
    {
        $this->formId = $formId;

        if ($formId === null) {
            $this->sections = \Illuminate\Database\Eloquent\Collection::make();
            $this->sections->push($this->sectionData());
        } else {
            $this->sections = Form::find($formId)->sections;
        }
    }

    public function rules()
    {
        return [
            'sections.*.name' => 'sometimes',
            'sections.*.ordering' => 'sometimes',
        ];
    }

    public function addSection()
    {
        $this->sections->push($this->sectionData());
    }

    public function removeSection($index)
    {
        unset($this->sections[$index]);
    }

    public function addField($index)
    {
        $this->emit('addField', $index);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store($form)
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->notify('validation error...', 'error');
            throw $e;
        }

        foreach ($this->sections as $section) {
            $section->form_id = $form;
            $section->save();

            $this->emit('sectionSaved', $form, $section->id);
        }
    }

    public function render()
    {
        return view('zeus-bolt::forms.create-section');
    }
}
