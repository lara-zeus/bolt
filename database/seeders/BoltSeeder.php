<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\FieldResponse;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;
use LaraZeus\Bolt\Models\Section;

class BoltSeeder extends Seeder
{
    public function run()
    {
        $form = Form::factory()
            ->count(1)
            ->has(
                Section::factory()
                    ->count(3)
                    ->state(function (array $attributes, Form $form) {
                        return [
                            'form_id' => $form->id,
                        ];
                    })
                    ->has(
                        Field::factory()
                            ->count(2)
                            ->state(function (array $attributes, Section $section) {
                                return [
                                    'section_id' => $section->id,
                                ];
                            })
                    )
            )
            ->create();

        $form->first()->fields->each(function ($field) {
            Response::factory()
                ->count(2)
                ->state([
                    'form_id' => 1,
                    'user_id' => 1,
                ])
                ->has(
                    FieldResponse::factory()
                        ->count(2)
                        ->state(function (array $attributes, Response $response) use ($field) {
                            return [
                                'form_id' => $response->form_id,
                                'response_id' => $response->id,
                                'field_id' => $field->id,
                            ];
                        }), 'fieldsResponses')
                ->create();
        });
    }
}
