<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\Section;

class FieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Field::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'type' => 'TextInput',
            'section_id' => Section::factory(),
            'layout_position' => $this->faker->numberBetween(1, 2),
            'ordering' => $this->faker->numberBetween(1, 20),
            'html_id' => $this->faker->realTextBetween(1, 10),
            'html_name' => $this->faker->realTextBetween(1, 10),
        ];
    }
}
