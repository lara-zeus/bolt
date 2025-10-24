<?php

namespace LaraZeus\Bolt\Filament\Resources\CollectionResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class EditCollectionWarning extends Widget
{
    protected int | string | array $columnSpan = 'full';

    public ?Model $record = null;

    protected string $view = 'zeus::filament.resources.form-resource.widgets.edit-collection-warning';
}
