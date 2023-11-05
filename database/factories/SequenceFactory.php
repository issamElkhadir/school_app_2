<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sequence>
 */
class SequenceFactory extends Factory
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
      'code' => $this->faker->word(),
      'prefix' => $this->faker->word(),
      'suffix' => $this->faker->word(),
      'length' => fake()->numberBetween(1, 10),
      'next_value' => fake()->numberBetween(1, 10),
      'step' => fake()->numberBetween(1, 10),
      'start_value' => fake()->numberBetween(1, 10),
      'end_value' => fake()->numberBetween(1, 10),
    ];
  }
}
