<?php

namespace LaraZeus\Bolt\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Models\FieldResponse;

class FieldResponseFactory extends Factory
{
    protected $model = FieldResponse::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'form_id' => BoltPlugin::getModel('Forms')::factory(),
            'field_id' => BoltPlugin::getModel('Field')::factory(),
            'response_id' => BoltPlugin::getModel('Response')::factory(),
            'response' => $this->faker->words(3, true),
        ];
    }
}
