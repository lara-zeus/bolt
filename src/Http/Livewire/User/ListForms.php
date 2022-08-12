<?php

namespace LaraZeus\Bolt\Http\Livewire\User;

use LaraZeus\Bolt\Models\Form;
use Livewire\Component;

class ListForms extends Component
{
    public function render()
    {
        $forms = Form::query()
            ->whereIsActive(1)
            //->where('start_date', '<=', now())
            //->where('end_date', '>=', now())
            ->get();

        $viewName = 'zeus-bolt::list-forms';

        return view($viewName)
            ->with('forms', $forms)
            ->layout('zeus-bolt::components.app');
    }
}
