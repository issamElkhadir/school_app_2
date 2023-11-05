<?php

namespace Modules\Education\Database\factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\AllergyType;

class AllergyTypeFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = AllergyType::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'school_id' => School::factory(),
      'name' => $this->faker->name(),
      'description' => $this->faker->text(),
      'symptoms' => $this->faker->word(),
      'treatment' => $this->faker->word(),
    ];
  }
}

