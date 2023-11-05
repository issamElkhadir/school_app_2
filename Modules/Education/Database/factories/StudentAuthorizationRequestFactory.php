<?php

namespace Modules\Education\Database\factories;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\StudentAuthorizationRequest;
use Modules\Education\Entities\Subscription;
use Modules\Education\Entities\Unity;

class StudentAuthorizationRequestFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = StudentAuthorizationRequest::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'subscription_id' => Subscription::factory(),
      'unity_id' => Unity::factory(),
      'authorized_by' => User::factory(),
      'exempted' => $this->faker->boolean(),
      'content' => $this->faker->text('10'),
      'authorization_date' => $this->faker->date(),
      'file' => $this->faker->text('10'),
      'school_id' => School::factory(),
    ];
  }
}
