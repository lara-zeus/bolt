<?php

namespace LaraZeus\Bolt\Http\Livewire\Admin;

use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;

class EntriesF extends BoltCrudBase
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'zeus-bolt::forms.entries';
    protected static ?string $title = 'Manage Entries';

    public $perPage = 1;
    public $desc;
    public $fields;
    public $action;
    public $modals = [
        'showDeleteModal' => false,
        'showEditModal' => false,
        'showFilters' => false,
        'showDetails' => false,
    ];

    public $searchFields;
    public $flattenedRows;
    public $filterFields;
    public $buttons;
    public $forUserOnly = false;
    protected $queryString = ['sorts'];
    public $selectPage = false;
    public $selectAll = false;
    public $selected = [];


    public $model = Response::class;
    //public $title = 'Manage Entries';
    public $setListView = 'zeus-bolt::forms.entries';
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
    public $form;
    protected $rows;
    protected $rowsQuery;

    protected function getViewData(): array
    {
        return [
            'rowsQuery'=> $this->getAllRowsQuery(),
            'rows'=> $this->getAllRows(),
        ];
    }

    public function init()
    {
        $this->form = Form::find(request()->route('id')); //OrFail todo
        $this->rowsQuery  = $this->getAllRowsQuery();
        $this->rows  = $this->getAllRows();
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
