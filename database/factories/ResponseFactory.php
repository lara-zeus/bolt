<?php

namespace LaraZeus\Bolt\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaraZeus\Bolt\Models\Response;

class ResponseFactory extends Factory
{
    protected $model = Response::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'form_id' => config('zeus-bolt.models.Form')::factory(),
            'status' => 'NEW',
            'user_id' => 1,
            'notes' => $this->faker->text(),
        ];
    }
}
