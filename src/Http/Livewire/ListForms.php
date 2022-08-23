<?php

namespace LaraZeus\Bolt\Http\Livewire;

use LaraZeus\Bolt\Models\Form;
use Livewire\Component;

class ListForms extends Component
{
    public function render()
    {
        $forms = Form::query()->whereIsActive(1)->get();

        $viewName = 'zeus-bolt::list-forms';

        return view($viewName)
            ->with('forms', $forms)
            ->layout('zeus-bolt::components.app');
    }
}
