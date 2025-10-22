<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;
use Throwable;

class CreateForm extends CreateRecord
{
    use Translatable;

    protected static string $resource = FormResource::class;

    public function areFormActionsSticky(): bool
    {
        return BoltPlugin::get()->isFormActionsAreSticky();
    }

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
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
                $this->mountAction('fields options', ['item' => $fieldId], ['schemaComponent' => "form.sections.$sectionId.fields"]);
                $this->callMountedAction();
                $this->unmountAction();
            }
        }
    }
}
