<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use Livewire\Attributes\Url;

class ListResponses extends ListRecords
{
    use \LaraZeus\Bolt\Concerns\EntriesAction;

    protected static string $resource = ResponseResource::class;

    #[Url(history: true, keep: true)]
    public int $form_id = 0;

    protected function getHeaderActions(): array
    {
        return $this->getEntriesActions();
    }

    public function getHeading(): string | Htmlable
    {
        return __('List Entries');
    }

    public function getBreadcrumbs(): array
    {
        $form = BoltPlugin::getModel('Form')::findOrFail($this->form_id);

        return [
            FormResource::getUrl() => FormResource::getBreadcrumb(),
            FormResource::getUrl('view', ['record' => $form->slug]) => $form->name,
            '#' => __('List Entries'),
        ];
    }
}
