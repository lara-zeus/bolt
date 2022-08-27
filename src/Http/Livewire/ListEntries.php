<?php

namespace LaraZeus\Bolt\Http\Livewire;

use LaraZeus\Bolt\Models\Response;
use Livewire\Component;

class ListEntries extends Component
{
    public $model = Response::class;

    public $title = 'My Entries';

    public $titleSingular = 'entry';

    public $breadcrumbTitle = 'Entries';

    public $forUserOnly = true;

    public $filters = [
        'search' => '',
        'name' => '',
    ];

    public $oprations = [
        'search' => false,
        'filters' => false,
        'bulkActions' => false,
        'create' => false,
        'edit' => false,
        'delete' => false,
        'show' => true,
    ];

    public function fields()
    {
        return collect([
            [
                'id' => 'form.name',
                'label' => 'Form Name',
                'sortable' => true,
            ],
            [
                'id' => 'status',
                'label' => 'status',
                'sortable' => true,
            ],
        ]);
    }

    public function render()
    {
        return view('zeus-bolt::forms.entries')->layout('zeus::components.app');
    }
}
