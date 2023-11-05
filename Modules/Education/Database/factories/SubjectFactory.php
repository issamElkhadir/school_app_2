<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\ClassroomType;
use Modules\Education\Entities\Unity;

class SubjectFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\Subject::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => $this->faker->name(),
      'color' => $this->faker->colorName(),
      "massar_id" => $this->faker->randomNumber(),
      "picture" => base64_encode(file_get_contents($this->faker->image())),
      "order" => $this->faker->numerify('#####'),
      "classroom_type_id" => ClassroomType::factory(),
      "unity_id" => Unity::factory(),

    ];
  }
}
