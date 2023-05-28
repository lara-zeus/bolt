<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    /**
     * @return string
     */
    public function getModel(): string
    {
        return config('zeus-bolt.models.Section');
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
            'form_id' => config('zeus-bolt.models.Form')::factory(),
            'ordering' => $this->faker->numberBetween(1, 10),
        ];
    }
}
