<?php

namespace LaraZeus\Bolt\Models;

use Carbon\Carbon;

trait HasUpdates
{
    public function getLastUpdatedAttribute($value)
    {
        return '<span class="text-xs text-gray-600">' . Carbon::parse($this->updated_at)->format(config('zeus.defaultDateFormat')) . '</span>';
    }
}
