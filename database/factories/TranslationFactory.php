<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'module' => $this->faker->word(),
      'model' => $this->faker->word(),
      'value' => $this->faker->word(),
      'key' => $this->faker->word(),
      'language_id' => Language::factory(),
    ];
  }
}
