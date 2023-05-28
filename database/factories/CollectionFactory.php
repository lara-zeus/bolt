<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CollectionFactory extends Factory
{
    public function getModel(): string
    {
        return config('zeus-bolt.models.Collection');
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
            'user_id' => config('auth.providers.users.model')::factory(),
            'values' => 'abc',
        ];
    }
}
