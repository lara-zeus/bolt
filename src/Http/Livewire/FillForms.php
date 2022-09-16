<?php

namespace LaraZeus\Bolt\Http\Livewire;

use Filament\Forms;
use Filament\Forms\Components\Wizard;
use LaraZeus\Bolt\Events\FormMounted;
use LaraZeus\Bolt\Events\FormSent;
use LaraZeus\Bolt\Models\Collection;
use LaraZeus\Bolt\Models\FieldResponse;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;
use LaraZeus\Thunder\Models\Office;
use Livewire\Component;

class FillForms extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public Form $zeusForm;

    public $item;

    public $itemData;

    public $zeusData = [];

    protected function getFormSchema(): array
    {
        $sections = [];

        // todo bolt should not know about the predefiend fields for any extintion
        if ($this->item !== null) {
            $sections[] = Forms\Components\TextInput::make('itemData.title')->label(__('Ticket Title'))->required();
        }

        foreach ($this->zeusForm->sections()->orderBy('ordering')->get() as $section) {
            $fields = [];
            foreach ($section->fields()->orderBy('ordering')->get() as $field) {
                $setField = ( new $field->type )->renderClass::make('zeusData.'.$field->id)
                    ->label($field->name)
                    ->id($field->html_id)//->rules(collect($field->rules)->pluck('rule'))
;

                // todo so ugly change!
                if (isset($field->description)) {
                    $setField = $setField->helperText($field->description);
                }
                if (isset($field->options['prefix'])) {
                    $setField = $setField->prefix($field->options['prefix']);
                }
                if (isset($field->options['suffix'])) {
                    $setField = $setField->suffix($field->options['suffix']);
                }
                if (isset($field->options['is_required']) && $field->options['is_required']) {
                    $setField = $setField->required();
                }

                $haseDataSource = [
                    '\LaraZeus\Bolt\Fields\Classes\Select',
                    '\LaraZeus\Bolt\Fields\Classes\Radio',
                    '\LaraZeus\Bolt\Fields\Classes\CheckboxList',
                    '\LaraZeus\Bolt\Fields\Classes\MultiSelect',
                ];
                if (in_array($field->type, $haseDataSource)) {
                    $setField = $setField->options(collect(Collection::find($field->options['dataSource'])->values)->pluck('itemValue', 'itemKey'));
                    if (isset($field->options['is_inline']) && $field->options['is_inline']) {
                        $setField->inline();
                    }
                }

                if ($field->type == '\LaraZeus\Bolt\Fields\Classes\FileUpload') {
                    $setField
                        ->disk(config('zeus-bolt.uploads.disk'))
                        ->directory(config('zeus-bolt.uploads.directory'));
                }
                // todo so ugly change!

                $fields[] = Forms\Components\Card::make()->schema([$setField]);
            }

            if (optional($this->zeusForm->options)['show-as-wizard']) {
                $sections[] = Wizard\Step::make($section->name)->schema($fields);
            } else {
                $sections[] = Forms\Components\Section::make($section->name)->schema($fields);
            }
        }

        if (optional($this->zeusForm->options)['show-as-wizard']) {
            return [Wizard::make($sections)];
        }

        return $sections;
    }

    protected function getFormModel(): Form
    {
        return $this->zeusForm;
    }

    // todo $itemSlug is temp solution, refactor later
    // bot shuld not care about other extintions
    public function mount($slug, $itemSlug = null)
    {
        if ($itemSlug !== null) {
            // todo dynamic checks for ext 'preShowHook'
            $this->item = Office::whereSlug($itemSlug)->firstOrFail();
        }

        $this->zeusForm = Form::with(['sections', 'sections.fields'])->whereSlug($slug)->whereIsActive(1)->firstOrFail();

        abort_if(optional($this->zeusForm->options)['require-login'] && ! auth()->check(), 401);

        foreach ($this->zeusForm->fields as $field) {
            $this->zeusData[$field->id] = '';
        }

        event(new FormMounted($this->zeusForm));
        //$rules = $validationAttributes = [];
    }

    public function resetAll()
    {
        $this->reset();
    }

    public function store()
    {
        $this->validate();

        $response = Response::create([
            'form_id' => $this->zeusForm->id,
            'user_id' => (auth()->check()) ? auth()->user()->id : null,
            'status' => 'NEW',
            'notes' => '',
        ]);

        foreach ($this->form->getState()['zeusData'] as $field => $value) {
            $fieldResponse['response'] = $value ?? '';
            $fieldResponse['response_id'] = $response->id;
            $fieldResponse['form_id'] = $this->zeusForm->id;
            $fieldResponse['field_id'] = $field;
            FieldResponse::create($fieldResponse);
        }

        event(new FormSent($response, $this->item, $this->form->getState()['itemData']));

        return redirect()->route('bolt.user.submitted', ['slug' => $this->zeusForm->slug]);
    }

    public function render()
    {
        return view('zeus-bolt::forms.fill-forms')->layout(config('zeus-bolt.layout'));
    }
}
