<?php

namespace LaraZeus\Bolt\Http\Livewire;

use Filament\Forms;
use Filament\Forms\Components\Wizard;
use LaraZeus\Bolt\Models\Collection;
use LaraZeus\Bolt\Models\FieldResponse;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;
use Livewire\Component;

class FillForms extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public Form $zeusForm;
    public $zeusData = [];

    protected function getFormSchema() : array
    {
        $sections = [];
        foreach ($this->zeusForm->sections()->orderBy('ordering')->get() as $section) {
            $fields = [];
            foreach ($section->fields()->orderBy('ordering')->get() as $field) {
                $setField = ( new $field->type )->renderClass::make('zeusData.' . $field->id)
                    ->label($field->name)
                    ->helperText($field->description)
                    ->id($field->html_id)
                    //->rules(collect($field->rules)->pluck('rule'))
                ;
                if ($field->type === '\LaraZeus\Bolt\Fields\Classes\Select') { // todo change
                    $setField = $setField->options(collect(Collection::find($field->options['dataSource'])->values)->pluck('itemValue', 'itemKey'));
                }

                /*if(isset($field->options['dateType']) && $field->options['dateType'] !== null){
                    if($field->options['dateType'] === 'date'){
                        $setField = $setField->date();
                    } else if($field->options['dateType'] === 'date'){
                        $setField = $setField->time();
                    } else {
                        $setField = $setField->datetime();
                    }
                }*/

                $fields[] = Forms\Components\Card::make()->schema([ $setField ]);
            }

            if ($this->zeusForm->options['show-as-wizard']) {
                $sections[] = Wizard\Step::make($section->name)->schema($fields);
            } else {
                $sections[] = Forms\Components\Section::make($section->name)->schema($fields);
            }
        }

        if ($this->zeusForm->options['show-as-wizard']) {
            return [ Wizard::make($sections) ];
        }

        return $sections;
    }

    protected function getFormModel() : Form
    {
        return $this->zeusForm;
    }

    public function mount($slug)
    {
        $this->zeusForm = Form::with([ 'sections', 'sections.fields' ])->whereSlug($slug)->whereIsActive(1)->firstOrFail();

        abort_if($this->zeusForm->options['require-login'] && !auth()->check(), 401);

        foreach ($this->zeusForm->fields as $field) {
            $this->zeusData[$field->id] = '';
        }

        //$rules = $validationAttributes = [];
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
            'user_id' => ( auth()->check() ) ? auth()->user()->id : null,
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
