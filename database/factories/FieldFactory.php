<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    /**
     * @return string
     */
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
            'layout_position' => $this->faker->numberBetween(1, 2),
            'ordering' => $this->faker->numberBetween(1, 20),
            'html_id' => $this->faker->realTextBetween(1, 10),
            'html_name' => $this->faker->realTextBetween(1, 10),
        ];
    }
}
