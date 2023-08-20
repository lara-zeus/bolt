<?php

namespace LaraZeus\Bolt\Livewire;

use LaraZeus\Bolt\BoltPlugin;
use Livewire\Component;

class Submitted extends Component
{
    public $slug;

    public $form;

    public $extension;

    public function mount($slug, $extension = null)
    {
        $this->slug = $slug;
        $this->form = BoltPlugin::getModel('Form')::whereSlug($slug)->firstOrFail();
        $this->extension = $extension;
    }

    public function render()
    {
        return view(app('boltTheme') . '.submitted')
            ->layout(config('zeus.layout'));
    }
}
