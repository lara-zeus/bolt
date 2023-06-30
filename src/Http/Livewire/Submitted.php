<?php

namespace LaraZeus\Bolt\Http\Livewire;

use Livewire\Component;

class Submitted extends Component
{
    public $slug;

    public $form;

    public $extension;

    public function mount($slug, $extension = null)
    {
        $this->slug = $slug;
        $this->form = config('zeus-bolt.models.Form')::whereSlug($slug)->firstOrFail();
        $this->extension = $extension;
    }

    public function render()
    {
        seo()
            ->title($this->form->name . ' ' . config('zeus-bolt.site_title', 'Laravel'))
            ->description($this->form->description . ' ' . config('zeus-bolt.site_description', 'Laravel'))
            ->site(config('zeus-bolt.site_title', 'Laravel'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus-bolt.site_color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('boltTheme') . '.submitted')
            ->layout(config('zeus-bolt.layout'));
    }
}
