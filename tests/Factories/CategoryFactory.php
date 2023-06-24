<?php

namespace LaraZeus\Bolt\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function getModel(): string
    {
        return config('zeus-bolt.models.Category');
    }

    /**
     * Define the model's default state.
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'ordering' => $this->faker->numberBetween(1, 10),
            'is_active' => 1,
            'description' => $this->faker->words(5, true),
            'slug' => $this->faker->slug,
        ];
    }
}
