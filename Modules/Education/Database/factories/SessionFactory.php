<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Classroom;
use Modules\Education\Entities\Schedule;
use Modules\Education\Entities\Staff;
use Modules\Education\Entities\Subject;

class SessionFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\Session::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => 'session '. $this->faker->word(),
      "schedule_id" => Schedule::factory(),
      "classroom_id" => Classroom::factory(),
      "subject_id" => Subject::factory(),
      "staff_id" => Staff::factory(),
      'start_time' => $this->faker->time(),
      "end_time" => $this->faker->time(),
      "day" => $this->faker->numberBetween(1, 7),
      "content" => $this->faker->word(),

    ];
  }
}
