<?php

namespace Modules\Education\Database\factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiseaseFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\Disease::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'school_id' => School::factory(),
      'name' => $this->faker->name,
      'description' => $this->faker->text,
      'symptoms' => $this->faker->text,
      'treatment' => $this->faker->text,
    ];
  }
}
