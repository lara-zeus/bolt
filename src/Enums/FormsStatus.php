<?php

namespace LaraZeus\Bolt\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum FormsStatus: string implements HasColor, HasIcon, HasLabel
{
    case NEW = 'NEW';
    case OPEN = 'OPEN';
    case CLOSE = 'CLOSE';

    public function getLabel(): string
    {
        return __('zeus-bolt::forms.status_labels.' . $this->name);
    }

    public function getColor(): string
    {
        return match ($this) {
            self::NEW => 'success',
            self::OPEN => 'info',
            self::CLOSE => 'danger',
        };
    }

    public static function getChartColors(): array
    {
        return [
            '#21C55D',
            '#EF4444',
            '#ccc',
        ];
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::NEW => 'heroicon-o-document',
            self::OPEN => 'heroicon-o-x-circle',
            self::CLOSE => 'heroicon-o-lock-closed',
        };
    }
}
