<?php

namespace Modules\Education\Database\factories;

use App\Models\Currency;
use App\Models\MeasureUnit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Category;
use Modules\Education\Entities\Level;

class PackFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\Pack::class;

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
      'level_id' => Level::factory(),
      'sale_price' => $this->faker->randomFloat(2, 0, 1000),
      'vat' => $this->faker->randomFloat(2, 0, 1000),
      'status' => $this->faker->boolean(),
      'description' => $this->faker->text(),
      'invoicing_policy' => $this->faker->randomElement([1, 2]),
      'unit_id' => MeasureUnit::factory(),

    ];
  }
}
