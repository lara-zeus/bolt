<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;

/**
 * @property Form $record.
 */
class ViewResponse extends ViewRecord
{
    public Response $response;

    public int $responseID;

    protected static string $view = 'zeus::filament.resources.response-resource.pages.show-entry';

    protected static string $resource = FormResource::class;

    public function mount(int | string $record): void
    {
        parent::mount($record);

        $this->response = Response::find($this->responseID);
        static::authorizeResourceAccess();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('set-status')
                ->visible(function (): bool {
                    return $this->response->form->extensions === null;
                })
                ->label(__('Set Status'))
                ->icon('heroicon-o-tag')
                ->action(function (array $data): void {
                    $this->response->status = $data['status'];
                    $this->response->notes = $data['notes'];
                    $this->response->save();
                }),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return __('view response #') . $this->response->id;
    }

    public function getBreadcrumbs(): array
    {
        return [
            FormResource::getUrl() => FormResource::getBreadcrumb(),
            FormResource::getUrl('view', ['record' => $this->record->slug]) => $this->record->name,
            FormResource::getUrl('report', ['record' => $this->record->slug]) => __('Entries Report'),
            __('view the entry'),
        ];
    }
}
