<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Language>
 */
class LanguageFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'name' => $this->faker->unique()->languageCode,
      'direction' => $this->faker->randomElement(['ltr', 'rtl']),
      'local_code' => $this->faker->languageCode,
      'iso_code' => $this->faker->languageCode,
      'url_code' => $this->faker->languageCode,
      'status' => $this->faker->boolean,
    ];
  }
}
