<?php

namespace LaraZeus\Bolt\Concerns;

trait HasActive
{
    public function getIsActiveDescAttribute(): string
    {
        return ($this->is_active === 0)
            ? '<span class="text-xs text-red-800 rounded-full bg-red-100 px-2.5 py-0.5 font-semibold">' . __('zeus-bolt::forms.inactive') . '</span>'
            : '<span class="text-xs text-green-800 rounded-full bg-green-100 px-2.5 py-0.5 font-semibold">' . __('zeus-bolt::forms.active') . '</span>';
    }
}
