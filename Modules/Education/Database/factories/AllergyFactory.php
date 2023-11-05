<?php

namespace Modules\Education\Database\factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Allergy;
use Modules\Education\Entities\AllergyType;

class AllergyFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Allergy::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'school_id' => School::factory(),
      'allergy_type_id' => AllergyType::factory(),
      'name' => $this->faker->name(),
      'rtl_name' => fake('ar')->name(),
      'short_name' => $this->faker->userName(),
      'description' => $this->faker->text(),
      'status' => $this->faker->boolean(),
    ];
  }
}

