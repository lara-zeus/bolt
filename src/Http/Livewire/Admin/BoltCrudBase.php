<?php

namespace LaraZeus\Bolt\Http\Livewire\Admin;

use Filament\Resources\Pages\Page;

class BoltCrudBase extends Page
{
    use  WithSorting, WithBulkActions;

    public $desc;
    public $fields;
    public $action;
    public $model;
    public $modals = [
        'showDeleteModal' => false,
        'showEditModal' => false,
        'showFilters' => false,
        'showDetails' => false,
    ];
    public $filters = [
        'search' => '',
        'amount-min' => null,
    ];
    public $searchFields;
    public $flattenedRows;
    public $filterFields;
    public $buttons;
    public $forUserOnly = false;
    public $oprations = [
        'search' => true,
        'filters' => true,
        'bulkActions' => true,
        'create' => true,
        'edit' => true,
        'delete' => true,
        'show' => true,
    ];
    public $setListView;
    protected $queryString = ['sorts'];

    public function rules()
    {
        return $this->fields->where('rules')->mapWithKeys(function ($item) {
            $newItem['model.'.$item['id']] = $item['rules'];
            return $newItem;
        })->toArray();
    }

    public function mount()
    {
        $this->fields = $this->fields();

        $this->model = $this->makeBlankRow();

        if (method_exists($this, 'init')) {
            $this->init();
        }

        if (method_exists($this, 'buttons')) {
            $this->buttons = $this->buttons();
        }

        if (method_exists($this, 'desc')) {
            $this->desc = $this->desc();
        }
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

   /* public function exportSelected()
    {
        $count = $this->selectedRowsQuery->count();
        if ($count === 0) {
            $this->notify('Please select some rows first', 'error');
            $this->modals['showDeleteModal'] = false;

            return;
        }

        return response()->streamDownload(function () {
            echo $this->selectedRowsQuery->toCsv();
        }, $this->model->getTable().'.csv');
    }*/

    /*public function deleteSelected()
    {
        $count = $this->selectedRowsQuery->count();

        if ($count === 0) {
            $this->notify('Please select some rows first', 'error');
            $this->modals['showDeleteModal'] = false;

            return;
        }

        $this->selectedRowsQuery->delete();

        $this->modals['showDeleteModal'] = false;

        $this->notify('You\'ve deleted '.$count.' rows');
    }*/

    public function makeBlankRow()
    {
        $initAttributes = $this->fields->where('defaultValue')->mapWithKeys(function ($item) {
            $newItem[$item['id']] = $item['defaultValue'];
            return $newItem;
        })->toArray();

        return $this->model::make($initAttributes);
    }

    public function resetAll()
    {
        $this->reset('filters', 'sorts');
    }

    public function create()
    {
        if ($this->model->getKey()) {
            $this->model = $this->makeBlankRow();
        }
        $this->action = 'create';
        $this->modals['showEditModal'] = true;
    }

    public function edit($modelId)
    {
        $getModelRow = $this->model::find($modelId);

        if ($this->model->isNot($getModelRow)) {
            $this->model = $getModelRow;
        }

        $this->action = 'edit';
        $this->modals['showEditModal'] = true;
    }

    public function save()
    {
        $this->validate();
        if (Schema::hasColumn($this->model->getTable(), 'user_id')) {
            $this->model->user_id = auth()->user()->id;
        }

        if (isset($this->uploads)) {
            foreach ($this->uploads as $upload) {
                $this->model->{$upload} = $this->{$upload}->store('logos','public');
            }
        }

        $this->model->save();
        $this->modals['showEditModal'] = false;
        $this->notify('successfully saved!');
    }

    public function show($modelId)
    {
        $getModelRow = $this->model::find($modelId);
        if ($this->model->isNot($getModelRow)) {
            $this->model = $getModelRow;
        }

        $this->action = 'show';
        $this->modals['showDetails'] = true;
    }

    public function getAllRows()
    {
        $getFilters = collect($this->filters)->forget('search')->keys()->toArray();

        $this->filterFields = $this->fields->whereIn('id', $getFilters);
        $this->searchFields = $this->fields->where('searchable')->pluck('id')->toArray();

        $query = $this->model::query()
            ->when($this->filters['search'],
                fn($query, $search) => $query->search($this->searchFields, $search)
            );

        if ($this->forUserOnly) {
            $query->where('user_id', auth()->user()->id);
        }

        if (method_exists($this, 'listQuery')) {
            if (is_array($this->listQuery())) {
                call_user_func_array([$query, $this->listQuery()[0]], $this->listQuery()[1]);
            }
        }

        foreach ($this->filterFields as $filter) {
            $query->when($this->filters[$filter['id']],
                fn($query, $field) => $query->where($filter['id'], $field));
        }

        if (!$this->sorts) {
            $query->orderBy('id', 'desc');
        }

        $this->flattenedRows = \Illuminate\Support\Arr::dot($query->get()->toArray());

        foreach ($this->sorts as $field => $direction) {
            $query->orderBy($field, $direction);
        }

        return $query->simplePaginate($this->perPage);
    }

    /*public function render(): View
    {
        return view('zeus-bolt::forms.entries')
            ->layout('filament::components.layouts.app')
            ->with('rows', $this->rows)
            ;
    }*/
}
