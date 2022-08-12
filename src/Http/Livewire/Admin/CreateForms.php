<?php

namespace LaraZeus\Bolt\Http\Livewire\Admin;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use LaraZeus\Bolt\Models\Form;

class CreateForms extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'zeus-bolt::forms.create-forms';

    use UsesBlankData;

    public Form $form;
    public $options = [
        'emailsNotification' => '',
        'confirmationMessage' => '',
        'requireLogin' => false,
        'oneEntryPerUser' => false,
        'webHook' => '',
        'sectionsToPages' => false,
    ];
    public $modals = [
        'FormOptions' => false,
        'FormTexts' => false,
        'FormSettings' => false,
    ];

    public $formId;

    public function mount($formId = null)
    {
        //Notification::make()->title(__('Please select some rows first'))->danger()->send();

        $this->formId = $formId;

        if ($formId === null) {
            $this->form = $this->formData();
        } else {
            $this->form = Form::find($formId);
        }
    }

    public function setSlug()
    {
        if ($this->formId === null) {
            $this->form->slug = Str::slug($this->form->name, '-');
        }
    }

    public function resetAll()
    {
        $this->reset();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function rules()
    {
        $rules = [
            'form.name' => 'required|min:3|max:255',
            'form.is_active' => 'sometimes',
            'form.user_id' => 'required',
            'form.slug' => 'required',
            'form.desc' => 'sometimes',
            'form.details' => 'sometimes',
            'form.start_date' => 'sometimes',
            'form.end_date' => 'sometimes',
            'form.ordering' => 'sometimes',
            'form.layout' => 'sometimes',
        ];
        foreach ($this->options as $option => $val) {
            $rules['form.options.'.$option] = 'sometimes';
        }

        return $rules;
    }

    public function store()
    {
        Notification::make()->title(__('saving...'))->send();

        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            Notification::make()->title(__('validation error...'))->danger()->send();
            throw $e;
        }

        $this->form->save();
        $this->emit('formSaved', $this->form->id);
    }
}
