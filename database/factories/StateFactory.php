<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\State>
 */
class StateFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'name' => $this->faker->name(),
      'country_id' => Country::factory(),
      'country_code' => $this->faker->countryCode(),
      'fips_code' => $this->faker->word(),
      'iso2' => $this->faker->languageCode(),
      'type' => $this->faker->word(),
      'latitude' => $this->faker->latitude(),
      'longitude' => $this->faker->longitude(),
      'flag' => $this->faker->boolean(),
      'wikiDataId' => $this->faker->word(),
    ];
  }
}
