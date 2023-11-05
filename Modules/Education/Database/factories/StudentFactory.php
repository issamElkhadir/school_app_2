<?php

namespace Modules\Education\Database\factories;

use App\Models\City;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\Student::class;

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
      'image' => fake()->imageUrl(),
      'rtl_first_name' => fake('ar')->name(),
      'rtl_last_name' => fake('ar')->name(),

      'gender' => $this->faker->randomElement(['male','female']),
      'nationality_id' => Country::factory(),
      'birth_city_id' => City::factory(),
      'cin' => $this->faker->numerify('########'),
      'cne' => $this->faker->numerify('########'),
      'birthday' => $this->faker->date(),
      'native_language' => Language::inRandomOrder()->first()->id ?? null,
      'second_language' => Language::inRandomOrder()->first()->id ?? null,
      'quotation' => $this->faker->randomFloat(2, 0, 20),
      'insurance_name' => $this->faker->name(),
      'insurance_number' =>  $this->faker->numerify('##########'),
      'old_school' =>   $this->faker->name(),
      'old_academy' => $this->faker->name(),
      'old_delegation' => $this->faker->name(),
      'notes' => $this->faker->text(),
      'how_he_knew_the_school' => $this->faker->text(),
      'has_scholarship' => $this->faker->boolean(),
      'scholarship_holder' => $this->faker->boolean(),

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

    ];
  }
}
