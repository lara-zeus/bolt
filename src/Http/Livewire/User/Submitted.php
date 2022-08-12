<?php

namespace LaraZeus\Bolt\Http\Livewire\User;

use LaraZeus\Bolt\Models\Form;
use Livewire\Component;

class Submitted extends Component
{
    public $slug;
    public $form;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->form = Form::whereSlug($slug)->firstOrFail();

    }

    public function render()
    {
        return view('zeus-bolt::submitted')->layout(config('zeus-bolt.layout'));
    }
}
