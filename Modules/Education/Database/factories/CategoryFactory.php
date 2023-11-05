<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Branch;

class CategoryFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\Category::class;

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
      "parent_category_id" => null,
      'short_name' => $this->faker->name(),
      "status" => $this->faker->boolean(),
      "description" => $this->faker->text('200'),

    ];
  }
}
