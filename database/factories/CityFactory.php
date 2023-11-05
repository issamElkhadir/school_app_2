<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
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
      'country_id' => \App\Models\Country::factory(),
      'state_id' => \App\Models\State::factory(),
      'country_code' => $this->faker->countryCode(),
      'state_code' => $this->faker->countryCode(),
      'latitude' => $this->faker->latitude(),
      'longitude' => $this->faker->longitude(),
      'flag' => $this->faker->boolean(),
    ];
  }
}
