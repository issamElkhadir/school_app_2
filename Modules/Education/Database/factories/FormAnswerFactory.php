<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\FormQuestion;
use Modules\Education\Entities\FormSection;
use Modules\Education\Entities\Participator;

class FormAnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Education\Entities\FormAnswer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'answer' => [
                'option_1' => $this->faker->word(),
                'option_2' => $this->faker->word()
            ] ,
            'participator_id' => Participator::factory(),
            'question_id' => FormQuestion::factory() ,
            'section_id' => FormSection::factory() ,
        ];
    }
}

