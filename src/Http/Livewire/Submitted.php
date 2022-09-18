<?php

namespace LaraZeus\Bolt\Http\Livewire;

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
        seo()
            ->title($this->form->name . ' ' . config('zeus-bolt.site_title', 'Laravel'))
            ->description($this->form->desc . ' ' . config('zeus-bolt.site_description', 'Laravel'))
            ->site(config('zeus-bolt.site_title', 'Laravel'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus-bolt.site_color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('bolt-theme') . '.submitted')->layout(config('zeus-bolt.layout'));
    }
}
