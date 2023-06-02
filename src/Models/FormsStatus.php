<?php

namespace LaraZeus\Bolt\Models;

use Illuminate\Database\Eloquent\Model;

class FormsStatus extends Model
{
    use \Sushi\Sushi;

    public function getRows()
    {
        return [
            [
                'key' => 'NEW',
                'label' => __('New'),
                'desc' => 'used when a new form created by the user or an employee',
                'color' => 'success',
                'icon' => 'heroicon-o-document',
                'class' => 'px-2 py-0.5 text-xs rounded-xl text-success-700 bg-success-500/10',
            ],
            [
                'key' => 'CLOSE',
                'label' => __('closed'),
                'desc' => 'used when a new form created by the user or an employee',
                'color' => 'danger',
                'icon' => 'heroicon-o-x-circle',
                'class' => 'px-2 py-0.5 text-xs rounded-xl text-danger-700 bg-danger-500/10',
            ],
        ];
    }

    protected function sushiShouldCache()
    {
        return !app()->isLocal();
    }
}
