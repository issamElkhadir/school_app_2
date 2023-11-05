<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AcademicYearFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\AcademicYear::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => $this->faker->name(),
      'rtl_name' => $this->faker->name(),
      "status" => $this->faker->boolean(),
      "is_locked" => $this->faker->boolean(),
      "start_date" => $this->faker->date(),
      "end_date" => $this->faker->date(),
      "parent_academic_year_name" => $this->faker->name(),
//      "parent_academic_year_id" => AcademicYear::factory(),

    ];
  }
}
