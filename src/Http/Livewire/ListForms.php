<?php

namespace LaraZeus\Bolt\Http\Livewire;

use LaraZeus\Bolt\Models\Form;
use Livewire\Component;

class ListForms extends Component
{
    public function render()
    {
        return view(app('bolt-theme').'.list-forms')
            ->with('forms', Form::query()->whereIsActive(1)->get())
            ->layout(config('zeus-bolt.layout'));
    }
}
