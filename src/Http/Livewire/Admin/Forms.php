<?php

namespace LaraZeus\Bolt\Http\Livewire\Admin;

use LaraZeus\Bolt\Models\Form;

class Forms extends BoltCrudBase
{
    public $model = Form::class;
    public $title = 'Manage Forms';
    public $titleSingular = 'form';
    public $breadcrumbTitle = 'Forms';

    public $createRoute = 'bolt.admin.form.create';
    public $editRoute = 'bolt.admin.form.edit';

    public $filters = [
        'search' => '',
        'name' => '',
    ];

    public $buttons;

    public function buttons()
    {
        return [
            'showForm' => [
                'title' => 'Open the form',
                'link' => 'bolt.user.form.show:slug', //route('bolt.user.form.show',['slug'=>$row->slug]),
                'icon' => 'heroicon-o-external-link', /*'<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>',*/
                'target'=>'_blank',
            ],
            'formEntries' => [
                'title' => 'Form Entries',
                'link' => 'bolt.admin.manageEntries:id', //route('bolt.user.form.show',['slug'=>$row->slug]),
                'icon' => 'heroicon-o-clipboard-list', //svg('heroicon-o-clipboard-list'), //<x-heroicon-o-folder-add class="inline align-text-bottom h-5 w-5" />',
            ],
        ];
    }

    public function fields()
    {
        return collect([
            [
                'id' => 'name',
                'type' => 'input.text',
                'label' => 'Form Name',
                'sortable' => true,
                'searchable' => true,
                'rules' => 'required|min:3',
            ],
            [
                'id' => 'ordering',
                'type' => 'input.text',
                'label' => 'Ordering',
                'rules' => 'required',
                'sortable' => true,
                'searchable' => true,
                'defaultValue' => 1,
            ],
            [
                'id' => 'is_active',
                'listAtt' => 'is_active_desc',
                'type' => 'input.checkbox',
                'label' => 'Active?',
                'defaultValue' => 1,
                'sortable' => true,
                'searchable' => true,
                'rules' => 'sometimes',
            ],
        ]);
    }
}
