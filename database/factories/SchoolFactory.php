<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \App\Models\School::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => fake()->name(),
      'rtl_name' => fake()->name(),
      'short_name' => fake()->name(),
      'active' => fake()->boolean(),

      "contact_address" => fake()->address(),
      "contact_rtl_address" => fake()->address(),
      "contact_name" => fake()->name(),
      "contact_email" => fake()->email(),
      "contact_whatsapp" => fake()->phoneNumber(),
      "contact_website" => fake()->url(),
      "contact_phone_1" => fake()->phoneNumber(),
      "contact_phone_2" => fake()->phoneNumber(),
      "contact_fax_1" => fake()->phoneNumber(),
      "contact_fax_2" => fake()->phoneNumber(),
      "contact_mobile_1" => fake()->phoneNumber(),
      "contact_mobile_2" => fake()->phoneNumber(),
      "contact_street" => fake()->streetAddress(),
      "contact_zip" => fake()->postcode(),
      "contact_country_id" => Country::inRandomOrder()->first()->id ?? null,
      "contact_city_id" => City::inRandomOrder()->first()->id ?? null,

      "authorization_date" => fake()->date(),
      "authorization_number" => fake()->numerify("##-##"),
      "authorization_information" => fake()->text(),
      "rtl_authorization_information" => fake()->text(),
      "cnss" => fake()->numerify("#########"),
      "rc" => fake()->numerify("#########"),
      "ice" => fake()->numerify("#########"),
      "establishment_type" => fake()->randomElement(['private', 'public']),
      "responsible_name" => fake()->name(),
      "responsible_phone_number" => fake()->phoneNumber(),

    ];
  }
}
