<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Subject;

class SubjectSequenceFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\SubjectSequence::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'content' => $this->faker->text(),
      'nbh' => $this->faker->numerify('##'),
      "status" => $this->faker->boolean(),
      "subject_id" => Subject::factory(),

    ];
  }
}
