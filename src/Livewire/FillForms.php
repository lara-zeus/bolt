<?php

namespace LaraZeus\Bolt\Livewire;

use Filament\Forms;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Concerns\Designer;
use LaraZeus\Bolt\Events\FormMounted;
use LaraZeus\Bolt\Events\FormSent;
use LaraZeus\Bolt\Facades\Extensions;
use LaraZeus\Bolt\Models\Form;
use Livewire\Component;

/**
 * @property mixed $form
 */
class FillForms extends Component implements Forms\Contracts\HasForms
{
    use Designer;
    use Forms\Concerns\InteractsWithForms;

    public Form $zeusForm;

    public array $extensionData;

    public array $zeusData = [];

    public bool $sent = false;

    public bool $inline = false;

    protected function getFormSchema(): array
    {
        return static::ui($this->zeusForm, $this->inline);
    }

    protected function getFormModel(): Form
    {
        return $this->zeusForm;
    }

    /**
     * @throws \Throwable
     */
    public function mount(string $slug, string $extensionSlug = null, bool $inline = false): void
    {
        $this->inline = $inline;

        $this->zeusForm = BoltPlugin::getModel('Form')::query()
            ->with(['fields', 'sections.fields'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $this->extensionData = Extensions::init($this->zeusForm, 'canView', ['extensionSlug' => $extensionSlug]) ?? [];

        foreach ($this->zeusForm->fields as $field) {
            $this->zeusData[$field->id] = '';
        }

        $this->form->fill();

        event(new FormMounted($this->zeusForm));
    }

    public function store(): void
    {
        $this->validate();

        $response = BoltPlugin::getModel('Response')::create([
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
            BoltPlugin::getModel('FieldResponse')::create([
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
        $this->extensionData['extInfo'] = $extensionItemId;

        $response->update(['extension_item_id' => $extensionItemId['itemId'] ?? null]);

        if (isset($this->zeusForm->options['emails-notification']) && ! empty($this->zeusForm->options['emails-notification'])) {
            $emails = explode(',', $this->zeusForm->options['emails-notification']);

            foreach ($emails as $email) {
                $mailable = config('zeus-bolt.defaultMailable');
                Mail::to($email)->send(new $mailable($this->zeusForm, $response));
            }
        }

        $this->sent = true;
    }

    public function render(): View
    {
        if (! $this->inline) {
            seo()
                ->title($this->zeusForm->name . ' - ' . __('Forms') . ' - ' . config('zeus.site_title', 'Laravel'))
                ->description($this->zeusForm->description . ' - ' . config('zeus.site_description') . ' ' . config('zeus.site_title'))
                ->site(config('zeus.site_title', 'Laravel'))
                ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
                ->rawTag('<meta name="theme-color" content="' . config('zeus.site_color') . '" />')
                ->withUrl()
                ->twitter();
        }

        $view = match (true) {
            $this->zeusForm->need_login => 'zeus::errors.login-required',
            ! $this->zeusForm->date_available => 'zeus::errors.date-not-available',
            $this->zeusForm->onePerUser() => 'zeus::errors.one-entry-per-user',
            default => app('boltTheme') . '.fill-forms',
        };

        if ($this->inline) {
            return view($view);
        }

        return view($view)->layout(config('zeus.layout'));
    }
}
