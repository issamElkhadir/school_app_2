<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FormFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Education\Entities\Form::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "slug" => $this->faker->slug(),
            "description" => $this->faker->paragraph(2),
            "duration" => $this->faker->numberBetween(1,100),
            "is_active" => $this->faker->boolean() ,
            "preferences" => [
                'parameter_1' => $this->faker->word(),
                'parameter_2' => $this->faker->word(),
                'parameter_3' => $this->faker->word()
            ]
        ];
    }
}

