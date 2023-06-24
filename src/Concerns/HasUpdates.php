<?php

namespace LaraZeus\Bolt\Concerns;

use Carbon\Carbon;

trait HasUpdates
{
    public function getLastUpdatedAttribute($value): string
    {
        return '<span class="text-xs text-gray-600">' . Carbon::parse($this->updated_at)->format(config('zeus.defaultDateFormat')) . '</span>';
    }
}
