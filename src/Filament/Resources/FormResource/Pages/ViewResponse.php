<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use LaraZeus\Bolt\BoltPlugin;
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

    protected string $view = 'zeus::filament.resources.response-resource.pages.show-entry';

    protected static string $resource = FormResource::class;

    public function mount(int | string $record): void
    {
        parent::mount($record);

        $this->response = BoltPlugin::getModel('Response')::find($this->responseID);
        static::authorizeResourceAccess();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('set-status')
                ->visible(function (): bool {
                    return $this->response->form->extensions === null;
                })
                ->label(__('zeus-bolt::response.set_status'))
                ->icon('heroicon-o-tag')
                ->schema([
                    Select::make('status')
                        ->label(__('zeus-bolt::response.status'))
                        ->default(fn () => $this->response->status)
                        ->options(BoltPlugin::getEnum('FormsStatus'))
                        ->required(),
                    Textarea::make('notes')
                        ->default(fn () => $this->response->notes)
                        ->label(__('zeus-bolt::response.notes')),
                ])
                ->action(function (array $data): void {
                    $this->response->status = $data['status'];
                    $this->response->notes = $data['notes'];
                    $this->response->save();
                }),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return __('zeus-bolt::response.view_response_number') . $this->response->id;
    }

    public function getBreadcrumbs(): array
    {
        return [
            FormResource::getUrl() => FormResource::getBreadcrumb(),
            FormResource::getUrl('view', ['record' => $this->record->slug]) => $this->record->name,
            FormResource::getUrl('report', ['record' => $this->record->slug]) => __('zeus-bolt::response.entries_report'),
            __('zeus-bolt::response.view_the_entry'),
        ];
    }
}
