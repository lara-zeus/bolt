<?php

namespace LaraZeus\Bolt\Livewire;

use Filament\Forms;
use Illuminate\View\View;
use LaraZeus\Bolt\Models\Response;
use Livewire\Component;

class ShowEntry extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

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
            ->title(__('Show entry') . ' #' . $this->response->id . ' - ' . config('zeus.site_title', 'Laravel'))
            ->description(__('Show entry') . ' - ' . config('zeus.site_description', 'Laravel'))
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
