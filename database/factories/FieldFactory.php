<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    public function getModel(): string
    {
        return config('zeus-bolt.models.Field');
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'type' => '\LaraZeus\Bolt\Fields\Classes\TextInput',
            'section_id' => config('zeus-bolt.models.Section')::factory(),
            'ordering' => $this->faker->numberBetween(1, 20),
        ];
    }
}
