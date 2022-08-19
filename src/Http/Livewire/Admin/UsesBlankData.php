<?php

namespace LaraZeus\Bolt\Http\Livewire\Admin;

use Illuminate\Support\Str;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Section;

trait UsesBlankData
{
    public function fieldData($sec)
    {
        return [
            'section_id' => $sec,
            'html_id' => Str::random(10),
            'ordering' => 1,
            'name' => '',
            'desc' => '',
            'rules' => [
                [
                    'rule'=>'',
                    'options'=>'',
                ],
            ],
            'type' => 'listValues', //listValues
            'options' => [
                'dataType' => 'single',
                'showAs' => 'select',
                'searchable' => 'not-searchable',
                'dateType' => 'datetime',
                'filesSize' => '1024',
                'filesType' => 'images',
                'dataSource' => 0,
            ],
            // todo add options here
        ];
    }

    public function sectionData()
    {
        return Section::make([
            'ordering' => 1,
        ]);
    }

    public function formData()
    {
        return Form::make([
            'options' => $this->options,
            'ordering' => 1,
            'is_active' => true,
            'layout' => 'ONE',
            'user_id' => auth()->user()->id ?? 0,
        ]);
    }
}
