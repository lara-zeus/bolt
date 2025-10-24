<?php

namespace LaraZeus\Bolt\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use LaraZeus\Bolt\Events\FormMounted;
use LaraZeus\Bolt\Events\FormSent;
use LaraZeus\Bolt\Facades\Designer;
use LaraZeus\Bolt\Facades\Extensions;
use LaraZeus\Bolt\Models\Form;
use Livewire\Component;
use Throwable;

/**
 * @property mixed $form
 */
class FillForms extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Form $zeusForm;

    public array $extensionData;

    public array $zeusData = [];

    public bool $sent = false;

    public bool $inline = false;

    protected static ?string $boltFormDesigner = null;

    public function getBoltFormDesigner(): ?string
    {
        return static::$boltFormDesigner;
    }

    public static function getBoltFormDesignerUsing(?string $form): void
    {
        static::$boltFormDesigner = $form;
    }

    protected function getFormSchema(): array
    {
        $getDesignerClass = $this->getBoltFormDesigner() ?? Designer::class;

        return $getDesignerClass::ui($this->zeusForm, $this->inline);
    }

    protected function getFormModel(): Form
    {
        return $this->zeusForm;
    }

    /**
     * @throws Throwable
     */
    public function mount(
        mixed $slug,
        mixed $extensionSlug = null,
        mixed $extensionData = [],
        mixed $inline = false,
    ): void {
        $this->inline = $inline;

        $this->zeusForm = config('zeus-bolt.models.Form')::query()
            ->with(['fields', 'sections.fields'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $this->extensionData = Extensions::init($this->zeusForm, 'canView', ['extensionSlug' => $extensionSlug, 'extensionData' => $extensionData]) ?? [];

        foreach ($this->zeusForm->fields as $field) {
            $this->zeusData[$field->id] = '';
        }

        $this->form->fill();

        event(new FormMounted($this->zeusForm));
    }

    public function store(): void
    {
        $this->validate();

        Extensions::init($this->zeusForm, 'preStore', $this->extensionData);

        $response = config('zeus-bolt.models.Response')::create([
            'form_id' => $this->zeusForm->id,
            'user_id' => (auth()->check()) ? auth()->user()->id : null,
            'status' => 'NEW',
            'notes' => '',
        ]);

        $state = $this->form->getState();

        $fieldsData = Arr::except($state['zeusData'], 'extensions');

        foreach ($fieldsData as $field => $value) {
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
        $this->extensionData['extensionsComponent'] = $state['zeusData']['extensions'] ?? [];

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
                ->title($this->zeusForm->name . ' - ' . __('zeus-bolt::forms.forms') . ' - ' . config('zeus.site_title', 'Laravel'))
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
