<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaraZeus\Bolt\Models\Category;
use LaraZeus\Bolt\Models\Form;

class FormFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Form::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'  => $this->faker->words(3, true),
            'user_id' => config('auth.providers.users.model')::factory(),
            'layout' => $this->faker->numberBetween(1, 2),
            'ordering' => $this->faker->numberBetween(1, 20),
            'desc' => $this->faker->text(),
            'slug' => $this->faker->slug(),
            'is_active' => 1,
            'category_id' => Category::factory(),
            'start_date' => $this->faker->dateTime(),
            'end_date' => $this->faker->dateTime(),
        ];
    }
}
