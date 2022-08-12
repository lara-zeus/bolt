<?php

namespace LaraZeus\Bolt\Http\Livewire\Admin;

use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;

class Entries extends BoltCrudBase
{
    public $perPage = 1;
    public $model = Response::class;
    public $title = 'Manage Entries';
    public $titleSingular = 'entry';
    public $breadcrumbTitle = 'Entries';
    public $filters = [
        'search' => '',
        'name' => '',
    ];
    public $oprations = [
        'search' => true,
        'filters' => true,
        'bulkActions' => true,
        'create' => false,
        'edit' => false,
        'delete' => true,
        'show' => true,
    ];
    public $setListView = 'zeus-bolt::forms.entries';
    public $form;

    public function init()
    {
        $this->form = Form::find(request()->route('id')); //OrFail todo
    }

    public function desc()
    {
        $formTitle = $this->form->name;
        return 'for <strong>'.$formTitle.'</strong>';
    }

    public function listQuery()
    {
        return ['where', ['form_id', (int) $this->form->id]];
    }

    public function fields()
    {
        return collect([
            [
                'id' => 'form.name',
                'label' => 'Form Name',
                'sortable' => true,
                'inShow' => false,
            ],
            [
                'id' => 'user.name',
                'label' => 'user',
                'inShow' => false,
            ],
            [
                'id' => 'status',
                'label' => 'status',
                'sortable' => true,
                'inShow' => true,
            ],
            [
                'id' => 'notes',
                'label' => 'notes',
                'inShow' => true,
            ],
        ]);
    }
}
