<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Models\Form;
use Throwable;

/**
 * @property Form $record.
 */
class EditForm extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = FormResource::class;

    public function areFormActionsSticky(): bool
    {
        return BoltPlugin::get()->isFormActionsAreSticky();
    }

    public function getTitle(): string | Htmlable
    {
        return __('Edit Form');
    }

    public static function getNavigationLabel(): string
    {
        return __('Edit Form');
    }

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            Action::make('open')
                ->label(__('Open'))
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->tooltip(__('open form'))
                ->color('warning')
                ->url(fn () => route(BoltPlugin::get()->getRouteNamePrefix() . 'bolt.form.show', $this->record))
                ->visible(fn (Form $record) => $record->extensions === null)
                ->openUrlInNewTab(),
        ];
    }

    /**
     * @throws Throwable
     */
    protected function beforeValidate(): void
    {
        $formSections = $this->form->getComponent('data.sections')->getState();

        foreach ($formSections as $sectionId => $section) {
            foreach ($section['fields'] as $fieldId => $field) {
                $this->mountAction('fields options', ['item' => $fieldId]);
                $this->callMountedAction(['item' => $fieldId]);
                $this->unmountAction();
            }
        }
    }
}
