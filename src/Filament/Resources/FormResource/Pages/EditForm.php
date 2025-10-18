<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;
use Throwable;

/**
 * @property Form $record.
 */
class EditForm extends EditRecord
{
    use Translatable;

    protected static string $resource = FormResource::class;

    public function areFormActionsSticky(): bool
    {
        return BoltPlugin::get()->isFormActionsAreSticky();
    }

    public function getTitle(): string | Htmlable
    {
        return __('zeus-bolt::forms.edit_form');
    }

    public static function getNavigationLabel(): string
    {
        return __('zeus-bolt::forms.edit_form');
    }

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            Action::make('open')
                ->label(__('zeus-bolt::forms.actions.open'))
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->tooltip(__('zeus-bolt::forms.actions.open_tooltip'))
                ->color('warning')
                ->url(fn () => route(BoltPlugin::get()->getRouteNamePrefix() . 'bolt.form.show', $this->record))
                ->visible(fn (Form $record) => $record->extensions === null)
                ->openUrlInNewTab(),
        ];
    }

    /**
     * @throws Throwable
     */
    protected function afterValidate(): void
    {
        $formSections = $this->form->getComponent('sections')->getState();

        foreach ($formSections as $sectionId => $section) {
            foreach ($section['fields'] as $fieldId => $field) {
                $context = ['schemaComponent' => "form.sections.$sectionId.fields"];

                if (array_key_exists('id', $section)) {
                    $context['recordKey'] = $section['id'];
                }

                $this->mountAction('fields options', ['item' => $fieldId], context: $context);
                $this->callMountedAction();
                $this->unmountAction();
            }
        }
    }
}
