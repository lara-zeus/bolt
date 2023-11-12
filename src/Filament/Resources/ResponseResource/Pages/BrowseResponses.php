<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Concerns\EntriesAction;
use LaraZeus\Bolt\Filament\Actions\SetResponseStatus;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use Livewire\Attributes\Url;

class BrowseResponses extends Page implements Tables\Contracts\HasTable
{
    use EntriesAction;
    use InteractsWithTable;

    protected static string $resource = ResponseResource::class;

    protected static string $view = 'zeus::filament.resources.response-resource.pages.browse-responses';

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    #[Url(history: true, keep: true)]
    public int $form_id = 0;

    public function getTitle(): string
    {
        return __('Browse Entries');
    }

    public function table(Table $table): Table
    {
        return $table
            ->paginated([1])
            ->recordClasses('bg-gray-100')
            ->query(BoltPlugin::getModel('Response')::query()->where('form_id', $this->form_id))
            ->columns([
                Tables\Columns\ViewColumn::make('response')
                    ->label(__('Browse Entries'))
                    ->view('zeus::filament.resources.response-resource.pages.show-entry'),
            ])
            ->actions([
                SetResponseStatus::make(),
            ], position: Tables\Enums\ActionsPosition::AfterContent)
            ->filters([
                SelectFilter::make('status')
                    ->options(BoltPlugin::getModel('FormsStatus')::query()->pluck('label', 'key'))
                    ->label(__('Status')),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return $this->getEntriesActions();
    }

    public function getBreadcrumbs(): array
    {
        $form = BoltPlugin::getModel('Form')::findOrFail($this->form_id);
        $breadcrumb = $this->getBreadcrumb();

        return [
            FormResource::getUrl() => FormResource::getBreadcrumb(),
            FormResource::getUrl('view', ['record' => $form->slug]) => $form->name,
            ...(filled($breadcrumb) ? [$breadcrumb] : []),
        ];
    }
}
