<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AbsenceTypeFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\AbsenceType::class;

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
      'status' => $this->faker->boolean(),
    ];
  }
}
