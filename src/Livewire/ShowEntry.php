<?php

namespace LaraZeus\Bolt\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\View\View;
use LaraZeus\Bolt\Models\Response;
use Livewire\Component;

class ShowEntry extends Component implements HasForms
{
    use InteractsWithForms;

    public Response $response;

    public function mount(int $responseID): void
    {
        $this->response = config('zeus-bolt.models.Response')::with('user')
            ->where('user_id', auth()->user()->id)
            ->where('id', $responseID)
            ->firstOrFail();
    }

    public function render(): View
    {
        seo()
            ->title(__('zeus-bolt::response.show_entry') . ' #' . $this->response->id . ' - ' . config('zeus.site_title', 'Laravel'))
            ->description(__('zeus-bolt::response.show_entry') . ' - ' . config('zeus.site_description', 'Laravel'))
            ->site(config('zeus.site_title', 'Laravel'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus.site_color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('boltTheme') . '.show-entry')
            ->with('response', $this->response)
            ->layout(config('zeus.layout'));
    }
}
