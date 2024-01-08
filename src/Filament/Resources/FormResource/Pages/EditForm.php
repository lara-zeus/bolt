<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\Bolt\Concerns\EntriesAction;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Models\Form;

/**
 * @property Form $record.
 */
class EditForm extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    use EntriesAction;

    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            ...$this->getEntriesActions($this->record->id),
            Action::make('open')
                ->label(__('Open'))
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->tooltip(__('open form'))
                ->color('warning')
                ->url(fn () => route('bolt.form.show', $this->record))
                ->openUrlInNewTab(),
        ];
    }
}
