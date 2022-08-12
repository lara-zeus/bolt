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
        $user = config('auth.providers.users.model')::factory()
            ->state([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ])
            ->create();

        $form = Form::factory()
            ->count(1)
            ->state(['user_id' => $user->id])
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
                                    'form_id' => $section->form_id,
                                    'section_id' => $section->id,
                                ];
                            })
                    )
            )
            ->create();

        $form->first()->fields->each(function ($field) use ($user) {
            Response::factory()
                ->count(2)
                ->state([
                    'form_id' => $field->form_id,
                    'user_id' => $user->id,
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
                        })
                    , 'fieldsResponses')
                ->create();
        });
    }
}
