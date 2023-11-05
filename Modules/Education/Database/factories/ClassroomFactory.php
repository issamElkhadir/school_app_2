<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\ClassroomType;
use App\Models\School;

class ClassroomFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\Classroom::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => $this->faker->name(),
      'rtl_name' => $this->faker->name(),
      'image' => $this->faker->imageUrl(),
      'capacity' => $this->faker->randomNumber(2, 0, 100),
      'classroom_type_id' => ClassroomType::factory(),
      'school_id' => School::factory()

    ];
  }
}
