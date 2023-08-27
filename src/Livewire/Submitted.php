<?php

namespace LaraZeus\Bolt\Livewire;

use Illuminate\View\View;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Models\Form;
use Livewire\Component;

class Submitted extends Component
{
    public string $slug;

    public Form $form;

    public array $extension;

    public function mount(string $slug, array $extension = null): void
    {
        $this->slug = $slug;
        $this->form = BoltPlugin::getModel('Form')::whereSlug($slug)->firstOrFail();
        $this->extension = $extension;
    }

    public function render(): View
    {
        return view(app('boltTheme') . '.submitted')
            ->layout(config('zeus.layout'));
    }
}
