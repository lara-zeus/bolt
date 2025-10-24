<?php

namespace LaraZeus\Bolt\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaraZeus\Bolt\Fields\Classes\TextInput;
use LaraZeus\Bolt\Models\Field;
use LaraZeus\Bolt\Models\Section;

class FieldFactory extends Factory
{
    protected $model = Field::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'type' => TextInput::class,
            'section_id' => Section::factory(),
            'ordering' => $this->faker->numberBetween(1, 20),
        ];
    }
}
