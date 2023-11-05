<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\FormSection;

class FormQuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Education\Entities\FormQuestion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()

    {
        return [
            'title' => $this->faker->title(),
            'type' => $this->faker->randomLetter(),
            'description' => $this->faker->paragraph(2),
            'section_id' => FormSection::factory(),
            'is_required' => $this->faker->boolean(), 
            'order' => $this->faker->numberBetween(1,100),
            'points' => $this->faker->numberBetween(1,100),
            'options' => [
                'option_1' => $this->faker->word(),
                'option_2' => $this->faker->word(),
                'option_3' => $this->faker->word()
            ]
        ];
    }
}

