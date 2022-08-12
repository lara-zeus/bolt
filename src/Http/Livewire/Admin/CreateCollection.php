<?php

namespace LaraZeus\Bolt\Http\Livewire\Admin;

use LaraZeus\Bolt\Models\Collection;
use Livewire\Component;

class CreateCollection extends Component
{
    public $items;
    public Collection $collection;
    public $showCollectionModals;
    public $fld;
    public $options;

    protected $listeners = ['addCollection'];

    protected $validationAttributes = [
        'collection.values.*.itemKey' => 'the key',
        'collection.values.*.itemValue' => 'the value',
        'collection.name' => 'the Collection Name',
    ];

    public function rules()
    {
        return [
            'collection.values' => 'sometimes',
            'collection.values.*.itemKey' => 'sometimes',
            'collection.values.*.itemValue' => 'sometimes',
            'collection.values.*.itemIsDefault' => 'sometimes',
            'collection.name' => 'sometimes',
        ];
    }

    public function mount($fld, $options = true)
    {
        $this->fld = $fld;
        $this->options = $options;

        $this->initCollection();
    }

    public function initCollection()
    {
        $this->collection = new Collection();
        $this->items = [];
        $this->items[] = [
            'itemKey' => '1',
            'itemValue' => 'One',
            'itemIsDefault' => false,
        ];
        $this->collection->values = $this->items;
    }

    public function addListItem()
    {
        $this->items[] = [
            'itemKey' => '1',
            'itemValue' => 'One',
            'itemIsDefault' => false,
        ];
        $this->collection->values += $this->items;
    }

    public function saveCollection()
    {
        $this->validate(
            [
                'collection.values' => 'required',
                'collection.values.*.itemKey' => 'required|slug',
                'collection.values.*.itemValue' => 'required',
                'collection.values.*.itemIsDefault' => 'sometimes',
                'collection.name' => 'required',
                'collection.user_id' => 'sometimes',
            ],
            [
                'collection.values.*.itemKey.slug' => 'the key should not have spaces!',
            ]
        );
        $this->collection->user_id = auth()->user()->id ?? 0;
        $this->collection->save();

        $this->emit('collectionSaved', $this->collection->id, $this->fld);
        $this->showCollectionModals = false;
        $this->initCollection();

        if (!$this->options) {
            return redirect()->route('bolt.admin.collections');
        }
    }

    public function addCollection($collectionId = 0)
    {
        $this->showCollectionModals = true;
        if ($collectionId === 0) {
            $this->initCollection();
        } else {
            $this->collection = Collection::find($collectionId);
        }
    }

    public function updateOrder($orderedIds)
    {
        $newOrderdValues = collect($orderedIds)->map(function ($id) {
            return $this->collection->values[(int) $id['value']];
        })->toArray();

        $this->collection->values = $newOrderdValues;
        $this->collection->user_id = auth()->user()->id ?? 0;
        $this->collection->save();
    }

    public function render()
    {
        return view('zeus-bolt::create-collection');
    }
}
