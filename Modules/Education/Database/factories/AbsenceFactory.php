<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\AbsenceType;
use Modules\Education\Entities\Achievement;
use Modules\Education\Entities\Student;
use Modules\Education\Entities\Subscription;

class AbsenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Education\Entities\Absence::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'absence_type_id' => AbsenceType::factory() ,
            'student_id' => Student::factory() ,
            'achievement_id' => Achievement::factory() ,
            'subscription_id' => Subscription::factory() ,
            'note' => $this->faker->paragraph(2) ,
            'date' => $this->faker->date()
        ];
    }
}


