<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Cycle;

class BranchFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\Branch::class;

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
      'short_name' => $this->faker->name(),
      "status" => $this->faker->boolean(),
      "description" => $this->faker->text('200'),
      "cycle_id" => Cycle::factory(),

    ];
  }
}
