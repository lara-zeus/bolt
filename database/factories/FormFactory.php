<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FormFactory extends Factory
{
    public function getModel(): string
    {
        return config('zeus-bolt.models.Form');
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
            'user_id' => config('auth.providers.users.model')::factory(),
            'layout' => $this->faker->numberBetween(1, 2),
            'ordering' => $this->faker->numberBetween(1, 20),
            'desc' => $this->faker->text(),
            'slug' => $this->faker->slug(),
            'is_active' => 1,
            'category_id' => config('zeus-bolt.models.Category')::factory(),
            'start_date' => $this->faker->dateTime(),
            'end_date' => $this->faker->dateTime(),
        ];
    }
}
