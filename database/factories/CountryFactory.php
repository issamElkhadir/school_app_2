<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'name' => $this->faker->country(),
      'iso3' => $this->faker->unique()->countryISOAlpha3(),
      'numeric_code' => $this->faker->numerify('###'),
      'iso2' => $this->faker->unique()->countryISOAlpha3(),
      'phone_code' => $this->faker->unique()->numerify('###'),
      'capital' => $this->faker->city,
      'currency' => $this->faker->currencyCode,
      'currency_name' => $this->faker->currencyCode(),
      'currency_symbol' => $this->faker->currencyCode(),
      'tld' => $this->faker->tld(),
      'native' => $this->faker->country,
      'region' => $this->faker->streetName(),
      'subregion' => $this->faker->streetName(),
      'timezones' => [$this->faker->timezone()],
      'translations' => [
        'de' => $this->faker->country,
        'es' => $this->faker->country,
        'fr' => $this->faker->country,
      ],
      'latitude' => $this->faker->latitude,
      'longitude' => $this->faker->longitude,
      'emoji' => $this->faker->emoji,
      'emojiU' => $this->faker->emoji,
    ];
  }
}
