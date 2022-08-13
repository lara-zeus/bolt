<?php

namespace LaraZeus\Bolt\Http\Livewire\Admin;

use LaraZeus\Bolt\Models\Collection;

class Collections extends BoltCrudBase
{
    public $model = Collection::class;
    protected static ?string $title = 'Manage Collections';
    public $titleSingular = 'collection';
    public $breadcrumbTitle = 'Collections';
    public $createRoute = 'COMPONENT';

    public $filters = [
        'search' => '',
        'name' => '',
        'values' => '',
    ];

    public function fields()
    {
        return collect([
            [
                'id' => 'name',
                'type' => 'input.text',
                'label' => 'Collection Name',
                'sortable' => true,
                'searchable' => true,
                'rules' => 'required|min:3',
            ],
            [
                'id' => 'values',
                'type' => 'input.array',
                //'type' => 'input.array',
                'listAtt' => 'values_list',
                //'type' => 'input.textarea',
                'label' => 'Values',
                'searchable' => true,
                'rules' => 'required',
            ],
        ]);
    }
}
