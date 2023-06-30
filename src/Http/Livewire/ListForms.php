<?php

namespace LaraZeus\Bolt\Http\Livewire;

use Livewire\Component;

class ListForms extends Component
{
    public function render()
    {
        seo()
            ->title(config('zeus-bolt.site_title', 'Laravel'))
            ->description(__('Forms') . ' ' . config('zeus-bolt.site_description', 'Laravel'))
            ->site(config('zeus-bolt.site_title', 'Laravel'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus-bolt.site_color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('boltTheme') . '.list-forms')
            ->with('forms', config('zeus-bolt.models.Form')::query()->whereIsActive(1)->get())
            ->with('categories', config('zeus-bolt.models.Category')::has('forms')->where('is_active', 1)->orderBy('ordering')->get())
            ->layout(config('zeus-bolt.layout'));
    }
}
