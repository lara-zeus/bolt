<?php

namespace LaraZeus\Bolt\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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
            'form_id' => config('zeus-bolt.models.Form')::factory(),
            'field_id' => config('zeus-bolt.models.Field')::factory(),
            'response_id' => config('zeus-bolt.models.Response')::factory(),
            'response' => $this->faker->words(3, true),
        ];
    }
}
