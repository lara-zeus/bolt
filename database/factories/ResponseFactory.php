<?php

namespace Database\Factories;

use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResponseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Response::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'form_id' => Form::factory(),
            'status' => 'NEW',
            'user_id' => 1,
            'notes' => $this->faker->text(),
        ];
    }
}
