<?php

namespace LaraZeus\Bolt\Http\Livewire;

use Filament\Forms;
use LaraZeus\Bolt\Events\FormMounted;
use LaraZeus\Bolt\Events\FormSent;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Models\Form;
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
        return Bolt::prepareFieldsAndSectionToRender($this->zeusForm, $this->item);
    }

    protected function getFormModel(): Form
    {
        return $this->zeusForm;
    }

    // todo $itemSlug is temp solution, refactor later
    // todo Bolt should not care about other extension
    public function mount($slug, $itemSlug = null)
    {
        // todo dynamic checks for ext 'preShowHook'
        /*if ($itemSlug !== null) {
            $this->item = Office::whereSlug($itemSlug)->firstOrFail();
        }*/

        /** @phpstan-ignore-next-line */
        $this->zeusForm = config('zeus-bolt.models.Form')::with(['sections', 'sections.fields'])->whereSlug($slug)->whereIsActive(1)->firstOrFail();

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

        $response = config('zeus-bolt.models.Response')::create([
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
            config('zeus-bolt.models.FieldResponse')::create($fieldResponse);
        }

        event(new FormSent($response, $this->item, $this->form->getState()['itemData'] ?? null));

        /* todo
         * issues:
         * api tokes?
         * events is better
         */
        /*if(isset($this->zeusForm->options['web-hook']) && !empty($this->zeusForm->options['web-hook'])){
            $post = Http::post($this->zeusForm->options['web-hook'], [
                'form_id' => $this->zeusForm->id,
                'response' => $response,
            ]);
        }*/

        return redirect()->route('bolt.user.submitted', ['slug' => $this->zeusForm->slug]);
    }

    public function render()
    {
        seo()
            ->title($this->zeusForm->name . ' ' . config('zeus-bolt.site_title', 'Laravel'))
            ->description($this->zeusForm->desc . ' ' . config('zeus-bolt.site_description', 'Laravel'))
            ->site(config('zeus-bolt.site_title', 'Laravel'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus-bolt.site_color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('bolt-theme') . '.fill-forms')->layout(config('zeus-bolt.layout'));
    }
}
