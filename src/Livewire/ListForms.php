<?php

namespace LaraZeus\Bolt\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class ListForms extends Component
{
    public function render(): View
    {
        seo()
            ->site(config('zeus.site_title', 'Laravel'))
            ->title(__('zeus-bolt::forms.forms') . ' - ' . config('zeus.site_title'))
            ->description(__('zeus-bolt::forms.forms') . ' - ' . config('zeus.site_description') . ' ' . config('zeus.site_title'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus.site_color') . '" />')
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
