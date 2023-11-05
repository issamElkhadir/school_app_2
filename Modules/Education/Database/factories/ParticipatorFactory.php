<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Form;
use Modules\Education\Entities\Student;

class ParticipatorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Education\Entities\Participator::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'password' => $this->faker->password(),
            'token' => $this->faker->text(),
            'student_id' => Student::factory(),
            'form_id' => Form::factory()
        ];
    }
}

