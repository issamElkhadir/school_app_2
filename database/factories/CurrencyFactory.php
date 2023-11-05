<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'name' => fake()->name(),
      'code' => fake()->currencyCode(),
      'symbol' => fake()->currencyCode(),
      'symbol_native' => fake()->currencyCode(),
      'decimal_digits' => fake()->numberBetween(1, 4),
      'rounding' => fake()->randomFloat(4, 2, 1),
      'name_plural' => fake()->name(),
      'is_active' => fake()->boolean(),
    ];
  }
}
