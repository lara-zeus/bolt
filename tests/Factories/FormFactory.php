<?php

namespace LaraZeus\Bolt\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Tests\Models\User;

class FormFactory extends Factory
{
    protected $model = Form::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'user_id' => User::factory(),
            'ordering' => $this->faker->numberBetween(1, 20),
            'description' => $this->faker->text(),
            'slug' => $this->faker->slug(),
            'is_active' => 1,
            'category_id' => config('zeus-bolt.models.Category')::factory(),
            'start_date' => $this->faker->dateTime(),
            'end_date' => $this->faker->dateTime(),
        ];
    }
}
