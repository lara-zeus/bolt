<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use LaraZeus\Bolt\Models\Form;

class ListResponses extends ListRecords
{
    use \LaraZeus\Bolt\Concerns\EntriesAction;

    protected static string $resource = ResponseResource::class;

    public int $form_id = 0;

    public Form $form;

    protected $queryString = [
        'form_id',
    ];

    public function mount(): void
    {
        $this->form_id = request('form_id', 0);
        $this->form = BoltPlugin::getModel('Form')::findOrFail($this->form_id);
    }

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
        return [
            FormResource::getUrl() => FormResource::getBreadcrumb(),
            FormResource::getUrl('view', ['record' => $this->form->slug]) => $this->form->name,
            '#' => __('List Entries'),
        ];
    }
}
