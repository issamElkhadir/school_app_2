<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\Staff::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'salary' => $this->faker->randomFloat(2, 2000, 100_000),
      'week_hours' => $this->faker->randomFloat(2, 0, 100),
      'name' => $this->faker->name(),
      'phone' => $this->faker->phoneNumber(),
      'email' => $this->faker->unique()->safeEmail(),
      'address' => $this->faker->address(),

    ];
  }
}
