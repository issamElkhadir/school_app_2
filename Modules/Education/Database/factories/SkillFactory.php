<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Cycle;
use Modules\Education\Entities\Level;
use Modules\Education\Entities\Staff;
use Modules\Education\Entities\Subject;

class SkillFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\Skill::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'level_id'=> Level::factory(),
      'subject_id'=> Subject::factory(),
      "staff_id" => Staff::factory(),
      "note" => $this->faker->text('200'),

    ];
  }
}
