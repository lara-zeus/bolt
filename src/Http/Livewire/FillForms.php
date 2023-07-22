<?php

namespace LaraZeus\Bolt\Http\Livewire;

use Filament\Forms;
use Illuminate\Support\Facades\Mail;
use LaraZeus\Bolt\Events\FormMounted;
use LaraZeus\Bolt\Events\FormSent;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Facades\Extensions;
use LaraZeus\Bolt\Models\Form;
use Livewire\Component;

/**
 * @property mixed $form
 */
class FillForms extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public Form $zeusForm;

    public $extensionData;

    public $extensions;

    public $zeusData = [];

    protected function getFormSchema(): array
    {
        return Bolt::prepareFieldsAndSectionToRender($this->zeusForm);
    }

    protected function getFormModel(): Form
    {
        return $this->zeusForm;
    }

    /**
     * @throws \Throwable
     */
    public function mount($slug, $extensionSlug = null)
    {
        $this->zeusForm = config('zeus-bolt.models.Form')::query()
            ->with([
                'sections', 'sections.fields',
            ])
            ->whereSlug($slug)
            ->whereIsActive(1)
            ->firstOrFail();

        $this->extensionData = Extensions::init($this->zeusForm, 'canView', ['extensionSlug' => $extensionSlug]) ?? [];

        foreach ($this->zeusForm->fields as $field) {
            $this->zeusData[$field->id] = '';
        }

        $this->form->fill();

        event(new FormMounted($this->zeusForm));
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
            $setValue = $value;

            if (! empty($setValue) && is_array($setValue)) {
                $value = json_encode($value);
            }

            config('zeus-bolt.models.FieldResponse')::create([
                'response' => (! empty($value)) ? $value : '',
                'response_id' => $response->id,
                'form_id' => $this->zeusForm->id,
                'field_id' => $field,
            ]);
        }

        event(new FormSent($response));

        $this->extensionData['response'] = $response;
        $this->extensionData['extensionsComponent'] = $this->form->getState()['extensions'] ?? [];

        $extensionItemId = Extensions::init($this->zeusForm, 'store', $this->extensionData) ?? [];

        $response->update(['extension_item_id' => $extensionItemId['itemId'] ?? null]);

        if (isset($this->zeusForm->options['emails-notification']) && ! empty($this->zeusForm->options['emails-notification'])) {
            $emails = explode(',', $this->zeusForm->options['emails-notification']);

            foreach ($emails as $email) {
                $mailable = config('zeus-bolt.default_mailable');
                Mail::to($email)->send(new $mailable($this->zeusForm, $response));
            }
        }

        return redirect()->route('bolt.submitted', ['slug' => $this->zeusForm->slug, $extensionItemId['itemId'] ?? 0]);
    }

    public function render()
    {
        seo()
            ->title($this->zeusForm->name . ' ' . config('zeus-bolt.site_title', 'Laravel'))
            ->description($this->zeusForm->description . ' ' . config('zeus-bolt.site_description', 'Laravel'))
            ->site(config('zeus-bolt.site_title', 'Laravel'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus-bolt.site_color') . '" />')
            ->withUrl()
            ->twitter();

        if ($this->zeusForm->need_login) {
            return view('zeus::errors.login-required')
                ->layout(config('zeus.layout'));
        }

        if (! $this->zeusForm->date_available) {
            return view('zeus::errors.date-not-available')
                ->layout(config('zeus-bolt.layout'));
        }

        if ($this->zeusForm->onePerUser()) {
            return view('zeus::errors.one-entry-per-user')
                ->layout(config('zeus.layout'));
        }

        return view(app('boltTheme') . '.fill-forms')
            ->layout(config('zeus.layout'));
    }
}
