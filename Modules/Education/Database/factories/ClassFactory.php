<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Clazz;
use Modules\Education\Entities\Level;
use App\Models\School;

class ClassFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Clazz::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => $this->faker->name(),
      'rtl_name' => fake('ar')->name(),
      'status' => $this->faker->boolean(),
      'level_id' => Level::factory(),
      'school_id' => School::factory()

    ];
  }
}
