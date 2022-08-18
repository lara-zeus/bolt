<?php

namespace LaraZeus\Bolt\Http\Livewire\User;

use LaraZeus\Bolt\Models\FieldResponse;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;
use Livewire\Component;
use Filament\Forms;

class FillForms extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public Form $zeusForm;
    public $zeusData = [];

    protected function getFormSchema() : array
    {
        $sections = [];
        foreach ($this->zeusForm->sections as $section) {
            $fields = [];
            foreach ($section->fields as $field) {
                $class    = '\Filament\Forms\Components\\' . $field->type;
                $fields[] = Forms\Components\Card::make()->schema([
                    $class::make('zeusData.' . $field->id)
                        ->label($field->name)
                        ->helperText($field->description)
                        ->id($field->html_id)
                        ->rules(collect($field->rules)->pluck('rule')->toArray())
                    //->extraAttributes(['title' => 'Text input'])
                    //->default()
                    //->hint('[Forgotten your password?](forgotten-password)')
                    //->hintIcon('heroicon-s-translate')
                    //->placeholder('John Doe')
                ]);
            }

            $sections[] = Forms\Components\Section::make($section->name)->schema($fields);
        }

        return $sections;
    }

    protected function getFormModel() : Form
    {
        return $this->zeusForm;
    }

    public function mount($slug)
    {
        $this->zeusForm = Form::with([ 'sections', 'fields' ])->whereSlug($slug)->firstOrFail();

        foreach ($this->zeusForm->fields as $field) {
            $this->zeusData[$field->id] = '';
            /*$this->fieldResponse[$field->id] = FieldResponse::make([
                'form_id'     => $this->zeusForm->id,
                'field_id'    => $field->id,
                'response_id' => $this->response->id,
                'response'    => '',
            ]);*/
        }

        $rules = $validationAttributes = [];
        /*foreach ($this->zeusForm->fields as $field) {
            $rules['fieldResponse.' . $field->id . '.response']                = $field->rules;
            $validationAttributes['fieldResponse.' . $field->id . '.response'] = $field->name;
        }*/

        /*$rules['response.form_id'] = 'sometimes';
        $rules['response.status']  = 'sometimes';
        $rules['response.notes']   = 'sometimes';
        $rules['response.user_id'] = 'sometimes';*/

        /*$rules['fieldResponse.*.user_id']     = 'sometimes';
        $rules['fieldResponse.*.form_id']     = 'sometimes';
        $rules['fieldResponse.*.field_id']    = 'sometimes';
        $rules['fieldResponse.*.response_id'] = 'sometimes';
        $rules['fieldResponse.*.response']    = 'sometimes';*/

        //$this->rules                = $rules;
        // $this->validationAttributes = $validationAttributes;
    }

    public function resetAll()
    {
        $this->reset();
    }

    public function store()
    {
        $this->validate();
        $response = Response::make([
            'form_id' => $this->zeusForm->id,
            'user_id' => ( auth()->check() ) ? auth()->user()->id : 0,
            'status'  => 'NEW',
            'notes'   => '',
        ]);
        $response->save();

        foreach ($this->form->getState()['zeusData'] as $field => $value) {
            $fieldResponse['response']    = $value ?? '';
            $fieldResponse['response_id'] = $response->id;
            $fieldResponse['form_id']     = $this->zeusForm->id;
            $fieldResponse['field_id']    = $field;
            FieldResponse::create($fieldResponse);
        }

        return redirect()->route('bolt.user.submitted', [ 'slug' => $this->zeusForm->slug ]);
    }

    public function render()
    {
        return view('zeus-bolt::forms.fill-forms')->layout('zeus::components.app');
    }
}
