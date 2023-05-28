<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FieldResponseFactory extends Factory
{
    /**
     * @return string
     */
    public function getModel(): string
    {
        return config('zeus-bolt.models.FieldResponse');
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'form_id' => config('zeus-bolt.models.Form')::factory(),
            'field_id' => config('zeus-bolt.models.Field')::factory(),
            'response_id' => config('zeus-bolt.models.Response')::factory(),
            'response' => $this->faker->words(3, true),
        ];
    }
}
