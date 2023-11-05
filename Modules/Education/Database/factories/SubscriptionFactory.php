<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Clazz;
use Modules\Education\Entities\Cycle;
use Modules\Education\Entities\Student;

class SubscriptionFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\Subscription::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'class_id' => Clazz::factory(),
      'student_id' => Student::factory(),
      'principal' => $this->faker->boolean(),
      'subscription_date' => $this->faker->date(),
      'sequence' => $this->faker->word(),

    ];
  }
}
