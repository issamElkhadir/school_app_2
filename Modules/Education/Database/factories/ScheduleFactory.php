<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Clazz;
use Modules\Education\Entities\Level;

class ScheduleFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\Schedule::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => $this->faker->name(),
      'class_id' => Clazz::factory(),
      'level_id' => Level::factory(),
      'branch_id' => Branch::factory(),
      'active' => $this->faker->boolean(),
    ];
  }
}

