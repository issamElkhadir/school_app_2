<?php

namespace Database\Factories;

use App\Models\Enums\MeasureUnitType;
use App\Models\MeasureUnitCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MeasureUnit>
 */
class MeasureUnitFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'name' => $this->faker->word(),
      'active' => $this->faker->boolean(),
      'measure_unit_category_id' => MeasureUnitCategory::factory(),
      'ratio' => $this->faker->randomFloat(2, 0, 100),
      'type' => $this->faker->randomElement(MeasureUnitType::cases()),
    ];
  }
}
