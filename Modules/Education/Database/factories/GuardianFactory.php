<?php

namespace Modules\Education\Database\factories;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Guardian;

class GuardianFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Guardian::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'first_name' => fake()->name(),
      'last_name' => fake()->name(),
      'rtl_first_name' => fake('ar')->name(),
      'rtl_last_name' => fake('ar')->name(),
      'email_address' => fake()->unique()->safeEmail(),
      'home_phone' => fake()->phoneNumber(),
      'mobile_phone' => fake()->phoneNumber(),
      'cni_number' => fake()->numerify("#########"),
      'country_id' => Country::inRandomOrder()->first()->id ?? null,
      'city_id' => City::inRandomOrder()->first()->id ?? null,
      'gender' => fake()->randomElement(['male', 'female'])

    ];
  }
}
