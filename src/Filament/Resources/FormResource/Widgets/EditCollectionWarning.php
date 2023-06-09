<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class EditCollectionWarning extends Widget
{
    protected int|string|array $columnSpan = 'full';
    public ?Model $record = null;

    protected static string $view = 'zeus-bolt::filament.resources.form-resource.widgets.edit-collection-warning';
}
