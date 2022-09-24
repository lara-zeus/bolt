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
                'desc' => 'used when a new ticket created by the user or an employee',
                'color' => 'primary',
                'icon' => 'heroicon-o-document',
                'class' => 'px-2 py-0.5 text-xs rounded-xl text-primary-700 bg-primary-500/10',
            ],
            [
                'key' => 'CLOSE',
                'label' => __('closed'),
                'desc' => 'used when a new ticket created by the user or an employee',
                'color' => 'primary',
                'icon' => 'heroicon-o-document',
                'class' => 'px-2 py-0.5 text-xs rounded-xl text-secondary-700 bg-secondary-500/10',
            ],
        ];
    }

    protected function sushiShouldCache()
    {
        return true;
    }
}
