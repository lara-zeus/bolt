<?php

namespace LaraZeus\Bolt\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaraZeus\Bolt\Models\Collection;

class CollectionFactory extends Factory
{
    protected $model = Collection::class;

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
