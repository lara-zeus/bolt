<?php

namespace LaraZeus\Bolt\Filament\Resources\FormResource\Widgets;

use Filament\Widgets\Widget;

class BetaNote extends Widget
{
    protected int|string|array $columnSpan = 'full';
    protected static string $view = 'zeus-bolt::filament.resources.form-resource.widgets.beta-note';
}
