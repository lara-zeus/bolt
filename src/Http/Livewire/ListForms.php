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
            ->with(
                'categories',
                config('zeus-bolt.models.Category')::query()
                    ->whereHas('forms', function ($query) {
                        $query->whereNull('extensions');
                    })
                    ->where('is_active', 1)
                    ->orderBy('ordering')
                    ->get()
            )
            ->layout(config('zeus.layout'));
    }
}
